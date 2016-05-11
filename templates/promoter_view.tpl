
<link href="../css.css" rel="stylesheet" type="text/css" />
    <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1">
   <tr>
        <td width="53%" class="style4"><div align="left">Promoter N&deg;{ID}</div></td>
        <td width="47%" class="style4">&nbsp;</td>
  </tr>
    </table>
            <br>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#999999">
        <tr>
          <td bgcolor="#999999" class="style4"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">

              <tr>
                <td width="20%" height="36" bgcolor="#FFFFFF" class="style17">Promoter</td>
                <td width="29%" bgcolor="#FFFFFF" class="style17 style32"> {COMPANY} {PRIORITY} </td>
                <td width="18%" height="36" bgcolor="#FFFFFF" class="style17">Genre of music &nbsp;</td>
                <td bgcolor="#FFFFFF" class="style17 style34">{TYPEMUSIC}&nbsp;</td>
              </tr>

              <tr>
                <td bgcolor="#FFFFFF" class="style17">Contact person</td>
                <td bgcolor="#FFFFFF" class="style17 style34">{CONTACTPERSON}</td>
                <td width="18%" height="36" bgcolor="#FFFFFF" class="style17">City code</td>
                <td bgcolor="#FFFFFF" class="style17 style34">{CITYCODE}</td>
              </tr>
              <tr>
                <td width="18%" height="36" bgcolor="#FFFFFF" class="style17">Town</td>
                <td bgcolor="#FFFFFF" class="style17 style34">{TOWN}</td>
                <td width="18%" height="36" bgcolor="#FFFFFF" class="style17">Location</td>
                <td bgcolor="#FFFFFF" class="style17 style34">{LOCATION}</td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF" class="style17">Street address 1</td>
                <td bgcolor="#FFFFFF" class="style17  style34">{ADDR1}</td>
                <td height="36" bgcolor="#FFFFFF" class="style17">Country</td>
                <td bgcolor="#FFFFFF" class="style17 style34">{COUNTRY}</td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF" class="style17">Street address 2</td>
                <td bgcolor="#FFFFFF" class="style17 style34">{ADDR2}</td>
                <td height="36" bgcolor="#FFFFFF" class="style17">Local phone</td>
                <td bgcolor="#FFFFFF" class="style17 style34">{PHONE1}</td>
              </tr>
              <tr>
                <td height="36" bgcolor="#FFFFFF" class="style17">E-mail</td>
                <td bgcolor="#FFFFFF" class="style34">{EMAIL}</td>
                <td height="36" bgcolor="#FFFFFF" class="style17">Cell phone</td>
                <td bgcolor="#FFFFFF" class="style17 style34">{PHONE2}</td>
              </tr>
              <tr>
                <td height="36" bgcolor="#FFFFFF" class="style17">Website</td>
                <td bgcolor="#FFFFFF" class="style17 style34">{WWW}</td>
                <td height="36" bgcolor="#FFFFFF" class="style17">Week number</td>
                <td width="16%" bgcolor="#FFFFFF" class="style34">{WEEKNUM}</td>
              </tr>

              <tr>
                <td height="36" bgcolor="#FFFFFF" class="style17">Our comments</td>
                <td height="36" colspan="1" bgcolor="#FFFFFF" class="style17" ><div name='our_comment' id='our_comment' class="style34"><span  style='cursor:pointer;cursor:hand;' onclick="javascript:add_our_comment2({ID});">{COMMENTS}&nbsp;</span></div></td>
                <td height="36" bgcolor="#FFFFFF" class="style17">Capacity</td>
                <td width="16%" bgcolor="#FFFFFF" class="style34">{CAPACITY}</td>
            </tr>

              <tr>
                <td height="36" colspan="4" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;
                <a href='#' onclick="javascript:add_our_comment2({ID});"><img src="images/comment-add-24x24.png"  width="20" height="20" align="absmiddle"></a>
                &nbsp;<a href='#' onclick="javascript:add_our_comment2({ID});" class="style11">Add our comments</a>&nbsp;&nbsp;&nbsp;
                      <a href='#' onclick='javascript:add_contract({ID},0);' class='style11'><img src="images/note-edit-24x24.png" align="absmiddle"></a>&nbsp;
                      <a href='#' onclick='javascript:add_contract({ID},0);'  class='style11'>Add contract</a>&nbsp;&nbsp;&nbsp;
                      <a href='#' onclick='javascript:editinquiryInfo(0,{ID});' class='style11'><img src="images/note-edit-24x24.png" align="absmiddle"></a>&nbsp;
                      <a href='#' onclick='javascript:editinquiryInfo(0,{ID});'  class='style11'>Add inquiry</a>&nbsp;&nbsp;&nbsp;&nbsp;
                      <a href='#' onclick ='var list = document.getElementById("archive"); if (list.style.display == "none"){list.style.display = "block";}else{list.style.display = "none";}' class='style11'><img src="images/doc.gif" width="20" height="20" align="absmiddle">Archive</a>&nbsp;&nbsp;&nbsp;&nbsp;
                      <a href='#' onclick="javascript:message_form(0,2,{ID});" ><img src="images/forward-new-mail-24x24.png" border=0 align="absmiddle"></a>&nbsp;
                      <a href='#' onclick="javascript:message_form(0,2,{ID});" class="style11">Send message</a>&nbsp;&nbsp;&nbsp;&nbsp;
                      <a href='#' onclick="javascript:sms_form(0,2,{ID});" ><img src="images/forward-new-mail-24x24.png" border=0 align="absmiddle"></a>&nbsp;
                      <a href='#' onclick="javascript:sms_form(0,2,{ID});" class='style11'>Send SMS</a>
                </div></td>
              </tr>

              <tr>
                <td colspan=4>
                  <div id="archive" style="display:none">
                    <div style="background-color:white; margin: 5px; padding:5px; border-radius:5px;">
                        {EMAILS}
                    </div>
                    
                    <div style="background-color:white; margin: 5px; padding:5px; border-radius:5px;">
                        {SMSS}
                    </div>
                  </div>  
                </td>
              </tr>

          </table></td>
        </tr>
      </table>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1">
      <tr><td height="36"><a {BACK}><img src='images/back-24x24.png' align='absmiddle' border=0></a>&nbsp;<a {BACK} class='style17'>Back</a></td></tr></table>
      <hr>
      <input name="address" id="address" type="textbox" size="40" value="{COUNTRY}, {TOWN}"/>
      <input name="geocode" id="geocode" type="textbox" size="40" value="{COORDS}"/>
      <input type="button" value="Get geo" onclick="codeAddress()">
      <input id="savebutton" type="button" value="Save geo" onclick="javascript:promoter_save_geo({ID},document.getElementById('geocode').value);">

      <div id="map_canvas" style="height:600px;top:5px"></div>