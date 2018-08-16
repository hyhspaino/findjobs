
<html>

  <head>
     
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">


  <script src="js/nav.js"></script>
  </head>
  <body>
   <div align="center">
      <h1><img src = "pictures /ti.png"></h1>
   </div>


<?php
  require_once 'db.php';

  $conn = new mysqli($hn, $un, $pw, $db);
// set the cookie with the submitted user data
setcookie('login', $_POST['login']);
echo "<b>login:</b>".$_COOKIE['login'];
$APPLICANT_URL = "Applicant.php";
$EMPLOYER_URL = "Employer.php";
$ADMIN_URL = "Admin.php";


 if (!empty($_POST)) {
  // set the cookie with the submitted user data
  setcookie('login',$_POST['login']);
  // redirect the user to final landing page so cookie info is available
  header("Location:index.php");
 } else {
 echo "<b>login:</b>".$_COOKIE['login'];
 }


$success = True; //keep track of errors so it redirects the page only if there are no errors
//$db_connect = OCI_connect("ora_r8z8", "a35028125", "ug");


//if ($db_connect == false){
  //        echo "cannot connect";
    //    }

        	//	else if (array_key_exists('loginsubmit', $_POST)) {


				// Take Login and Password from form
					$bind1 = $_POST['login'];
$bind2= $_POST['psw'];
					echo "哈哈".	$bind1.$bind2;
				
				//Query applicant database to return a username
				// and password if it is in database
				$sql = "select APP_LOGIN, PASSWORD 
					from APPLICANTS where APP_LOGIN = '" . $bind1 ."' 
					AND  PASSWORD = '" . $bind2 ."' ";

			//	$stid = oci_parse($db_connect,$sql);
			//	oci_execute($stid);
 $result   = $conn->query($sql);



			//	$numrows = oci_fetch_all($stid, $res);
  $numrows = $result->num_rows;
  
 

				//check returned rows to see if contains anything
				if(($numrows) > 0){
				header( "Location: $APPLICANT_URL" );
				//jump to applicant page if username and password were in applicant table

				} else if ($numrows == 0){
					//check employer table since username and password was not 
					// found in applicant database
				$sql = "select EMP_LOGIN, PASSWORD 
					from EMPLOYER_RUNS where EMP_LOGIN = '" . $bind1 ."' 
					AND  PASSWORD = '" . $bind2 ."' ";

				//$stid = oci_parse($db_connect,$sql);
			//	oci_execute($stid);
 $result   = $conn->query($sql);

				//$numrows = oci_fetch_all($stid, $res);

  $numrows = $result->num_rows;
  
 

				if(($numrows) > 0){
				
				header( "Location: $EMPLOYER_URL" );
				//jump to applicant page if username and password were in applicant table

				}else{

	$sql = "select APP_LOGIN, PASSWORD 
					from ADMIN where APP_LOGIN = '" . $bind1 ."' 
					AND  PASSWORD = '" . $bind2 ."' ";

				//$stid = oci_parse($db_connect,$sql);
			//	oci_execute($stid);
 $result   = $conn->query($sql);

				//$numrows = oci_fetch_all($stid, $res);

  $numrows = $result->num_rows;
  
 if(($numrows) > 0){
				header( "Location: $ADMIN_URL" );
				//jump to admin page if username and password were in admin table

				}

else {
		echo "Incorrect username and password combination";
}
			
				}


			}
//}
/*
*/

?>

<img src = "pictures /ti.png">
</body>