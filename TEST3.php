<!DOCTYPE html>
<html>
<head>
<title>DocumentControl | TEST </title>
<link rel="stylesheet" type="text/css" href="DocConCSS.css">
</head>
<?php
require ("config.php");
?>
<div align="center">
<form action="/HRProprietary/HRCloud2/cloudCore.php" method="post" enctype="multipart/form-data">
  <p><input type="text" name='pdfworkSelected' id='pdfworkSelected' value="pdfworkSelected" multiple></p>
  <p><input type="text" name='pdfextension' id='pdfextension' value="extension"></p>
   <p><input type="text" name='userpdfconvertfilename' id='userpdfconvertfilename' value="userpdfconvertfilename"></p> 
    <p><input type="text" name='method1' id='method1' value="">method</p>
    <p><input type="text" name='pdfWork' id='pdfWork' value="">pdfWork</p>
    <p><input type="submit" value="submit" name='submit'></p>
  <input type="hidden" name="user_ID" value="<?php echo $AdmLogin;?>">

</form>
</div>
</div>
<hr />
</div>
</body>
</html>