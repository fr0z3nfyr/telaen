{include file=$headerTemplate pageTitle=#folders_to#|cat:" "|cat:$smUserEmail}

{include file=$menuTemplate}
<table cellspacing="0" cellpadding="0" width="100%" border="0">
  <tr>
    <td width="45%" class="headersLeft">&nbsp; .:<b> {$smLabel.fld_name_hea} </b>:.</td>
    <td width="15%" class="headers">.:<b> {$smLabel.fld_messages_hea} </b>:.</td>
    <td width="15%" class="headersRight">.:<b> {$smLabel.fld_size_hea} </b>:.</td>
    <td width="15%" class="headers">.:<b> {$smLabel.fld_empty_hea} </b>:.</td>
    <td class="headers">.:<b> {$smLabel.fld_delete_hea} </b>:.</td>
  </tr>
  {section name=i loop=$smFolderList}
  <tr>
    <td class="default">&nbsp;<a href="{$smFolderList[i].chlink}">{$smFolderList[i].name|escape:"html"}</a></td>
    <td class="cent">{$smFolderList[i].msgs}</td>
    <td class="right">{$smFolderList[i].boxsize} &nbsp;</td>
    <td class="cent"><a href="{$smFolderList[i].emptylink}">OK</a></td>
    <td class="cent">{$smFolderList[i].del}</td>
  </tr>
  <tr>
    <td colspan="5" class="separator"></td>
  </tr>
  {/section}
  <tr>
    <td class="default">&nbsp;</td>
    <td class="right"><b>{$smLabel.fld_total}</b> &nbsp;</td>
    <td class="right"><b>{$smTotalUsed}</b> &nbsp;</td>
    <td class="cent">&nbsp;</td>
    <td class="cent">&nbsp;</td>
  </tr>
  <form name="form1" action="folders.php" method="post" onsubmit="return create();">
    <tr>
      <td class="default" colspan="1"><table>

            <td><input type="text" name="newfolder" value="" class="textbox">
              &nbsp; </span></td>
            <td class="default" colspan="4"><table class="buttonTable" cellspacing="0" cellpadding="0">
                <tr>
                  <td valign="middle" class="buttonLeft">&nbsp;</td>
                  <td valign="middle" class="buttonMiddle"><input type="button" onclick="javascript:create();" class="button" value="{$smLabel.fld_make_new}"/></td>
                  <td valign="middle" class="buttonRight">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
        </table></td>
      <td colspan="4" class="default">&nbsp;</td>
    </tr>
  </form>
  {if $smQuotaEnabled eq 1}
  <tr>
    <td class="usage" colspan="5">&nbsp; {$smLabel.quota_usage_info}: {$smLabel.quota_usage_used} <b>{$smTotalUsed}</b> {$smLabel.quota_usage_of} <b>{$smQuotaLimit}</b> {$smLabel.quota_usage_avail}<br />
      <!-- <img src="inc/themes/hungi.mozilla/images/usage-start.gif" alt="" /> -->{$smUsageGraph}<!-- <img src="inc/themes/hungi.mozilla/images/usage-end.gif" alt="" /> --></td>
  </tr>
  {/if}
</table>
{include file=$footerTemplate} 
