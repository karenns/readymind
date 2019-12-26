<?php 


function create_header($active_page){
	
//session_start();
if($_SESSION['user']){
		
}
else{
	header("location:index.php");
}
$user_id = $_SESSION['user'];	
	
$html = "
<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
      <meta charset='utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <title>Ready Mind</title>
	<!-- BOOTSTRAP STYLES-->
    <link href='assets/css/bootstrap.css' rel='stylesheet' />
     <!-- FONTAWESOME STYLES-->
    <link href='assets/css/font-awesome.css' rel='stylesheet' />
        <!-- CUSTOM STYLES-->
    <link href='assets/css/custom.css' rel='stylesheet' />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id='wrapper'>
        <nav class='navbar navbar-default navbar-cls-top ' role='navigation' style='margin-bottom: 0'>
            <div class='navbar-header'>
                <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.sidebar-collapse'>
                    <span class='sr-only'>Toggle navigation</span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                </button>
                <a class='navbar-brand' href='home.php'>Ready Mind&nbsp;<img src='assets/img/ready_mind_transp.png' width='30px' height='35px'/></a> 
            </div>
  <div style='color: white;padding: 15px 50px 5px 50px;float: right;font-size: 16px;'>Hi, ".strtoupper($user_id)." &nbsp;&nbsp;&nbsp;&nbsp;<a href='logout.php' class='btn btn-danger square-btn-adjust'>Logout</a> </div>
        </nav>   
           <!-- /. NAV TOP  -->
                <nav class='navbar-default navbar-side' role='navigation'>
            <div class='sidebar-collapse'>
                <ul class='nav' id='main-menu'>
				<a href='home.php'>
				<li class='text-center' style='background-color:white;'>
                    <img src='assets/img/logo.png' class='user-image img-responsive'/>
				</li>
				</a>
					";

/* 		SELECTING THE ACTIVE PAGE		*/					
if ($active_page == "home"){
	$html .= "
			<li>
            <a class='active-menu' href='home.php'><i class='fa fa-dashboard fa-3x'></i>Dashboard</a>
            </li>	
	";
}else{
	$html .= "
			<li>
            <a href='home.php'><i class='fa fa-dashboard fa-3x'></i>Dashboard</a>
            </li>	
	";
}

if ($active_page == "customer"){
	$html .= "
			<li>
            <a class='active-menu' href='customer.php'><i class='fa fa-users fa-3x'></i>Customers</a>
            </li>		
	";
}else{
	$html .= "
			<li>
            <a href='customer.php'><i class='fa fa-users fa-3x'></i>Customers</a>
            </li>		
	";	
	
}
if ($active_page == "quotation"){
	$html .= "
            <li>
            <a  class='active-menu'  href='quotation.php'><i class='fa fa-book fa-3x'></i> Quotations</a>
            </li>	
	";
}else{
	$html .= "
            <li>
            <a href='quotation.php'><i class='fa fa-book fa-3x'></i> Quotations</a>
            </li>	
	";
	
}
if ($active_page == "profile"){
	$html .= "
			<li>
            <a class='active-menu'  href='profile.php'><i class='fa fa-user fa-3x'></i>Profile</a>
            </li>
	";
}else{
	$html .= "
			<li>
			<a href='profile.php'><i class='fa fa-user fa-3x'></i>Profile</a>
            </li>
	";
	
}

// Only the admin is allowed to create Users
if ($user_id == 'admin'){
	if ($active_page == "user"){
		$html .= "
				<li>
				<a class='active-menu'  href='user.php'><i class='fa fa-lock fa-3x'></i>System Users</a>
				</li>
		";
	}else{
		$html .= "
				<li>
				<a  href='user.php'><i class='fa fa-lock fa-3x'></i>System Users</a>
				</li>
		";	
	}
}

$html .= "					                     
                    <!--<li>
                        <a href='#'><i class='fa fa-users fa-3x'></i>Example<span class='fa arrow'></span></a>
                        <ul class='nav nav-second-level'>
                            <li>
                                <a href='#'>ADD NEW Customer</a>
                            </li>
                            <li>
                                <a href='#'>Second Level Link</a>
                            </li>
                            <li>
                                <a href='#'>Second Level Link<span class='fa arrow'></span></a>
                                <ul class='nav nav-third-level'>
                                    <li>
                                        <a href='#'>Third Level Link</a>
                                    </li>
                                    <li>
                                        <a href='#'>Third Level Link</a>
                                    </li>
                                    <li>
                                        <a href='#'>Third Level Link</a>
                                    </li>

                                </ul>
                               
                            </li>
                        </ul>
                      </li>  -->	
                </ul>
               
            </div>
            
        </nav>
        <!-- /. NAV SIDE  --> ";
		
echo $html;

}

?>