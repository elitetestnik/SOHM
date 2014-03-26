
<style type="text/css">
 table.c6 {border:15px white solid;background-color: #eeeeee;}
 table.c5 {border:1px gray solid;background-color: #eeeeee;}
 a.c4 {display:none;}
 a.c3 {margin-left:5px;display:none;}
 input.c2 {display:none;}
 a.c1 {margin-left:5px;}
</style>

  <table align='center' valign='middle' width='100%' height='100%' cellpadding="0" cellspacing="0"
  border="0">
    <tr>
      <td>
        <table class='c6' align='center' valign='middle' cellpadding="0" cellspacing="0">
          <tr>
            <td>
              <table class='h3 c5'>
                <tr>
                  <td colspan="2" align='right'><button onclick='javascript:hideInfo2();'><img src=
                  '/images/del.gif' width='20' height='20' border='0' alt=''></button></td>
                </tr>

                <tr>
                  <th colspan="2" class='h2'>{TITLE}</th>
                </tr>

                <tr>
                  <td valign='top' class='h1'>
                    <form method="post" action=
                    "javascript:save_inquiry(xajax.getFormValues('add_inq'));" name='add_inq' id=
                    'add_inq'>
                      <input type='hidden' name='id' value='{ID}'>

                      <table>
                        <tr>
                          <td>Artist</td>

                          <td>{ID_ARTIST}</td>

                          <td>Town</td>

                          <td><input type='text' name='town' id='town' size='20' value=
                          '{TOWN}'></td>
                        </tr>

                        <tr>
                          <td>Date</td>

                          <td nowrap><input type='text' name='venue_date' id='venue_date' size='20'
                          value='{VENUE_DATE}'> <a href='#' onclick=
                          'javascript:cal1xx.select(document.getElementById("venue_date"),"anchor1xx","yyyy-MM-dd");return false;'
                          name='anchor1xx' id='anchor1xx'><img src='../images/itinerary-24x24.png'
                          align='absmiddle' border="0"></a></td>

                          <td>Country</td>

                          <td><input type='text' name='country' id='country' size='20' value=
                          '{COUNTRY}'></td>
                        </tr>

                        <tr>
                          <td>Promoter</td>

                          <td>
                            {SELECTOR} <a href='#' onclick='javascript:swap_promoters(1)' id=
                            'link_new' class='c1' name="link_new">new</a> <input type='text' name=
                            'company' id='company' size='20' class='c2' value='{COMPANY}'><a href=
                            '#' onclick='javascript:swap_promoters(0)' id='link_old' class='c3'
                            name="link_old">existed</a><br>
                            <a id='check_link' class='c4' href='#' onclick=
                            "javascript:check_name(document.getElementById('company').value,'promoters',0,'get_promoter_data');"
                            name="check_link">check name</a><br>

                            <div id='check_results' name='check_results'></div>
                          </td>

                          <td>Local phone</td>

                          <td><input type='text' name='phone1' id='phone1' size='20' value=
                          '{PHONE1}'></td>
                        </tr>

                        <tr>
                          <td>Contact person</td>

                          <td><input type='text' name='contact_person' id='contact_person' size=
                          '20' value='{CONTACT_PERSON}'></td>

                          <td>Cell phone</td>

                          <td><input type='text' name='phone2' id='phone2' size='20' value=
                          '{PHONE2}'></td>
                        </tr>

                        <tr>
                          <td>Street address 1</td>

                          <td><input type='text' name='address1' id='address1' size='20' value=
                          '{ADDRESS1}'></td>

                          <td>Email</td>

                          <td><input type='text' name='email' id='email' size='20' value=
                          'EMAIL'></td>
                        </tr>

                        <tr>
                          <td>Street address 2</td>

                          <td><input type='text' name='address2' id='address2' size='20' value=
                          '{ADDRESS2}'></td>

                          <td>Website</td>

                          <td><input type='text' name='www' size='20' id='www' value='{WWW}'></td>
                        </tr>

                        <tr>
                          <td>City code</td>

                          <td><input type='text' name='city_code' id='city_code' size='20' value=
                          '{CITY_CODE}'></td>

                          <td> </td>

                          <td> </td>
                        </tr>

                        <tr>
                          <td>Comments</td>

                          <td colspan="3">
                          <textarea name='comments' id='comments' rows='4' cols='48'>
{COMMENTS}
</textarea></td>
                        </tr>

                        <tr>
                          <td>Artist fee</td>

                          <td><input name='artist_fee' id='artist_fee' required="" value=
                          '{ARTIST_FEE}' size='10' onblur='javascript:calculate_fee();' onkeyup=
                          'javascript:calculate_fee();'></td>

                          <td>Admin. exp.</td>

                          <td><input name='admin_exp' id='admin_exp' required="" value=
                          '{ADMIN_EXP}' size='10' onblur='javascript:calculate_fee();' onkeyup=
                          'javascript:calculate_fee();'></td>
                        </tr>

                        <tr>
                          <td>Productions exp.</td>

                          <td><input name='production_exp' id='production_exp' required="" value=
                          '{PRODUCTION_EXP}' size='10' onblur='javascript:calculate_fee();'
                          onkeyup='javascript:calculate_fee();'></td>

                          <td>Other exp.</td>

                          <td><input name='other_exp' id='other_exp' required="" value=
                          '{OTHER_EXP}' size='10' onblur='javascript:calculate_fee();' onkeyup=
                          'javascript:calculate_fee();'></td>
                        </tr>

                        <tr>
                          <td>Travel exp.</td>

                          <td><input name='travel_exp' id='travel_exp' required="" value=
                          '{TRAVEL_EXP}' size='10' onblur='javascript:calculate_fee();' onkeyup=
                          'javascript:calculate_fee();'></td>

                          <td>Total exp.</td>

                          <td><input name='total_exp' id='total_exp' required="" value=
                          '{TOTAL_EXP}' size='10'></td>
                        </tr>

                        <tr>
                          <td colspan="2"> </td>

                          <td>Currency abbr.</td>

                          <td><input name='currency' id='currency' required="" value='{CURRENCY}'
                          size='10'></td>
                        </tr>

                        <tr>
                          <td colspan="4" align='center'><input value='Save' type='button'></td>
                        </tr>
                      </table>
                    </form>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
