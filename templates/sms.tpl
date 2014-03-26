<table width="95%" border="0" align="center" cellpadding="0" cellspacing="1">
   <tr>
        <td width="53%" class="style4"><div align="left">Send SMS</div></td>
        <td width="47%" class="style4">&nbsp;</td>
    </tr>
    </table>

            <br>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#999999">
        <tr>
          <td bgcolor="#999999" class="style4">
          <form id='send_message' name='send_message' method="post"  action="javascript:send_sms(xajax.getFormValues('send_message'));">
           <INPUT TYPE="hidden" name='id' id='id' value='{ID}'>
          <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">

              <tr>
                <td height="36" bgcolor="#FFFFFF" class="style17"><div id='selector_div' name='selector_div'>{SELECTOR}</div></td>
              </tr>
             <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">
                <div id='message_cont'>

                <textarea NAME="message_txt" id='message_txt' cols='80' rows="5" onkeypress="checkSymbol(event)" onkeyup="checkSymbol(event)" onpaste="checkStr()" onclick="checkStr()" maxlength="160">{MESSAGE}</textarea>
                 </div>
                 <div id='symbol' style='font-size:11px; color:#555;'>Symbols left:&nbsp;<span id="symbols">160</span></div>
                </td>
              </tr>
              <tr>
                <td height="36" colspan="4" bgcolor="#FFFFFF">&nbsp;&nbsp;{SUBMIT}</td>
              </tr>
          </table>

          </form>

                    </td>
        </tr>
      </table>