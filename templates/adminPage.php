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

if($_SESSION['branch_id'] != 0){
	header('Location: homepage.php');
	exit;
}

//get all user info except admin
$getUser = $pdo->prepare("SELECT username, email, branch_name FROM abc_airline.users a, abc_airline.branch b WHERE a.branch_id=b.branch_id AND a.branch_id !=?");
$getUser->execute([$_SESSION['branch_id']]);
$result = $getUser->fetchAll();

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
		
				<a href="createID.php">Create Employee</a>			
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
            <h2>ADMIN: Existing Users</h2>
				<table>
					<tr>
						<td>User Name</td>
						<td>Email</td>
						<td>Branch</td>
					</tr>
                <?php
                    //get user info to display for admin
                    foreach($result as $row){
                        $username = $row['username'];
                        $email = $row['email'];
                        $bname = $row['branch_name'];

                        echo '
                        <tr align center>
                            <td>'.$username.'</td>
                            <td>'.$email.'</td>
                            <td>'.$bname.'</td>
                        </tr>';
                    }
                ?>
            </div>
		</div>
				
			
		</div>			
	</body>
</html>