<form id='save_settings' name='save_settings' onsubmit='return check_this_form(this);' action="javascript:save_settings(xajax.getFormValues('save_settings'));">
<INPUT TYPE="hidden" name='id' id='id' value='{ID}'>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="1">
   <tr>
        <td width="53%" class="style4"><div align="left">Settings </div></td>
        <td width="47%" class="style4">&nbsp;</td>
    </tr>
    </table>
            <br>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#999999">
        <tr>
          <td bgcolor="#999999" class="style4"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
<tr><td height='36' class='style18'>Setting name</td><td class='style18'>Value</td><td class='style18'>Description</td></tr>
			  <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">Company Name</td>
				<td height="36" bgcolor="#FFFFFF" class="style17">
				<INPUT TYPE="text" NAME="company_name" id='company_name' size='80' value="{COMPANY_NAME}" required='1'></td>
				<td height="36" bgcolor="#FFFFFF" class="style11">Used in messages (sent from)
				</td>
			  </tr>
			  <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">Email</td>
				<td height="36" bgcolor="#FFFFFF" class="style17">
				<INPUT TYPE="text" NAME="email" id='company_name' size='80' value="{EMAIL}" required='1' email='1'></td>
				<td height="36" bgcolor="#FFFFFF" class="style11">Used in messages (sent from address). All messages sent from this server will be from this address (Company Name &lt;email&gt;)
				</td>
			  </tr>
			  <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">Signee</td>
				<td height="36" bgcolor="#FFFFFF" class="style17">
				<INPUT TYPE="text" NAME="underwriter" id='underwriter' size='80' value="{UNDERWRITER}" required='1'></td>
				<td height="36" bgcolor="#FFFFFF" class="style11">Used in contracts (Contract signee)
				</td>
			  </tr>
			  <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">Bank Account</td>
				<td height="36" bgcolor="#FFFFFF" class="style17">
				<INPUT TYPE="text" NAME="bankaccount" id='bankaccount' size='80' value="{BANKACCOUNT}" required='1'></td>
				<td height="36" bgcolor="#FFFFFF" class="style11">Used in contracts (Bank account info)
				</td>
			  </tr>
			  <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">E-mail message footer</td>
				<td height="36" bgcolor="#FFFFFF" class="style17">
				<textarea name="footer1" id='footer1' rows="10" cols="60">{FOOTER1}</textarea></td>
				<td height="36" bgcolor="#FFFFFF" class="style11">Used in messages (message footer)
				</td>
			  </tr>
			  <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">Optional footer</td>
				<td height="36" bgcolor="#FFFFFF" class="style17">
				<textarea name="footer2" id='footer2' rows="10" cols="60">{FOOTER2}</textarea></td>
				<td height="36" bgcolor="#FFFFFF" class="style11">Used in contract
				</td>
			  </tr>
		  <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">Lists lenght</td>
				<td height="36" bgcolor="#FFFFFF" class="style17">
				<INPUT TYPE="text" NAME="perpage" id='perpage' size='80' value="{PERPAGE}" required='1'></td>
				<td height="36" bgcolor="#FFFFFF" class="style11">List items count per page (Artist, Promoters, Inquiries, etc.)
				</td>
			  </tr>
              <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">Start Page</td>
				<td height="36" bgcolor="#FFFFFF" class="style17">
                <select name='start_id'>{START_ID}</select></td>
				<td height="36" bgcolor="#FFFFFF" class="style11">First page displayed after login
				</td>
			  </tr>
			 <tr>
                <td height="36" colspan="4" bgcolor="#FFFFFF">&nbsp;&nbsp;{SUBMIT}</td>
              </tr>
          </table></td>
        </tr>
      </table><br />
</form>
 