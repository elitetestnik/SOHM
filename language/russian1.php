<?php
////////////////////////////////////////
//  ���� �� ������ ������������:
//  CMS "Mambo 4.5.2.3 Paranoia"
//  ���� �������: 06.08.2005
//  ������������ � ������������ ������
//  ����������� � ������ ������������:
//  - AndyR - mailto:andyr@mail.ru
//////////////////////////////////////
// �� �������� ������ ����:
$andyr_signature='Mambo_4523_Patanoia_012';
?>
<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/** common */
DEFINE('_LANGUAGE','ru');
DEFINE('_NOT_AUTH','� ��� ��� ���� ��� ��������� ����� �������.');
DEFINE('_DO_LOGIN','�� ������ ����� ��� ������������.');
DEFINE('_VALID_AZ09',"����������, ������� ��������� %s.  �� ������ ���� ��������, ������ ������� 0-9,a-z,A-Z � ����� ������ %d ��������.");
DEFINE('_CMN_YES',"��");
DEFINE('_CMN_NO',"���");
DEFINE('_CMN_SHOW',"��������");
DEFINE('_CMN_HIDE',"������");

DEFINE('_CMN_NAME',"���");
DEFINE('_CMN_DESCRIPTION',"��������");
DEFINE('_CMN_SAVE',"���������");
DEFINE('_CMN_CANCEL',"��������");
DEFINE('_CMN_PRINT',"������ ��� ������");
DEFINE('_CMN_PDF',"������ � ������� PDF");
DEFINE('_CMN_EMAIL',"��������� �� e-mail");
DEFINE('_ICON_SEP','|');
DEFINE('_CMN_PARENT',"��������");
DEFINE('_CMN_ORDERING',"�������");
DEFINE('_CMN_ACCESS',"������� �������");
DEFINE('_CMN_SELECT',"�����");

DEFINE('_CMN_NEXT',"���������");
DEFINE('_CMN_NEXT_ARROW',"&gt;&gt;");
DEFINE('_CMN_PREV',"����������");
DEFINE('_CMN_PREV_ARROW',"&gt;&gt;");

DEFINE('_CMN_SORT_NONE',"��� ����������");
DEFINE('_CMN_SORT_ASC',"�� �����������");
DEFINE('_CMN_SORT_DESC',"�� ��������");

DEFINE('_CMN_NEW',"��������");
DEFINE('_CMN_NONE',"���");
DEFINE('_CMN_LEFT',"����");
DEFINE('_CMN_RIGHT',"�����");
DEFINE('_CMN_CENTER',"�����");
DEFINE('_CMN_ARCHIVE','� �����');
DEFINE('_CMN_UNARCHIVE','�� ������'); DEFINE('_CMN_TOP','� (TOP)'); DEFINE('_CMN_BOTTOM','� (Bottom)');

DEFINE('_CMN_PUBLISHED',"������������");
DEFINE('_CMN_UNPUBLISHED',"��������������");

DEFINE('_CMN_EDIT_HTML','������������� HTML');
DEFINE('_CMN_EDIT_CSS','������������� CSS');

DEFINE('_CMN_DELETE','�������');

DEFINE('_CMN_FOLDER',"�������");
DEFINE('_CMN_SUBFOLDER',"����������");
DEFINE('_CMN_OPTIONAL',"�� �����������");
DEFINE('_CMN_REQUIRED',"�����������");

DEFINE('_CMN_CONTINUE',"����������");

DEFINE('_CMN_NEW_ITEM_LAST',"����� ������� ����� ���������");
DEFINE('_CMN_NEW_ITEM_FIRST','����� ������� ����� ������');
DEFINE('_LOGIN_INCOMPLETE','����������, ��������� ���� ������������ � ������.');
DEFINE('_LOGIN_BLOCKED','���� ������� ������ ���� �������������. �� ����� ��������� ���������� ����������� � �������������.');
DEFINE('_LOGIN_INCORRECT','������������ ��� ������������ (�����) ��� ������. ���������� ��� ���.');
DEFINE('_LOGIN_NOADMINS','�� �� ������ �����. �� ����� ��� ���������������.');
DEFINE('_CMN_JAVASCRIPT','!��������! ��� ���������� �������� ������ ���� �������� ��������� Java-Script.');

DEFINE('_NEW_MESSAGE','���� ����� ������ ���������');
DEFINE('_MESSAGE_FAILED','������������ ���������� �������� ��. ��������� �� ����������.');

DEFINE('_CMN_IFRAMES', '��������� �������� ����� ���� ��������� �����������. � ���������, ��� ������� �� ������������ Inline Frames');

DEFINE('_INSTALL_WARN','��� ����� �� ������������, ����������, ��������� ������� ���������� "installation", ������� ��� ����� � ������������� � ���, ����� - ������ �������� ��� ��������');
DEFINE('_TEMPLATE_WARN','<font color=\"red\"><b>����(�) ������������ ����� �� ������(�):</b></font>');
DEFINE('_NO_PARAMS','���������� ��� ���� ����� ���');
DEFINE('_HANDLER','�� ��������� ������� ��� ����');

/** mambots */
DEFINE('_TOC_JUMPTO',"������ ������");

/**  content */
DEFINE('_READ_MORE','���������...');
DEFINE('_READ_MORE_REGISTER','������ ��� ������������������ �������������...');
DEFINE('_MORE','���...');
DEFINE('_ON_NEW_CONTENT', "����� ������� ������� [ %s ]  � ��������� [ %s ]  �� ������� [ %s ]  � ���������  [ %s ]" );
DEFINE('_SEL_CATEGORY','�������� ���������');
DEFINE('_SEL_SECTION','�������� ������ (������)');
DEFINE('_SEL_AUTHOR','- ����� ������ -');
DEFINE('_SEL_POSITION','- ����� ������� -');
DEFINE('_SEL_TYPE','- ����� ���� -');
DEFINE('_EMPTY_CATEGORY','��������� ������ �����');
DEFINE('_EMPTY_BLOG','��� ��������� ��� �����������');
DEFINE('_NOT_EXIST','������������� �������� �� ����������.<br />����������, �������� ������ �������� �� �������� ����.');

/** classes/html/modules.php */
DEFINE('_BUTTON_VOTE','��!');
DEFINE('_BUTTON_RESULTS','�����');
DEFINE('_USERNAME','������������');
DEFINE('_LOST_PASSWORD','������ ������?');
DEFINE('_PASSWORD','������');
DEFINE('_BUTTON_LOGIN','�����');
DEFINE('_BUTTON_LOGOUT','�����');
DEFINE('_NO_ACCOUNT','�� �� ����������������.');
DEFINE('_CREATE_ACCOUNT','�����������');
DEFINE('_VOTE_POOR','������');
DEFINE('_VOTE_BEST','������');
DEFINE('_USER_RATING','�������');
DEFINE('_RATE_BUTTON','�������');
DEFINE('_REMEMBER_ME','��������� ����');

/** contact.php */
DEFINE('_ENQUIRY','��������');
DEFINE('_ENQUIRY_TEXT','��� ��������� ���� ���������� ����� ������ �������� �����');
DEFINE('_COPY_TEXT','��� ����� ������ ���������, ���������� ���� �������������� �����. <br>����: %s');
DEFINE('_COPY_SUBJECT','�����: ');
DEFINE('_THANK_MESSAGE','�������! ��������� ������� ����������.');
DEFINE('_CLOAKING','���� ����� e-mail ������� �� ����-�����. ����� ������� ���, � ��� ������ ���� ������� Java-Script');
DEFINE('_CONTACT_HEADER_NAME','���');
DEFINE('_CONTACT_HEADER_POS','���������');
DEFINE('_CONTACT_HEADER_EMAIL','e-mail');
DEFINE('_CONTACT_HEADER_PHONE','�������');
DEFINE('_CONTACT_HEADER_FAX','����');
DEFINE('_CONTACTS_DESC','���������� ���� ����� �����...');

/** classes/html/contact.php */
DEFINE('_CONTACT_TITLE','��������');
DEFINE('_EMAIL_DESCRIPTION','��������� ������ ����� ����������� ����:');
DEFINE('_NAME_PROMPT','������� ���� ���:');
DEFINE('_EMAIL_PROMPT',' ������� ��� e-mail:');
DEFINE('_MESSAGE_PROMPT',' ������� ����� ������ ���������:');
DEFINE('_SEND_BUTTON','���������');
DEFINE('_CONTACT_FORM_NC','����������, ��������� ����� ��������� � ���������.');
DEFINE('_CONTACT_TELEPHONE','�������: ');
DEFINE('_CONTACT_MOBILE','���.���.: ');
DEFINE('_CONTACT_FAX','����: ');
DEFINE('_CONTACT_EMAIL','e-mail: ');
DEFINE('_CONTACT_NAME','���: ');
DEFINE('_CONTACT_POSITION','���������: ');
DEFINE('_CONTACT_ADDRESS','�����: ');
DEFINE('_CONTACT_MISC','����������: ');
DEFINE('_CONTACT_SEL','�������� ����������:');
DEFINE('_CONTACT_NONE','��������� ������ ����������� ���� �� ������������.');
DEFINE('_EMAIL_A_COPY','��������� ����� ����� ������ �� ��� �����');
DEFINE('_CONTACT_DOWNLOAD_AS','���������� ��� ������� Download');
DEFINE('_VCARD','VCard-�����');

/** pageNavigation */
DEFINE('_PN_PAGE','��������');
DEFINE('_PN_OF','��');
DEFINE('_PN_START','� ������');
DEFINE('_PN_PREVIOUS','����������');
DEFINE('_PN_NEXT','���������');
DEFINE('_PN_END','� �����');
DEFINE('_PN_DISPLAY_NR','�������� #');
DEFINE('_PN_RESULTS','�����');

/** emailfriend */
DEFINE('_EMAIL_TITLE','�������� e-mail  �����');
DEFINE('_EMAIL_FRIEND','�������� �� e-mail ������ �� ��������.');
DEFINE('_EMAIL_FRIEND_ADDR','e-mail �����:');
DEFINE('_EMAIL_YOUR_NAME','���� ���:');
DEFINE('_EMAIL_YOUR_MAIL','��� e-mail:');
DEFINE('_SUBJECT_PROMPT',' ���� ������:');
DEFINE('_BUTTON_SUBMIT_MAIL','��������� e-mail');
DEFINE('_BUTTON_CANCEL','������');
DEFINE('_EMAIL_ERR_NOINFO','�� ������ ��������� ������ ���� e-mail � e-mail ���������� ����� ������.');
DEFINE('_EMAIL_MSG',' ������������! ��������� �������� � ����� "%s" �������� ��� %s ( %s ).

�� ������� ����������� � �� ���� ������: %s');
DEFINE('_EMAIL_INFO','������ ��������');
DEFINE('_EMAIL_SENT','������ �� ��� �������� ���������� ���');
DEFINE('_PROMPT_CLOSE','[������� ����]');

/** classes/html/content.php */
DEFINE('_AUTHOR_BY', ' �����');
DEFINE('_WRITTEN_BY', ' �������');
DEFINE('_LAST_UPDATED', '��������� ����������');
DEFINE('_BACK','[�����]');
DEFINE('_LEGEND','�������');
DEFINE('_DATE','����');
DEFINE('_ORDER_DROPDOWN','����������');
DEFINE('_HEADER_TITLE','��������');
DEFINE('_HEADER_AUTHOR','�����');
DEFINE('_HEADER_SUBMITTED','�����������');
DEFINE('_HEADER_HITS','����������');
DEFINE('_E_EDIT','�������������');
DEFINE('_E_ADD','��������');
DEFINE('_E_WARNUSER','����������, ������� [���������] ��� [������] ��� ������� ��������');
DEFINE('_E_WARNTITLE','�������� ������ ����� ��������');
DEFINE('_E_WARNTEXT','�������� ������ ����� ������� �����');
DEFINE('_E_WARNCAT','����������, �������� ���������');
DEFINE('_E_CONTENT','��������');
DEFINE('_E_TITLE','��������:');
DEFINE('_E_CATEGORY','���������:');
DEFINE('_E_INTRO','������� �����');
DEFINE('_E_MAIN','�������� �����');
DEFINE('_E_MOSIMAGE','�������� ��� {mosimage}');
DEFINE('_E_IMAGES','�������');
DEFINE('_E_GALLERY_IMAGES','������� ��������');
DEFINE('_E_CONTENT_IMAGES','������� � ������');
DEFINE('_E_EDIT_IMAGE','��������� �������');
DEFINE('_E_INSERT','��������');
DEFINE('_E_UP','����');
DEFINE('_E_DOWN','����');
DEFINE('_E_REMOVE','�������');
DEFINE('_E_SOURCE','�������� �����:');
DEFINE('_E_ALIGN','������������:');
DEFINE('_E_ALT','����� �������:');
DEFINE('_E_BORDER','�����:');
DEFINE('_E_APPLY','���������');
DEFINE('_E_PUBLISHING','����������');
DEFINE('_E_STATE','���������:');
DEFINE('_E_AUTHOR_ALIAS','��������� ������:');
DEFINE('_E_ACCESS_LEVEL','������� �������:');
DEFINE('_E_ORDERING','�������:');
DEFINE('_E_START_PUB','���� ������ ����������:');
DEFINE('_E_FINISH_PUB','���� ��������� ����������:');
DEFINE('_E_SHOW_FP','���������� �� ������� ��������:');
DEFINE('_E_HIDE_TITLE','������ ���������:');
DEFINE('_E_METADATA','����-������');
DEFINE('_E_M_DESC','��������:');
DEFINE('_E_M_KEY','�������� �����:');
DEFINE('_E_SUBJECT','����:');
DEFINE('_E_EXPIRES','���� ���������:');
DEFINE('_E_VERSION','������:');
DEFINE('_E_ABOUT','� ������');
DEFINE('_E_CREATED','���� ��������:');
DEFINE('_E_LAST_MOD','��������� ���������:');
DEFINE('_E_HITS','���������� ����������:');
DEFINE('_E_SAVE','���������');
DEFINE('_E_CANCEL','������');
DEFINE('_E_REGISTERED','������ ��� ������������������ �������������');
DEFINE('_E_ITEM_INFO','����������');
DEFINE('_E_ITEM_SAVED','������� ��������!');
DEFINE('_ITEM_PREVIOUS','&lt; ����.');
DEFINE('_ITEM_NEXT','����. &gt;');
DEFINE('_E_CAPTION','���������');

/** content.php */
DEFINE('_SECTION_ARCHIVE_EMPTY','� ��������� ����� �������� ������� � ���� ������� �� ����������. ���������� ����� �����');
DEFINE('_CATEGORY_ARCHIVE_EMPTY','� ��������� ����� �������� ������� � ���� ��������� �� ����������. ���������� ����� �����.');
DEFINE('_HEADER_SECTION_ARCHIVE','����� ��������');
DEFINE('_HEADER_CATEGORY_ARCHIVE','����� ���������');
DEFINE('_ARCHIVE_SEARCH_FAILURE','�� ������� �������� ������� ��� %s %s');	// ��������: �����, ����� ���
DEFINE('_ARCHIVE_SEARCH_SUCCESS','������� �������� ������ ��� %s %s');	// �����, ����� ���
DEFINE('_FILTER','������');
DEFINE('_ORDER_DROPDOWN_DA','���� - �� �����������');
DEFINE('_ORDER_DROPDOWN_DD','���� - �� ��������');
DEFINE('_ORDER_DROPDOWN_TA','��������� �� �����������');
DEFINE('_ORDER_DROPDOWN_TD','��������� �� ��������');
DEFINE('_ORDER_DROPDOWN_HA','���� �� �����������');
DEFINE('_ORDER_DROPDOWN_HD','���� �� ��������');
DEFINE('_ORDER_DROPDOWN_AUA','����� �� �����������');
DEFINE('_ORDER_DROPDOWN_AUD','����� �� ��������');
DEFINE('_ORDER_DROPDOWN_O','����������');

/** poll.php */
DEFINE('_ALERT_ENABLED','Cookies ������ ���� ���������!');
DEFINE('_ALREADY_VOTE','�� ��� ���������� � ���� ������!');
DEFINE('_NO_SELECTION','�� �� ������� ���� �����, ����������, ���������� ��� ���');
DEFINE('_THANKS','������� �� ���� ������� � ������!');
DEFINE('_SELECT_POLL','�������� ����� �� ������');

/** classes/html/poll.php */
DEFINE('_JAN','������');
DEFINE('_FEB','�������');
DEFINE('_MAR','����');
DEFINE('_APR','������');
DEFINE('_MAY','���');
DEFINE('_JUN','����');
DEFINE('_JUL','����');
DEFINE('_AUG','������');
DEFINE('_SEP','��������');
DEFINE('_OCT','�������');
DEFINE('_NOV','������');
DEFINE('_DEC','�������');
DEFINE('_POLL_TITLE','���������� ������');
DEFINE('_SURVEY_TITLE','�������� ������:');
DEFINE('_NUM_VOTERS','���������� ����������:');
DEFINE('_FIRST_VOTE','������ �����:');
DEFINE('_LAST_VOTE','��������� �����:');
DEFINE('_SEL_POLL','�������� �����:');
DEFINE('_NO_RESULTS','��� ������ �� ���������� ������.');

/** registration.php */
DEFINE('_ERROR_PASS','��������, ����� ������������ �� ������');
DEFINE('_NEWPASS_MSG','������� ������ ������������ $checkusername ������������� ����� ������ e-mail.\n'
.' ������������ $mosConfig_live_site ������ ������ �� ��������� ������ ������.\n\n'
.' ��� ����� ������: $newpass\n\n ���� �� �� ����������� ��������� ������, �� �����������.'
.' �����, ����� ��� �� ����� ������ ��� ���������. ���� ��� ��������� ������� ��������, ������ ������� '
.' �� ���� ��������� ����� ������ � ����� �������� ��� �� ������� ���.');
DEFINE('_NEWPASS_SUB','$_sitename :: ����� ������ ��� - $checkusername');
DEFINE('_NEWPASS_SENT','����� ������ ��� ������������ ������ � ���������!');
DEFINE('_REGWARN_NAME','����������, ������� ���� ��������� ���.');
DEFINE('_REGWARN_UNAME','����������, ������� ���� ��� ������������ (�����).');
DEFINE('_REGWARN_MAIL','����������, ������� ��������� ����� e-mail.');
DEFINE('_REGWARN_PASS','����������, ������� ��������� ������. ������ �� ������ ��������� �������, ��� ����� ������ ���� ������ 6 �������� � �������� ������ �� ���� (0-9) � ���������� ���� (a-z, A-Z)');
DEFINE('_REGWARN_VPASS1','����������, ��������� ������.');
DEFINE('_REGWARN_VPASS2','������ � ��� ������������� �� ���������, ����������, ���������� ��� ���.');
DEFINE('_REGWARN_INUSE','��� ��� ������������ ��� ������������. ����������, �������� ������.');
DEFINE('_REGWARN_EMAIL_INUSE','���� ����� e-mail ��� ������������. ����������, �������� ������.');
DEFINE('_SEND_SUB','������ � ����� ������������: %s �� ����� \'%s\'');
DEFINE('_USEND_MSG_ACTIVATE','������������, %s!
������� �� ����������� �� ����� \'%s\'. ��� ������� ������, �� ��������� � ���������, ����� ���, ��� �� ������� ������������ ����� ��� ��������������.

����� ������������ ��� �������, �� ������ ������ �������� ������ �� ���� ������
%s

����� ��������� �� ������ ����� �� ���� \'%s\', ��������� ��������� ������:
����� - %s
������ - %s
�� ��� ������ �� ���� ��������, ��� ��� ��� ������� ������������� � ������������� ������ ��� �����������.

----------------
� ���������,
����������.');

DEFINE('_USEND_MSG', "������������, %s,
������� �� ����������� �� ����� \'%s\'.
������ �� ������ ����� �� ���� \'%s\', ��������� ��������� ���� ����� ������");

DEFINE('_USEND_MSG_NOPASS','������������ $name,\n\n�� ���� ��������� ��� ������������ �� $mosConfig_live_site.\n'
.'�� ������ ������ ����� �� $mosConfig_live_site � ������ � �������, ���������� ���� ��� �����������.\n\n'
.'���������� �� ��������� �� ��� ������ �.�. ��� ������������� ������������� ������ ��� ������ �����������.\n');

DEFINE('_ASEND_MSG','������������, ����� ����� \'%s\'!

����� ������������ ����������������� �� ����� ����� -  \'%s\'.

��� ������ �������� ������ � ������������:
��������� ��� - %s
e-mail - %s
����� - %s

�� ��� ������ �� ���� ��������, ��� ��� ��� ������� ������������� � ������������� ������ ��� �����������.

----------------
� ���������,
���������� ������ �����.');

DEFINE('_REG_COMPLETE_NOPASS','<div class="componentheading">Registration Complete!</div><br />&nbsp;&nbsp;'
.'You may now login.<br />&nbsp;&nbsp;');
DEFINE('_REG_COMPLETE', '<div class="componentheading">����������� ���������!</div><br />������ �� ������ ����� �� ����, ��� ������������.');
DEFINE('_REG_COMPLETE_ACTIVATE', '<div class="componentheading">����������� ���������!</div><br />��� ������� ������ � �� ��������� ���� e-mail ���������� ���������� �� ��������� ������ ��������. <br /> ������ ��������, - � ������ ������, �� ������� ��� ������ ����� �������.');
DEFINE('_REG_ACTIVATE_COMPLETE', '<div class="componentheading">��������� ���������!</div><br />��� ������� ��� ������� �����������.<br />������ �� ������ ����� �� ����, ��������� ��������� ���� ����� � ������.');
DEFINE('_REG_ACTIVATE_NOT_FOUND', '<div class="componentheading">������������ ������ ��� ���������!!!</div><br />��������� ������� �� ��������������� ��� ��������� ������� �������� ��� �����������.');

/** classes/html/registration.php */
DEFINE('_PROMPT_PASSWORD','������ ������?');
DEFINE('_NEW_PASS_DESC','����������, ������� ���� ��� ������������ (�����) � ����� e-mail, ����� ������� ������ [��������� ������].<br />'
.'������ �� �������� ��� ����� ������ �� �����. ����������� ��� ����� ������ ��� ����� �� ����.');
DEFINE('_PROMPT_UNAME','������������:');
DEFINE('_PROMPT_EMAIL','����� e-mail:');
DEFINE('_BUTTON_SEND_PASS','��������� ������');
DEFINE('_REGISTER_TITLE','�����������');
DEFINE('_REGISTER_NAME','���� ���:');
DEFINE('_REGISTER_UNAME','�����:');
DEFINE('_REGISTER_EMAIL','e-mail:');
DEFINE('_REGISTER_PASS','������:');
DEFINE('_REGISTER_VPASS','������������� ������:');
DEFINE('_REGISTER_REQUIRED','���� �� ���������� (*) ����������� � ����������.');
DEFINE('_BUTTON_SEND_REG','������������������');
DEFINE('_SENDING_PASSWORD','��� ������ ����� ��������� �� ��������� ���� ����� e-mail.<br />����� �� �������� ������,'
.' �� ������� ����� �� ���� � �������� ���� ������ � ����� ������.');

/** classes/html/search.php */
DEFINE('_SEARCH_TITLE','�����');
DEFINE('_PROMPT_KEYWORD','����� �� �������� �����');
DEFINE('_SEARCH_MATCHES','������ %d ����������');
DEFINE('_CONCLUSION','����� ������� $totalRows ����������. ����� <b>$searchword</b> � ������� ');
DEFINE('_NOKEYWORD','������ �� �������');
DEFINE('_IGNOREKEYWORD','� ������ ���� ��������� ��������');
DEFINE('_SEARCH_ANYWORDS','����� �����');
DEFINE('_SEARCH_ALLWORDS','��� �����');
DEFINE('_SEARCH_PHRASE','������ ����������');
DEFINE('_SEARCH_NEWEST','����� - ������');
DEFINE('_SEARCH_OLDEST','������ - ������');
DEFINE('_SEARCH_POPULAR','����������');
DEFINE('_SEARCH_ALPHABETICAL','�� ��������');
DEFINE('_SEARCH_CATEGORY','������/���������');

/** templates/*.php */
DEFINE('_ISO','charset=Windows-1251');
DEFINE('_DATE_FORMAT','d-m-Y');  //Uses PHP's DATE Command Format - Depreciated
/**
* Modify this line to reflect how you want the date to appear in your site
*
*e.g. DEFINE("_DATE_FORMAT_LC","%A, %d %B %Y %H:%M"); //Uses PHP's strftime Command Format
*/
DEFINE('_DATE_FORMAT_LC',"%d-%m-%Y"); //Uses PHP's strftime Command Format
DEFINE('_DATE_FORMAT_LC2'," %d-%m-%Y %H:%M");
DEFINE('_SEARCH_BOX','�����...');
DEFINE('_NEWSFLASH_BOX','����������!');
DEFINE('_MAINMENU_BOX','������� ����');

/** classes/html/usermenu.php */
DEFINE('_UMENU_TITLE','���� ������������');
DEFINE('_HI','������������, ');

/** user.php */
DEFINE('_SAVE_ERR','����������, ��������� ��� ����.');
DEFINE('_THANK_SUB','������� �� ��� ��������. ������ �������� ����� ���������� \n ��������������� ����� ����������� �� �����.');
DEFINE('_UP_SIZE','�� �� ������ ��������� ����� �������� ������ ��� 15��.');
DEFINE('_UP_EXISTS','������� � ������ $userfile_name ��� ����������. ����������, �������� �������� ����� � ���������� ��� ���.');
DEFINE('_UP_COPY_FAIL','������ ��� �����������');
DEFINE('_UP_TYPE_WARN','�� ������ ��������� ������ ����������� � ������� gif ��� jpg.');
DEFINE('_MAIL_SUB','����� �������� �� ������������');
DEFINE('_MAIL_MSG','������������ $adminName,\n\n����� �������� � ������ $type � ��������� $title ���������� $author'
.' ��� ����� $mosConfig_live_site.\n'
.'����������, ������� � ������ �������������� $mosConfig_live_site ��� ��������� � ���������� ��� � $type.\n\n'
.'�� ��� ������ �� ���� ��������, ��� ��� ��� ������� ������������� � ������������� ������ ��� �����������\n\n

----------------
� ���������,
���������� ������ �����.');
DEFINE('_PASS_VERR1','���� �� ������� �������� ������, ����������, ������� ��� ��� ��� ��� ������������� ���������.');
DEFINE('_PASS_VERR2','���� �� ������ �������� ������, ����������, �������� ��������, ��� ������ � ��� ������������� ������ ���������.');
DEFINE('_UNAME_INUSE','������������ � ����� ������� ��� ����.');
DEFINE('_UPDATE','��������');
DEFINE('_USER_DETAILS_SAVE','���� ������ ���������.');
DEFINE('_USER_LOGIN','���� ������������');

/** components/com_user */
DEFINE('_EDIT_TITLE','������ ������');
DEFINE('_YOUR_NAME','��������� ���:');
DEFINE('_EMAIL','����� e-mail:');
DEFINE('_UNAME','��� ������������ (�����):');
DEFINE('_PASS','������:');
DEFINE('_VPASS','������������� ������:');
DEFINE('_SUBMIT_SUCCESS','��� �������� ������!');
DEFINE('_SUBMIT_SUCCESS_DESC','���� ���������� ������� ���������� ��������������. ����� ���������, ��� �������� ����� ����������� �� ���� �����');
DEFINE('_WELCOME','����� ����������!');
DEFINE('_WELCOME_DESC','����� ���������� � ��� ������ ������ ������ �����');
DEFINE('_CONF_CHECKED_IN','��� \'�� �����������\' �������� ������ ����� ������ \'�����������\'.');
DEFINE('_CHECK_TABLE','�������� �������');
DEFINE('_CHECKED_IN','��������� ');
DEFINE('_CHECKED_IN_ITEMS',' ��������');
DEFINE('_PASS_MATCH','������ �� ���������');

/** components/com_banners */
DEFINE('_BNR_CLIENT_NAME','������� ��� ��� �������.');
DEFINE('_BNR_CONTACT','�������� ���������� ���� ��� ����� �������.');
DEFINE('_BNR_VALID_EMAIL','������� �������� e-mail ��� �������.');
DEFINE('_BNR_CLIENT','�� ������ ������� �������,');
DEFINE('_BNR_NAME','��������� ����� ������� ���.');
DEFINE('_BNR_IMAGE','�������� ����������� ���� ��� ����� �������.');
DEFINE('_BNR_URL','������� URL ��� ��� ��� ����� �������.');

/** components/com_login */
DEFINE('_ALREADY_LOGIN','�� ��� ��������������!');
DEFINE('_LOGOUT','������� ����� ��� ���������� ������');
DEFINE('_LOGIN_TEXT','����������� ���� ������������ � ������ ��� ������� � �����');
DEFINE('_LOGIN_SUCCESS','���������� ����� ���! �� ������� ����� �� ����, ��� ������������.');
DEFINE('_LOGOUT_SUCCESS','�� �����. �� ��������!');
DEFINE('_LOGIN_DESCRIPTION','��� ��������� ������� � �������� �������� �����, ����������, �������������/�����������������.');
DEFINE('_LOGOUT_DESCRIPTION','��� ������ ������ �� �������� ������� �����');


/** components/com_weblinks */
DEFINE('_WEBLINKS_TITLE','������');
DEFINE('_WEBLINKS_DESC','� ������ ������� ������� �������� ���������� � �������� ������ � ����.'
.' <br />�������� �� ������ ���� ���� �� ��������, ����� �������� ������ ������.');
DEFINE('_HEADER_TITLE_WEBLINKS','������');
DEFINE('_SECTION','������:');
DEFINE('_SUBMIT_LINK','��������� ������');
DEFINE('_URL','URL:');
DEFINE('_URL_DESC','��������:');
DEFINE('_NAME','���:');
DEFINE('_WEBLINK_EXIST','���-������ � ����� ������ ��� ����������. �������� ��� � ���������� ��� ���.');
DEFINE('_WEBLINK_TITLE','���-������ ������ ����� ��������.');

/** components/com_newfeeds */
DEFINE('_FEED_NAME','��������� �����');
DEFINE('_FEED_ARTICLES','���-�� ������');
DEFINE('_FEED_LINK','������ �� �����');

/** whos_online.php */
DEFINE('_WE_HAVE', '������ �� �����:<br />');
DEFINE('_AND', ' � ');
DEFINE('_GUEST_COUNT','������ - $guest_array<br />');
DEFINE('_GUESTS_COUNT','������ - $guest_array<br />');
DEFINE('_MEMBER_COUNT','������������� - $user_array');
DEFINE('_MEMBERS_COUNT','������������� - $user_array');
DEFINE('_ONLINE',' ');
DEFINE('_NONE','����������� ���.');

/** modules/mod_stats.php */
DEFINE('_TIME_STAT','�����');
DEFINE('_MEMBERS_STAT','����������');
DEFINE('_HITS_STAT','�����������');
DEFINE('_NEWS_STAT','��������');
DEFINE('_LINKS_STAT','������');
DEFINE('_VISITORS','�����������');

/** /adminstrator/components/com_menus/admin.menus.html.php */
DEFINE('_MAINMENU_HOME','* 1-�  ���������� � ���� ���� [mainmenu] - �������� �� ��������� `Homepage` ��� ����� *');
DEFINE('_MAINMENU_DEL','* �� �� ������ ������� ��� ���� �.�. ��� ��������� ��� ���������� ������ ����� *');
DEFINE('_MENU_GROUP','* �������� `Menu Types` appear in more than one group *');


/** administrators/components/com_users */
DEFINE('_NEW_USER_MESSAGE_SUBJECT', '����������� � ����� ������������' );
DEFINE('_NEW_USER_MESSAGE', '������������, %s,

�� ���� ��������� ��� ������������ �� ���� %s ���������������.
���� - ���� ���������������� ������ ��� ����� �� %s:

����� - %s
������ - %s (����� �������� � "������ ����������")

�� ��� ������ �� ����� ��������. ��� �������������� ������������� � ������� ��� ������ ��� �����������.

----------------
� ���������,
���������� �����.');


/** administrators/components/com_massmail */
DEFINE('_MASSMAIL_MESSAGE', "������ � ����� '%s'

���������:
" );

?>
