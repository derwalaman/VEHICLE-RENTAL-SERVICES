<?php

    error_reporting(0);
    session_start();

    if (isset($_SESSION['selleremail'])) {
        if (isset($_SESSION['sellerpass'])) {
            $url = "index.php";
            header("Location: " . $url);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<title>Rent-a-Rev</title>
</head>

<body>

    <?php 

            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == 'POST') {

                if (isset($_POST['checkEmail'])) {
                    $checkEmail = $_POST['checkEmail'];
                    $SellerEmail = $_POST['sellerEmail'];
                    $SellerPass = $_POST['sellerPass'];

                    if($checkEmail){
                        session_start();
                        $_SESSION['selleremail']=$SellerEmail;
                        $_SESSION['sellerpass']=$SellerPass;
                        echo '<script>alert("Registeration done successfully......")</script>';
                        $url = "index.php";
                        echo"<meta http-equiv='refresh' content='0;url=$url'>";
                    } else {
                        echo '<script>alert("Registration Failed !! Please try again........")</script>';
                        $url = "loginSignup.php";
                        echo"<meta http-equiv='refresh' content='0;url=$url'>";
                    }

                } else {

                    if (isset($_POST['lvEmail'])){
                        $sellerEmail = $_POST['lvEmail'];
                        $sellerPassword = $_POST['lvPass'];
                        $sEmail = $_POST['vemail'];
                        $sPass = $_POST['vpass'];

                        if($sEmail && $sPass){
                            session_start();
                            $_SESSION['selleremail']=$sellerEmail;
                            $_SESSION['sellerpass']=$sellerPassword;
                            echo '<script>alert("Login done successfully.......")</script>';
                            $url = "index.php";
                            echo"<meta http-equiv='refresh' content='0;url=$url'>";
                        } else {
                            echo '<script>alert("Login Failed !! Please try again......")</script>';
                            $url = "loginSignup.php";
                            echo"<meta http-equiv='refresh' content='0;url=$url'>";
                        }
        
                    }

                }

            }

        ?>

    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">

                <form action="login.php" method="post" class="sign-in-form">
                    <h2 class="title">Sign in</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" required placeholder="Email" id="lemail" name="lemail" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" required placeholder="Password" id="lpass" name="lpass" />
                    </div>
                    <input type="submit" value="Login" class="btn solid" />
                    <p class="social-text">Or follow us on social media</p>
                    <div class="social-media">
                        <a href="https://wa.me/918238790204?text=Hello" class="social-icon">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://msng.link/o?amanderwal02=tg" class="social-icon">
                            <i class="fab fa-telegram"></i>
                        </a>
                        <a href="https://www.instagram.com/amanderwal02/" class="social-icon">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://github.com/amanderwal02" class="social-icon">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </form>

                <form action="register.php" method="post" class="sign-up-form">
                    <h2 class="title">Sign up</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" required placeholder="Sellername" name="names" id="names" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" required placeholder="Email" name="emails" id="emails" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" required placeholder="Password" id="pass" name="pass" />
                    </div>
                    <input type="submit" class="btn" value="Sign up" />
                    <p class="social-text">Or follow us on social media</p>
                    <div class="social-media">
                        <a href="https://wa.me/918238790204?text=Hello" class="social-icon">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://msng.link/o?amanderwal02=tg" class="social-icon">
                            <i class="fab fa-telegram"></i>
                        </a>
                        <a href="https://www.instagram.com/amanderwal02/" class="social-icon">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://github.com/amanderwal02" class="social-icon">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </form>

            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New here ?</h3>
                    <p>
                        Register yourself with us and rent 
                        your vehicle today and start earning !!
                    </p>
                    <button class="btn transparent" id="sign-up-btn">
                        Sign up
                    </button>
                </div>
                <img src="" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>One of us ?</h3>
                    <p>
                        Login your account and start earning today
                        by renting your vehicles !!
                    </p>
                    <button class="btn transparent" id="sign-in-btn">
                        Sign in
                    </button>
                </div>
                <img src="" class="image" alt="" />
            </div>
        </div>

    </div>

    <script src="app.js"></script>

</body>

</html>