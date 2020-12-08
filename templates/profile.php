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

//grab profile information
$info = $pdo->prepare("SELECT email, branch_name FROM abc_airline.users, abc_airline.branch WHERE abc_airline.users.branch_id=abc_airline.branch.branch_id AND username=?");
$info->execute([$_SESSION['username']]);
$row = $info->fetch();

$email = $row['email'];
$branch_name = $row['branch_name'];

$suid = $_SESSION['uid'];
$username = $_SESSION['username'];

//query to check available mail in database
$message = "SELECT message, username FROM abc_airline.message, abc_airline.users WHERE suid=uid AND ruid=$suid";
$stmt = $pdo->prepare($message);
$stmt->execute();

//grab private key
$priKey = file_get_contents("../database/secure_file/$username.key");

?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>ABC Airlines - Staff Profile</h1>
				<a href="homepage.php"></i>Home</a>
				<a href="profile.php"></i>Profile</a>
				<a href="logout.php"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Profile Information</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Username:</td>
						<td><?=$_SESSION['username']?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=$email?></td>
					</tr>
					<tr>
						<td>Branch:</td>
						<td><?=$branch_name?></td>
					</tr>
				</table>
			</div>
		</div>
		
		<div class="content">
			<div class="mail">
				<h2>Send Messages</h2>
				<form action="../database/sendMail.php" method="POST"> 
					<input type="email" placeholder="receiver@abcairline.com" name="to" id="to" required> <br><br>

					<textarea placeholder="Your Message Here" name="message" id="message" required></textarea> <br><br>

					<input type="hidden" name="suid" id="suid" value="<?=$_SESSION['uid']?>">
					<input type="submit" value="Send Message">
				</form>
			</div>

			<div>
				<h2>Inbox</h2>
				<?php 
					//display all messages
					$result = $stmt->fetchAll();
					foreach($result as $row){
						$inbox = base64_decode($row['message']);
						$from = $row['username'];

						//decode with privake key
						openssl_private_decrypt($inbox, $decrypted, $priKey);

						echo '<table>
								<tr>
									 <td>FROM:</td>
									 <td>'.$from.'</td>
								</tr>
								<tr>
									<td>Message:</td>
									<td>'.$decrypted.'</td>
								</tr>
						</table><br><br>
						';
					}
				?>
			</div>
		</div>
	</body>
</html>