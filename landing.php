
<?php
include('error.php');
//header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
//echo $undefined;
//include('404page.php');
// start session storage
session_start();
require_once './Models/Signup.php';
require_once './Models/Validation.php';
// require PHPMailerAutoload
require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

//new instance of validation class
$valididate = new Validation();
$error = '';

//check if form is set
    if (isset($_POST['Register'])){
        // gets value of requested variable
        $fname = filter_input(INPUT_POST, "fName");
        $lName = filter_input(INPUT_POST, "lName");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        // access_token => current minute (w/ leading zeros) and standard DES-based hash of $email, Swatch Internet time (0-999)
        $access = date('i') . crypt($email,'e') . date('B');

        // concatenate user's first and last name
        $fullName = $fname . ' ' . $lName;



        // new instance of PHPMailer
        $mail = new PHPMailer;

        // set mailer to use SMTP
        $mail->isSMTP();

        // Enable verbose debug output
        //$mail->SMTPDebug = 3;

        //Specify main & backup SMTP servers
        $mail->Host = 'smtp.gmail.com';

        // Enable SMTP authentication
        $mail->SMTPAuth = true;

        // SMTP username
        $mail->Username = 'healthhack.about@gmail.com';
        // SMTP password
        $mail->Password = 'p()s()w()d()';

        // Specify encrpytion
        $mail->SMTPSecure = 'TSL';

        // TCP port to connect to
        $mail->Port = 587;

        $mail->setFrom('healthhack.about@gmail.com', 'Health Hack');
        // Recipient
        $mail->addAddress("$email" , "$fullName");

        // Set email format to HTML
        $mail->isHTML(true);

        // Subject of email
        $mail->Subject = "Welcome to Healthhack!";
        // Body of email
        $url = "http://health-hack.azurewebsites.net/health-hack/index.php?access_token=" . $access;


        $mail ->Body = "Thanks for signing up $fullName. Welcome to Healthhack.<br /><br /><a href='$url'>Click her to confirm your account</a>.";
        // alternatively, set text for non-HTML ==> $mail->AltBody

        //new instance of Signup()
        $db = new Signup();
        //call newUser() method in Signup()
        $db->newUser($fname, $lName, $email, $password,$access);

        // validate => if email is unable to send, inform user and let them know mailer error
        if(!$mail->send())
        {
            $sentEmail = 'Message could not be sent';
            echo 'Mailer error: ' . $mail->ErrorInfo;
        }
        else
        {
            //echo 'Message has been sent to ' . $email;
            $sentEmail = "A confirmation email has been sent to $email. Please click the link to confirm";
        }

    }

    //check if form is set (login)
    if (isset($_POST['Login'])){

        // grab values from login form
        $loggedInUser = filter_input(INPUT_POST, 'loginUser');
        $loggedInPass = filter_input(INPUT_POST, 'loginPass');

        //new instance of Signup()
        $db = new Signup();
        //call newUser() method in Signup()
        $userId = $db->isValidUser($loggedInUser, $loggedInPass);


        //if invalid login
        if($userId)
        {
            // initialize new SESSION variable
            $_SESSION['user'] = $userId->user_id;

            //point page to index.php
            header("Location: index.php");
        }
        else
        {
            $error = "Invalid email or password. Please try again";
        }
    }

    // check if form is set (reset)
    if(isset($_POST['Reset'])){

        // grab values from reset form
        $userEmail = filter_input(INPUT_POST, "emailReset");

        // new instance of Signup()
        $db = new Signup();
        // call userInfoByEmail() in Signup()
        $Email = $db->userInfoByEmail($userEmail);

        $returnedUserEmail = $Email->email;
        $returnedUserName = $Email->first_name . ' ' . $Email->last_name;

        //if email is not registered
        if($Email === null)
        {
            $error = "We couldn't find the request email. Please enter a valid email";
            return false;
        }
        else
        {
            //encode a password reset token
            $passwordToken = base64_encode("$returnedUserEmail");

            // call grantPasswordResetToken() in Signup
            $reset = $db->grantPasswordResetToken($passwordToken,$returnedUserEmail);

            //check if grantPasswordResetToken() returned true
            if ($reset === null)
            {
                $error = "unable to reset password, please try again. Ensure provided email is correctly spelled.";

            }
            else
            {
                // new instance of PHPMailer
                $mail = new PHPMailer;

                // set mailer to use SMTP
                $mail->isSMTP();

                // Enable verbose debug output
                //$mail->SMTPDebug = 3;

                //Specify main & backup SMTP servers
                $mail->Host = 'smtp.gmail.com';

                // Enable SMTP authentication
                $mail->SMTPAuth = true;

                // SMTP username
                $mail->Username = 'healthhack.about@gmail.com';
                // SMTP password
                $mail->Password = 'p()s()w()d()';

                // Specify encrpytion
                $mail->SMTPSecure = 'TSL';

                // TCP port to connect to
                $mail->Port = 587;

                $mail->setFrom('healthhack.about@gmail.com', 'Health Hack');
                // Recipient
                $mail->addAddress("$returnedUserEmail" , "$returnedUserName");

                // Set email format to HTML
                $mail->isHTML(true);

                // Subject of email
                $mail->Subject = "Healthhack: Password reset ";
                // Body of email
                $url = "http://health-hack.azurewebsites.net/health-hack/Dashboard/resetpassword.php?reset_token=" . $passwordToken;


                $mail ->Body = "Hey $returnedUserName.<br /> Sorry you forgot your password.<br /><br /><a href='$url'>Click her to create a new one</a>.";
                // alternatively, set text for non-HTML ==> $mail->AltBody


                // validate => if email is unable to send, inform user and let them know mailer error
                if(!$mail->send())
                {
                    $sentEmail = 'Message could not be sent';
                    echo 'Mailer error: ' . $mail->ErrorInfo;
                }
                else
                {
                    //echo 'Message has been sent to ' . $email;
                    $sentEmail = "An email to reset your password has been sent to $returnedUserEmail. Please following the instructions in the email to reset your password";
                }
            }
        }
    }
?>
<!--

    Authors: Kelly Ann McNamara
    Client: Health Hack
    Project: Php Group Project 2017
    Verison: 1.0

    _________________________________

    INDEX
    01. Top Bar
    02. Main Content

-->
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!--<meta http-equiv="refresh" content="5">-->
    <title>Health Hack</title>
    <link rel="shortcut icon" sizes="16x16 24x24 32x32 48x48 64x64" href="opt-imgs/favicon.png">
    <!-- Importing Files -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="./main.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet">
</head>
<body>
    <div id="landing-topbar" class="col-12">
        <img src="opt-imgs/logo.svg" alt="Health Hack Logo" width="43" />
    </div>
    <main id="landing-main" class="col-12 row">
        <h2 class="col-12">You will never know your limits unless you push yourself.</h2>
        <span class="text-info"><?php if(isset($sentEmail)){ echo $sentEmail; }?></span>
        <div id="landing-btns" class="col-12">
            <button type="button" id="loging-btn" data-toggle="modal" data-target="#loginModal">Login</button>
            <button type="button" id="signup-btn" data-toggle="modal" data-target="#SignupModal">Sign Up</button>
        </div>
    </main>
    <div id="loginModal" class="modal fade" role="form">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
                <img src="opt-imgs/login-photo.png" class="profile-photo" alt="Profile Photo" />
                <h2>Health Hack</h2>
            <form action="landing.php" method="post" id="login-form">
                <span class="errorLogin alert-danger"><?php if (isset($error)){ echo $error;}?></span>
                <div class="form-field">
                    <label for="loginUser" class="formLabel">Email</label>
                    <input type="text" id="loginUser"  name="loginUser" class="textInput" placeholder="Email" />
                </div>
                <div class="form-field">
                    <label for="loginPass" class="formLabel">Password</label>
                    <input type="password" id="loginPass"  name="loginPass" class="textInput" placeholder="Password" />
                </div>
                <input type="submit" class="formSubmit" name="Login" value="Login" />
            </form>
                  <div class="form-field">
                      <button type="button" data-dismiss="modal" data-toggle="modal" data-target="#resetModal" class="formResetBtn">Reset Your Password</button>
                  </div>
          </div>
        </div>
      </div>
    </div>
    <div>
        <div id="SignupModal" class="modal fade" role="form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <img src="opt-imgs/login-photo.png" class="profile-photo" alt="Profile Photo" />
                        <h2>Health Hack</h2>
                        <h3>Create an Account</h3>
                        <form action="landing.php" method="post" id="signup-form">
                            <span class="errorSignup alert-danger"><?php if (isset($error)){ echo $error;}?></span>
<!--                            <span class="">--><?php //if (isset($error)){ echo $error;}?><!--</span>-->
                            <div class="form-field">
                                <label class="formLabel">First Name</label>
                                <input type="text" class="textInput" id="signupFirst" name="fName" placeholder="First Name"/>
                            </div>
                            <div class="form-field">
                                <label class="formLabel">Last Name</label>
                                <input type="text" class="textInput" id="signuplast" name="lName" placeholder="Last Name"/>
                            </div>
                            <div class="form-field">
                                <label class="formLabel">Email</label>
                                <input type="email" class="textInput" id="signupEmail" name="email" placeholder="Email"/>
                            </div>
                            <div class="form-field">
                                <label class="formLabel">Password</label>
                                <input type="password" class="textInput" id="signupPassword"  name="password" placeholder="Password" />
<!--                                <span class="text-info">Passwords must be 8 characters, contain at least 1 number and one capital letter. </span>-->
                            </div>
                            <input type="submit" class="button" name="Register" value="Register" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="resetModal" class="modal fade" role="form">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div>
                    <div class="modal-body">
                        <img src="opt-imgs/login-photo.png" class="profile-photo" alt="Profile Photo" />
                        <h2>Health Hack</h2>
                        <h3>Password reset</h3>
                        <p>Looks like you forgot your password. That happens, we understand. Please enter your email below and we'll send you a link to reset it.</p>
                        <form action="landing.php" method="post" id="reset-form">
                            <span class="errorReset alert-danger"><?php if (isset($error)){ echo $error;}?></span>
                            <div class="form-field">
                                <label class="formLabel">Email</label>
                                <input type="text" class="textInput" id="resetEmail" name="emailReset" placeholder="Email"
                            </div>
                            <input type="submit" class="button" name="Reset" value="Reset" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
    <!-- Importing Files -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script src="Scripts/script.js"></script>
</html>
