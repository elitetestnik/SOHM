<form id='send_message' name='send_message' onsubmit='return check_this_form(this);' action="javascript:save_message_template(xajax.getFormValues('send_message'));">
<INPUT TYPE="hidden" name='id' id='id' value='{ID}'>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="1">
   <tr>
        <td width="53%" class="style4"><div align="left">Edit message template</div></td>
        <td width="47%" class="style4">&nbsp;</td>
    </tr>
    </table>
            <br>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#999999">
        <tr>
          <td bgcolor="#999999" class="style4"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">

              <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">From:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="text" NAME="from_name" id='from_name' size='80' value="{FROM_NAME}" required='1'></td>
              </tr>
              <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">From email:&nbsp;&nbsp;<INPUT TYPE="text" NAME="from_email" id='from_email' size='80' value="{FROM_EMAIL}" required='1'></td>
              </tr>
              <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">Subject:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="text" NAME="subject" id='subject' size='80' value="{SUBJECT}" required='1'></td>
              </tr>
              <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">Html version of letter<TEXTAREA NAME="message" id='message' ROWS="30" COLS="80" >{MESSAGE}</TEXTAREA>

                </td>
              </tr>
              <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">Text version of letter <small>(need if you want to pass spam filers)</small><br /><TEXTAREA NAME="message_text" id='message_text' ROWS="8" COLS="80" >{MESSAGE_TEXT}</TEXTAREA>

                </td>
              </tr>
             <tr>
                <td height="36"  bgcolor="#FFFFFF"><table><tr><td><a {BACK}><img src='images/back-24x24.png' align='absmiddle' border=0></a>&nbsp;<a {BACK} class='style17'>Back</a></td><td>{SUBMIT}</td></tr></table></td>
              </tr>
          </table></td>
        </tr>
      </table><br />
</form>