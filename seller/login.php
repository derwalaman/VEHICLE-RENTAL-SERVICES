<?php
    
    error_reporting(0);

    $database = "ydwqrfyj_rentalServices";
    $username = "root";
    $server = "localhost";
    $pass = "";

    $passStatus = false;
    $emailStatus = false;

    $conn = mysqli_connect( $server , $username , $pass , $database );
    if( !($conn) ){
        die("Connection failed: " . mysqli_connect_error());
    }

    $method = $_SERVER['REQUEST_METHOD'];

    if( $method == 'POST'){

        if(isset($_POST['lemail'])){
            $sellerEmail = $_POST['lemail'];
            $sellerPassword = $_POST['lpass'];
        }

    }

    $sql = "SELECT * FROM `sellers`";
    $result = mysqli_query($conn , $sql);
    while( $row = mysqli_fetch_assoc($result) ){
        if($row['email'] == $sellerEmail){
            $emailStatus = true;
            if($row['pass'] == $sellerPassword){
                $passStatus = true;
            }
        }
    }

    $url = 'loginSignup.php';
    $postData = array(
        'lvEmail' => $sellerEmail , 'lvPass' => $sellerPassword , 'vemail' => $emailStatus , 'vpass' => $passStatus
    );

    echo "<form id='redirectForm' action='{$url}' method='post'>";
    foreach ($postData as $key => $value) {
        echo "<input type='hidden' name='{$key}' value='{$value}'>";
    }
    echo "</form>";
    echo "<script>document.getElementById('redirectForm').submit();</script>";
    exit();

?>