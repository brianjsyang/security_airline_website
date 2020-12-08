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
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <title>Create New Employee ID</title>
        <link href="style.css" rel="stylesheet" type="text/css">
	</head>

	<body>
		<div class="login">
			<h1>Create New Employee ID</h1>
			<form action="../database/insertAcc.php" method="POST">
				<label for="username"></label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				
				<label for="password"></label>
                <input type="password" name="user_pw" placeholder="Password" id="user_pw" required>
                
                <label for ="email"></label>
                <input type="text" name="email" placeholder="example@abcairline.com" id="email" required>
                
                <label for ="branch"></label>
                <select id="branch_id" name="branch_id">
                    <option value="none">--choose a branch--  
                    <option value="1">HQ
                    <option value="2">Branch 1
                    <option value="3">Branch 2    
                </select>
                

				<input type="submit" value="Create New Account">
			</form>
		</div>
	</body>
</html>