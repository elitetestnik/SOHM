<div>
  <style type="text/css">
 input.c5 {padding:0 0 0 30px; border:0; background-image:url(images/save-accept-24x24.png);background-repeat:no-repeat;background-color:white;text-decoration:underline;cursor:hand;}
  table.c4 {background-color: #999999}
  td.c3 {background-color: #999999}
  td.c2 {background-color: #FFFFFF}
  div.c1 {text-align: left}
  </style>
 <!-- -->
    <div><a href='{LINK}'><img src='images/back-24x24.png' align='middle' border=
      "0" alt=""/></a> <a href='{LINK}' class='style17'>Back</a>
    </div>
    <form name='add_cont2' id='add_cont2' method='POST' onsubmit='check_this_form(this)' action='{ACTION}'><input type='hidden' name='id' id='id' value='{ID_CONTRACT}' />

    <table class="c4" width='95%' border='0' align='center' cellpadding='0' cellspacing='1'>
      <tr>
        <td class='style4 c3'>
          <table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
            <tr>
              <td width='20%' height='36' class='style17 c2'>
                <div class="c1">
                  Contract date
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='contract_date' id='contract_date' type='text' size='12' maxlength=
                  '20' required='required' value='{CONTRACT_DATE}' />  <a href='#' onclick=
                  'javascript:cal1xx.select(document.getElementById("contract_date"),"contract_datexx","yyyy-MM-dd");return false;'
                  name='contract_datexx' id='contract_datexx'><img src='images/itinerary-24x24.png'
                  align='middle' border="0"  alt=""/></a>
                </div>
              </td>

              <td width='18%' height='36' class='style17 c2'>
                <div class="c1">
                  Promoter
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input type='hidden' name='id_promoter' id='id_promoter' value=
                  '{ID_PROMOTER}' /><input name='promoter' id='promoter' readonly='readonly' size=
                  '30' value='{PROMOTER}' />
                </div>
              </td>
            </tr>

            <tr>
              <td width='20%' height='36' class='style17 c2'>
                <div class="c1">
                  Contract в„–
                </div>
              </td>

              <td width='29%' class='style17 c2'>
                <div class='style34 c1'>
                  <input name='contract_no' required="" id='contract_no' type='text' size='10'
                  maxlength='20' value="{CONTRACT_NO}" />
                </div>
              </td>

              <td width='18%' height='36' class='style17 c2'>
                <div class="c1">
                  Contact person
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='contact_person' id='contact_person' value='{CONTACT_PERSON}' size=
                  "30" />
                </div>
              </td>
            </tr>

            <tr>
              <td class='style17 c2'>
                <div class="c1">
                  Artist
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input type='hidden' name='id_artist' id='id_artist' value=
                  '{ID_ARTIST}' /><input name='artist' id='artist' readonly="readonly" size='30'
                  value='{ARTIST}' />
                </div>
              </td>

              <td width='18%' height='36' class='style17 c2'>
                <div class="c1">
                  Town
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='town' id='town' value='{TOWN}' size="30" />
                </div>
              </td>
            </tr>

            <tr>
              <td class='style17 c2'>
                <div class="c1">
                  Concert date
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='concert_date' id='concert_date' type='text' size='12' maxlength='20'
                  required='1' value='{CONCERT_DATE}' /> <a href='#' onclick=
                  'javascript:cal2xx.select(document.getElementById(\"concert_date\"),\"concert_datexx\",\"yyyy-MM-dd\");return false;'
                  name='concert_datexx' id='concert_datexx'><img src='images/itinerary-24x24.png'
                  align='middle' border="0" alt=""/></a>
                </div>
              </td>

              <td height='36' class='style17 c2'>
                <div class="c1">
                  Address
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='address' id='address' value='{ADDRESS}' size="30" />
                </div>
              </td>
            </tr>

            <tr>
              <td class='style17 c2'>
                <div class="c1">
                  Venue
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='venue' id='venue' size='30' required="" value='{VENUE}' />
                </div>
              </td>

              <td height='36' class='style17 c2'>
                <div class="c1">
                  Local phone
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='phone1' id='phone1' value='{PHONE1}' size="30" />
                </div>
              </td>
            </tr>

            <tr>
              <td height='36' class='style17 c2'>
                <div class="c1">
                  Capacity
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='capacity' id='capacity' value='{CAPACITY}' size='30' />
                </div>
              </td>

              <td height='36' class='style17 c2'>
                <div class="c1">
                  Cell phone
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='phone2' id='phone2' value='{PHONE2}' size="30" />
                </div>
              </td>
            </tr>

            <tr>
              <td height='36' class='style17 c2'>
                <div class="c1">
                  Art of performance
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='art_of_perf' id='art_of_perf' value='ART_OF_PERF' size='30' />
                </div>
              </td>

              <td height='36' class='style17 c2'>
                <div class="c1">
                  E-mail
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='email' id='email' value='{EMAIL}' size='30' />
                </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </form>
    <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>
      <tr>
        <td width='53%' class='style4'>
          <div class='style5 c1'>
            Performance:
          </div>
        </td>

        <td width='47%' class='style4'> </td>
      </tr>
    </table>

    <table class="c4" width='95%' border='0' align='center' cellpadding='0' cellspacing='1'>
      <tr>
        <td class='style4 c3'>
          <table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
            <tr>
              <td class='style17 c2'>
                <div class="c1">
                  Press conf.
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='presconf' id='presconf' value='{PRESCONF}' size='30' />
                </div>
              </td>

              <td width='18%' height='36' class='style17 c2'>
                <div class="c1">
                  Dinner time
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='dinner' id='dinner' value='{DINNER}' size='30' />
                </div>
              </td>
            </tr>

            <tr>
              <td width='20%' height='36' class='style17 c2'>
                <div class="c1">
                  Get in time
                </div>
              </td>

              <td width='29%' class='style17 c2'>
                <div class='style34 c1'>
                  <input name='acc_to_stage' id='acc_to_stage' value='{ACC_TO_STAGE}' size='30' />
                </div>
              </td>

              <td width='18%' height='36' class='style17 c2'>
                <div class="c1">
                  Sound check
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='soundcheck' id='soundcheck' value='{SOUNDCHECK}' size='30' />
                </div>
              </td>
            </tr>

            <tr>
              <td class='style17 c2'>
                <div class="c1">
                  Doors open
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='doorsopen' id='doorsopen' value='{DOORSOPEN}' size='30' />
                </div>
              </td>

              <td width='18%' height='36' class='style17 c2'>
                <div class="c1">
                  Concert start
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='concert_start' id='concert_start' value='{CONCERT_START}' size=
                  '30' />
                </div>
              </td>
            </tr>

            <tr>
              <td class='style17 c2'>
                <div class="c1">
                  Perform. duration
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='perf_duration' id='perf_duration' value='{PERF_DURATION}' size=
                  '30' />
                </div>
              </td>

              <td height='36' class='style17 c2'>
                <div class="c1">
                  Publicity
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='publicity' id='publicity' value='{PUBLICITY}' size='30' />
                </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>
      <tr>
        <td width='53%' class='style4'>
          <div class='style5 c1'>
            The promoter have to pay for the following:
          </div>
        </td>

        <td width='47%' class='style4'> </td>
      </tr>
    </table>

    <table class="c4" width='95%' border='0' align='center' cellpadding='0' cellspacing='1'>
      <tr>
        <td class='style4 c3'>
          <table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
            <tr>
              <td width='20%' height='36' class='style17 c2'>
                <div class="c1">
                  Artist fee
                </div>
              </td>

              <td width='29%' class='style17 c2'>
                <div class='style34 c1'>
                  <input name='artist_fee' id='artist_fee' required="" value='{ARTIST_FEE}' size=
                  '30' onblur='javascript:calculate_fee();' />
                </div>
              </td>

              <td width='18%' height='36' class='style17 c2'>
                <div class="c1">
                  Administration expenses
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='admin_exp' id='admin_exp' required="" value='{ADMIN_EXP}' size='30'
                  onblur='javascript:calculate_fee();' />
                </div>
              </td>
            </tr>

            <tr>
              <td class='style17 c2'>
                <div class="c1">
                  Productions expenses
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='production_exp' id='production_exp' required="" value=
                  '{PRODUCTION_EXP}' size='30' onblur='javascript:calculate_fee();' />
                </div>
              </td>

              <td width='18%' height='36' class='style17 c2'>
                <div class="c1">
                  Other expenses
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='other_exp' id='other_exp' required="" value='{OTHER_EXP}' size='30'
                  onblur='javascript:calculate_fee();' />
                </div>
              </td>
            </tr>

            <tr>
              <td class='style17 c2'>
                <div class="c1">
                  Travelling expenses
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='travel_exp' id='travel_exp' required="" value='TRAVEL_EXP' size='30'
                  onblur='javascript:calculate_fee();' />
                </div>
              </td>

              <td height='36' class='style17 c2'>
                <div class="c1">
                  Total expenses
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='total_exp' id='total_exp' required="" value='{TOTAL_EXP}' size=
                  '30' />
                </div>
              </td>
            </tr>

            <tr>
              <td class='style17 c2' colspan="2"></td>

              <td height='36' class='style17 c2'>
                <div class="c1">
                  Currency abbr.
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='currency' id='currency' required='required' value='{CURRENCY}' size=
                  '30' />
                </div>
              </td>
            </tr>

            <tr>
              <td height='36' class='style17 c2' colspan='2'>
                <div class="c1">
                  The artist fee have to pay as follows
                </div>
              </td>

              <td class='style17 c2' colspan='2'>
                <div class='style34 c1'>
                  <input name='pay_follows' id='pay_follows' value='{PAY_FOLLOWS}' size='30' />
                </div>
              </td>
            </tr>

            <tr>
              <td height='36' class='style17 c2' colspan='2'>
                <div class="c1">
                  Other expenses that have to be payed by the promoter
                </div>
              </td>

              <td class='style17 c2' colspan='2'>
                <div class='style34 c1'>
                  <input name='exp_prom_other' id='exp_prom_other' value='{EXP_PROM_OTHER}' size=
                  '30' />
                </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>
      <tr>
        <td width='53%' class='style4' colspan="2">
          <div class='style5 c1'>
            Sound company:
          </div>
        </td>
      </tr>
    </table>

    <table class="c4" width='95%' border='0' align='center' cellpadding='0' cellspacing='1'>
      <tr>
        <td class='style4 c3'>
          <!--  <div id='sound_info' name='sound_info'>   -->

          <table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
            <tr>
              <td width='20%' height='36' class='style17 c2'>
                <div class="c1">
                  Sound company
                </div>
              </td>

              <td width='29%' class='style17 c2'>
                <div class='style34 c1'>
                  <input name='sound_name' id='sound_name' value='{SOUND_NAME}' size='30' />
                </div>
              </td>

              <td width='18%' height='36' class='style17 c2'>
                <div class="c1">
                  Cell phone
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='sound_phone2' id='sound_phone2' value='{PHONE2}' size='30' />
                </div>
              </td>
            </tr>

            <tr>
              <td class='style17 c2'>
                <div class="c1">
                  Contact person
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='sound_contact' id='sound_contact' value='{SOUND_CONTACT}' size=
                  '30' />
                </div>
              </td>

              <td width='18%' height='36' class='style17 c2'>
                <div class="c1">
                  E-mail
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='sound_email' id='sound_email' value='{SOUND_EMAIL}' size='30' />
                </div>
              </td>
            </tr>

            <tr>
              <td class='style17 c2'>
                <div class="c1">
                  Phone
                </div>
              </td>

              <td class='style17 c2'>
                <div class='style34 c1'>
                  <input name='sound_phone1' id='sound_phone1' value='{SOUND_PHONE1}' size='30' />
                </div>
              </td>

              <td height='36' class='style17 c2'> </td>

              <td class='style17 c2'> </td>
            </tr>
          </table><!--</div>    -->
        </td>
      </tr>
    </table>

    <table class="c4" width='95%' border='0' align='center' cellpadding='0' cellspacing='1'>
      <tr>
        <td class='style4 c3'>
          <table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
            <tr>
              <td width='92%' height='36' class='style17 c2'>
                <div class="c1">
                  One signed copy should be returned in (days)
                </div>
              </td>

              <td width='8%' class='style17 c2' align='center' valign='middle'><input name=
              'issue_date' id='issue_date' size='10' value='{ISSUE_DATE}' /></td>
            </tr>
          </table>
        </td>
      </tr>
    </table><br />

    <table class="c4" width='95%' border='0' align='center' cellpadding='0' cellspacing='1'>
      <tr>
        <td class='style4 c3'>
          <table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
            <tr>
              <td class="c2" height='36'>
                <div class="c1" id='savebt'>
                      <input type='submit' value='Save' class='style17 c5' align=
                  'middle' /><a href=
                  '{LIVE_SITE}/modules/contract.php?lang=no&amp;id={ID_CONTRACT}' title=
                  'Print contract' target='_blank'><img src='images/printbutton.png' border="0"
                  align='middle' width='24' height='24' alt=""/></a>   <a href=
                  '{LIVE_SITE}/modules/contract.php?lang=no&amp;id={ID_CONTRACT}' title=
                  'Print contract' target='_blank' class='style17'>Print</a>     <a href=
                  '{LIVE_SITE}/modules/contract.php?lang=en&amp;id={ID_CONTRACT}' title=
                  'Print english version' target='_blank' class='style17'><img src=
                  'images/printbutton.png' width='24' height='24' border="0" align=
                  'middle'  alt=""/></a>  <a href=
                  '{LIVE_SITE}/modules/contract.php?lang=en&amp;id={ID_CONTRACT}' title=
                  'Print english version' target='_blank' class='style17'>Print ENG</a>   
                  <a href='#' onclick=
                  'javascript:message_form_contract(0,2,{ID_PROMOTER},0,{ID_CONTRACT});'><img src=
                  'images/forward-new-mail-24x24.png' border="0" align='middle'  alt=""/></a> 
                  <a href='#' onclick=
                  'javascript:message_form_contract(0,2,{ID_PROMOTER},0,{ID_CONTRACT});' class=
                  'style17'>Send via email [EN]</a>   <a href='#' onclick=
                  'javascript:message_form_contract(0,2,{ID_PROMOTER},1,{ID_CONTRACT});'><img src=
                  'images/forward-new-mail-24x24.png' border="0" align='middle'  alt=""/></a> <a href=
                  '#' onclick=
                  'javascript:message_form_contract(0,2,{ID_PROMOTER},1,{ID_CONTRACT});' class=
                  'style17'>Send via email [NO]</a>    <a href=
                  '{LIVE_SITE}/modules/itn.php?id={ID_CONTRACT}' title='Print itinerary' target=
                  '_blank'><img src='images/printbutton.png' border="0" align='middle' width=
                  '24' height='24'  alt=""/></a>  <a href='{LIVE_SITE}/modules/itn.php?id={ID_CONTRACT}'
                  title='Print itinerary' target='_blank' class='style17'>Print itinerary</a>
                </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>


</div>