<table width="95%" border="0" align="center" cellpadding="0" cellspacing="1">
   <tr>
        <td width="53%" class="style4"><div align="left">Send message</div></td>
        <td width="47%" class="style4">&nbsp;</td>
    </tr>
    </table>

            <br>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#999999">
        <tr>
          <td bgcolor="#999999" class="style4">
          <form id='send_message' name='send_message' method="post"  action="javascript:send_message(xajax.getFormValues('send_message'));">
           <INPUT TYPE="hidden" name='id' id='id' value='{ID}'>
          <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">

              <tr>
                <td height="36" bgcolor="#FFFFFF" class="style17"><div id='selector_div' name='selector_div'>{SELECTOR}</div></td>
              </tr>
              <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">Subject:&nbsp;&nbsp;<INPUT TYPE="text" NAME="subject" id='subject' size='80' value="{SUBJECT}" required='1'></td>
              </tr>
             <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">Template:&nbsp;&nbsp;{TEMPLATE}</td>
              </tr>
              <tr>
                <td  height="36" bgcolor="#FFFFFF" class="style17">
                <div id='message_cont'>
               <TEXTAREA NAME="message" id='message' ROWS="30" COLS="80" class="ckeditor" > Dear %USERNAME% {MESSAGE}</TEXTAREA>                
				</div>
                </td>
              </tr>
               <tr>
                <td height="36" colspan="4" bgcolor="#FFFFFF"><input type="hidden" name='filenames' id="filenames" value="">Attached files<div id='attachedfiles'>&nbsp;</div></td>
              </tr>
               <tr>
                <td height="36" colspan="4" bgcolor="#FFFFFF">&nbsp;&nbsp;{SUBMIT}</td>
              </tr>
          </table>

          </form>
          <table width='100%' bgcolor='white'><tr><td><div id="container">
                <form action="modules/upload.php{MSG_ID}" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" >
                     <p id="f1_upload_process">Loading...<br/><img src="images/loader.gif" /><br/></p>
                     <p id="f1_upload_form" align="center"><br/>
                         <label class='style34'>Attach file:
                              <input name="myfile" type="file" size="30" />
                         </label>
                         <label>
                             <input type="submit" name="submitBtn" class="sbtn" value="Upload" />
                         </label>
                     </p>

                     <iframe id="upload_target" name="upload_target" src="" style="width:0;height:0;border:0px solid #fff;"></iframe>
                 </form>
             </div></td>
        </tr>
      </table>
          </td>
        </tr>
      </table>