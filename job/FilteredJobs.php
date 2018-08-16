<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors

 require_once 'db.php';

  $conn = new mysqli($hn, $un, $pw, $db);

  $current_login = $_COOKIE['login'];



function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
  //echo "<br>running ".$cmdstr."<br>";
  global $db_conn, $success;
  $statement = oci_parse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

  if (!$statement) {
    echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
    $e = OCI_Error($db_conn); // For OCIParse errors pass the       
    // connection handle
    echo htmlentities($e['message']);
    $success = False;
  }

  $r = oci_execute($statement);
  if (!$r) {
    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
    $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
    echo htmlentities($e['message']);
    $success = False;
  } else {

  }
  return $statement;

}

function printResult($result) { //prints results from a select statement
  echo "<h1>Filtered Jobs</h1>";
  echo "<table border = 1>";
  echo "<tr><th>ID</th><th>Title</th><th>Salary</th></tr>";

  while ($row = oci_fetch_assoc($result)) {
    echo "<tr><td>" . $row["JOB_ID"] . "</td><td>" . $row["JOB_TITLE"] . "</td><td>" . $row["SALARY"] . "</td></tr>"; 
  }
  echo "</table>";
}

if ($conn) {

  echo "<h1>Filtered Jobs</h1>";
  echo "<table border = 1>";
  echo "<tr><th>ID</th><th>Title</th><th>Salary</th></tr>";

  if(array_key_exists('filter_jobs', $_POST)) {
    $salary = $_POST['filter_salary'];
    $skill =  $_POST['filter_skill'];

    $sql = "select j.JOB_ID, j.SALARY, j.JOB_TITLE "
                              . "from JOB_POSTINGS j, JOB_REQUIRES_SKILLS js "
                              . "where   j.JOB_ID = js.jobID AND " 
                              . "SALARY >= " . $salary . " AND "
                              . "js.skill = " . "'" . $skill . "'";



      $result_skills_total   = $conn->query( $sql );
  $num_jobs = $result_skills_total->num_rows; 
 for ($jk = 0 ; $jk < $num_jobs ; ++$jk)
  {
       $result_skills_total->data_seek($jk);
    $row_cur_skill = $result_skills_total->fetch_array(MYSQLI_ASSOC);
 

  echo "<tr><td>" . $row_cur_skill["JOB_ID"] . "</td><td>" . $row_cur_skill["JOB_TITLE"] . "</td><td>" . $row_cur_skill["SALARY"] . "</td></tr>"; }

  echo "</table>";
    //printResult($result);

    //unset($_POST['filter_jobs'];
  }
  oci_close($db_conn);
}else {
  echo "cannot connect";
  $e = OCI_Error(); // For OCILogon errors pass no handle
  echo htmlentities($e['message']);
}

?>
