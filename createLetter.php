<html>

<head>
<title>Request Letter</title>
<link rel="stylesheet" id="theme" href="css/reqLetter.css">
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" id="theme" href="css/createLetter.css">

</head>

<body>
	

	
	
<?php
	include_once ("dbconnection.php");
include_once"Exception_file.php";
	session_start();
//	validations if session is empty or the hr is trying to access a page that he is not allowed to access
try{if($_SESSION["job"]==null){
	
	throw new customExceptionLogin();
	
}
   if($_SESSION["job"]!="HR"){
	   
	   throw new customExceptionLoginHR();

	if(!$conn){
		throw new customExceptionFailedConnection();
		
		
	}   
   }
   }
	catch(customExceptionLoginHR|customExceptionLogin|customExceptionFailedConnection $e){
		
		$e->reroute($_SESSION['ID']);
		
	}
	
	if($_POST['letterid']===NULL)
	{
		header("Location:HRLetter.php");
	}

include "Header.php";

//	array to hold the check variable to be used to checked data in the checkboxes
$a=array();
//	flags to hold checked check boxes
$mobilex="false";
$Passportx="false";
$Martialx="false";
$Hirex="false";
$Salaryx="false";



if(!empty($_POST['check_list']))
{
foreach($_POST['check_list'] as $check) 
{

array_push($a,$check);
}

}


for($i=0;$i<count($a);$i++)
{
if($a[$i]=="Mobile")
{
$mobilex="true";
}
else if ($a[$i]=="Passport")
{
$Passportx="true";
}
else if ($a[$i]=="Martial")
{
$Martialx="true";
}
else if ($a[$i]=="Hire")
{
$Hirex="true";
}
else if ($a[$i]=="Salary")
{
$Salaryx="true";
}	
}


?>



<div class='letterContent'>


<?php
//if the letter is directed to an embassy show the generated form of the letter directed to embassy and hr can edit it
if ($_POST['directedto']=="Embassy"){
?>
<form action='HRLetter.php' method="post">
<textarea class='letter' name='lettercontent' rows='16' cols='150'>
To Embassy,	
we want to notify you about <?php echo  ''.$_POST['firstname'].' '.$_POST['lastname'].''; ?> about his current position with our organization. He requests to travel abroad to  <?php echo  ''.$_POST['comment'].' ';?>. His National ID is <?php echo  ''.$_POST['nationalid'].'';?>




Human Resources,			
<?php echo  ''.$_SESSION['name'].' ' .$_SESSION['lastname'].'';  ?>                                               
<?php																								 if($mobilex =="true") echo "			                                                                                      Mobile Number : 0".$_POST['mobile']."\n			                                                                                      ";
																										if($Martialx=="true") echo "Marital Status: ".$_POST['marital']."\n			                                                                                      ";
																										if($Hirex=="true")    echo "Hire Date     : ".$_POST['hiredate']."\n			                                                                                      ";
																										if($Salaryx=="true")   echo "Salary        : ".$_POST['salary']."\n"; ?>

</textarea>
<input type='hidden' name='letterid' value='<?php echo ''.$_POST['letterid'].'';?>'>
<input type='submit' class='submit' name='submit-letter' value='submit letter'>
</form>
<?php 
}
?>

<?php
//if the letter is directed to an governemt show the generated form of the letter directed to government and hr can edit it
if ($_POST['directedto']=="Gov"){
?>
<form action='HRLetter.php' method="post">
<textarea class='letter' name='lettercontent' rows='10' cols='150'>
To the governement,
we want to notify you about <?php echo  ''.$_POST['firstname'].' '.$_POST['lastname'].''; ?> about his current position with our organization. He requests to <?php echo  ' '.$_POST['comment'].' ';?>. His National ID is <?php echo  ''.$_POST['nationalid'].'';?>




Human Resources,			
<?php echo  ''.$_SESSION['name'].' ' .$_SESSION['lastname'].'';  ?>                                               
<?php																								 if($mobilex =="true") echo "			                                                                                      Mobile Number : 0".$_POST['mobile']."\n			                                                                                      ";
																										if($Martialx=="true") echo "Marital Status: ".$_POST['marital']."\n			                                                                                      ";
																										if($Hirex=="true")    echo "Hire Date     : ".$_POST['hiredate']."\n			                                                                                      ";
																										if($Salaryx=="true")   echo "Salary        : ".$_POST['salary']."\n"; ?>
</textarea>
<input type='hidden' name='letterid' value='<?php echo ''.$_POST['letterid'].'';?>'>
<input type='submit' class='submit' name='submit-letter' value='submit letter'>
</form>
<?php 
}
?>


<?php
//if the letter is directed to a bank show the generated form of the letter directed to bank and hr can edit it
if ($_POST['directedto']=="Bank"){
?>
<form action='HRLetter.php' method="post">
<textarea class='letter' name='lettercontent' rows='10' cols='150'>
To Bank,		
we want to notify you about <?php echo  ''.$_POST['firstname'].' '.$_POST['lastname'].''; ?> about his current position with our organization. He requests to <?php echo  ' '.$_POST['comment'].' ';?>. His National ID is <?php echo  ''.$_POST['nationalid'].'';?> 




Human Resources,			
<?php echo  ''.$_SESSION['name'].' ' .$_SESSION['lastname'].'';  ?>                                               
<?php																								 if($mobilex =="true") echo "			                                                                                      Mobile Number : 0".$_POST['mobile']."\n			                                                                                      ";
																										if($Martialx=="true") echo "Marital Status: ".$_POST['marital']."\n			                                                                                      ";
																										if($Hirex=="true")    echo "Hire Date     : ".$_POST['hiredate']."\n			                                                                                      ";
																										if($Salaryx=="true")   echo "Salary        : ".$_POST['salary']."\n"; ?>
</textarea>
<input type='hidden' name='letterid' value='<?php echo ''.$_POST['letterid'].'';?>'>
<input type='submit' class='submit' name='submit-letter' value='submit letter'>
</form>
<?php 
}
?>


<?php
//if the letter is directed to 'to whom it may concern' show the generated form of the letter directed to 'to whom it may concern' and hr can edit it
if ($_POST['directedto']=="General"){
?>
<form action='HRLetter.php' method="post">
<textarea class='letter' name='lettercontent' rows='10' cols='150'>
To whom it may concern,
we want to notify you about <?php echo  ''.$_POST['firstname'].' '.$_POST['lastname'].''; ?> about his current position with our organization. He requests to <?php echo  ' '.$_POST['comment'].' ';?>. His National ID is <?php echo  ''.$_POST['nationalid'].'';?>



Human Resources,			
<?php echo  ''.$_SESSION['name'].' ' .$_SESSION['lastname'].'';  ?>                                               
 <?php																								 if($mobilex =="true") echo "			                                                                                      Mobile Number : 0".$_POST['mobile']."\n			                                                                                      ";
																										if($Martialx=="true") echo "Marital Status: ".$_POST['marital']."\n			                                                                                      ";
																										if($Hirex=="true")    echo "Hire Date     : ".$_POST['hiredate']."\n			                                                                                      ";
																										if($Salaryx=="true")   echo "Salary        : ".$_POST['salary']."\n"; ?>


</textarea>
<input type='hidden' name='letterid' value='<?php echo ''.$_POST['letterid'].'';?>'>
<input type='submit' class='submit' name='submit-letter' value='submit letter'>
</form>
<?php 
}
?>




</div>	

	<script src='js/refresh.js'></script>


</body>
</html>