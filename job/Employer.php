<html>
<head>
  <title>Employer</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="css/style.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  

  <script src="js/nav.js"></script>
</head>
<div class="container">
  <h1><img src = "pictures /ti.png"></h1>
  
<div class="topnav" id="myTopnav">
  <a data-toggle="tab" href="#applicants" class="active">Applicants</a>
  <a data-toggle="tab" href="#my_jobs">My Jobs</a>
  <a data-toggle="tab" href="#add">Post New Job</a>
  <a data-toggle="tab" href="#my_applicants">Applied</a>

  <a data-toggle="tab" href="#offer_invite">Offer/Invite for Job</a>
  <a data-toggle="tab" href="#delete">Delete Job Postings</a>

  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>

  <div class="tab-content">

    <!-- __________________APPLICANTS_PANEL_____________________START_________________-->

    <div id="applicants" class="tab-pane fade in active">
      <h3>Applicants</h3>
      <p>List of applicants</p>
      <?php

      // this php mark as done

       require_once 'db.php';

  $db_conn = new mysqli($hn, $un, $pw, $db);

  $current_login = $_COOKIE['login'];

function exeSql($sql,$fieldArray,$conn) {
 
      $result_total   = $conn->query( $sql );
  $num_results = $result_total->num_rows; 
 
 for ($i = 0 ; $i < $num_results ; ++$i)
  {

$htmlTags = "<tr>";
     $result_total->data_seek($i);
    $row_cur_skill =  $result_total ->fetch_array(MYSQLI_ASSOC);
   
    foreach ($fieldArray as $filed) {
 $htmlTags=$htmlTags."<td>". $row_cur_skill[$filed]."</td>";
}
 $htmlTags=$htmlTags."</tr>";
echo $htmlTags;
}


}




        if ($db_conn == false){
          echo "cannot connect";
        }
        $sql = "select * from APPLICANTS";

       
        echo "<table border = 1>";
        echo "<tr><th>Login</th><th>Name</th><th>Phone #</th><th>Email</th><th>Address</th></tr>";
       

 $fieldArray=array("APP_LOGIN","NAME","PHONE_NUMBER","EMAIL","ADDRESS"); 
exeSql($sql,$fieldArray,$db_conn);
      
        echo "</table>";
        echo "</br>";
      ?>

      <form method = "POST" action = "FilteredApplicants.php">
        Skill: <input type="text" name="skill">
        <input type="submit" value="Filter" name = "filter">
      </form>
    </div>
    

    <!-- __________________APPLICANTS_PANEL_____________________END_________________-->



    <!-- __________________MY_JOBS_PANEL_____________________START_________________-->

    <div id="my_jobs" class="tab-pane fade">
      <h3>My Jobs</h3>
      <p>List of jobs created by me</p>

      <?php
        $sql = "select * from JOB_POSTINGS where LOGIN = '" . $current_login . "'";

  
        echo "<table border = 1>";
        echo "<tr><th>Job ID</th><th>Title</th><th>Date</th><th>Salary</th><th>Description</th></tr>";
       

 $fieldArray=array("JOB_ID","JOB_TITLE","POSTING_DATE","SALARY","DESCRIPTION"); 
exeSql($sql,$fieldArray,$db_conn);
      
        echo "</table>";
      ?>

    </div>
      <!-- __________________MY_JOBS_PANEL_____________________END_________________-->


<!-- __________________ADD PANEL_____________________START_________________-->

    <div id="add" class="tab-pane fade">
      <h3>New Job</h3>
      <form method = "POST" action = "Employer.php" id = "add_job">
        <p>Title: <input type="text" name="job_title"> Salary ($): <input type="text" name="job_salary"></p>
        <p>Description <input type="text" name="job_description" ></p>
        <p>Required Skills</p>
        <select name = "skill1" form = "add_job">
          <option value = "empty">----</option>
          <?php


            $sql = "select skill from SKILLS";

         $result_my_skills_total   = $db_conn->query( $sql );
  $num_my_skills = $result_my_skills_total->num_rows; 
 for ($jk = 0 ; $jk < $num_my_skills ; ++$jk)
  { 
      $result_my_skills_total->data_seek($jk);
    $row_my_skill = $result_my_skills_total->fetch_array(MYSQLI_ASSOC);
 var_dump($row_my_skill);
              $skill = $row_my_skill['skill'];
              echo " <option value='". $skill ."''>". $skill ."</option>";
            }
          ?>
        </select>
        <select name = "prof1" form = "add_job">
          <?php
            for($i = 0; $i <= 10; $i++){
              echo " <option value='". $i ."''>". $i ."</option>";
            }
          ?>
        </select>
        </br>
        <select name = "skill2" form = "add_job">
          <option value = "empty">----</option>
          <?php
          
            $sql = "select skill from SKILLS";

         $result_my_skills_total   = $db_conn->query( $sql );
  $num_my_skills = $result_my_skills_total->num_rows; 
 for ($jk = 0 ; $jk < $num_my_skills ; ++$jk)
  { 
      $result_my_skills_total->data_seek($jk);
    $row_my_skill = $result_my_skills_total->fetch_array(MYSQLI_ASSOC);
 var_dump($row_my_skill);
              $skill = $row_my_skill['skill'];
              echo " <option value='". $skill ."''>". $skill ."</option>";
            }
        
          ?>
        </select>
        <select name = "prof2" form = "add_job">
          <?php
            for($i = 0; $i <= 10; $i++){
              echo " <option value='". $i ."''>". $i ."</option>";
            }
          ?>
        </select>
        </br>
        <select  name = "skill3" form = "add_job">
          <option value = "empty">----</option>
          <?php
         
   $sql = "select skill from SKILLS";

         $result_my_skills_total   = $db_conn->query( $sql );
  $num_my_skills = $result_my_skills_total->num_rows; 
 for ($jk = 0 ; $jk < $num_my_skills ; ++$jk)
  { 
      $result_my_skills_total->data_seek($jk);
    $row_my_skill = $result_my_skills_total->fetch_array(MYSQLI_ASSOC);
 
              $skill = $row_my_skill['skill'];
              echo " <option value='". $skill ."''>". $skill ."</option>";
            }
          ?>
        </select>
        <select name = "prof3" form = "add_job">
          <?php
            for($i = 0; $i <= 10; $i++){
              echo " <option value='". $i ."''>". $i ."</option>";
            }
          ?>
        </select>
        </br>
        </br>
        <input type="submit" value="Post Job" name = "post">
    </form>
    </div>


    <!-- __________________ADD PANEL_____________________END_________________-->



    <!-- __________________MY_APPLICANTS_PANEL_____________________START_________________-->
    <div id="my_applicants" class="tab-pane fade">
      <h3>Applicants applied to my jobs</h3>
      <p>List of Applicants applied to my jobs</p>

      <?php
        $jobs_by_employer = "create view jobs_by_employer as select job_id from JOB_POSTINGS where login = '".$current_login."'"; 
    $db_conn->query( $jobs_by_employer );
 
        $yams = "select A.login 
                 from APPLY A, jobs_by_employer J
                 where A.job_id = J.job_id";
        $sql = "select Ap.app_login, A2.job_id, Ap.name, Ap.phone_number, Ap.email, Ap.address 
                from APPLICANTS Ap, APPLY A2 
                where Ap.app_login in (" . $yams . ") AND Ap.app_login = A2.login";
 
        

        echo "<table border = 1>";
        echo "<tr><th>Job ID</th><th> Login</th><th>Name</th><th>Phone #</th><th>Email</th><th>Address</th></tr>";
      

 $fieldArray=array("job_id","app_login","name","phone_number","email","address"); 
exeSql($sql,$fieldArray,$db_conn);
    
        echo "</table>";



        //delete the created view
        $drop = "drop view jobs_by_employer";
        
   $db_conn->query( $drop );
 
      ?>

    </div>

    <!-- __________________MY_APPLICANTS_PANEL_____________________END_________________-->


    <!-- __________________OFFER/INVITE_PANEL_____________________START_________________-->


    <div id="offer_invite" class="tab-pane fade">
      <h3>Offer Job</h3>
      <form method = "POST" action = "Employer.php">
        <p>Applicant login: <input type="text" name="app_login"></p>
        <p>Job_ID: <input type="text" name="job_id"></p>
        <input type="submit" value="Offer" name="offer">
      </form>
      <h3>Invite to a Job Interview</h3>
      <form method = "POST" action = "Employer.php">
        <p>Applicant login: <input type="text" name="app_login"></p>
        <p>Job_ID: <input type="text" name="job_id"></p>
        <p>Date (YYYY-MON-DD): <input type="text" name="date"></p>
        <p>Time (hh:mm:ss): <input type="text" name="time"></p>
        <p>Address: <input type="text" name="address"></p>
        <input type="submit" value="Invite" name="invite">
      </form>
    </div>

    <!-- __________________OFFER/INVITE_PANEL_____________________END_________________-->




    <!-- __________________DELETE_PANEL_____________________START_________________-->

    <div id="delete" class="tab-pane fade">
      <h3>Delete Job by Job ID</h3>
      <form method = "POST" action = "Employer.php">
        Job ID: <input type="text" name="delete_job_id">
        <input type="submit" value="Delete Job" name="delete">
      </form>
    </div>

    <!-- __________________DELETE_PANEL_____________________START_________________-->


    <!-- __________________PERFECT_PANEL_____________________START_________________-->

   

    </div> 
    <!-- __________________PERFECT_PANEL_____________________END_________________-->
  </div>
</div>
</html>





<?php



if ($db_conn){

  //______________POST________________
  if(array_key_exists('post', $_POST)){

    
    $job_title = $_POST['job_title'];

    $salary = $_POST['job_salary'];

    $desc = $_POST['job_description'];

    $date = date("o") ."-". date("m") ."-". date("d");

    $query = "select job_id from JOB_POSTINGS";
  

    $random = rand(10000000,99999999);


   




    $job_id = $random; //Set the job_id for a job posting

    $date = "str_to_date('" .$date. "','%Y-%m-%d')";

    //Add the job_posting into the JOB_POSTINGS
    $statement = "insert into JOB_POSTINGS VALUES ('" . $job_id . "','" . $current_login . "','" . $desc . "'," . $date . ",'" . $job_title . "','" . $salary . "')"; 
    $db_conn->query( $statement );
 
    //Retrieve the skills and proficiencies from input
    $skill1 = $_POST['skill1'];
    $skill2 = $_POST['skill2'];
    $skill3 = $_POST['skill3'];

    $prof1 = $_POST['prof1'];
    $prof2 = $_POST['prof2'];
    $prof3 = $_POST['prof3'];


    //Add the skills to a job_requires_skill
    if($skill1 != 'empty'){    
      $query = "insert into JOB_REQUIRES_SKILLS VALUES ('" . $job_id . "','" . $skill1 . "','" . $prof1 . "')";
         $db_conn->query( $query );
 
    }

    if(($skill2 != 'empty') && ($skill2 != $skill1)){
      $query = "insert into JOB_REQUIRES_SKILLS VALUES ('" . $job_id . "','" . $skill2 . "','" . $prof2 . "')";
      $db_conn->query( $query );

 
    }

    if($skill3 != 'empty' && ($skill3 != $skill1) && ($skill3 != $skill2) && ($prof3 != 0)){
   
      $query = "insert into JOB_REQUIRES_SKILLS VALUES ('" . $job_id . "','" . $skill3 . "','" . $prof3 . "')";
       $db_conn->query( $query );

    }

          echo '<script>window.location.href="Employer.php"</script>';
 
   
  }



  //_____________OFFER______________
    if(array_key_exists('offer', $_POST)){
      $app_login = $_POST['app_login'];
      $job_id = $_POST['job_id'];

      //create a row in job_offers{ employer_login, applicant_login, job_id }
      $check_query = "select * from JOB_POSTINGS where login = '" . $current_login . "' AND job_id = '" . $job_id . "'";
     

 $result   = $db_conn->query($check_query);
  $check = $result->num_rows;  //// my company did post this job
   
 

      $query = "select * from JOB_OFFERS where applicant_login = '". $app_login ."' AND job_id = '". $job_id ."' AND employer_login = '". $current_login ."'";
        
    
 $result   = $db_conn->query($query);
  $count = $result->num_rows;  // // is there already an offer record
   

      if(($count == 0) && ($check == 1)){ // check if there is any other job_offer like that
        $query = "insert into JOB_OFFERS VALUES ('". $current_login ."','". $app_login ."',". $job_id .")";
         
$db_conn->query($query);
    
        $check = 0;
        $count = 0;
      }
      else{
          echo '<script>alert("there is an offer already")</script>';
      }

    }

    //_____________INVITE______________
    if(array_key_exists('invite', $_POST)){
      $app_login = $_POST['app_login'];
      $job_id = $_POST['job_id'];
      $date = "str_to_date('" . $_POST['date'] . "','%Y-%m-%d')";
      $time = $_POST['time'];
      $address = $_POST['address'];

      //checks if there are even such people in apply table (does not check the interview ID yet)
      $query = "select * from APPLY where login = '" . $app_login . "' AND job_id = '" . $job_id . "'";

 $result   = $db_conn->query($query);
  $count = $result->num_rows;
   
 for ($jk = 0 ; $jk < $count ; ++$jk)
  {
       $result->data_seek($jk);
    $row_cur_skills = $result->fetch_array(MYSQLI_ASSOC);
   $int_id_check = $row_cur_skills['iv_id'];

 }
        

      //No people who applied yet
      if ($count == 0){    //no such person in Apply table

        $random = rand(10000000,99999999);
     
        //ADD ROW TO INTERVIEWS

        $add_interview_query = "insert into INTERVIEWS VALUES (" . $random . ",'n'," . $date . ",'" . $time . "','" . $address . "')"; 
  $db_conn->query($add_interview_query);
        
        $insert_query = "insert into APPLY VALUES ('" . $app_login . "'," . $job_id . "," . $random . ")";
  
      $db_conn->query($insert_query);
  

        $count = 0;
      }

      // People who applied to job already (They are in Apply Table)
      else{
        
        if($int_id_check == null){    // There is such person in Apply, but he/she has no interview set up yet 
          $random = rand(10000000,99999999);
       
          $add_interview_query = "insert into INTERVIEWS VALUES (" . $random . ",'n'," . $date . ",'" . $time . "','" . $address . "')"; 
  $db_conn->query($add_interview_query);
        
          $final_query = "update APPLY set iv_id = " . $random . " where login = '" . $app_login . "' AND job_id = '" . $job_id . "'"; 
           $db_conn->query($final_query);
        
    
        }
        else{    // There is already a set up interview
          
          echo '<script>alert("There is already a set up interview")</script>';
        }
      }

      //check if this data is in Apply, if so, add the interview_id to it, if not, add a row
      //if not added already, add a row in Interviews table
    }

    //________________DELETE___________________
    if(array_key_exists('delete', $_POST)){ 
      $job_id = $_POST['delete_job_id'];

      
      // Need to manually delete the interviews that are related to a job_posting being deleted
      $query = "select iv_id from APPLY where job_id = '" . $job_id . "'"; 
        $result_ivid   = $db_conn->query($query);
  $numrows_ivid = $result_ivid->num_rows; 
 for ($jk = 0 ; $jk < $numrows_ivid ; ++$jk) {

       $result_ivid->data_seek($jk);
    $row = $result_ivid->fetch_array(MYSQLI_ASSOC);
 
        $delete_query = "delete from INTERVIEWS
                         where interview_id = '" . $row['iv_id'] . "'"; 
      $db_conn->query($delete_query);
      }

      // This part of the code is delete cascade,
      //so when Job_Posting entry is deleted,
      // all the entries that are referencing that Job Posting
      // in Job_Requires_Skills and Apply tables are also deleted
      $delete_query = "delete from JOB_POSTINGS
                       where JOB_ID = '" . $job_id . "'";
     
      $db_conn->query($delete_query);
    }
}
?>





