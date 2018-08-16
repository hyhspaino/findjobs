<html>
<head>
  <style>
  .error {color: #FF0000;}
  </style>
  <title>Applicant Signup</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  
  <link rel="stylesheet" href="css/style.css">
</head>

<?php
// ================CONNECT===================
// connect to mysql db

  require_once 'db.php';

  $db_conn = new mysqli($hn, $un, $pw, $db);

  $current_login = $_COOKIE['login'];
// ==========================================

// ================APPLICANT=================
// set default value to variables
$applogin = $aname = $apassword = $aemail = $aaddress = "";
$aregistrationerr = $apploginerr = $asinerr = $anameerr = $aphonenumbererr = $apassworderr = $aconfirmpassworderr = $aemailerr = "";
$asin = $aphonenumber = 0;
$isvalid = 0;
$isregistered = 0;
$hastried = 0;

// check if form was submitted, then check the format of each input
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // isvalid is set to 0 if any input is in the wrong format
  $isvalid = 1;

  // hastried is set to 1 to begin displaying error messages
  $hastried = 1;

  // check format of applogin (required)
  if (empty($_POST['applogin'])) {
    $apploginerr = "Login is required.";
    $isvalid = 0;
  } else {
    $applogin = check_input($_POST['applogin']);
    // check if applogin uses valid characters
    if (!preg_match("/^[-.,:;!?#=%&$+@a-z_A-Z0-9 ]*$/",$applogin)) {
      $apploginerr = "Only letters, numbers, white space, and common symbols(-.,:;!?#=%&$+@) are allowed";
      $isvalid = 0;
    }
  }

  // check format of asin (optional, but if not empty has to be all numbers)
  // no input on asin is valid
  if (empty($_POST['asin'])) {
    $asin = 0;
  } elseif (!ctype_digit($_POST['asin'])) {
    // input was not empty, but was not all digits
    $asinerr = "Invalid SIN.";
    $isvalid = 0;
  } else {
    // input was all digits
    $asin = check_input($_POST['asin']);
  }

  // check format of aname (required)
  if (empty($_POST['aname'])) {
    $anameerr = "Name is required.";
    $isvalid = 0;
  } else {
      $checkaname = check_input($_POST['aname']);
      // check if name only has letters and whitespace
      if (!preg_match("/^[a-zA-Z ]*$/",$checkaname)) {
      $anameerr = "Only letters and white space allowed";
      $isvalid = 0;
      } else {
          $aname = check_input($_POST['aname']);
        }
  }

  // check format of aphonenumber (optional, but if not empty has to be all numbers)
  // no input on aphonenumber is valid
  if (empty($_POST['aphonenumber'])) {
    $aphonenumber = 0;
  } elseif (!ctype_digit($_POST['aphonenumber'])) {
    // input was not empty, but was not all digits
    $aphonenumbererr = "Invalid phone number.";
    $isvalid = 0;
  } else {
      // input was all digits
      $aphonenumber = check_input($_POST['aphonenumber']);
  }

  // check format of apassword (required)
  if (empty($_POST['apassword'])) {
    $apassworderr = "Password is required.";
    $isvalid = 0;
  } else {
    $apassword = check_input($_POST['apassword']);
    // check if apassword uses valid characters
    if (!preg_match("/^[-.,:;!?#=%&$+@a-z_A-Z0-9 ]*$/",$apassword)) {
      $apassworderr = "Only letters, numbers, white space, and common symbols(-.,:;!?#=%&$+@) are allowed";
      $isvalid = 0;
    }
  }

  // check if aconfirmpassword (required) matches password
  $aconfirmpassword = check_input($_POST['aconfirmpassword']);
  if (strcmp($apassword, $aconfirmpassword) !== 0) {
    $isvalid = 0;
    $apassworderr = "Passwords did not match.";
    $aconfirmpassworderr = "Passwords did not match.";
  }

  // check format of aemail (required)
  if (empty($_POST["aemail"])) {
  $aemailerr = "Email is required.";
  $isvalid = 0;
  } else {
     $checkaemail = check_input($_POST["aemail"]);
     // check if e-mail address is well-formed
     if (!filter_var($checkaemail, FILTER_VALIDATE_EMAIL)) {
       $aemailerr = "Invalid email format.";
       $isvalid = 0;
     } else {
         $aemail = check_input($_POST["aemail"]);
       }
  }
  
  // aaddress is optional, no restrictions on input
  $aaddress = check_input($_POST['aaddress']);
}

// removes whitespace, slashes, hsc
function check_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
// ==========================================

// ============APPLICANT QUERIES=============
// queries for applicant insertions
if($isvalid == 1){
  $applicantsquery = "INSERT INTO APPLICANTS(APP_LOGIN,SIN,NAME,PHONE_NUMBER,PASSWORD,EMAIL,ADDRESS) VALUES('$applogin','$asin','$aname','$aphonenumber','$apassword','$aemail','$aaddress')";
 

 $db_conn->query($applicantsquery);

 
  header("Location: http://hou119.myweb.cs.uwindsor.ca/60334/project/job/index.php");
}

 
//===========================================
?>

    <header class="wrapper clearfix">
      
    </header>
    <img src = "pictures /ti.png">
    <p>Already have an account?<a class="btn" href="index.php">Sign In to your account!</a>
      <br>
      Not an applicant?<a class="btn" href="signupemployer.php">Sign Up as an Employer!</a></p>
     
      
      <p><span class="error"><?php echo $aregistrationerr;?></span><p>
      <p><span class="error">* required field.</span></p>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Login: <input type="text" name="applogin">
        <span class="error">* <?php echo $apploginerr;?></span>
        <br><br>
        Password:
        <input type="password" name="apassword">
        <span class="error">* <?php echo $apassworderr;?></span>
        <br><br>
        Confirm Password:
        <input type="password" name="aconfirmpassword">
        <span class="error">* <?php echo $aconfirmpassworderr;?></span>
        <br><br>
        Name:
        <input type="text" name="aname">
        <span class="error">* <?php echo $anameerr;?></span>
        <br><br>
        Address:
        <input type="text" name="aaddress">
        <br><br>
        SIN:
        <input type="text" name="asin">
        <span class="error"> <?php echo $asinerr;?></span>
        <br><br>
        Phone Number:
        <input type="text" name="aphonenumber">
        <span class="error"> <?php echo $aphonenumbererr;?></span>
        <br><br>
        Email:
        <input type="text" name="aemail">
        <span class="error">* <?php echo $aemailerr;?></span>
        <br><br>
        <input type="submit" name="submit" value="Register">
      </form> 
    </div>

</html>