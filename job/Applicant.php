<head>
  <title>Applicant</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">


  <script src="js/nav.js"></script>
</head>

<!-- Connect to the database and initialize the current user! -->

<?php
 require_once 'db.php';

  $conn = new mysqli($hn, $un, $pw, $db);

  $current_login = $_COOKIE['login'];

 
 
if ($conn) {

  // ----------------------------------------------------------------------------------------------------- //
  // ----------------------------------------------------------------------------------------------------- //
  //                                    HANDLE APPLY TO JOB                                                //
  // ----------------------------------------------------------------------------------------------------- //
  // ----------------------------------------------------------------------------------------------------- //
  if(array_key_exists('apply_to_job', $_POST)) {
    
    $job_id = $_POST['applied_job_id'];

    // Insert into apply table with no interview (dont get interview right after application)

    $sql = "insert into APPLY values ('" . $current_login . "','" . $job_id . "',null)"; 
   
      $insertApply   = $conn->query( $sql );
echo '<script>alert("success");</script>';

  
  }





    // ----------------------------------------------------------------------------------------------------- //
    // ----------------------------------------------------------------------------------------------------- //
    //                                        ADD/UPDATE SKILLS                                              //
    // ----------------------------------------------------------------------------------------------------- //
    // ----------------------------------------------------------------------------------------------------- //


    if (array_key_exists('add_update_skill', $_POST)) {
        $skill = $_POST['skill_list'];
        $proficiency = $_POST['skill_proficiency'];


        // Check if the inputted skill already exists for the current applicant
        $sql = "select * from APPLICANT_HAS_SKILLS a where skill = '" . $skill . "' AND login = '" . $current_login ."'";

        $result   = $conn->query($sql);
        $count = $result->num_rows;

     
        if ($count == 0) {
            $sql1 = "insert into APPLICANT_HAS_SKILLS values ('" . $current_login . "','" . $skill ."'," . $proficiency . ")";
            $stid1   = $conn->query($sql1);

        }

     
        else {
            $sql2 = "update APPLICANT_HAS_SKILLS set proficiency = " . $proficiency . " where skill = '" .
                $skill . "' AND login = '" . $current_login ."'";
            $stid2 = $conn->query($sql2);

        }

    }

}
?>


<div class="container">
 
  



<div class="topnav" id="myTopnav">
  <a  data-toggle="tab" href="#jobs" class="active">Jobs</a>

  <a data-toggle="tab"  href="#my_skills">My Skills</a>
  <a  data-toggle="tab" href="#add_skill">Add/Update Skill</a>

  <a  data-toggle="tab" href="#applied_jobs">Applied Jobs</a>

  <a  data-toggle="tab" href="#interview_offers">Interview Offers</a>
  <a data-toggle="tab"  href="#interviews">Interviews Accepted</a>

  <a  data-toggle="tab" href="#job_offers">Job Offers</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
  
    <img src = "pictures /ti.png">
  <!-- __________________________________________________________________________________________________ -->
  <!-- __________________________________________________________________________________________________ -->
  <!--                                    VIEW ALL JOBS TAB                                               -->
  <!-- __________________________________________________________________________________________________ -->
  <!-- __________________________________________________________________________________________________ -->

  <div class="tab-content">
    <div id="jobs" class="tab-pane fade in active">  
      <h3>Jobs</h3>
      
      <h4>Apply for a Job Now!</h4>

      <!-- Form to apply to a specified job ID ... Database logic implemented below! -->
      <form method="POST" action="Applicant.php" id="apply_to_job">  
        <p>Job ID: <input type="text" name="applied_job_id" size="8">
          <input type="submit" value="Apply Now!" name="apply_to_job"></p>
      </form>
      
      <p>List of jobs</p>
      <!-- PHP code and queries to display all jobs -->
      <?php
        
      

        $success = True;

        $get_jobs = "select * from JOB_POSTINGS";        
      

         $result   = $conn->query($get_jobs);
  $numrows = $result->num_rows;
  
 

        if ($success) {
          echo "<table border=1>";
          echo "<tr><th>Title</th><th>ID</th><th>Date</th><th>Salary</th><th>Required Skills</th><th>Description</th></tr>";


 for ($j = 0 ; $j < $numrows ; ++$j)
  {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);

            $job_id = $row['JOB_ID'];
       
            $job_title = $row['JOB_TITLE'];
            //$company = $row['COMPANY_NAME'];
            $posting_date = $row['POSTING_DATE'];
            $salary = $row['SALARY'];
            $desc = $row['DESCRIPTION'];

            // Get the skills associated to this job            
            $get_skills_for_job = "select skill from JOB_REQUIRES_SKILLS where jobID = " . $job_id;
        
        
      $result_skills   = $conn->query($get_skills_for_job);
  $numrows_skills = $result_skills->num_rows;
  
 
            $skills = "";
            $count = 0;

        


 for ($jk = 0 ; $jk < $numrows_skills ; ++$jk)
  {
       $result_skills->data_seek($jk);
    $row_cur_skills = $result_skills->fetch_array(MYSQLI_ASSOC);
 
                $current_skill = $row_cur_skills['skill'];
                if (count == 0) {
                  $skills = $skills . $current_skill;
                }
                else {
                  $skills = $skills . ", " . $current_skill;
                }

                $count = $count + 1;

              }




         

            
            $job_info = "<tr><td>" . $job_title . "</td><td>" . $job_id .  "</td><td>" . $posting_date . "</td><td>" . $salary . "</td><td>" . $skills . "</td><td>" . $desc . "</td></tr>";
            echo "" . $job_info . "";
  
            }
          echo "</table>";
        } 
        else {
          echo "Error when accessing database!";
        }

        $get_num_jobs = "select count(*) as num_jobs from JOB_POSTINGS";
             $result_skills_total   = $conn->query($get_num_jobs);
  
    $totol = $result_skills_total->fetch_array(MYSQLI_ASSOC);
 
  
 echo "<p>" . $totol['num_jobs'] . " total jobs</p>";

     
      ?> 

      <!-- Form to filter jobs based on skill and salary! -->

   

     
    </div>

  <!-- __________________________________________________________________________________________________ -->
  <!-- __________________________________________________________________________________________________ -->
  <!--                              VIEW ALL INTERVIEWS TAB                                               -->
  <!-- __________________________________________________________________________________________________ -->
  <!-- __________________________________________________________________________________________________ -->

    <div id="interviews" class="tab-pane fade">
      <h3>Interviews</h3>
      <p>List of Scheduled Interviews</p>
      <?php


 require_once 'db.php';

        $conn = new mysqli($hn, $un, $pw, $db);


          $current_login = $_COOKIE['login'];

        if ($conn == false){
          echo "cannot connect";
        }


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


          echo "<table border=1>";
          echo "<tr><th>Interview ID</th><th>Job ID</th><th>Date</th><th>Time</th><th>Address</th></tr>";

        
        $get_all_my_interviews =  "select a.job_id, i.interview_id, i.interview_date, i.interview_time, i.address "
                . "from INTERVIEWS i, APPLY a "
                . "where i.interview_id in ("
                                          . "select iv_id "
                                          . "from APPLY "
                                          . "where login = " . "'" . $current_login . "'"  
                                          . ") AND i.interview_id = a.iv_id AND "
                                          . "i.accepted = 'y'";
   
   
 $fieldArray=array("interview_id","job_id","interview_date","interview_time","address"); 
exeSql($get_all_my_interviews,$fieldArray,$conn);
       
          echo "</table>";
  
      ?>
    </div>

  
    <div id="my_skills" class="tab-pane fade">
      <h3>My Skills</h3>
      <p>List of my skills</p>
      <?php
        $conn = new mysqli($hn, $un, $pw, $db);
        if ($conn == false){
          echo "cannot connect";
        }

 echo "<table border =1>";
          echo "<tr><th>Skill</th><th>Proficiency</th></tr>";

        $get_my_skills = "select * from APPLICANT_HAS_SKILLS where login = " . "'" . $current_login . "'" ;

             $result_my_skills_total   = $conn->query( $get_my_skills );
  $num_my_skills = $result_my_skills_total->num_rows; 
 for ($jk = 0 ; $jk < $num_my_skills ; ++$jk)
  {
       $result_my_skills_total->data_seek($jk);
    $row_my_skill = $result_my_skills_total->fetch_array(MYSQLI_ASSOC);
 

    
     
         
       
            $skill = $row_my_skill['skill'];
            $proficiency = $row_my_skill['proficiency'];
            
            $skill_info = "<tr><td>" . $skill . "</td><td>" . $proficiency . "</td></tr>";
            echo "" . $skill_info . "";
  
            }
          echo "</table>";
       
      ?> 
    </div>

  <!-- __________________________________________________________________________________________________ -->
  <!-- __________________________________________________________________________________________________ -->
  <!--                                   ADD/UPDATE MY SKILLS TAB                                         -->
  <!-- __________________________________________________________________________________________________ -->
  <!-- __________________________________________________________________________________________________ --> 

    <div id="add_skill" class="tab-pane fade">
      <h3>Add/Update Skill</h3>
    
      <!-- Form that allows applicant to either add a new skill or update proficiency of existing skill -->  
      <form method="POST" action="Applicant.php" id="add_update_skill">  
        <p>Proficiency level (1 to 7) <input type="number" name="skill_proficiency" size="3"></p>
        <p>Skill: 
        <select name="skill_list" form="add_update_skill">
          <?php
 


          $sql_skills = "select skill from SKILLS";

          $result_skills_total   = $conn->query($sql_skills);
          $num_jobs = $result_skills_total->num_rows;
          for ($jk = 0 ; $jk < $num_jobs ; ++$jk)
          {
              $result_skills_total->data_seek($jk);
              $row_cur_skill = $result_skills_total->fetch_array(MYSQLI_ASSOC);

              $skill = $row_cur_skill['skill'];
              echo " <option value='". $skill ."''>". $skill ."</option>";
          }

          ?>



        </select>
        </p>
        <input type="submit" value="Add/Update Skill" name="add_update_skill">
      </form>
    </div>
    
  <!-- __________________________________________________________________________________________________ -->
  <!-- __________________________________________________________________________________________________ -->
  <!--                                   VIEW/ACCEPT/REJECT MY JOB OFFERS TAB                                           -->
  <!-- __________________________________________________________________________________________________ -->
  <!-- __________________________________________________________________________________________________ --> 

    <div id="job_offers" class ="tab-pane fade">
      <h3>Job Offers</h3>

      <!-- Form to allow applicant to accept/reject one of their specified job offers -->
      <p>Accept Job Now!</p>
      <form method="POST" action="Applicant.php" id="accept_job">  
        <p>Job ID: <input type="text" name="accepted_job_id" size="8">
          <input type="submit" value="Accept Job Now!" name="accept_job">
          <input type="submit" value="Reject Job Now!" name="reject_job"></p>
      </form>
      
      <p>List of job offers</p>
      <?php
        $conn = new mysqli($hn, $un, $pw, $db);
        if ($conn == false){
          echo "cannot connect";
        }

        $get_my_job_offers =  "select jp.job_id, jp.salary, jp.posting_date, jp.job_title, jp.description, c.company_name "
                . "from JOB_POSTINGS jp, JOB_OFFERS jo, EMPLOYER_RUNS e, COMPANIES c "
                . "where   jp.job_id = jo.job_id AND "
                . "jo.applicant_login = " . "'" . $current_login . "'" . " AND "
                . "e.emp_login = jp.login AND "
                . "e.c_id = c.c_id";



          echo "<table border=1>";
          echo "<tr><th>CompanyName</th><th>Title</th><th>ID</th><th>Date</th><th>Salary</th><th>Description</th></tr>";

      $fieldArray=array("company_name","job_title","job_id","posting_date","salary","description");
      exeSql($get_my_job_offers,$fieldArray,$conn);

      echo "</table>";


      ?>
    </div>

  <!-- __________________________________________________________________________________________________ -->
  <!-- __________________________________________________________________________________________________ -->
  <!--                                   VIEW/ACCEPT/REJECT MY INTERVIEWS OFFERS TAB                      -->
  <!-- __________________________________________________________________________________________________ -->
  <!-- __________________________________________________________________________________________________ --> 

    <div id="interview_offers" class ="tab-pane fade">
      <h3>Interview Offers</h3>
      <p>Accept Inteview Now!</p>
      
      <!-- This form will allow an applicant to either accept or reject an invitation to a specified interview offer -->
      <form method="POST" action="Applicant.php" id="accept_interview">  
        <p>Interview ID: <input type="text" name="accepted_interview_id" size="8">
          <input type="submit" value="Accept Interview Now!" name="accept_interview">
          <input type="submit" value="Reject Interview Now!" name="reject_interview"></p>
      </form>

      <p>List of Pending Interview Offers</p>

      <?php
        $conn = new mysqli($hn, $un, $pw, $db);
        if ($conn == false){
          echo "cannot connect";
        }

        // Interview offers are identified with a 'n' in
        $my_interview_offers =  "select  i.interview_id, a.job_id, i.interview_date, i.interview_time, i.address "
                . "from  INTERVIEWS i, APPLY a "
                . "where   a.iv_id = i.interview_id AND "
                . "a.login = " . "'" . $current_login ."'" .  " AND "
                . "i.accepted = 'n'";


          echo "<table border=1>";
          echo "<tr><th>Interview ID</th><th>Job ID</th><th>Interview Date</th><th>Time</th><th>Address</th></tr>";

      $fieldArray=array("interview_id","job_id","interview_date","interview_time","address");
      exeSql($my_interview_offers,$fieldArray,$conn);


      echo "</table>";

      ?>
    </div>

 

    <div id="applied_jobs" class ="tab-pane fade">
      <h3>Applied Jobs</h3>
      <p>List of applied jobs</p>
      <?php

        $conn = new mysqli($hn, $un, $pw, $db);

        if ($conn == false){
          echo "cannot connect";
        }

        $applied_jobs =  "select * "
                      . "from JOB_POSTINGS j "
                      . "where j.job_id in ("
                                          . "select a.job_id "
                                          . "from APPLY a "
                                          . "where login = " . "'" . $current_login . "'"
                                        . ")";




      echo "<table border=1>";
          echo "<tr><th>Title</th><th>ID</th><th>Date</th><th>Salary</th><th>Description</th></tr>";
      $fieldArray=array("JOB_TITLE","JOB_ID","POSTING_DATE","SALARY","DESCRIPTION");
      exeSql($applied_jobs,$fieldArray,$conn);


      echo "</table>";

      ?>
    </div>
  </div>
</div>


 



<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors
 require_once 'db.php';

  $conn = new mysqli($hn, $un, $pw, $db);

if ($conn) {



    // ----------------------------------------------------------------------------------------------------- //
    // ----------------------------------------------------------------------------------------------------- //
    //                                        ACCEPT INTERIVEWS                                              //
    // ----------------------------------------------------------------------------------------------------- //
    // ----------------------------------------------------------------------------------------------------- //


    if (array_key_exists('accept_interview', $_POST)) {
        // When accepting interview, update the corresponding entry in the interview table to have a 'y' in
        // the accepted column to differentiate between interview offers and scheduled interviews
        $interview_id = $_POST['accepted_interview_id'];
        $sql = "update INTERVIEWS set accepted = 'y' where interview_id = " . $interview_id;

       $conn->query($sql);

       
    }

    // ----------------------------------------------------------------------------------------------------- //
    // ----------------------------------------------------------------------------------------------------- //
    //                                        REJECT INTERIVEWS                                              //
    // ----------------------------------------------------------------------------------------------------- //
    // ----------------------------------------------------------------------------------------------------- //


    if (array_key_exists('reject_interview', $_POST)) {
        // When rejecting an interview delete the interview from the interviews table, this will cascade to the
        // apply table because an interview rejection means that the applicant is not interested in the job anymore
        $job_id = $_POST['accepted_interview_id'];
        $sql = "delete from INTERVIEWS where interview_id = " . $interview_id;
        $conn->query($sql);
       
    }


  // ----------------------------------------------------------------------------------------------------- //
  // ----------------------------------------------------------------------------------------------------- //
  //                                    HANDLE ACCEPT/REJECT JOB                                           //
  // ----------------------------------------------------------------------------------------------------- //
  // ----------------------------------------------------------------------------------------------------- //

  if(array_key_exists('accept_job', $_POST) or array_key_exists('reject_job', $_POST)) {
    $job_id = $_POST['accepted_job_id'];

  $sql = "select iv_id from APPLY where job_id = " . $job_id . " AND login = '" . $current_login ."'";
   

        $result_total   = $conn->query( $sql );
  $num_results = $result_total->num_rows; 
 
 for ($i = 0 ; $i < $num_results ; ++$i)
  {
 
     $result_total->data_seek($i);
    $row_cur_skill =  $result_total ->fetch_array(MYSQLI_ASSOC);

      $interview_id = $row_cur_skill['iv_id'];
   }
    

    // Remove this job offer since it was either accpeted or rejected
    $sql1 = "delete from JOB_OFFERS where job_id = " . $job_id . " AND applicant_login = '" . $current_login ."'";
          $conn->query( $sql1 );
 
    // Removed the application from Apply table because job was accepted or rejected
    $sql2 = "delete from APPLY where job_id = " . $job_id . " AND login = '" . $current_login ."'";
  $conn->query( $sql2 );
     
    // If there was an associated interview, delete that interview from interview table
 
      $sql3 = "delete from INTERVIEWS where interview_id = " . $interview_id;
         $conn->query( $sql3 );
         

    // If this job was accepted, then this job is no longer available, delete the job, it will
    // cascade down to JOB_REQUIRES_SKILLS table
    if (array_key_exists('accept_job', $_POST)) {
      $sql4 = "delete from JOB_POSTINGS where job_id = " . $job_id;
      
          $conn->query( $sql4 );


echo '<script> window.location.href="Applicant.php"</script>';
    }


    //
  }



}

 
?>