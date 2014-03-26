<TABLE align='center' valign='middle' width='100%' height='100%' cellpadding=0 cellspacing=0 border=0>
<TR>
	<TD>
<TABLE style='border:15px white solid;background-color: #eeeeee;' align='center' valign='middle' cellpadding=0 cellspacing=0>
<TR>
	<TD>
<TABLE class='h3' style='border:1px gray solid;background-color: #eeeeee;'><TR><td colspan=2 align='right'><button onclick='javascript:hideInfo();'><IMG SRC='/images/del.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></button></td></TR>
<TR><TH colspan=2 class='h2'>Choose mailing list to save search results to</TH>
</TR><TR><TD valign='top'  class='h1'>
<FORM METHOD=POST name='list_form' id='list_form' onsubmit='return check_this_form(this);' ACTION="javascript:export_list_save(xajax.getFormValues('list_form'));">
<input type="hidden" name='type' value="{TYPE}" />
<input type="hidden" name='id' value="{ID}" />
<input type="hidden" name='search' value="{SEARCH}" />
<input type="hidden" name='weeknum' value="{WEEKNUM}" />
<input type="hidden" name='country' value="{COUNTRY}" />
<input type="hidden" name='town' value="{TOWN}" />
<TABLE class='h3'><TR><TD valign='top'  class='h1'><TABLE width='99%'>
<TR><TD>Choose&nbsp;maillist</TD><TD>{LIST_ID}</TD></TR>
<TR id='newlistname' ><TD>New&nbsp;list&nbsp;name</TD><TD><input name="list_name" value="" size="30"/></TD></TR>
</TABLE></TD></TR><tr><td align='center' colspan=2>
<input type='submit' value='Save' class='button'></td></tr></TABLE></FORM>
</TD></TR></TABLE></TD></TR></TABLE></TD></TR></TABLE>