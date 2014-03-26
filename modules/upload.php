<?php
if( 1==1) {
if (!defined('_VALID_MOS')) define( '_VALID_MOS', 1 );
require_once("../config.php");
require_once($mosConfig_absolute_path."/globals.php" );
if (isset ($_REQUEST['msg_id']))
{$destination_path = $mosConfig_absolute_path ."/attachments/".$_REQUEST['msg_id']."/";

if (!is_dir($destination_path)) { @mkdir($destination_path,0777);}}

else $destination_path = $mosConfig_absolute_path ."/"."attachments"."/";
$fileup=$attfile="";
   $result = 0;

   $target_path = $destination_path . basename( $_FILES['myfile']['name']);

   if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
      @chmod($target_path,0666);
      $result = 1;
      $fileup=$_FILES['myfile']['name']; $attfile=$target_path;
   }
 }
   sleep(1);
?>
<script language="javascript" type="text/javascript">
window.top.window.showAttach(<?php echo "'".$fileup."','".$attfile."'"; ?>);
window.top.window.stopUpload(<?php echo $result; ?>);
</script>
