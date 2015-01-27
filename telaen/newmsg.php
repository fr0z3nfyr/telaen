<?php
/************************************************************************
Telaen is a GPL'ed software developed by

 - The Telaen Group
 - http://jimjag.github.io/telaen/

*************************************************************************/
define('I_AM_TELAEN', basename($_SERVER['SCRIPT_NAME']));

require './inc/init.php';
/* @var $TLN Telaen */

// assign metas
$smarty->assign('pageMetas', $pmetas);

extract(Telaen::pull_from_array($_GET, array('nameto', 'mailto'), 'str'));
extract(
    Telaen::pull_from_array(
        $_POST, array('to', 'cc', 'bcc', 'subject', 'requireReceipt',
        'priority', 'body', 'is_html', 'textmode', 'sig', 'todo', 'rtype', 'uidl', ), 'str'
    )
);
// Recall $folder is always available via preinit.php

$mbox = $TLN->tdb->get_message($uidl, $folder);
if ($todo == 'send') {
    $mail = new PHPMailer();

    if ($TLN->config['phpmailer_sendmail'] != "") {
        $mail->Sendmail = $TLN->config['phpmailer_sendmail'];
    }
    if ($TLN->config['phpmailer_timeout'] != 0) {
        $mail->Timeout = $TLN->config['phpmailer_timeout'];
    }

    $ARTo = $TLN->get_names(stripslashes($to));
    $ARCc = $TLN->get_names(stripslashes($cc));
    $ARBcc = $TLN->get_names(stripslashes($bcc));

    // html head and foot to add, the editor can do it, but causes some problems with sign and footer
    $htmlHead = "
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
<html>
<head><meta http-equiv='Content-Type' content='text/html; charset={$lang['default_char_set']}'></head>
<body>
	";

    $htmlFoot = "
</body>
</html>";

    // build the email
    if ((count($ARTo)+count($ARCc)+count($ARBcc)) > 0) {
        // set lang for error messages, english for now
        $mail->SetLanguage('en', 'inc/language/');

        // for password authenticated servers
        $mail->SMTPAuth = $TLN->config['use_password_for_smtp'];

        // use user data or static data for smtp auth
        if ($TLN->config['smtp_static_auth']) {
            $mail->Username = $TLN->config['smtp_static_user'];
            $mail->Password = $TLN->config['smtp_static_password'];
        } else {
            $mail->Username = $auth['user'];
            $mail->Password = $auth['pass'];
        }

        // if using the advanced editor
        if ($is_html == 'true') {
            $mail->IsHTML(1);
            if (!empty($TLN->config['footer'])) {
                $body .= preg_replace('|(\r?\n)|', "<br>$1", $TLN->config['footer']);
            }
            // add html head and foot
            $body = $htmlHead.$body.$htmlFoot;
            $mail->AltBody = "\nThis Email is formatted in HTML. Your Email client appears to be incompatible.\n";
        } elseif (!empty($TLN->config['footer'])) {
            $body .= $TLN->config['footer'];
        }

        $mail->CharSet = $TLN->charset;
        $mail->Hostname = getenv('SERVER_NAME');
        $mail->From = ($TLN->config['allow_modified_from'] && !empty($TLN->prefs['reply-to'])) ? $TLN->prefs['reply-to'] : $auth['email'];
        $mail->FromName = $mail->encodeHeader($TLN->prefs['real-name']);
        $mail->AddReplyTo($TLN->prefs['reply-to'], $TLN->mime_encode_headers($TLN->prefs['real-name']));

        $mail->Host = $TLN->config['smtp_server'];
        $mail->WordWrap = 76;
        $mail->Priority = $priority;

        if ($TLN->config['smtp_debug']) {
            $mail->SMTPDebug = true;
        }

        // add an header for keep a track of client IP
        $mail->AddCustomHeader('X-Originating-IP: '.getenv('REMOTE_ADDR'));

        // add return-receipt if required
        if (isset($requireReceipt)) {
            $mail->ConfirmReadingTo =  $TLN->prefs['reply-to'];
        }

        // add recipients
        if (count($ARTo) != 0) {
            for ($i = 0;$i<count($ARTo);$i++) {
                $name = $ARTo[$i]['name'];
                $email = $ARTo[$i]['mail'];
                if ($name != $email) {
                    $mail->AddAddress($email, $TLN->mime_encode_headers($name));
                } else {
                    $mail->AddAddress($email);
                }
            }
        }

        if (count($ARCc) != 0) {
            for ($i = 0;$i<count($ARCc);$i++) {
                $name = $ARCc[$i]['name'];
                $email = $ARCc[$i]['mail'];
                if ($name != $email) {
                    $mail->AddCC($email, $TLN->mime_encode_headers($name));
                } else {
                    $mail->AddCC($email);
                }
            }
        }

        if (count($ARBcc) != 0) {
            for ($i = 0;$i<count($ARBcc);$i++) {
                $name = $ARBcc[$i]['name'];
                $email = $ARBcc[$i]['mail'];
                if ($name != $email) {
                    $mail->AddBCC($email, $TLN->mime_encode_headers($name));
                } else {
                    $mail->AddBCC($email);
                }
            }
        }

        if (isset($mbox['attachments'])) {
            $attachs = $mbox['attachments'];
            for ($i = 0;$i<count($attachs);$i++) {
                if (file_exists($attachs[$i]['localname'])) {
                    $mail->AddAttachment($attachs[$i]['localname'], $attachs[$i]['name'], 'base64', $attachs[$i]['type']);
                }
            }
        }

        $mail->Subject = $TLN->mime_encode_headers(stripslashes($subject));
        $mail->Body = stripslashes($body);
        $mail->Mailer = $TLN->config['mailer_type'];

        if (($mail->Send()) === false) {
            $smarty->assign('umMailSent', false);
            $smarty->assign('umErrorMessage', $mail->ErrorInfo);
        } else {
            $smarty->assign('umMailSent', true);

            if (isset($mbox['attachments'])) {
                unset($mbox['attachments']);
                reset($mbox);
                $UserMbox->Save($mbox);
            }

            if ($TLN->prefs['save_to_sent']) {
                if (!$TLN->mail_connect()) $TLN->redirect_and_exit('index.php?err=1', true);
                if (!$TLN->mail_auth(false)) $TLN->redirect_and_exit('index.php?err=0');
                $TLN->mail_save_message('sent', $mail->getSentMIMEMessage(), '\\SEEN');
                unset($mbox['headers']['sent']);
                $TLN->mail_disconnect();
                $UserMbox->Save($mbox);
            }
        }
    } else {
        die("<script language='javascript' type='text/javascript'>location = 'index.php?err=3';</script>");
    }

    $jssource = $commonJS;
    $jssource .= "
	<script language='javascript' type='text/javascript'>
	//<![CDATA[
	function newmsg() { location = 'newmsg.php?pag=$pag&folder=".urlencode($folder)."'; }
	function folderlist() { location = 'folders.php?folder=".urlencode($folder)."'}
	function emptytrash() { location = 'folders.php?empty=trash&folder=".urlencode($folder)."&goback=true';}
	function search() { location = 'search.php?folder=".urlencode($folder)."';}
	//]]>
	</script>
	";

    $smarty->assign('umJS', $jssource);

    $smarty->display("$themez/newmsg-result.tpl");
} elseif ($todo == 'edit') {
    // priority
    $priority_level = (!isset($priority) || empty($priority)) ? 3 : $priority;
    $smarty->assign('umPriority', $priority_level);

    // adv editor
    if (!isset($textmode)) {
        $textmode = null;
    }
    $show_advanced = ((!$textmode) && ($TLN->prefs['editor_mode'] != 'text')) ? 1 : 0;
    $js_advanced = ($show_advanced) ? 'true' : 'false';

    $signature = $TLN->prefs['signature'];
    if ($show_advanced) {
        $signature = nl2br($signature);
    }

    $add_sig = $TLN->prefs['add_signature'];
    $addSignature = ($add_sig) ? 1 : 0;
    $smarty->assign('umAddSignature', $addSignature);

        // return receipt
        $rr = ($TLN->prefs['require_receipt']) ? true : false;
    $smarty->assign('requireReceipt', $rr);

    // hidden inputs ---- Note: these should be moved into template...
    $forms = "<input type='hidden' name='todo' value='edit' />
	<input type='hidden' name='is_html' value='$js_advanced' />
	<input type='hidden' name='folder' value='$folder' />
	<input type='hidden' name='uidl' value='$uidl' />
	<input type='hidden' name='sig' value='".htmlspecialchars($signature)."' />
	<input type='hidden' name='textmode' value='$textmode' />
	";
    $smarty->assign('umForms', $forms);

    $jssource = $commonJS;

    if ($show_advanced) {
        $jssource .= "
	<script type='text/javascript' src='inc/vendor/editors/tinymce/tinymce.gzip.js'></script>
	<script type='text/javascript' src='inc/vendor/editors/tinymce/tiny_init.js'></script>
		";
    }

    require './inc/js/newmsg_js.php';
    $smarty->assign('umJS', $jssource);

    if (!isset($body)) {
        $body = null;
    }
    $body = stripslashes($body);

    if (isset($rtype)) {
        $mail_info = $mbox['headers'][$folder][$ix];

        if (($rtype == 'forward' && !stristr($mail_info['flags'], '\\FORWARDED'))
            || ($rtype != 'forward' && !stristr($mail_info['flags'], '\\ANSWERED'))) {
            if (!$TLN->mail_connect()) {
                $TLN->redirect_and_exit('index.php?err=1', true);
            }
            if (!$TLN->mail_auth()) {
                $TLN->redirect_and_exit('index.php?err=0');
            }
            if ($rtype != 'forward' && $TLN->mail_set_flag($mail_info, '\\ANSWERED', '+')) {
                $mbox['headers'][$folder][$ix] = $mail_info;
                $UserMbox->Save($mbox);
            }
            if ($rtype == 'forward' && $TLN->mail_set_flag($mail_info, '\\FORWARDED', '+')) {
                $mbox['headers'][$folder][$ix] = $mail_info;
                $UserMbox->Save($mbox);
            }
            $TLN->mail_disconnect();
        }

        $filename = $mail_info['localname'];

        if (!file_exists($filename)) {
            die("<script>location = 'messages.php?err=2&folder=".urlencode($folder)."&pag=$pag&refr=true';</script>");
        }
        $result = $TLN->read_file($filename);
        $TLN->sanitize = ($TLN->config['sanitize_html'] || !$TLN->config['allow_scripts']);
        $email = $TLN->Decode($result);

        $result = $TLN->fetch_structure($result);

        $tmpbody = $email['body'];
        $subject = $mail_info['subject'];

        $ARReplyTo = $email['reply-to'];
        $ARFrom = $email['from'];
        $useremail = $auth['email'];

        // From
        if ($ARReplyTo[0]['mail'] != "") {
            $name = $ARReplyTo[0]['name'];
            $thismail = $ARReplyTo[0]['mail'];
        } else {
            $name = $ARFrom[0]['name'];
            $thismail = $ARFrom[0]['mail'];
        }
        $fromreply = "\"$name\" <$thismail>";

        // These are used for re-add my address in the quoted message, since we remove it from To & CC lists
        // I don't want my adr in To or CC fields when I reply-all, but I want to see it in the quoted message.
        // If someone finds a better way to do this is welcome....
        $myToAdr = "";
        $myCCAdr = "";

        // To
        $ARTo = $email['to'];
        for ($i = 0;$i<count($ARTo);$i++) {
            $name = $ARTo[$i]['name'];
            $thismail = $ARTo[$i]['mail'];

            // avoid to add my address in the TO list
            if ($thismail != $auth['email'] && $thismail != $TLN->prefs['reply-to']) {
                if (isset($toreply)) {
                    $toreply .= ", \"$name\" <$thismail>";
                } else {
                    $toreply = "\"$name\" <$thismail>";
                }
            } else {
                $myToAdr = "\"$name\" <$thismail>";
            }
        }

        // CC
        $ARCC = $email['cc'];
        for ($i = 0;$i<count($ARCC);$i++) {
            $name = $ARCC[$i]['name'];
            $thismail = $ARCC[$i]['mail'];

            // avoid to add my address in the CC list
            if ($thismail != $auth['email'] && $thismail != $TLN->prefs['reply-to']) {
                if (isset($ccreply)) {
                    $ccreply .= ", \"$name\" <$thismail>";
                } else {
                    $ccreply = "\"$name\" <$thismail>";
                }
            } else {
                $myCCAdr = "\"$name\" <$thismail>";
            }
        }

        $allreply = $TLN->clear_names($fromreply.', '.$toreply);
        $ccreply = $TLN->clear_names($ccreply);
        $fromreply = $TLN->clear_names($fromreply);

        $msgsubject = $email['subject'];

        $fromreply_quote = $fromreply;
        $toreply_quote = $toreply;
        $ccreply_quote = $ccreply;
        $msgsubject_quote = $msgsubject;

        // re-add my address in the quoted message, why? look at line #412
        if (!empty($myToAdr)) {
            if (empty($toreply_quote)) {
                $toreply_quote = $myToAdr;
            } else {
                $toreply_quote = $myToAdr.','.$toreply_quote;
            }
        }

        if (!empty($myCCAdr)) {
            if (empty($ccreply_quote)) {
                $ccreply_quote = $myCCAdr;
            } else {
                $ccreply_quote = $myCCAdr.','.$ccreply_quote;
            }
        }

        if ($show_advanced) {
            $fromreply_quote = htmlspecialchars($fromreply_quote);
            $toreply_quote = htmlspecialchars($toreply_quote);
            $ccreply_quote = htmlspecialchars($ccreply_quote);
            $msgsubject_quote = htmlspecialchars($msgsubject_quote);
            $linebreak = '<br>';
        } else {
            $tmpbody = strip_tags($tmpbody);
            $quote_string = '> ';
            $tmpbody = $quote_string.preg_replace('|\n|', "\n$quote_string", $tmpbody);
        }

        $body = "
{$lang['reply_delimiter']}$linebreak
{$lang['reply_from_hea']} ".preg_replace('|(")|', "", $fromreply_quote)."$linebreak
{$lang['reply_to_hea']} ".preg_replace('|(")|', "", $toreply_quote);

        if (!empty($ccreply)) {
            $body .= "$linebreak
{$lang['reply_cc_hea']} ".preg_replace('|(")|', "", $ccreply_quote);
        }

        $body .= "$linebreak
{$lang['reply_subject_hea']} ".$msgsubject_quote."$linebreak
{$lang['reply_date_hea']} ".@strftime($lang['date_format'], $email['date'])."$linebreak
$linebreak
$tmpbody";

        if ($show_advanced) {
            $body = "
<br>
<blockquote dir='ltr' style='padding-right: 0px; padding-left: 5px; margin-left: 5px; border-left: #000000 2px solid; margin-right: 0px'>
  <div style='font: 10pt arial'>
  $body
  </div>
</blockquote>
<br>
";
        }

        switch ($rtype) {
        case 'reply':
            if (!preg_match("/^{$lang['reply_prefix']}/i", trim($subject))) {
                $subject = "{$lang['reply_prefix']} $subject";
            }
            $to = $fromreply;
            break;
        case 'replyall':
            if (!preg_match("/^{$lang['reply_prefix']}/i", trim($subject))) {
                $subject = "{$lang['reply_prefix']} $subject";
            }
            $to = $allreply;
            $cc = $ccreply;
            break;
        case 'forward':
            if (!preg_match("/^{$lang['forward_prefix']}/i", trim($subject))) {
                $subject = "{$lang['forward_prefix']} $subject";
            }
            if (count($email['attachments']) > 0) {
                for ($i = 0; $i < count($email['attachments']); $i++) {
                    $current = $email['attachments'][$i];
                    $ind = count($mbox['attachments']);
                    $mbox['attachments'][$ind]['localname'] = $current['filename'];
                    $mbox['attachments'][$ind]['name'] = $current['name'];
                    $mbox['attachments'][$ind]['type'] = $current['content-type'];
                    $mbox['attachments'][$ind]['size'] = $current['size'];
                }
                $UserMbox->Save($mbox);
            }
            break;
        }
        if ($add_sig && !empty($signature)) {
            if ($show_advanced) {
                $body = "<br><br>----<br>$signature<br><br>$body";
            } else {
                $body = "\r\n\r\n----\r\n$signature\r\n\r\n$body";
            }
        }
    } elseif ($add_sig && !empty($signature) && empty($body)) {
        if ($show_advanced) {
            $body = "<br><br>----<br>$signature<br><br>$body";
        } else {
            $body = "\r\n\r\n----\r\n$signature\r\n\r\n$body";
        }
    }

    $haveSig = empty($signature) ? 0 : 1;
    $smarty->assign('umHaveSignature', $haveSig);

    $strto = (isset($nameto) && preg_match('|([-a-z0-9_$+.]+@[-a-z0-9_.]+[-a-z0-9_])|i', $mailto)) ?
    "<input class='textbox' style='width : 200px;' type='text' size='20' name='to' value='&quot;".htmlspecialchars(stripslashes($nameto))."&quot; <".htmlspecialchars(stripslashes($mailto)).">' />
	" : "<input class='textbox' style='width : 200px;' type='text' size='20' name='to' value='".htmlspecialchars(stripslashes($to))."' />";

    $strcc = "<input class='textbox' style='width : 200px;' type='text' size='20' name='cc' value='".htmlspecialchars(stripslashes($cc))."' />";
    $strbcc = "<input class='textbox' style='width : 200px;' type='text' size='20' name='bcc' value='".htmlspecialchars(stripslashes($bcc))."' />";
    $strsubject = "<input class='textbox' style='width : 200px;' type='text' size='20' name='subject' value='".htmlspecialchars(stripslashes($subject))."' />";

    if (isset($mbox['attachments']) && count($attachs = $mbox['attachments']) > 0) {
        $smarty->assign('umHaveAttachs', 1);
        $attachlist = array();
        for ($i = 0;$i<count($attachs);$i++) {
            $index = count($attachlist);

            $attachlist[$index]['name'] = $attachs[$i]['name'];
            $attachlist[$index]['size'] = Telaen::bytes2bkmg($attachs[$i]['size']);
            $attachlist[$index]['type'] = $attachs[$i]['type'];
            $attachlist[$index]['link'] = "javascript:upwin($i)";
        }
        $smarty->assign('umAttachList', $attachlist);
    }

    if (!$show_advanced) {
        $body = stripslashes($body);
    }

    if (!isset($txtarea)) {
        $txtarea = null;
    }
    /*
     * Force the below to 0. We do not want to
     * enable the old HTML editor even when using
     * HTML Email.
     */
    // $umAdvEdit = ($show_advanced) ? 1 : 0 ;
    $umAdvEdit = 0;

    $smarty->assign('umBody', $body);
    $smarty->assign('umTo', $strto);
    $smarty->assign('umCc', $strcc);
    $smarty->assign('umBcc', $strbcc);
    $smarty->assign('umSubject', $strsubject);
    $smarty->assign('umTextEditor', $txtarea);
    $smarty->assign('umAdvancedEditor', $umAdvEdit);

    $smarty->display("$themez/newmsg.tpl");
} else {
    $TLN->redirect_and_exit('messages.php?folder='.urlencode($folder).'&pag=1');
}
