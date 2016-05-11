<link href="../css.css" rel="stylesheet" type="text/css" />
   <style type="text/css">
<!--
.style35 {color: #000000}
-->
   </style>
   <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1">
   <tr>
        <td width="53%" class="style4"><div align="left">Artist N&deg;{ID}</div></td>
        <td width="47%" class="style4">&nbsp;</td>
    </tr>
    </table>
            <br>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#999999">
        <tr>
          <td bgcolor="#999999" class="style4"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">

              <tr>
                <td width="20%" height="36" bgcolor="#FFFFFF" class="style17"><div align="left">Artist</div></td>
                <td width="29%" bgcolor="#FFFFFF" class="style17"><div align="left" class="style35">{COMPANY}</div></td>
                <td width="18%" height="36" bgcolor="#FFFFFF" class="style17"><div align="left"><p>City code </p></div></td>
                <td bgcolor="#FFFFFF" class="style17"><div align="left" class="style34">{CITYCODE}</div></td>
              </tr>

              <tr>
                <td bgcolor="#FFFFFF" class="style17"><div align="left"><p>Contact person </p></div></td>
                <td bgcolor="#FFFFFF" class="style17"><div align="left" class="style34">{CONTACTPERSON}</div></td>
                <td width="18%" height="36" bgcolor="#FFFFFF" class="style17"><div align="left">
                <p>Town </p></div></td>
                <td bgcolor="#FFFFFF" class="style17"><div align="left" class="style34">{TOWN}</div></td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF" class="style17"><div align="left"><p>Street address 1 </p>
                </div></td>
                <td bgcolor="#FFFFFF" class="style17"><div align="left" class="style34">{ADDR1}</div></td>
                <td height="36" bgcolor="#FFFFFF" class="style17"><div align="left">
                    <p>Country </p>
                </div></td>
                <td bgcolor="#FFFFFF" class="style17"><div align="left" class="style34">{COUNTRY}</div></td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF" class="style17"><div align="left">
                    <p>Street address 2 </p>
                </div></td>
                <td bgcolor="#FFFFFF" class="style17"><div align="left" class="style34">{ADDR2}</div></td>
                <td height="36" bgcolor="#FFFFFF" class="style17"><div align="left">
                    <p>Local phone </p>
                </div></td>
                <td bgcolor="#FFFFFF" class="style17"><div align="left" class="style34">{PHONE1}</div></td>
              </tr>
              <tr>
                <td height="36" bgcolor="#FFFFFF" class="style17"><div align="left">
                    <p>Email </p>
                </div></td>
                <td bgcolor="#FFFFFF" class="style17"><div align="left" class="style34"><a href="#" onclick="javascript:message_form(0,1,{ID});" class="style11">{EMAIL}</a></div></td>
                <td height="36" bgcolor="#FFFFFF" class="style17"><div align="left">
                    <p>Cell phone </p>
                </div></td>
                <td bgcolor="#FFFFFF" class="style17"><div align="left" class="style34">{PHONE2}</div></td>
              </tr>
              <tr>
                <td height="36" bgcolor="#FFFFFF" class="style17"><div align="left">
                    <p>Website</p>
                </div></td>
                <td bgcolor="#FFFFFF" class="style17"><div align="left" class="style34"><a href="//{WWW}">{WWW}</a></div></td>
                <td height="36" bgcolor="#FFFFFF" class="style17">&nbsp;</td>
                <td width="16%" bgcolor="#FFFFFF" class="style34">&nbsp;</td>
              </tr>
              <tr>
                <td height="36" bgcolor="#FFFFFF" class="style17"><div align="left">
                    <p>Agency</p>
                </div></td>
                <td bgcolor="#FFFFFF" class="style17"><div align="left" class="style34">{AGENCY}</div></td>
                <td height="36" bgcolor="#FFFFFF" class="style17">Agent</td>
                <td width="16%" bgcolor="#FFFFFF" class="style34">{AGENT}</td>
              </tr>

              <tr>
                <td height="36" bgcolor="#FFFFFF" class="style17"><p align="left">Our comments</p></td>
                <td height="36" colspan="3" bgcolor="#FFFFFF" class="style17"><div name='our_comment' id='our_comment' class="style34">{COMMENTS}</div></td>
              </tr>

              <tr>
                <td height="36" colspan="4" bgcolor="#FFFFFF"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;
                <a href='#' onclick="javascript:add_our_comment({ID},'artists');"><img src="images/comment-add-24x24.png"  align="absmiddle" border=0></a>
                &nbsp;<a href='#' onclick="javascript:add_our_comment({ID},'artists');" class="style11">Add our comments</a>&nbsp;&nbsp;&nbsp;<a  class='style17' href='#bottom' onclick="javascript:viewSchedule({ID},'{TODAY}','{TODAY}');"><IMG SRC='images/right.gif' BORDER='0' align='absmiddle'></a>&nbsp;<a  class='style11' href='#bottom' onclick="javascript:viewSchedule({ID},'{TODAY}','{TODAY}');">Show artist itinerary</a>&nbsp;&nbsp;<a href='#' onclick='javascript:add_contract(0,{ID});'  class='style11'><img src="images/doc.gif" width="20" height="20"  border=0 align="absmiddle"></a>&nbsp;<a href='#' onclick='javascript:add_contract(0,{ID});'  class='style11'>New contract</a>&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/doc.gif" width="20" height="20" border=0 align="absmiddle">Archive&nbsp;&nbsp;&nbsp;&nbsp;</span><a href='#' onclick='javascript:message_form(0,3,{ID});'><img src="images/forward-new-mail-24x24.png" border=0 align="absmiddle"></a>&nbsp;<a href='#' class="style11" onclick='javascript:message_form(0,1,{ID});'>Send message</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' onclick="javascript:sms_form(0,1,{ID});" class='style11'><img src="images/right.gif" width="21" height="21" align="absmiddle"></a>&nbsp;<a href='#' onclick="javascript:sms_form(0,1,{ID});" class='style11'>Send SMS</a></div></td>
              </tr>
          </table></td>
        </tr>
      </table>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1">
      <tr><td height="36"><a {BACK}><img src='images/back-24x24.png' align='absmiddle' border=0></a>&nbsp;<a {BACK} class='style17'>Back</a></td></tr></table>
      <br />
<div id='sch_info' name='sch_info' style='display:none;'>&nbsp;</div>
<div id='opt_info' name='opt_info' style='display:none;'>&nbsp;</div>
<div id='perf_info' name='perf_info' style='display:none;'>&nbsp;</div>
