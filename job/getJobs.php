
<?php 
  require_once 'db.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);
  
    $query    = "SELECT skill,count(*) as cnt FROM `JOB_REQUIRES_SKILLS` group by skill";
 //$query    = "SELECT * FROM `JOB_REQUIRES_SKILLS`";
   $allskills = array();
    $result   = $conn->query($query);
while( $row=mysqli_fetch_assoc($result)){

array_push($allskills,$row);
// print_r($row);
}
//var_dump($allskills);

echo  json_encode($allskills); 

  $result->close(); 
  $conn->close();
  
  
?>
