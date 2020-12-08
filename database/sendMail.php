<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../database/dbsetup.php';

//connect to database: PHP Data object representing Database connection
$pdo = db_connect();

//important variables
$email = $_POST['to'];
$message = $_POST['message'];
$suid = $_POST['suid'];

//verify receiver email exists in database
$verfy_mail = "SELECT * FROM abc_airline.users WHERE email=?";
$check = $pdo->prepare($verfy_mail);
$check->execute([$email]);

if($check->rowCount() > 0){
    //email exists
    //grab public key of receiver
    $receiver = "SELECT pub_key, users.uid FROM abc_airline.users, abc_airline.pub_key WHERE abc_airline.users.uid=abc_airline.pub_key.uid AND users.uid = (SELECT uid FROM abc_airline.users WHERE email='$email')";

    $stmt = $pdo->prepare($receiver);
    $stmt->execute();
    $row = $stmt->fetch();

    $pubKey = $row['pub_key'];
    $receiverID = $row['uid'];

    //encrypt message with receiver's public key
    openssl_public_encrypt($message, $secret, $pubKey);

    $encrypted_msg = base64_encode($secret);


    //insert encrypted message to database.
    $insert_msg = "INSERT INTO abc_airline.message (ruid, message, suid)
                    VALUES ('$receiverID', '$encrypted_msg', '$suid')";
    $stmt2 = $pdo->prepare($insert_msg);
    $stmt2->execute();

    if($stmt2->rowCount() == 0){
        echo '<script>
                alert("Message was unable to be sent.")
                location="../templates/profile.php"
            </script>';
    }
    else{
        echo '<script>
                alert("Message sent!")
                location="../templates/profile.php"
            </script>';
    }        
}
else{
    echo '<script>
             alert("No such email exists.")
            location="../templates/profile.php"
        </script>';
}

?>