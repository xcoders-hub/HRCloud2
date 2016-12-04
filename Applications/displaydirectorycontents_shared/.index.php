<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="./.favicon.ico">
   <title>HRCLoud2 | Shared Files Viewer</title>

   <link rel="stylesheet" href="./.style.css">
<script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
   <script src="./.sorttable.js"></script>
<script type="text/javascript">
function goBack() {
  window.history.back(); }
</script>
</head>
<body>
<div id="container">
<div align="center"><h3>HRCloud2 Shared Files</h3></div>
<div align="center" style="margin-bottom:10px;"><form><input type='submit' name="refresh" id="refresh" value='&#x21BA' href="#" class="submitsmall" onclick="toggle_visibility('loadingCommandDiv');"></form></div>

<table class="sortable">
  <thead>
	<tr>
	  <th>Filename</th>
	  <th>Type</th>
	  <th>Un-Share</th>
	  <th>Size</th>
	  <th>Date Modified</th>
	</tr>
	  </thead>
	  <tbody><?php
if (!file_exists('/var/www/html/HRProprietary/HRCloud2/config.php')) {
  echo nl2br('</head>ERROR!!! HRC2Index19, Cannot process the HRCloud2 configuration file (config.php).'."\n"); 
  die (); }
else {
  require('/var/www/html/HRProprietary/HRCloud2/config.php'); }
$fileCounter = 0;

	function pretty_filesize($file) {
	  $size=filesize($file);
	  if($size<1024){$size=$size." Bytes";}
	  elseif(($size<1048576)&&($size>1023)){$size=round($size/1024, 1)." KB";}
	  elseif(($size<1073741824)&&($size>1048575)){$size=round($size/1048576, 1)." MB";}
	  else{$size=round($size/1073741824, 1)." GB";}
	  return $size; }

	if($_SERVER['QUERY_STRING']=="hidden") { $hide="";
	 $ahref="./";
	 $atext="Hide";}
	else { $hide=".";
	 $ahref="./?hidden";
	 $atext="Show"; }
	 $myDirectory=opendir(".");
	while ($entryName=readdir($myDirectory)) {
	  $dirArray[]=$entryName; }
	closedir($myDirectory);
	$indexCount=count($dirArray);
	sort($dirArray);
	for ($index = 0; $index < $indexCount; $index++) {
	  if (substr("$dirArray[$index]", 0, 1)!=$hide) {
		$favicon="";
		$class="file";
		$name=$dirArray[$index];
		$modtime=date("M j Y g:i A", filemtime($dirArray[$index]));
		$namehref=$dirArray[$index];
		$timekey=date("YmdHis", filemtime($dirArray[$index]));
		if(is_dir($dirArray[$index])) {
		  $extn="&lt;Directory&gt;";
		  $size="&lt;Directory&gt;";
		  $sizekey="0";
		  $class="dir";
		  if(file_exists($namehref."/favicon.ico")) {
		    $favicon=" style='background-image:url($namehref/favicon.ico);'";
		    $extn="&lt;Website&gt;"; }
				if ($name=="."){$name=". (Current Directory)"; $extn="&lt;System Dir&gt;"; $favicon=" style='background-image:url($namehref/.favicon.ico);'";}
				if ($name==".."){$name=".. (Parent Directory)"; $extn="&lt;System Dir&gt;"; } }

		  else {
		  $extn=pathinfo($dirArray[$index], PATHINFO_EXTENSION);
		  switch ($extn) {
		    case "txt": $extn="Text File"; 
		    break;
		    default: 
		    if ($extn!="") {
		      $extn=strtoupper($extn)." File"; } 
		    else {$extn="Unknown"; } break; }
		  $size=pretty_filesize($dirArray[$index]);
          $sizekey=filesize($dirArray[$index]); }

		if ($namehref == 'index.html' or $namehref == 'style.css' or $namehref == 'Notes' or $namehref == 'Contacts' 
			or strpos($namehref, '.css') == 'true' or strpos($namehref, '.html') == 'true' or strpos($namehref, '.css') == 'true' 
			or strpos($namehref, 'Shared') == 'true') continue;
	 echo("<tr class='$class'>
			<td><a href='./$namehref'$favicon class='name'>$name</a></td>
			<td><a href='./$namehref'>$extn</a></td>
			<td><div id='$namehref' name='UnShare$fileCounter' onclick=\"UnShare$fileCounter(); toggle_visibility('loadingCommandDiv');\" ><img src='$URL/HRProprietary/HRCloud2/Resources/x.png'></div></td>
			<td sorttable_customkey='$sizekey'><a href='./$namehref'>$size</a></td>
			<td sorttable_customkey='$timekey'><a href='./$namehref'>$modtime</a></td>
		</tr>"); ?>
<script type="text/javascript">
function UnShare<?php echo $fileCounter; ?>() {
$("#UnShare<?php echo $fileCounter; ?>").click(function(){
var unshareSelected = $('#UnShare<?php echo $fileCounter; ?>').attr('id');
$.ajax( {
    type: 'POST',
    url: 'cloudCore.php',
    data: { unshareConfirm : "1", filesToUnShare : unshareSelected},
    success: function(data) {
        window.location.href = "cloudCore.php";
    }
} );
});
};
</script>
<?php 
$fileCounter++;
} } ?>
	    </tbody>
	</table>

</div>
</body>
</html>
