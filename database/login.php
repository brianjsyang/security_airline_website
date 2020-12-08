<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../database/dbsetup.php';


//connect to database: PHP Data object representing Database connection
$pdo = db_connect();
session_start();

if(!empty($_POST)){
    //grab user_id and user_pw for validation
    $stmt = $pdo->prepare('SELECT uid, user_pw, branch_id FROM abc_airline.users WHERE username=?');
    $stmt->execute([$_POST['username']]);
    
    if($stmt->rowCount() > 0){
        //matching row exists
        //verify password
        $row = $stmt->fetch();
        $uid = $row['uid'];
        $user_pw = $row['user_pw'];
        $branch_id = $row['branch_id'];

        if(password_verify($_POST['user_pw'], $user_pw)){
            //password match
            session_regenerate_id();
            $_SESSION['login'] = TRUE;
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['uid'] = $uid;
            $_SESSION['branch_id'] = $branch_id;
            
            header('Location: ../templates/homepage.php');
        }
        else {
            //password mismatch
            echo '<script>
                    alert("Incorrect username and/or password. Please try again.")
                    location="../templates/index.html"
            </script>';
        }
    }
    else {
        //no such id exists
        echo '<script>
                    alert("Incorrect username and/or password. Please try again.")
                    location="../templates/index.html"
            </script>';
    }
}

//end php
?>