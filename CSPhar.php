<?php
	function getDataFromUrl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		$returnData = curl_exec($ch);
		curl_close($ch);
		return $returnData;
	}
	const BR = '<br/>';
	const NEWLINE = '<br/><br/>';
	#header('Content-type: text/html; charset=utf-8');
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="CSPhar.css" type="text/css">
	<title>CSphars</title>
	<style type="text/css"></style>
	
</head>
<header class="header">
	<div class="text">ClearSkyPhar<div class="small-header text" style="color:black;text-decoration:none;">Here you can grab the latest *.phar files compiled by CircleCI</div>
	</div>
	<div class="text-right"><a class="small-header" href="https://github.com/ClearSkyTeam/ClearSky">Visit ClearSky on GitHub <img src="http://wolvesfortress.de/dynmappe/GitHub-Mark-32px.png"></a>
  	</div>
</header>
<script type="text/javascript">
	document.title = "CSphars - Loading...";
</script>
<div class="content">
<?php
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
	$uri = 'https://';
} else {
	$uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'];
?>
<script type="text/javascript">
if(window.location.href != "<?php echo($uri.'/CSPhar.php?doShowCompact=true') ?>" && window.location.href != "<?php echo($uri.'/CSPhar.php?doShowCompact=false') ?>"){
	window.location.replace("<?php echo($uri.'/CSPhar.php?doShowCompact=true') ?>");
}
</script>
<?php
	ob_implicit_flush(true);
	$compact = $_GET['doShowCompact'];
	if($compact == "false"){
		echo("BETA");
	}
	#echo('<font face="Consolas">');
	#echo("Time: ".date("d-m-Y - H:i:s", time()));echo(BR);
	#echo('<font face="sans-serif">');
	#echo(nl2br(print_r($json,true)));
	echo('<div id="load1">'."Loading...".'</div>');
	$rawData = getDataFromUrl("https://circleci.com/api/v1/project/ClearSkyTeam/ClearSky");
	$json = json_decode($rawData);
	echo('<strong> <a href="http://wolvesfortress.de/circleci.php">Latest phar (Build:'.$json[0]->build_num.')</a> </strong>');echo(NEWLINE);echo(BR);
	?>
	<script type="text/javascript">
		document.getElementById('load1').style.display = 'none';
	</script>
	<?php
	foreach($json as $buildObject){
		if($compact == "true"){
			echo('<div class="table">');
			echo('<div class="tr"><div class="td">Build #'.$buildObject->build_num.": ".'</div><div class="td"><a href="'.$buildObject->build_url.'"><span style="color:#FFC000">Build-Info</span></a></div>'.' <div class="td"><div id="phar'.$buildObject->build_num.'">'.'Loading...'.'</div></div></div>');
			echo(BR);
			echo("</div>");
		}else{
			echo('<div class="normal">');
			$currentInfo = '<div class= "normalCell"><div class="commitCellTable"><div class="normalRow"><font size=5>COMMIT_NAME</font></div><div class="normalRow"><div class="commitCellRowTableInfoTable"><div class="smallCell">--:-- ago</div><div class= "smallCell">Took:-:--</div></div></div></div></div><div class= "normalCell"><div class="normalCellTable"><div class="normalRow">Changes</div><div class="normalRow">Committer</div><div class="normalRow">CommitID</div></div></div>';
			switch($buildObject->status){
				case "running":
					echo('<div class="tr"><div class="buildInfoCellRunning">Build #'.$buildObject->build_num.": ".'</div>'.$currentInfo.'<div class="normalCell"><a href="'.$buildObject->build_url.'"><span style="color:#FFC000">CircleCI</span></a></div>'.' <div class="pharCell"><div id="phar'.$buildObject->build_num.'">'.'Loading...'.'</div></div></div>'."\n");
				break;
				case "success":
					echo('<div class="tr"><div class="buildInfoCellGreen">Build #'.$buildObject->build_num.": ".'</div>'.$currentInfo.'<div class="normalCell"><a href="'.$buildObject->build_url.'"><span style="color:#FFC000">CircleCI</span></a></div>'.' <div class="pharCell"><div id="phar'.$buildObject->build_num.'">'.'Loading...'.'</div></div></div>'."\n");
				break;
				case "failed":
					echo('<div class="tr"><div class="buildInfoCellRed">Build #'.$buildObject->build_num.": ".'</div>'.$currentInfo.'<div class="normalCell"><a href="'.$buildObject->build_url.'"><span style="color:#FFC000">CircleCI</span></a></div>'.' <div class="pharCell"><div id="phar'.$buildObject->build_num.'">'.'Loading...'.'</div></div></div>'."\n");
				break;
				default: echo("UNKNOWN BUILD STATUS OF BUILD".$buildObject->build_num." BUILD_STATUS IN OBJECT ".'BuildObjectManager::getNextBuildData($json)->status'.": '".$buildObject->status."'");echo(BR);
				break;
			}

			echo(BR);
			echo("</div>");
		}
	}
	echo('<font face="Consolas">');
	echo("Time: ".date("d-m-Y - H:i:s", time()));
	echo(NEWLINE);
	echo("Changelog:
".BR."
ToDo: Performance improvements, branch selection
".BR."
17/07/2016: Continue the new design, and finally add the acual info
".BR."
16/07/2016: First work on the new design, you can view it by setting ?doShowCompact to false
".BR."
15/07/2016: Header overhaul, nice CSS thanks to @thebigsmileXD
".BR."
14/07/2016: Fixed some bugs.
");
	foreach($json as $buildObject){
		#echo('<div id="load'.$buildObject->build_num.'">'."Loading...".'</div>');echo(BR);
		$rawData = getDataFromUrl('https://circleci.com/api/v1/project/ClearSkyTeam/ClearSky/'.$buildObject->build_num.'/artifacts');
		$currentBuildJson = json_decode($rawData);
		#echo(BR);
		#echo(nl2br(print_r($currentBuildJson,true)));
		#echo(BR);
		#echo(nl2br(print_r($currentBuildJson['url'],true)));
		#echo(BR);
?>
<script type="text/javascript">
	document.getElementById('phar<?php echo $buildObject->build_num ?>').innerHTML = '<?php 
if(isset($currentBuildJson[0])){
	echo('<a href="'.$currentBuildJson[0]->url.'"><span style="color:#00D12A">Phar</span></a>');
}else{
	echo('<span style="color:#FF0000">'.'NoPhar'.'</span>');
}
?>';
</script>
<?php
/*
		if(isset($currentBuildJson[0])){
			echo('<a href="'.$currentBuildJson[0]->url.'"><span style="color:#00D12A">Phar</span></a>');
		}else{
			echo('<span style="color:#FF0000">'.'FailedBuild'.'</span>');
		}
*/
	}
?>
<script type="text/javascript">
	document.title = "CSphars";
</script>
<?php
	exit;
?>
Something went very, very wrong <br/>
ERR_9999