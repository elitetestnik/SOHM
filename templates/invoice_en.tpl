
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Expires" content="-1" />
  <title>{TITLE}</title>
  <style type="text/css">
/*<![CDATA[*/
  @media print {
    #print { display:none; visibility:none;}
  }

  /*]]>*/
  </style>
  <style type="text/css">
/*<![CDATA[*/
  body,html {margin:0px;padding:0;}
  p,span,td,h1,th,h2,h5 { font-family: Tahoma,Verdana,Arial; font-size: 9pt; font-weight: normal; }
  .f2 { font-family: "Arial Black", "Impact"; font-weight: 700;color:#777; }
  .p {margin:2px;line-height:120%;}
  .s10 { font-size:10pt;}
  .s9 { font-size:9pt;}
  .s8 { font-size:8pt;}
  .s7 { font-size:7pt;}
  .s24 { font-size:20pt;}
  #wrap { width: 752px; overflow: hidden; }
  table.t1 td { vertical-align: top;}
  .mt300 { margin-top: 300px; }
  .b { font-weight: bold; }
  h1 { font-size: 18pt; text-align: center; width: 99%; }
  h5 { font-size: 10pt; text-align: center; width: 99%; }
  .bc { border-collapse: collapse; }
  .bs { border: 1px #777 solid }
  .bg { background-color: #CCCCCC; }
  .ac { text-align: center; }
  .al { text-align: left; padding-left: 4em; }
  .ar { text-align: right;padding-right: 4em; }
  .al1 { text-align: left; padding-left: 1em; }
  .ar1 { text-align: right;padding-right: 1em; }
  .border_bottom_3px_solid_black{border-bottom:3px solid black;}
  /*]]>*/
  
  </style>
{SCRIPT2}
</head>

<body {SCRIPT}>
  <div id="print">
    <table width="752" border="0" cellpadding="0" cellspacing="0" align="center">
      <tr>
        <td align="right">{PRINTBUTTON}{SENDBUTTON}{LINKBUTTON}</td>
      </tr>
    </table>
  </div>

  <div id='wrap'>

    <table align="justify" width="99%" class='t1'>
      <tr>
              <td align='center'>
          <table border="0" cellpadding="2" cellspacing="0">
            <tr>
              <TD class='border_bottom_3px_solid_black'>&nbsp;<br><br></TD>
           
              <td rowspan="2" valign='middle' align='center'>
                <img src='../upload/image/logo2.png' width='200' height='60' align='absmiddle' border='0'>
                    <br> <span class='s8'>www.stenolav-management.no</span>
              </td>
              
              <TD class='border_bottom_3px_solid_black'>&nbsp;<br><br></TD>
            </tr>

            <tr>
              <td align='center'>
                <p class='p1 s9'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gamle Vormedalsveg 42&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
                5545 Vormedal<br />
                Norway</p>
              </td>

              <td align='center'>
                <p class='p1 s9'>Phone: +-47-977 11025<br />
                E-mail: post@stenolav-management.no<br />
                Org. nr. 881 348 012</p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
<table class='t1 b'>
      <tr>
               <td class=" s10">{PNAME}</td>
      </tr>

      <tr>
        <td class=" s10">Att: {PPERS}</td>
      </tr>

      <tr>
        <td class=" s10">{PADR1}</td>
      </tr>
      <tr>
        <td class="s10">{PADR2}</td>
      </tr>
      <tr>
        <td class=" s10">{PADR3}</td>
      </tr>
      <tr>
        <td class=" s10">{PCOUNTRY}</td>
      </tr>
    </table>
 <br />
 <br />
 <br />
 <br />
 <br />
 <br />
 <br />
    <h1>INVOICE&nbsp;{CONTRACT_NO}</h1>

    <h5>Date: {CONTRACT_DATE}</h5>

    <table class='t1 bc' cellpadding="7" cellspacing="0" width="50%">
      <tr>
        <td class='bg bs bc b'>Artist:</td>

        <td class='bs bc b'>{ARTIST}</td>
      </tr>
    </table><br />

    <table align="justify" width="99%" border="0">
      <tr>
        <td class='al1'>Terms:&nbsp;{TERMS}</td>

        <td class='ar1'>&nbsp;</td>
      </tr>
    </table>

    <p></p><br />

    <table align="justify" width="99%" class='bc' cellpadding="7">
      <tr>
		 <td class='b bc bg bs ac' width='60%'>ITEM</td>
		 <td class='b bc bg bs ac' width='33%'>AMOUNT</td>
	</tr>
      <tr>
        <td class='bc bs al'>Artist fee</td>

        <td class='bc bs ar'>{ARTIST_FEE}&nbsp;{CURRENCY}</td>
      </tr>

      <tr>
        <td class='bc bs al'>Travelling expenses</td>

        <td class='bc bs ar'>{TRAVEL_EXP}&nbsp;{CURRENCY}</td>
      </tr>

      <tr>
        <td class='bc bs al'>Productions expenses</td>

        <td class='bc bs ar'>{PROD_EXP}&nbsp;{CURRENCY}</td>
      </tr>

      <tr>
        <td class='bc bs al'>Administration expenses</td>

        <td class='bc bs ar'>{ADMIN_EXP}&nbsp;{CURRENCY}</td>
      </tr>

      <tr>
        <td class='bc bs al'>Other expenses</td>

        <td class='bc bs ar'>{OTHER_EXP}&nbsp;{CURRENCY}</td>
      </tr>

      <tr>
        <td class='b bc ar'>TOTAL AMOUNT PAYABLE THIS INVOICE</td>

        <td class='b bc ar bs bg'>{TOTAL_EXP}&nbsp;{CURRENCY}</td>
      </tr>
    </table>
<br />
<p class='s10'>Sten Olav Helgeland Management<br />
Bank info:<br />
Haugesund Sparebank<br />
Postboks 203<br />
5501 Haugesund<br />
Norway<br />
Account no.: 3240.05.20886<br />
IBAN:NO21 3240 0520 886<br />
BIC/SWIFT address:DNBANOKK</p>
<p>In case of late payment, it will be calculated default interest established by the Norwegian Ministry of Finance's current rates.</p>
<!--
    <p>For and on behalf of<br />
    Sten&nbsp;Olav&nbsp;Helgeland&nbsp;Management&nbsp;___________________________________<br /></p>
-->
  </div>
</body>
</html>
