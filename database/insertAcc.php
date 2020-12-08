<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../database/dbsetup.php';

//connect to database: PHP Data object representing Database connection
$pdo = db_connect();

//insert new account information to the database
$username = $_POST['username'];
$user_pw = password_hash($_POST['user_pw'], PASSWORD_DEFAULT); 
$email = $_POST['email'];
$branch_id = $_POST['branch_id'];

$insert = "INSERT INTO abc_airline.users (username, user_pw, email, branch_id)
            VALUES ('$username', '$user_pw', '$email', '$branch_id')";

$stmt = $pdo->prepare($insert);
$stmt->execute();

if($stmt->rowCount() == 0) {
    //Failed to create.
    echo '<script>
            alert("Faile to create new account. Verify info and try again.")
            location="../templates/createID.php"
    </script>';
}
else {
    //Create public/private key pair for the new user.
    $config = array(
        "digest_alg" => "sha512",
        "private_key_bits" => 4096,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );
        
    $res = openssl_pkey_new($config);

    openssl_pkey_export($res, $priKey);
    $pubKey = openssl_pkey_get_details($res);
    $pubKey = $pubKey["key"];
    
    //Grab receiver UID
    $last_ID = $pdo->lastInsertId();
    $intID = (int)$last_ID;
    

    $insertPub = "INSERT INTO abc_airline.pub_key (uid, pub_key)
                    VALUES ('$intID', '$pubKey')";
    $stmt = $pdo->prepare($insertPub);
    $stmt->execute();

    file_put_contents("secure_file/$username.key", $priKey);
    
    //creation success
    echo '<script>
            alert("New Account has been succesfully created")
            location="../templates/adminPage.php"
    </script>';
    
    
}

//end php
?>