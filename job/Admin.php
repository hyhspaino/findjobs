<html>
<head>
  <title>Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);


      function drawChart() {




      
  $.ajax({url: "getJobs.php", success: function(result){
var resultObj = JSON.parse(result);

 var chartdata = [ ['category', 'Total']];

for (var i = resultObj.length - 1; i >= 0; i--) {
  chartdata.push([resultObj[i].skill, parseInt(resultObj[i].cnt)]);
}


     var data = google.visualization.arrayToDataTable(chartdata);

        var options = {
          title: 'percentage of each skill'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);

    console.log("哈哈",JSON.parse(result));
       // $("#div1").html(result);
    }});



      }
    </script>
  <link rel="stylesheet" href="css/style.css"></head>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">


  <script src="js/nav.js"></script>
<div class="container">
  <h1><img src = "pictures /ti.png"></h1>
  

<div class="topnav" id="myTopnav">
  <a data-toggle="tab"  href="#applicants" class="active">All Applicants</a>
  <a  data-toggle="tab" href="#company">All Companies</a>
  <a data-toggle="tab"  href="#jobs">All Jobs</a> 

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

    
    </div>
    

    <!-- __________________APPLICANTS_PANEL_____________________END_________________-->



    <!-- __________________MY_JOBS_PANEL_____________________START_________________-->

    <div id="jobs" class="tab-pane fade">
      <h3>My Jobs</h3>
      <p>List of All Jobs   </p>
      <?php
        $sql = "select * from JOB_POSTINGS";

  
        echo "<table border = 1>";
        echo "<tr><th>Job ID</th><th>Title</th><th>Date</th><th>Salary</th><th>Description</th></tr>";
       

 $fieldArray=array("JOB_ID","JOB_TITLE","POSTING_DATE","SALARY","DESCRIPTION"); 
exeSql($sql,$fieldArray,$db_conn);
      
        echo "</table>";
      ?>


    <h5>Filter jobs!</h5>
      <p><font size="2"> Salary&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Skill</font></p>
      <form method="POST" action="FilteredJobs.php" id="filtered_jobs">  
        <p><input type="number" name="filter_salary" value="0" size="18">
            <select name = "filter_skill" form="filtered_jobs">
              <?php
                $sql_skills = "select skill from SKILLS";

      $result_skills_total   = $db_conn->query($sql_skills);
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
          <input type="submit" value="Filter Jobs" name="filter_jobs"> 
        </p>
      </form>
 






    <div id="piechart" style="width: 900px; height: 500px;"></div>


    </div>
      <!-- __________________MY_JOBS_PANEL_____________________END_________________-->

 



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



   <div id="company" class="tab-pane fade">
      <h3>My Jobs</h3>
      <p>List of jobs created by me</p>

      <?php
        $sql = "select * from COMPANIES";

  
        echo "<table border = 1>";
        echo "<tr><th>company_name</th></tr>";
       

 $fieldArray=array("company_name"); 
exeSql($sql,$fieldArray,$db_conn);
      
        echo "</table>";
      ?>

    </div> 


    <!-- __________________DELETE_PANEL_____________________START_________________-->

    <div id="delete" class="tab-pane fade">
      <h3>Delete Job by Job ID</h3>
      <form method = "POST" action = "Employer.php">
        Job ID: <input type="text" name="delete_job_id">
        <input type="submit" value="Delete Job" name="delete">
      </form>
    </div>

    
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
echo    $statement;
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





