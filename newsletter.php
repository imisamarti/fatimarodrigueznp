<?php 

$user = "imartine_im";  
$password = "Successgirl1";  
$host = "localhost";  
$dbase = "imartine_frmailinglist";  
$table = "newsletter";  
 
$first_name =  $_POST['fname']; 
$last_name = $_POST['lname']; 
$email = $_POST['email']; 
// message that will be displayed when everything is OK :)
$okMessage = 'We got your request successfully. We will get back to you shortly!';

// If something goes wrong, we will display this message.
$errorMessage = 'There was an error while submitting the form. Please try again later';

  
// Connection to DBase  
$dbConnection = new PDO('mysql:dbname=imartine_frmailinglist;host=localhost;charset=utf8', 'imartine_im', 'Successgirl1');

$dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$dbc= mysqli_connect($host,$user,$password, $dbase)  
or die("Unable to select database"); 

try{

	// $query=  "INSERT INTO $table  ". "VALUES ('". mysqli_real_escape_string($dbc,$first_name)  .",'". mysqli_real_escape_string($dbc,$last_name)  ."','". mysqli_real_escape_string($dbc,$email)  ."')";

$query= $dbConnection->prepare("INSERT INTO $table  ". "VALUES (:id,:first_name,:last_name,:email)"); 

$query->bindValue(":id",'i');
$query->bindValue(":first_name", $first_name);
$query->bindValue(":last_name", $last_name);
$query->bindValue(":email", $email);
 
 $query->execute();
// echo $query;
 
// mysqli_query ($dbc, $query) 
// or die ("Error querying database: ". mysqli_error($dbc)); 


$responseArray = array('type' => 'success', 'message' => $okMessage);

$dbConnection = null;

mysqli_close($dbc); 


}catch(\Exception $e){

	$responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
// else just display the message
else {
    echo $responseArray['message'];
}

 
?> 




