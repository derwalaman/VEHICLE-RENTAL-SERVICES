<?php

    error_reporting(0);

    $username = "root";
    $server = "localhost";
    $pass = "";
    $conn = mysqli_connect( $server , $username , $pass );

    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }

    $database = "ydwqrfyj_rentalServices";
    $sql = "SHOW DATABASES";
    $result1 = mysqli_query($conn , $sql);
    $dbExist = false;
    while( $row = mysqli_fetch_assoc($result1) ){
        if( $row['Database'] == $database ){
            $dbExist = true;
        }
    }
    if ( !($dbExist) ){
        echo '<script>alert("Please Sign up !!")</script>';
        $url = "loginSignup.php";
        header("Location: " . $url);
    }

    $passStatus = false;
    $emailStatus = false;

    $conn = mysqli_connect( $server , $username , $pass , $database );
    if( !($conn) ){
        die("Connection failed: " . mysqli_connect_error());
    }

    $method = $_SERVER['REQUEST_METHOD'];

    if( $method == 'POST'){

        if(isset($_POST['lemail'])){
            $userEmail = $_POST['lemail'];
            $userPassword = $_POST['lpass'];
        }

    }

    $table = "users";
    $sql = "SHOW TABLES LIKE '$table'";
    $result2 = mysqli_query($conn , $sql);
    $tableExist = false;
    $row = mysqli_num_rows($result2);
    if( $row > 0 ){
        $tableExist = true;
    }
    if( !($tableExist) ){
        echo '<script>alert("Please Sign up !!")</script>';
        $url = "loginSignup.php";
        header("Location: " . $url);
    }

    $sql = "SELECT * FROM `users`";
    $result = mysqli_query($conn , $sql);
    while( $row = mysqli_fetch_assoc($result) ){
        if($row['email'] == $userEmail){
            $emailStatus = true;
            if($row['pass'] == $userPassword){
                $passStatus = true;
            }
        }
    }

    $url = 'loginSignup.php';
    $postData = array(
        'lvEmail' => $userEmail , 'lvPass' => $userPassword , 'vemail' => $emailStatus , 'vpass' => $passStatus
    );

    echo "<form id='redirectForm' action='{$url}' method='post'>";
    foreach ($postData as $key => $value) {
        echo "<input type='hidden' name='{$key}' value='{$value}'>";
    }
    echo "</form>";
    echo "<script>document.getElementById('redirectForm').submit();</script>";
    exit();

?>