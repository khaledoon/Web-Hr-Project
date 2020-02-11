<?php

session_start();
include"Exception_file.php";
include"dbconnection.php";

try{
	if(!$conn){
		 throw new customExceptionFailedConnection();
	}	
		
    if($_SESSION['job']==null){
	throw new customExceptionLogin();	
	}
    if($_SESSION['job']!="HR"){
        
        throw new customExceptionLoginHR();
    }
    }catch(customExceptionLogin|customExceptionLoginHR|customExceptionFailedConnection $e){
		
		echo $e->reroute($_SESSION['ID']);
		
	}
if (isset($_POST['showimage']))
{
echo "Passport Image:<br>";
echo "<img src='".$_POST['PassportImage']."'><br><br><br>";
echo "National Image:<br>";
echo "<img src='".$_POST['NationalImage']."'><br><br><br>";
echo "Profile Image:<br>";
echo "<img src='".$_POST['ProfileImage']."'><br><br><br>";
}
?>