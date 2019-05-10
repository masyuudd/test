<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>

<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "operator";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>

<?php require_once('Connections/lubu.php'); ?>
<?php 

$agentname 	= $_GET['lokasi'];
$type 		= $_GET['type'];
$sungai		= $_GET['name'];


$tipehrs = "wldetail.php?type=hourly&lokasi=".$agentname."&name=".$sungai;
$tipeday = "wldetail.php?type=daily&lokasi=".$agentname."&name=".$sungai;
$tipemon = "wldetail.php?type=monthly&lokasi=".$agentname."&name=".$sungai;
$tipeyer = "wldetail.php?type=yearly&lokasi=".$agentname."&name=".$sungai;
$tipewek = "wldetail.php?type=weekly&lokasi=".$agentname."&name=".$sungai;

?>



<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>PLTM LUBU</title>
	<meta name="description" content="Bootstrap Metro Dashboard">
	<meta name="author" content="Dennis Ji">
	<meta name="keyword" content="Metro, Metro UI, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
	
	<!-- start: CSS -->
	<link id="bootstrap-style" href="css/bootstrap.min.css" rel="stylesheet">
	<link id="bootstrap-style" href="css/bootstrap-datepicker.min.css" rel="stylesheet">
	
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link id="base-style" href="css/style.css" rel="stylesheet">
	<link id="base-style-responsive" href="css/style-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
	<link href="css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
	<!-- end: CSS -->
	

	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> -->
	<script type="text/javascript" language="javascript" src="js/jquery-1.12.4.js"></script>
	
	<script src='js/jquery.dataTables.min.js'></script>
	<!-- Graph ---->
	<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.js"></script>
	<script src="js/jquery.flot.pie.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	
	<!-- Datatables -->
	<script src="js/rgraph/RGraph.common.core.js"></script>
    <script src="js/rgraph/RGraph.common.dynamic.js"></script>
    <script src="js/rgraph/RGraph.common.effects.js"></script>
    <script src="js/rgraph/RGraph.common.tooltips.js"></script>
	<script src="js/rgraph/RGraph.bar.js"></script>
	<script src="js/rgraph/RGraph.line.js"></script>
	<script src="js/rgraph/jquery.min.js"></script>
	
	<!-- end: J
	
	
	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<link id="ie-style" href="css/ie.css" rel="stylesheet">
	<![endif]-->
	
	<!--[if IE 9]>
		<link id="ie9style" href="css/ie9.css" rel="stylesheet">
	<![endif]-->
		
	<!-- start: Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico">
	<!-- end: Favicon -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link id="base-style" href="css/custom.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> -->
	<style>
	/* Add a black background color to the top navigation */

	</style>
</head>

<body id="dt_example">
		<!-- start: Header -->
		
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<?php require_once("helper/company.php")?>
								
				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
				<?php require_once("helper/headermenu.php");?>
				</div>
				<!-- end: Header Menu -->
				
			</div>
		</div>
	</div>
	
	<!-- start: Header -->
	
		<div class="container-fluid-full">
		<div class="row-fluid">
				
			<!-- start: Main Menu -->
			<?php //require_once("helper/leftmenu2.php")?>
			<!-- end: Main Menu -->
			
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			
	<!-- start: Content -->

	<div  class="container">
			
		<?php //require_once("helper/resume_data.php");	?>
	
		<!-- <h1 class="page_title"><?php echo $agentname;  ?></h1> -->


		<div class="row">
			<div class="topnav">
				
				<a class="title" href="#home">
					<span><?php echo $agentname;  ?></span>
				</a>
				
				<div class="topnav-right">
						<a class="<?php if($type=='hourly') echo 'active';?>" href="<?php echo $tipehrs; ?>">Hourly </a> 
						<a class="<?php if($type=='daily') echo 'active';?>" href="<?php echo $tipeday; ?>">Daily </a> 
						<a class="<?php if($type=='monthly') echo 'active';?>" href="<?php echo $tipemon; ?>"> Monthly </a>
						<a class="<?php if($type=='yearly') echo 'active';?>" href=<?php echo $tipeyer; ?>> Yearly</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<?php 
						if($type=="hourly"){			
							require_once("hourly.php");
						}
						if($type=="daily"){			
							require_once("temp.php");
						}
						if($type=="weekly"){			
							echo $tipewek;
						}
						if($type=="monthly"){			
							require_once("mon.php");
						}
						if($type=="yearly"){			
							require_once("year.php");
						}
					?>
			</div>
		</div>
	

				
     
     

	</div>
	<!--/.fluid-container-->
	<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
	<div class="modal hide fade" id="myModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Settings</h3>
		</div>
		<div class="modal-body">
			<p>Here settings can be configured...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			<a href="#" class="btn btn-primary">Save changes</a>
		</div>
	</div>
	
	<div class="clearfix"></div>
	</br>
	<footer>

		<p>
			<span style="text-align:left;float:left">&copy; 2019 PT. OMBILIN ELECTRIC POWER</span>
			
		</p>

	</footer>
	
	<!-- start: JavaScript-->
	
		<!-- start: JavaScript-->

		<script src="js/jquery-migrate-1.0.0.min.js"></script>
	
		<script src="js/jquery-ui-1.10.0.custom.min.js"></script>
	
	
		<script src="js/bootstrap.min.js"></script>
	
		<script src="js/jquery.cookie.js"></script>
	
		<script src='js/fullcalendar.min.js'></script>
	
		

		<script src="js/excanvas.js"></script>
		
		<script src="js/jquery.flot.js"></script>
		<script src="js/jquery.flot.pie.js"></script>
		<script src="js/jquery.flot.stack.js"></script>
		<script src="js/jquery.flot.resize.min.js"></script>
	
		<script src="js/jquery.chosen.min.js"></script>
	
		<script src="js/jquery.uniform.min.js"></script>
		
		<script src="js/jquery.cleditor.min.js"></script>
	
		<script src="js/jquery.noty.js"></script>
	
		<script src="js/jquery.elfinder.min.js"></script>
	
		<script src="js/jquery.raty.min.js"></script>
	
		<script src="js/jquery.iphone.toggle.js"></script>
	
		<script src="js/jquery.uploadify-3.1.min.js"></script>
	
		<script src="js/jquery.gritter.min.js"></script>
	
		<script src="js/jquery.imagesloaded.js"></script>
	
		<script src="js/jquery.masonry.min.js"></script>
	
		<script src="js/jquery.knob.modified.js"></script>
	
		<script src="js/jquery.sparkline.min.js"></script>
	
		<script src="js/counter.js"></script>
	
		<script src="js/retina.js"></script>

		<script src="js/custom.js"></script>
			
		<script type="text/javascript" language="javascript" src="js/bootstrap-datepicker.min.js"></script>
	<!-- end: JavaScript-->
	<script src='js/fnSetFilteringDelay.js'></script>

	
	
	<!-- end  javaScript-->
	<style>
.align-center{
	text-align: center;
}
textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input{
	height: 32px;
}

.pstimbul {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
}

.pstimbul .pstimbultext {
    visibility: hidden;
    min-width: 100px;
    background-color: #152121c7;
    color: #fff;
    text-align: left;
    border-radius: 6px;
    /* padding: 15px 15px; */
    position: absolute;
    z-index: 1;
    padding-bottom: 15px;
    padding-left: 15px;
    font-weight: bold;
}

.pstimbul:hover .pstimbultext {
    visibility: visible;
}
div.dt-buttons {
    position: relative;
    float: right;
}


</style>

</body>
</html>


