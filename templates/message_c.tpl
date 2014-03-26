<form id='send_message' name='send_message' onsubmit='return check_this_form(this);' action="javascript:send_message(xajax.getFormValues('send_message'));">
<INPUT TYPE="hidden" name='id' id='id' value='{ID}'>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="1">
   <tr>
        <td width="53%" class="style4"><div align="left">Send message</div></td>
        <td width="47%" class="style4">&nbsp;</td>
    </tr>
    </table>
            <br>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#999999">
        <tr>
          <td bgcolor="#999999" class="style4"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">

              <tr>
                <td height="36" bgcolor="#FFFFFF" class="style17"><div id='selector_div' name='selector_div'>{SELECTOR}</div></td>
              </tr>
              <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">Subject:&nbsp;&nbsp;<INPUT TYPE="text" NAME="subject" id='subject' size='80' value="{SUBJECT}" required='1'></td>
              </tr>
              <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17"><div>{MESSAGE}</div><TEXTAREA NAME="message" id='message' style='display:none;'><STYLE type="text/css">
@media print {
   *, BODY {font-size: 10pt; line-height: 140%; background: #FFFFFF; color:black;}
   #print { display:none; visibility:none;}
   table.cont th {font-size: 10pt;color:black;border:0;padding:2px;text-align:left;}
   table.cont td {font-size: 10pt; color:black;}
   table { width:99%;font-size:10pt;}
   p {font-size: 10pt; line-height: 140%; background: #FFFFFF; color:black;}
   .head {font-size: 12pt; text-align:center; line-height: 140%; background: #FFFFFF; color:black;}
}
@media screen {
*, BODY {font-size: 10pt; line-height: 140%; background: #FFFFFF; color:black;}
table { width:800px;}
table.cont  {border-collapse:collapse; border:0; font-size:10pt;}
table.cont th {color: black;border:0;padding:3px;color:black; font-size:10pt;text-align:left;}
table.cont td {color:black; font-size:10pt;}
p {font-size: 10pt; line-height: 140%; background: #FFFFFF; color:black;}
.head {font-size: 12pt; text-align:center; line-height: 140%; background: #FFFFFF; color:black;}

}
</STYLE>
{MESSAGE}</textarea></td>
              </tr>
             <tr>
                <td height="36" colspan="4" bgcolor="#FFFFFF">&nbsp;&nbsp;{SUBMIT}</td>
              </tr>
          </table></td>
        </tr>
      </table><br />
</form>