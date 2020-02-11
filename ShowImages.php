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
    if($_SESSION['job']!="EM"){
        
        throw new customExceptionLoginEM();
    }
    }catch(customExceptionLogin|customExceptionLoginEM|customExceptionFailedConnection $e){
		
		echo $e->reroute($_SESSION['ID']);
		
	}

echo "Passport Image:<br>";
echo "<img src='".$_SESSION['PassportImage']."'><br><br><br>";
echo "National Image:<br>";
echo "<img src='".$_SESSION['NationalImage']."'><br><br><br>";
echo "Profile Image:<br>";
echo "<img src='".$_SESSION['ProfileImage']."'><br><br><br>";
?>