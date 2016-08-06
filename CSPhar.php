<?php
if(!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])){
	$uri = 'https://';
}else{
	$uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'];
const BR = '<br/>';
const NEWLINE = '<br/><br/>';
$debugBuffer = [];
$production = true;
	
function getDataFromUrl($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	$returnData = curl_exec($ch);
	curl_close($ch);
	return $returnData;
}
	
function addToDebugBuffer($string){
	global $debugBuffer;
	$debugBuffer[] = $string;
}
function flushDebugBuffer($forceDisplay = false){
	global $debugBuffer, $production;
	if(!$production){
		showDebugBuffer();
	}elseif($production && $forceDisplay){
		echo(BR."Sorry for this, I'm currently debugging this site due to technical difficulties. If this site appears broken apart from this text, please check back later");
		showDebugBuffer();
	}
}
function showDebugBuffer(){
	echo(BR."START_OF_flushDebugBuffer()_OUTPUT");
	foreach($debugBuffer as $debugString){
		echo(BR.htmlspecialchars($debugString));
		echo("\n");
	}
	echo(BR."END_OF_flushDebugBuffer()_OUTPUT");
}
function setProgress($progress){
	?>
	<script type="text/javascript">
		document.getElementById("load1").innerHTML = '<div class="progress"> <div class="determinate" style="width: <?php echo($progress);?>"></div>';
	</script>
	<?php
	ob_flush();
	flush();
}
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="CSPhar.css" type="text/css">
	<title>CSphars</title>
	<style type="text/css"></style>
	<link rel="stylesheet" href="CSPhar.css" type="text/css">
	<title>CSphars</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<style type="text/css"></style>
	<!--EXTERNAL_STUFF-->
	<!--Google Icon Font-->
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!--materialize.css (min)-->
	<link type="text/css" rel="stylesheet" href="materialize.min.css"  media="screen,projection"/>
	<!--EXTERNAL_STUFF-->
</head>
<header class="header">
	<div class="text">
		ClearSkyPhar
	</div>
	<div class="small-header text" style="color:black;text-decoration:none;">
		Here you can grab the latest phars compiled by CircleCI
	</div>
</div>
<div class="text-right">
	<a class="small-header" href="https://github.com/ClearSkyTeam/ClearSky">Visit ClearSky on GitHub <img src="http://wolvesfortress.de/dynmappe/GitHub-Mark-32px.png"></a>
</div>
</header>
<script type="text/javascript">
document.title = "CSphars - Loading...";
</script>
<body>
<!--EXTERNAL_STUFF-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="materialize.min.js"></script>
<!--EXTERNAL_STUFF-->
<div class="content">
<script type="text/javascript">
	if(window.location.href.substr(0, "<?php echo($uri.'/CSPhar.php?type=x') ?>".length) != "<?php echo($uri.'/CSPhar.php?type=0') ?>" && window.location.href.substr(0, "<?php echo($uri.'/CSPhar.php?type=x') ?>".length) != "<?php echo($uri.'/CSPhar.php?type=1') ?>" && window.location.href.substr(0, "<?php echo($uri.'/CSPhar.php?type=x') ?>".length) != "<?php echo($uri.'/CSPhar.php?type=2') ?>"){
		window.location.replace("<?php echo($uri.'/CSPhar.php?type=1&branch=php7') ?>");
	}
</script>
<?php
$type = $_GET['type'];
$branch = $_GET['branch'];
switch($type){
	case 0: echo("oldDesign");echo(BR);
	break;
	case 1:
	break;
	case 2: echo("materialDesign-ALPHA");echo(BR);
	break;
}
if(!isset($_GET['branch'])){
	echo("&branch= is missing!");
	exit;
}
echo('<strong>Selected branch = "'.$branch.'"</strong>');
echo('<div id="load1">'.'<div class="progress"> <div class="determinate" style="width: 5%"></div></div>'.'</div>');
ob_flush();
flush();
$rawData = getDataFromUrl("https://circleci.com/api/v1/project/ClearSkyTeam/ClearSky");
$json = json_decode($rawData);
setProgress("10%");
ob_flush();
flush();
#echo(nl2br(print_r($json,true)));
?>
<script type="text/javascript">
$(document).ready(function() {
	$('select').material_select();
});
</script>
<form>
	<div class="table">
		<div class="textFieldCell1" id="form1">
			<div class="input-field col s12">
				<select id="submitBranch" name="branch">
					<?php
					// includes Simple HTML DOM Parser
					include "simple_html_dom.php";
					$url = 'https://github.com/ClearSkyTeam/ClearSky';
					// Create a DOM object
					$html = new simple_html_dom();
					// Load HTML from a string
					$html->load_file($url);
					// Get all nodes with "tm-article-subtitle"... Then we are annoyed because of someone didn't finish this annotation...
					$nodes = $html->find('div > div > div:nth-child(3) > div:nth-child(1) > a:nth-child(1) > span');
					// loop and print nodes content
					foreach($nodes as $i => $node){
						addToDebugBuffer("currentSateIN__fo_loop?nodei=>node".$i);
						if(strpos($node, "select-menu-item-text css-truncate-target js-select-menu-filter-text") !== false){
							$option = trim(str_replace(['<span',' class="select-menu-item-text css-truncate-target js-select-menu-filter-text"','/span>','title','                 ','               '], ['<option','','/span>','name'], $nodes[$i]));
							addToDebugBuffer("currentIteratedOption::".$option); addToDebugBuffer("CurrentBranchInternalSel::".$branch);
							if(strpos($option, $branch) !== false)
								addToDebugBuffer("DID_FIND_ACTUAL_FINDING");
							$option = str_replace($branch.'"',$branch.'" selected',$option);
							print $option;
						}
					}
					// Clear dom object
					$html->clear();
					unset($html);
					?>
				</select>
				<label>Branch selection:</label>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	document.getElementById('submitBranch').onchange = function() {
		console.log("REDIRECT_TO_BRANCH");
		window.location.replace("<?php echo($uri.'/CSPhar.php?type=1&branch=') ?>"+document.getElementById('submitBranch').value);
	};
	</script>
</form>
<!--
	<script type="text/javascript">
	document.getElementById('load1').innerHTML = '<div class="table"><div class="textFieldCell1"><input placeholder="php7" id="branch_input" type="text" class="validate"></div></div><button class="btn waves-effect waves-light" id="submitBranch" "type="submit" name="submitBranch">Submit<i class="material-icons right">send</i></button>';
	</script>
	<script type="text/javascript">
	document.getElementById('submitBranch').onclick = function() {
	console.log("REDIRECT_TO_BRANCH");
	window.location.replace("<?php echo($uri.'/CSPhar.php?type=1&branch=') ?>"+document.getElementById('branch_input').value);
	};
	</script>
//-->
<?php
flushDebugBuffer();
setProgress("20%");
ob_flush();
flush();
foreach($json as $buildObject){
	echo("\n");
	if($buildObject->branch == $branch){
		#echo(nl2br(print_r($buildObject,true)));
		switch($type){
			case 0:
			echo('<div class="table">');
			echo('<div class="tr"><div class="td">Build #'.$buildObject->build_num.": ".'</div><div class="td"><a href="'.$buildObject->build_url.'"><span style="color:#FFC000">Build-Info</span></a></div>'.' <div class="td"><div id="phar'.$buildObject->build_num.'">'.'Loading...'.'</div></div></div>');
			echo("</div>");
			break;
			case 1:
			echo('<div class="normal">');
			$currentInfo = '<div class= "normalCell"><div class="commitCellTable"><div class="normalRow"><div class="commitCell"><a href="'.$buildObject->all_commit_details[0]->commit_url.'"><font size=4>'.$buildObject->subject.'</font></a></div></div><div class="normalRow"><div class="commitCellRowTableInfoTable"><div class="smallCell1">--:-- ago</div><div class= "smallCell2">Took:-:--</div></div></div></div></div><div class= "normalCell"><div class="normalCellTable"><div class="normalRow"><a href="'.$buildObject->compare.'">Changes</a></div><div class="normalRow">'.$buildObject->user->login.'</div><div class="normalRow">'.substr($buildObject->vcs_revision,0,8).'</div></div></div>';
			switch($buildObject->status){
				case "running":
				echo('<div class="tr"><div class="buildInfoCellRunning">Build #'.$buildObject->build_num.": ".'</div>'.$currentInfo.'<div class="normalCell"><a href="'.$buildObject->build_url.'"><span style="color:#FFC000">CircleCI</span></a></div>'.' <div class="pharCell"><div id="phar'.$buildObject->build_num.'">'.'Loading...'.'</div></div></div>'."\n");
				break;
				case "success":
				case "fixed":
				echo('<div class="tr"><div class="buildInfoCellGreen">Build #'.$buildObject->build_num.": ".'</div>'.$currentInfo.'<div class="normalCell"><a href="'.$buildObject->build_url.'"><span style="color:#FFC000">CircleCI</span></a></div>'.' <div class="pharCell"><div id="phar'.$buildObject->build_num.'">'.'Loading...'.'</div></div></div>'."\n");
				break;
				case "failed":
				echo('<div class="tr"><div class="buildInfoCellRed">Build #'.$buildObject->build_num.": ".'</div>'.$currentInfo.'<div class="normalCell"><a href="'.$buildObject->build_url.'"><span style="color:#FFC000">CircleCI</span></a></div>'.' <div class="pharCell"><div id="phar'.$buildObject->build_num.'">'.'Loading...'.'</div></div></div>'."\n");
				break;
				default: echo("(by the way, this is an error) UNKNOWN BUILD STATUS OF BUILD '".$buildObject->build_num."' BUILD_STATUS IN OBJECT ".'BuildObjectManager::decodeData($json)[$currentBuildNum]->status'.": '".$buildObject->status."'");echo(BR);
				break;
			}
			echo(BR);
			echo("</div>");
			break;
			case 2:
			echo('<div class="normal">');
			$currentInfo = '<div class= "normalCell"><div class="commitCellTable"><div class="normalRow"><font size=5>COMMIT_NAME</font></div><div class="normalRow"><div class="commitCellRowTableInfoTable"><div class="smallCell1">--:-- ago</div><div class= "smallCell2">Took:-:--</div></div></div></div></div><div class= "normalCell"><div class="normalCellTable"><div class="normalRow">Changes</div><div class="normalRow">Committer</div><div class="normalRow">CommitID</div></div></div>';
			switch($buildObject->status){
				case "running":
				echo('<div class="tr"><div class="buildInfoCellRunning">Build #'.$buildObject->build_num.": ".'</div>'.$currentInfo.'<div class="normalCell"><a href="'.$buildObject->build_url.'"><span style="color:#FFC000">CircleCI</span></a></div>'.' <div class="pharCell"><div id="phar'.$buildObject->build_num.'">'.'Loading...'.'</div></div></div>'."\n");
				break;
				case "success":
				case "fixed":
				echo('<div class="tr"> <div class="s12 12col(full)">
					<div class="card grey lighten-2">
				<div class="card-content black-text"><div class="buildInfoCellGreen">Build #'.$buildObject->build_num.": ".'</div>'.$currentInfo.'<div class="normalCell"><a href="'.$buildObject->build_url.'"><span style="color:#FFC000">CircleCI</span></a></div>'.' <div class="pharCell"><div id="phar'.$buildObject->build_num.'">'.'Loading...'.'</div></div></div></div></div></div>'."\n");
				break;
				case "failed":
				echo('<div class="tr"><div class="buildInfoCellRed">Build #'.$buildObject->build_num.": ".'</div>'.$currentInfo.'<div class="normalCell"><a href="'.$buildObject->build_url.'"><span style="color:#FFC000">CircleCI</span></a></div>'.' <div class="pharCell"><div id="phar'.$buildObject->build_num.'">'.'Loading...'.'</div></div></div>'."\n");
				break;
				default: echo("UNKNOWN BUILD STATUS OF BUILD".$buildObject->build_num." BUILD_STATUS IN OBJECT ".'BuildObjectManager::getNextBuildData($json)->status'.": '".$buildObject->status."'");echo(BR);
				break;
			}
			break;
			default:
			echo("Lol, wrong ?type="); echo(BR);
		}
	}
}
echo('<font face="Consolas">');
echo("Time: ".date("d-m-Y - H:i:s", time()));
echo(NEWLINE);
echo("Changelog:
".BR."
ToDo: AJAX
".BR."
06/08/2016 Squashed all the bugs out of the new branch selection system and made its design better. Implemented a totally useless loading bar. Internally cleaned up the code, and the indenting of the code.
".BR."
05/08/2016 Now we have a dropdown selector for branches instead of you needing to type the branch name manually in. Sadly this increased site loading time by about 10%. Fixed some other minor bugs.
".BR."
31/07/2016 Finally fixed the text escaping the header (And other HEADER improvements)
".BR."
17/07/2016: CommitName,ChangesLink,ComitterName,CommitID BetterDesign Branch Selection
".BR."
16/07/2016: First work on the new design, you can view it by setting ?doShowCompact to false
".BR."
15/07/2016: Header overhaul, nice CSS thanks to @thebigsmileXD
".BR."
14/07/2016: Fixed some bugs.
");
echo('</font>');
setProgress("30%");
ob_flush();
flush();
$realToDoBuildObjects = 0;
foreach($json as $buildObject){
	if($buildObject->branch == $branch){
		$realToDoBuildObjects++;
	}
}
$addProgressPerBuildObject = 70 / $realToDoBuildObjects;
$currentProgress = 30;
foreach($json as $buildObject){
	if($buildObject->branch == $branch){
		$currentProgress = $addProgressPerBuildObject + $currentProgress;
		setProgress($currentProgress."%");
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
	}
	ob_flush();
	flush();
}
?>
<script type="text/javascript">
	document.getElementById('load1').style.display = 'none';
	document.getElementById("form1").style.overflow = 'visible';
	document.title = "CSphars";
</script>
<?php
exit;
?>
Something went very, very wrong <br/>
ERR_9999