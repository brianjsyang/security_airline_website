<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../database/dbsetup.php';

//connect to database: PHP Data object representing Database connection
$pdo = db_connect();

session_start();
if(!isset($_SESSION['login'])) {
	header('Location: index.html');
	exit;
}

if($_SESSION['branch_id'] == 0){
	header('Location: adminpage.php');
	exit;
}

//get branch name
$branch_id = $_SESSION['branch_id'];

$get_name = $pdo->prepare("SELECT branch_name FROM abc_airline.branch WHERE branch_id=?");
$get_name->execute([$branch_id]);

$res = $get_name->fetch();
$branch_name = $res['branch_name'];


//get aircraft data
$get_data = $pdo->prepare("SELECT * FROM abc_airline.ac_maint WHERE permission=? ORDER BY prev_maint");
$get_data->execute([$branch_id]);

$res_data = $get_data->fetchAll();


//end php
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>ABC Airlines - Management Page</h1>
				<a href="profile.php">Profile</a>
				<a href="logout.php">Logout</a>
			</div>
		</nav>

		<div class="content">
			<h2>Home Page</h2>
			<p>Welcome back, <?=$_SESSION['username']?>!</p>
		</div>

		<div class="content2">
			<div>
				<h2>Aircraft Data: <?=$branch_name?></h2>
				<table>
					<tr>
						<td>Registration</td>
						<td>Model</td>
						<td>Previous Maintenance Date</td>
						<td>Next Maintenance Date</td>
					</tr>
			<?php 	
				//PHP code to show all info
				foreach($res_data as $row){
					$aid = $row['aid'];
					$amodel = $row['amodel'];
					$prev_maint = $row['prev_maint'];
					$next_maint = $row['next_maint'];

					echo '
						<tr align=center>
							<td>'.$aid.'</td>
							<td>'.$amodel.'</td>
							<td>'.$prev_maint.'</td>
							<td>'.$next_maint.'</td>
						</tr>';
				}
				
			?>	
		</div>			
	</body>
</html>