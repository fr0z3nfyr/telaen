{config_load file=$umLanguageFile section="Error"}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>UebiMiau Webmail - {$umLabel.err_title}</title>
	<meta http-equiv="Content-Type" content="text/html; charset={$umLabel.default_char_set}">
	<link rel="stylesheet" href="themes/webmail/css.css" type="text/css">
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr><td valign="middle" align="center">
<table width="750" border="0" cellspacing="0" cellpadding="0" class="frame" align="center">

	<tr><td class=top><img src="themes/webmail/images/logo.gif" border="0""></td></tr>
	<tr><td><img src="themes/webmail/images/bandeau-h.gif" border="0"></td></tr>
	<tr>
		<td background="themes/webmail/images/ligne-fond.gif">
			<table width="450" border="0" cellspacing="1" cellpadding="1" align="center">
				<tr><td align="center"><br><font color="red">.: <b>{$umLabel.err_title}</b> :.</font><br></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td align="center">{$umLabel.err_msg}<br><br>
				<small>{$umLabel.err_system_msg} 
				{if $umErrorCode eq "1"}{$umLabel.error_connect}
				{elseif $umErrorCode eq "2"}{$umLabel.error_retrieving}
				{else}{$umLabel.error_other}{/if}</small></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td align="center">> <a href="logout.php?sid={$umSid}&tid={$umTid}&lid={$umLid}" class="lien">{$umLabel.err_exit}</a> <</td></tr>
				<tr><td>&nbsp;</td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class=bot>
			<img src="themes/webmail/images/bandeau-b.gif" border="0" width="750" height="25">
		</td>
	<tr>
</table>
</td></tr>
</table>
</body>
</html>