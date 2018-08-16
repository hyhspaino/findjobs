<h3>Filtered Applicants</h3>

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

	if(!$db_conn){
		echo "Cannot connect to the database";
	}

	if($db_conn){
		if(array_key_exists('filter',$_POST)){
			 
			$skill = $_POST['skill'];

			$query = "select * 
					  from APPLICANTS Ap, APPLICANT_HAS_SKILLS A
					  where Ap.APP_LOGIN = A.login AND skill = '" . $skill . "'";
	 

			echo "<table border = 1>";
        	echo "<tr><th>Login</th><th>Name</th><th>Phone #</th><th>Email</th><th>Address</th></tr>";


 $fieldArray=array("APP_LOGIN","NAME","PHONE_NUMBER","EMAIL","ADDRESS"); 
exeSql($query,$fieldArray,$db_conn);
      
       
        	echo "</table>";
		}
	}
?>