<TABLE align='center' valign='middle' width='100%' height='100%' cellpadding=0 cellspacing=0 border=0>
<TR>
	<TD>
<TABLE style='border:15px white solid;background-color: #eeeeee;' align='center' valign='middle' cellpadding=0 cellspacing=0>
<TR>
	<TD>
<TABLE class='h3' style='border:1px gray solid;background-color: #eeeeee;'><TR><td colspan=2 align='right'><button onclick='javascript:hideInfo();'><IMG SRC='/images/del.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></button></td></TR>
<TR><TH colspan=2 class='h2'>Add link to database</TH>
</TR><TR><TD valign='top'  class='h1'>
<FORM METHOD=POST name='link_form' id='link_form' onsubmit='return check_this_form(this);' ACTION="javascript:links_save(xajax.getFormValues('link_form'));">
<input type="hidden" name='link_id' value="{ID}" />
<TABLE class='h3'><TR><TD valign='top'  class='h1'><TABLE width='99%'>
<TR ><TD>Link&nbsp;name</TD><TD>
<input name="link_name" value="{NAME}" size="30"/></TD></TR>
<TR ><TD>Link&nbsp;URL</TD><TD>
<input name="link_url" value="{URL}" size="30"/></TD></TR>
</TABLE></TD></TR><tr><td align='center' colspan=2>
<input type='submit' value='Save' class='button'></td></tr></TABLE></FORM>
</TD></TR></TABLE></TD></TR></TABLE></TD></TR></TABLE>