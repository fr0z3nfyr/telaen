<?php
/************************************************************************
Telaen is a GPL'ed software developed by

 - The Telaen Group
 - http://jimjag.github.io/telaen/

*************************************************************************/
define('I_AM_TELAEN', basename($_SERVER['SCRIPT_NAME']));

require_once './inc/class/class.Telaen.php';
require_once './inc/preinit.php';
$TLN = new Telaen();
$TLN->load_config();
require_once './inc/errorhandler.php';

extract(Telaen::pull_from_array($_GET, array('f_email', 'f_user', 'lng', 'tem', 'six'), 's'));
require_once './inc/user_tl.php';

require_once $config['SMARTY_DIR'].'Smarty.class.php';
$smarty = new Smarty();
$smarty->security = true;
$smarty->secure_dir = array('./');
$smarty->compile_dir = $TLN->config['temporary_directory'].'/smarty_ct/';
$smarty->template_dir = './themes';
$smarty->config_dir = './langs';
$smarty->use_sub_dirs = true;
if (!is_dir($smarty->compile_dir)) {
    mkdir($smarty->compile_dir, (isset($TLN->config['dirperm']) ? $TLN->config['dirperm'] : "0755"));
}

$smarty->assign('umLabel', $lang);

// Assign also the webmail title to smarty, check for empty title before
if (!isset($TLN->config['webmail_title'])) {
    $TLN->config['webmail_title'] = 'Telaen Webmail';
}
$smarty->assign('webmailTitle', $TLN->config['webmail_title']);

// Assing the header and footer paths because inc.php is not loaded in index
$smarty->assign('headerTemplate', $header_template);
$smarty->assign('footerTemplate', $footer_template);

// Detect errors
if (isset($_GET['err'])) {
    $smarty->assign('errorCode', $_GET['err']);
    $smarty->assign('error', 'true');
} else {
    $smarty->assign('error', 'false');
}

$jssource = "
<script language=\"javascript\" type=\"text/javascript\">
//<![CDATA[
	function selectLanguage() {
		sSix		= '';
		sUser		= '';
		sEmail		= '';
		sLanguage	= '';
		sTheme		= '';

		try {
			frm = document.forms[0];
			if(frm.six && frm.six.options)
				sSix = frm.six.options[frm.six.selectedIndex].value;
			if(frm.f_user)
				sUser = frm.f_user.value;
			if(frm.f_email)
				sEmail = frm.f_email.value;
			if(frm.tem)
				sTheme = frm.tem.options[frm.tem.selectedIndex].value;
			if(frm.lng)
				sLanguage = frm.lng.options[frm.lng.selectedIndex].value;
			sLocation = 'index.php?lng='+sLanguage+'&tem='+sTheme+'&f_user='+escape(sUser)+'&six='+sSix+'&f_email='+sEmail;
			location.replace(sLocation);
		} catch(err) {
			alert('Your browser do not support JS'); // Vola: this is stupid... if js doesn't work also alert doesn't work :)
		}
	}
//]]>
</script>
";

//$smarty->debugging = true;
$mail_server_type = strtoupper($TLN->config['mail_server_type']);
$smarty->assign('umServerType', $mail_server_type);

switch ($mail_server_type) {
    case 'DETECT':

        break;
    case 'ONE-FOR-EACH':

        $aval_servers = count($TLN->config['mail_servers']);
        $smarty->assign('umAvailableServers', $aval_servers);

        if (!$aval_servers) {
            die("You must set at least one server in \$mail_servers, please review your config.php");
        }
        if ($aval_servers == 1) {
            $strServers = '@'.$TLN->config['mail_servers'][0]['domain']." <input type=\"hidden\" name=\"six\" value=\"0\" />";
        } else {
            $strServers = "<select name=\"six\">\r";
            for ($i = 0;$i<$aval_servers;$i++) {
                $sel = ($i == $six) ? "selected=\"selected\"" : "";
                $strServers .= "<option value=\"$i\" $sel>@".$TLN->config['mail_servers'][$i]["domain"]."</option> \r";
            }
            $strServers .= "</select>\r";
        }

        $smarty->assign('umServer', $strServers);
        break;
    case 'ONE-FOR-ALL':

        break;
    default:
        die('Unknown server mode, please see config.php');
}

// Protect from XSS
if (isset($f_email) && !PHPMailer::validateAddress($f_email)) {
    $f_email = 'unknown@example.com';
}
if (isset($f_user) && !PHPMailer::validateAddress("$f_user@example.com")) {
    $f_user = 'unknown';
}

$smarty->assign('umEmail', $f_email);
$smarty->assign('umUser', $f_user);
$smarty->assign('umPass', $f_pass);
$smarty->assign('umJS', $jssource);

$avallangs = count($languages);
if ($avallangs == 0) {
    die('You must provide at least one language');
}

$avalthemes = count($themes);
if ($avalthemes == 0) {
    die('You must provide at least one theme');
}

$smarty->assign('umAllowSelectLanguage', $TLN->config['allow_user_change_language']); $func($textout);

if ($allow_user_change_language) {
    $langsel = "<select name=\"lng\" onchange=\"selectLanguage()\">\r";
    foreach ($languages as $key => $val) {
        $selected = ($selected_language == $key) ? "selected=\"selected\"" : "";
        $langsel .= "<option value=\"$key\" $selected>".$val."</option> \r";
    }
    $langsel .= "</select>\r";
    $smarty->assign("umLanguages", $langsel);
}

$smarty->assign('umAllowSelectTheme', $TLN->config['allow_user_change_theme']);

if ($allow_user_change_theme) {
    $themsel = "<select name=\"tem\" onchange=\"selectLanguage()\">\r";
    foreach ($themes as $key => $val) {
        $selected = ($selected_theme == $key) ? "selected=\"selected\"" : "";
        $themsel .= "<option value=\"$key\" $selected>".$val."</option> \r";
    }
    $themsel .= "</select>\r";
    $smarty->assign('umThemes', $themsel);
}

$smarty->display("$selected_theme/login.htm");
