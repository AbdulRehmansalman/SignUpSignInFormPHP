<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title> Login / Signup Form</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css'>
    <?php include "css/style.php"; ?>
</head>

<body>
    <?php
    include 'dbcon.php';
    //! For SignIn Functionality
    if (isset($_POST['signin'])) {

        $emailverify =  $_POST['emailverify'];
        $passwordverify = $_POST['passwordverify'];
        $email_search = "select * from mtdb where email='$emailverify'";
        $query1 = mysqli_query($con, $email_search);
        //? Abb hum pata lagye ge,wo email ,aik baar db ma hai k nhi 
        $email_count1 = mysqli_num_rows($query1);
        if ($email_count1) {
            $email_pass = mysqli_fetch_assoc($query1);
            //! Jo Bhi USER ne email id de,Aus k correspondinhg humein ye password mil rha 
            $db_pass = $email_pass['password'];
            echo "WITHOUT HASH" . $db_pass;

            //? Abb jo Hum Likh rhe wo simple hai ,Or wo db ma Encrpted hai ,Tu Chrack kese karain :
            $pass_decode = password_verify($passwordverify, $db_pass);
            // echo "passworduserTyped" ." ". $passwordverify;

             echo "After hash" . " " . $pass_decode;

            //  Agar jo hum ne daala ,wo same hai ,wo user ne put kia,or jo dbbase ma likha tu;
            if ($pass_decode == true) {
                echo "Login Succesful";
            } else {
                echo "Password Incorrect";
                echo var_Dump($pass_decode);
            }
        } else {
            echo "Invalid Email";
        }
    }
//* For Sign up Button Functionality
    if (isset($_POST['submit'])) {
        //! This function is used whwn user enter special chracter and to add security layer:
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

        // ? Hashing
        $pass = password_hash($password, PASSWORD_BCRYPT);
        $cpass = password_hash($cpassword, PASSWORD_BCRYPT);
        // ? Check if same email is not enetered
        $eamilquery = "select * from mtdb where email='$email'";
        $query = mysqli_query($con, $eamilquery);
        // ! It Check if the email,rows is more than 0: Then we Dont get Registered
        $emailcount = mysqli_num_rows($query);
        if ($emailcount > 0) {
            echo "email already Exist";
        } else {
            if ($password === $cpassword) {
                $insertquery = "insert into mtdb (name,email,password,cpassword) values ('$name','$email','$pass','$cpass') ";
                $iquery = mysqli_query($con, $insertquery);
                if ($iquery) {
    ?>
                    <script>
                        alert("Sign up Succesful--:---- ");
                    </script>
                <?php
                } else {
                    echo " Not Inserted Data";
                }
            } else {
                ?>
                <script>
                    alert(" Password Incorrect!! plz Enter Correct Password");
                </script>

    <?php

            }
        }
    }

    ?>


    

    <div class="ocean">
        <div class="wave"></div>
        <div class="wave"></div>
    </div>
    <!-- Log In Form Section -->
    <section>
        <div class="container" id="container">
            <div class="form-container sign-up-container">
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="post">
                    <h1>Sign Up</h1>

                    <span>Or use your Email for registration</span>
                    <label>
                        <input type="text" placeholder="Name" name="name" required />
                    </label>
                    <label>
                        <input type="email" placeholder="Email" name="email" required />
                    </label>
                    <label>
                        <input type="password" placeholder="Password" name="password" required />
                    </label>
                    <label>
                        <input type="password" placeholder="Confirm Password" name="cpassword" required />
                    </label>
                    <button style="margin-top: 9px" type="submit" name="submit">Sign Up</button>
                </form>
            </div>
            <div class="form-container sign-in-container">
                <form action="" method="post">
                    <h1>Sign in</h1>
                    <div class="social-container">
                        <a href="#" target="_blank" class="social"><i class="fab fa-github"></i></a>
                        <a href="#" target="_blank" class="social"><i class="fab fa-codepen"></i></a>
                        <a href="#" target="_blank" class="social"><i class="fab fa-google"></i></a>
                    </div>
                    <span> Or sign in using E-Mail Address</span>
                    <label>
                        <input type="email" placeholder="Email" name="emailverify" />
                    </label>
                    <label>
                        <input type="password" placeholder="Password" name="passwordverify" />
                    </label>
                    <a href="#">Forgot your password?</a>
                    <button type="submit" name="signin">Sign In</button>
                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h1>Log in</h1>
                        <p>Sign in here if you already have an account </p>
                        <button class="ghost mt-5" id="signIn">Sign In</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1>Create, Account!</h1>
                        <p>Sign up if you still don't have an account ... </p>
                        <button class="ghost" id="signUp">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js'></script>
    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () =>
            container.classList.add('right-panel-active'));

        signInButton.addEventListener('click', () =>
            container.classList.remove('right-panel-active'));
    </script>
</body>

</html>