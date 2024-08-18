<?php

    error_reporting(0);

    $database = "ydwqrfyj_rentalServices";
    $username = "root";
    $server = "localhost";
    $pass = "";
    $conn = mysqli_connect( $server , $username , $pass );

    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SHOW DATABASES";
    $result1 = mysqli_query($conn , $sql);
    $dbExist = false;
    while( $row = mysqli_fetch_assoc($result1) ){
        if( $row['Database'] == $database ){
            $dbExist = true;
        }
    }
    if ( !($dbExist) ){
        $sql = "CREATE DATABASE $database";
        mysqli_query($conn , $sql);
    }

    $conn = mysqli_connect( $server , $username , $pass , $database);
    if( !($conn) ){
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $table = "sellers";
    $sql = "SHOW TABLES LIKE '$table'";
    $result2 = mysqli_query($conn , $sql);
    $tableExist = false;
    $row = mysqli_num_rows($result2);
    if( $row > 0 ){
        $tableExist = true;
    }
    if( !($tableExist) ){
        $sql = "CREATE TABLE `$table` ( `s.no.` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT , `name` VARCHAR(100) NOT NULL , `email` VARCHAR(100) NOT NULL , `pass` VARCHAR(100) NOT NULL , `tstamp` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP)";
        mysqli_query($conn , $sql);
    }

?>

<?php
    
    require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';
    require 'PHPMailer-master/src/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    $method = $_SERVER['REQUEST_METHOD'];
    $checkEmail = false;

    if($method == 'POST'){
        
        if(isset($_POST['emails'])){
            global $sellerEmail;
            global $sellerPassword;
            global $sellerName;
            $sellerEmail = $_POST['emails'];
            $sellerName = $_POST['names'];
            $sellerPassword = $_POST['pass'];
        }
    
    }

    $sql = "SELECT * FROM `sellers`";
    $result = mysqli_query($conn , $sql);
    $emailSame = false;
    while( $rows = mysqli_fetch_assoc($result) ){
        if($rows['email'] == $sellerEmail){
            $emailSame = true;
        }
    }
    
    if($emailSame){

        $url = 'loginSignup.php';
        $postData = array(
            'checkEmail' => $checkEmail , 'sellerEmail' => $sellerEmail , 'sellerPassword' => $sellerPassword
        );

        echo "<form id='redirectForm' action='{$url}' method='post'>";
        foreach ($postData as $key => $value) {
            echo "<input type='hidden' name='{$key}' value='{$value}' />";
        }
        echo "</form>";
        echo "<script>document.getElementById('redirectForm').submit();</script>";
        exit();

    } else {

        function sendMail($sellerEmail , $sellerPassword , $sellerName , $checkEmail){

            global $checkEmail;
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP(); 
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'amanderwal.xyz@gmail.com';
                $mail->Password = 'jprythitbczgwwsp';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('rar@gmail.com' , 'Rent-a-Rev');
                $mail->addAddress( $sellerEmail , $sellerName );
                $mail->isHTML(true);
                $mail->Subject = 'Welcome to Rent-a-Rev';
                $mail->Body = "Hello $sellerName , welcome to our seller dashboard of vehicle rental services 'Rent-a-Rev'!!<br><br>Your Login Credentials are :<br>
                id = $sellerEmail <br>password = $sellerPassword<br><br>Visit our website at 
                <a href='amanderwal.xyz'>amanderwal.xyz</a><br>Thank you,<br>Rent-a-Rev";
                $result = $mail->send();
                if($result){
                    $checkEmail = true;
                }
            } catch (Exception $e) {
                
            }

        }

        sendMail($sellerEmail , $sellerPassword , $sellerName , $checkEmail);
    
        if($checkEmail){
            $sql = "INSERT INTO `$table` ( `name` , `email` , `pass` ) VALUES ('$sellerName' , '$sellerEmail' , '$sellerPassword')";
            mysqli_query($conn , $sql);
        }

        $url = 'loginSignup.php';
        $postData = array(
            'checkEmail' => $checkEmail , 'sellerEmail' => $sellerEmail , 'sellerPassword' => $sellerPassword
        );

        echo "<form id='redirectForm' action='{$url}' method='post'>";
        foreach ($postData as $key => $value) {
            echo "<input type='hidden' name='{$key}' value='{$value}'>";
        }
        echo "</form>";
        echo "<script>document.getElementById('redirectForm').submit();</script>";
        exit();

    }

?>