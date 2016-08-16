<?php 
// / This file was downloaded on 7/27/16 by Justin G. for HRCloud2 from 
// / https://css-tricks.com/snippets/php/display-styled-directory-contents/
// / Thank you to the author, Chris Coyier!!!
// / https://css-tricks.com/author/chriscoyier/
// / IMPORTANT NOTE: THIS SCRIPT IS NO LONGER EXECUTABLE OUTSIDE OF HRC2 !!!
// / IMPORTANT NOTE: THIS SCRIPT WILL ONLY FUNCTION WHEN INCLUDED OR REQUIRED BY HRC2 !!!

?>
<!doctype html>
<html>
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" href="Applications/displaydirectorycontents_72716/favicon.ico">
   <title>Cloud Contents</title>
</head>
    <script type="text/javascript" src="Applications/jquery-3.1.0.min.js"></script>
    <link rel="stylesheet" href="Applications/displaydirectorycontents_72716/style.css">
    <script src="Applications/displaydirectorycontents_72716/sorttable.js"></script>
    <script type="text/javascript">
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block'; }
    </script>
<body>
<div id="container">

	<table class="sortable">
	    <thead>
		<tr>
			<th>Filename</th>
			<th>Select</th>
			<th>Type</th>
			<th>Size</th>
			<th>Date Modified</th>
		</tr>
	    </thead>
	    <tbody><?php
$tableCount = 0;
	// Adds pretty filesizes
	function pretty_filesize($file) {
		$size=filesize($file);
		if($size<1024){$size=$size." Bytes";}
		elseif(($size<1048576)&&($size>1023)){$size=round($size/1024, 1)." KB";}
		elseif(($size<1073741824)&&($size>1048575)){$size=round($size/1048576, 1)." MB";}
		else{$size=round($size/1073741824, 1)." GB";}
		return $size;
	}

 	// Checks to see if veiwing hidden files is enabled
	if($_SERVER['QUERY_STRING']=="hidden")
	{$hide="";
	 $ahref="./";
	 $atext="Hide";}
	else
	{$hide=".";
	 $ahref="./?hidden";
	 $atext="Show";}

	 // Opens directory
	 $myDirectory=opendir($CloudLoc.$UserDirPOST.$UserID);

	// Gets each entry
	while($entryName=readdir($myDirectory)) {
	   $dirArray[]=$entryName;
	}

	// Closes directory
	closedir($myDirectory);

	// Counts elements in array
	$indexCount=count($dirArray);

	// Sorts files
	sort($dirArray);

	// Loops through the array of files
	for($index=0; $index < $indexCount; $index++) {

	// Decides if hidden files should be displayed, based on query above.
	    if(substr("$dirArray[$index]", 0, 1)!=$hide) {

	// Resets Variables
		$favicon="";
		$class="file";

	// Gets File Names
		$name=$dirArray[$index];
		$namehref=$dirArray[$index];
		if (substr_compare($namehref, '/', 1)) { 
			$namehref = substr_replace('/'.$namehref, $namehref, 0); }

	// Gets Date Modified
		$modtime=date("M j Y g:i A", filemtime($CloudUsrDir.$dirArray[$index]));
		$timekey=date("YmdHis", filemtime($CloudUsrDir.$dirArray[$index]));


	// Separates directories, and performs operations on those directories
		if(is_dir($dirArray[$index]))
		{
				$extn="&lt;Directory&gt;";
				$size="&lt;Directory&gt;";
				$sizekey="0";
				$class="dir";

			// Gets favicon.ico, and displays it, only if it exists.
				if(file_exists("$namehref/favicon.ico"))
					{
                        $slash = '/';
						$favicon=" style='background-image:url($slash$namehref/favicon.ico);'";
						$extn="&lt;Website&gt;";
					}

			// Cleans up . and .. directories
				if($name=="."){$name=". (Current Directory)"; $extn="&lt;System Dir&gt;"; $favicon=" style='background-image:url($slash$namehref/favicon.ico);'";}
				if($name==".."){$name=".. (Parent Directory)"; $extn="&lt;System Dir&gt;";}
		}

	// File-only operations
		else{
			// Gets file extension
			$extn=pathinfo($dirArray[$index], PATHINFO_EXTENSION);

			// Prettifies file type
			switch ($extn){
				case "png": $extn="PNG Image"; break;
				case "jpg": $extn="JPEG Image"; break;
				case "jpeg": $extn="JPEG Image"; break;
				case "svg": $extn="SVG Image"; break;
				case "gif": $extn="GIF Image"; break;
				case "ico": $extn="Windows Icon"; break;

				case "txt": $extn="Text File"; break;
				case "log": $extn="Log File"; break;
				case "htm": $extn="HTML File"; break;
				case "html": $extn="HTML File"; break;
				case "xhtml": $extn="HTML File"; break;
				case "shtml": $extn="HTML File"; break;
				case "php": $extn="PHP Script"; break;
				case "js": $extn="Javascript File"; break;
				case "css": $extn="Stylesheet"; break;

				case "pdf": $extn="PDF Document"; break;
				case "xls": $extn="Spreadsheet"; break;
				case "xlsx": $extn="Spreadsheet"; break;
				case "doc": $extn="Microsoft Word Document"; break;
				case "docx": $extn="Microsoft Word Document"; break;

				case "zip": $extn="ZIP Archive"; break;
				case "htaccess": $extn="Apache Config File"; break;
				case "exe": $extn="Windows Executable"; break;

				default: if($extn!=""){$extn=strtoupper($extn)." File";} else{$extn="Folder";} break;
  
			}

			// Gets and cleans up file size
				$size=pretty_filesize($CloudUsrDir.$dirArray[$index]);
				$sizekey=filesize($CloudUsrDir.$dirArray[$index]);
		}
if (isset($_POST['UserDirPOST'])) {
  $namehref1 = $namehref.' UserDirPOST : '.$UserDirPOST; }
if (!isset($_POST['UserDirPOST'])) {
  $namehref1 = $namehref; }
$FileURL = 'DATA/'.$UserID.$UserDirPOST.$namehref;
$ArchiveArray = array('zip', 'rar', 'tar', 'bz', 'gz', 'bz2', '7z', 'iso', 'vhd');
$DearchiveArray = array('zip', 'rar', 'tar', 'bz', 'gz', 'bz2', '7z', 'iso', 'vhd');
$DocumentArray = array('txt', 'doc', 'docx', 'rtf', 'xls', 'xlsx', 'odf', 'ods');
$ImageArray = array('jpeg', 'jpg', 'png', 'bmp', 'gif', 'pdf');
$MediaArray = array('3gp', 'avi', 'mp3', 'mp4', 'mov', 'aac', 'oog');
$extnRAW=pathinfo($dirArray[$index], PATHINFO_EXTENSION);
if (in_array($extnRAW, $DearchiveArray)) {
	$specialHTML = ('<img id=\'dearchivebutton$tableCount\' name=\'dearchiveButton$tableCount\' href=\'#\' src=\'Resources/dearchive.png\' alt=\'Unpack\'/>'); }
if (in_array($extnRAW, $DocumentArray)) {
	$specialHTML = '<img src="Resources/makepdf.png" alt=\'Create PDF\'/>'; }
if (in_array($extnRAW, $ImageArray)) {
	$specialHTML = '<img src="Resources/photoedit.png" alt=\'Edit Photo\'/>'; }
if (in_array($extnRAW, $MediaArray)) {
	$specialHTML = '<img src="Resources/stream.png" alt=\'Stream Media\'/>'; }
if ($extn == "Folder") {
	$specialHTML = '<img src="Resources/archive.png" alt=\'Compress\'/>'; }

	 echo("
		<tr class='$class'>
			<td><a id='corePostDL$tableCount' href='#'$favicon class='name' onclick=".'toggle_visibility(\'loading\');'.">$name</a></td>
			<td><div><input type='checkbox' name='corePostSelect$tableCount' id='corePostSelect$tableCount' onclick=".'toggle_visibility(\'loading\');'."</div></td>
            <td><a id='corePostDL$tableCount' name='corePostDL$tableCount' href='#' onclick=".'toggle_visibility(\'loading\');'.">$extn</a></td>
			<td sorttable_customkey='$sizekey'><a id='corePostDL$tableCount' href='#' name='corePostDL$tableCount' onclick=".'toggle_visibility(\'loading\');'.">$size</a></td>
			<td sorttable_customkey='$timekey'><a id='corePostDL$tableCount' href='#' name='corePostDL$tableCount' onclick=".'toggle_visibility(\'loading\');'.">$modtime</a></td>
		
		</tr>");
?>
<script type="text/javascript">
            jQuery(document).ready(function($){
                $('#corePostDL<?php echo $tableCount; ?>').on("click",function(){
                    $.ajax({
                        url: "cloudCore.php",
                        type: "POST",
                        data: { 'filesToDownload': "<?php echo $namehref; ?>", 'download': "1" },
                        success: function(response){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        },
                        error: function(){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        }
                    });
                });
            });
            </script>
<script type="text/javascript">
            jQuery(document).ready(function($){
                $('#dearchiveButton<?php echo $tableCount; ?>').on("click",function(){
                    $.ajax({
                        url: "cloudCore.php",
                        type: "POST", 
                        data: { 'dearchive': "1", 'dearchiveSelected': "<?php echo $namehref; ?>" },
                        success: function(response){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        },
                        error: function(){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        }
                    });
                });
            });
            </script>            
<script type="text/javascript">
            jQuery(document).ready(function($){
                $('#archiveButton<?php echo $tableCount; ?>').on("click",function(){
                    $.ajax({
                        url: "cloudCore.php",
                        type: "POST", 
                        data: { 'archiveSelected': "<?php echo $namehref; ?>", 'archive': "1" },
                        success: function(response){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        },
                        error: function(){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        }
                    });
                });
            });
            </script>
<script type="text/javascript">
            jQuery(document).ready(function($){
                $('#archiveButton<?php echo $tableCount; ?>').on("click",function(){
                    $.ajax({
                        url: "cloudCore.php",
                        type: "POST", 
                        data: { 'archiveSelected': "<?php echo $namehref; ?>", 'archive': "1", 'archextension': "rar" },
                        success: function(response){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        },
                        error: function(){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        }
                    });
                });
            });         
         </script>
<script type="text/javascript">
            jQuery(document).ready(function($){
                $('#archiveButton<?php echo $tableCount; ?>').on("click",function(){
                    $.ajax({
                        url: "cloudCore.php",
                        type: "POST", 
                        data: { 'archiveSelected': "<?php echo $namehref; ?>", 'archive': "1", 'archextension': "tar" },
                        success: function(response){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        },
                        error: function(){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        }
                    });
                });
            });
            </script>
<script type="text/javascript">
            jQuery(document).ready(function($){
                $('#archiveButton<?php echo $tableCount; ?>').on("click",function(){
                    $.ajax({
                        url: "cloudCore.php",
                        type: "POST", 
                        data: { 'archiveSelected': "<?php echo $namehref; ?>", 'archive': "1", 'archextension': "tar.bz" },
                        success: function(response){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        },
                        error: function(){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        }
                    });
                });
            });
            </script>          
<script type="text/javascript">
            jQuery(document).ready(function($){
                $('#archiveButton<?php echo $tableCount; ?>').on("click",function(){
                    $.ajax({
                        url: "cloudCore.php",
                        type: "POST", 
                        data: { 'archiveSelected': "<?php echo $namehref; ?>", 'archive': "1", 'archextension': "tar.bz2" },
                        success: function(response){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        },
                        error: function(){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        }
                    });
                });
            });
            </script>
<script type="text/javascript">
            jQuery(document).ready(function($){
                $('#archiveButton<?php echo $tableCount; ?>').on("click",function(){
                    $.ajax({
                        url: "cloudCore.php",
                        type: "POST", 
                        data: { 'archiveSelected': "<?php echo $namehref; ?>", 'archive': "1", 'archextension': "tar.gz" },
                        success: function(response){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        },
                        error: function(){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        }
                    });
                });
            });  
            </script>         
<script type="text/javascript">
            jQuery(document).ready(function($){
                $('#archiveButton<?php echo $tableCount; ?>').on("click",function(){
                    $.ajax({
                        url: "cloudCore.php",
                        type: "POST", 
                        data: { 'archiveSelected': "<?php echo $namehref; ?>", 'archive': "1", 'archextension': "iso" },
                        success: function(response){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        },
                        error: function(){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        }
                    });
                });
            });  
            </script>
<script type="text/javascript">
            jQuery(document).ready(function($){
                $('#archiveButton<?php echo $tableCount; ?>').on("click",function(){
                    $.ajax({
                        url: "cloudCore.php",
                        type: "POST", 
                        data: { 'archiveSelected': "<?php echo $namehref; ?>", 'archive': "1", 'archextension': "vhd" },
                        success: function(response){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        },
                        error: function(){
                          window.location.replace("http://<?php echo $URL.'/HRProprietary/HRCloud2/'.$FileURL; ?>");
                        }
                    });
                });
            });  
            </script>           

    <?php
    $tableCount++;
	   }
	}
	?>
	</table>
<div align='center' id='loading' name='loading' style="display:none;"><img src='Resources/pacman.gif'/></div>

</div>
</body>
</html>