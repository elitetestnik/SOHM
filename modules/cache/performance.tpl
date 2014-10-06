
<TABLE align='center' valign='middle' width='100%' height='100%' cellpadding=0 cellspacing=0 border=0>
<TR>
	<TD>
<TABLE style='border:15px white solid;background-color: #eeeeee;' align='center' valign='middle' cellpadding=0 cellspacing=0>
<TR>
	<TD>
<TABLE class='h3' style='border:1px gray solid;background-color: #eeeeee;'><TR><td colspan=2 align='right'><button onclick='javascript:hideInfo();'><IMG SRC='/images/del.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></button></td></TR>
<TR><TH colspan=2 class='h2'>Perfomance information&nbsp;№&nbsp;{PERF_ID}</TH>
</TR><TR><TD valign='top'  class='h1'>
<FORM METHOD='POST' ACTION="javascript:savePerform(xajax.getFormValues('perform'));" id='perform' name='perform' >
<INPUT TYPE='hidden' NAME='id_artist' id='id_artist' value='{ID_ARTIST}'>
<INPUT TYPE='hidden' NAME='id_promoter' id='id_promoter' value='{ID_PROMOTER}'>
<INPUT TYPE='hidden' NAME='perf_id' id='perf_id' value='{PERF_ID}'>
<INPUT TYPE='hidden' NAME='contract_id' id='contract_id' value='{CI}'>
<TABLE class='h3'>
<TR><TD valign='top'  class='h1'>
<TABLE width='99%'>
<TR><TD>Contract ID</TD><TD><INPUT TYPE='text' NAME='contract_id_' id='contract_id_' value='{CI}' disabled></TD></TR>
<TR><TD>Date of</TD><TD><INPUT TYPE='text' NAME='date_of' id='date_of' value='{DA}'>&nbsp;&nbsp;
<a href='#' onclick='javascript:cal1xx.select(document.getElementById("date_of"),"date_of","yyyy-MM-dd");return false;'  NAME='date_ofxx' ID='date_ofxx'><img src='images/itinerary-24x24.png'  align='absmiddle' border=0></a>&nbsp;&nbsp;<input type='checkbox' {FD} name='freeday' id='freeday' value='1' onclick="processScheduleFieldsState();">&nbsp;One day off</TD></TR>
<TR><TD>Capacity</TD><TD><INPUT TYPE='text' id="form_capacity" NAME='capacity' value='{CP}'></TD></TR>
<TR><TD>Promoter</td><td>{PL}</TD></TR>
</table><br /> <TABLE width='99%' style='border:1px gray solid;' id="form_venue">
<tr><th colspan=4 align='left'><strong>Venue</strong></th></tr>
<TR><TD>Name</TD><TD><INPUT TYPE='text' NAME='venue' value='{VE}'></TD><TD>City</TD><TD><INPUT TYPE='text' NAME='city' value='{CT}'></TD></TR>
<TR><TD>Country</TD><TD><INPUT TYPE='text' NAME='country' value='{CO}'></TD><TD>Street</TD><TD><INPUT TYPE='text' NAME='venue_street' value='{VSTREET}'></TD></TR>
<TR><TD>Phone</TD><TD><INPUT TYPE='text' NAME='venue_phone' value='{VPHONE}'></TD><TD>Email</TD><TD><INPUT TYPE='text' NAME='venue_email' value='{VEMAIL}'></TD></TR>
<!--<TR><TD>Link to map</TD><TD colspan=3><INPUT TYPE='text' NAME='venue_link' value='{VLINK}' size=50></TD></TR>
--></table><br /><TABLE width='99%' style='border:1px gray solid;'>
<tr><th colspan=4 align='left'><strong>HOTEL</strong></th></tr>
<TR><TD>Name</TD><TD><INPUT TYPE='text' NAME='hotel' value='{HT}'></TD><TD>City</TD><TD><INPUT TYPE='text' NAME='hotel_city' value='{HTCITY}'></TD></TR>
<TR><td colspan=2>&nbsp;</td><TD>Street</TD><TD><INPUT TYPE='text' NAME='hotel_street' value='{HTSTREET}'></TD></TR>
<TR><TD>Phone</TD><TD><INPUT TYPE='text' NAME='hotel_phone' value='{HTPHONE}'></TD><TD>Email</TD><TD><INPUT TYPE='text' NAME='hotel_email' value='{HTEMAIL}'></TD></TR>
<!--<TR><TD>Link to map</TD><TD colspan=3><INPUT TYPE='text' NAME='hotel_link' value='{HTLINK}' size=50></TD></TR>
--></table><br />
<TABLE width='99%'>
<TR><TD>Press conference</TD><TD><INPUT TYPE='text'  id="form_pressconf" NAME='pressconf' value='{PC}'>&nbsp;<font color='#777'>hh:mm (24hour)</font></TD></TR>
<TR><TD>Dinner time</TD><TD><INPUT TYPE='text'       id="form_dinner" NAME='dinner' value='{DINNER}'>&nbsp;<font color='#777'>hh:mm (24hour)</font></TD></TR>
<TR><TD>Get in time</TD><TD><INPUT TYPE='text'       id="form_getintime" NAME='getintime' value='{GI}'>&nbsp;<font color='#777'>hh:mm (24hour)</font></TD></TR>
<TR><TD>Sound check</TD><TD><INPUT TYPE='text'       id="form_soundcheck" NAME='soundcheck' value='{SC}'>&nbsp;<font color='#777'>hh:mm (24hour)</font></TD></TR>
<TR><TD>Doors open</TD><TD><INPUT TYPE='text'        id="form_doorsopen" NAME='doorsopen' value='{DO}'>&nbsp;<font color='#777'>hh:mm (24hour)</font></TD></TR>
<TR><TD>Concert start</TD><TD><INPUT TYPE='text'     id="form_onstage" NAME='onstage' value='{ONSTAGE}'>&nbsp;<font color='#777'>hh:mm (24hour)</font></TD></TR>
<!--<TR><TD>Concert start</TD><TD><INPUT TYPE='text' id="form_concert_start" NAME='concert_start' value='{CS}'>&nbsp;<font color='#777'>hh:mm (24hour)</font></TD></TR>-->
<TR><TD>Perfomace duration</TD><TD><INPUT TYPE='text' id="form_performance_duration" NAME='perf_duration' value='{PERF_DURATION}' />&nbsp;<font color='#777'>minutes</font></TD></TR>
<TR><TD>Comments</TD><TD><textarea name='ps' rows='5' cols='30'>{PS}</textarea></TD></TR>
<tr><td align='center' colspan=2>
<button value='Save' class='button'>Save</button>
<!--  -->
</td></tr>
</TABLE> </TD></TR></TABLE></FORM>
</TD></TR></TABLE>
</TD></TR></TABLE>
</TD></TR></TABLE>
