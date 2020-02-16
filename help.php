<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Hr System</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" id="theme"  href="help.css">
<link  src="js/jquery-2.1.4.min.js">
<!-- <link href='https://fonts.googleapis.com/css?family=Oxygen:400,300,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lora' rel='stylesheet' type='text/css'> -->



<script>
function myFunction(y) {
	/* array made to switch between tiles displays as policy in the beginning of the page then switch as needed */
var idarr=["poll","FAQQ"]



var x = document.getElementById(y);

var count=0;
for(var i=0;i<idarr.length;i++)
{

var l=document.getElementById(idarr[count]+'');

l.style.display="none";

count++;
}

x.style.display="block"

}

</script>


</head>

<body>




<div class="parentdiv">
<?php
include_once "dbconnection.php";
include_once "Exception_file.php";
	session_start();
	
	/* exception made so that the HR cant access the help page */
try{
	if(!$conn){
		 throw new customExceptionFailedConnection();
	}	
    if($_SESSION['job']==null){
	throw new customExceptionLogin();	
	}
    if($_SESSION['job']=="HR"){
        
        throw new customExceptionLoginEM();
    }	
    }catch(customExceptionLogin|customExceptionLoginEM|customExceptionFailedConnection $e){
		
		echo $e->reroute($_SESSION['ID']);
		
	}	
	
	
include "Header.php";
?>

<div class="LeftDiv">

<!--placing the tiles in the left DIV and calling the function to access the desired page clicked -->
	
	
<div>
<div id="Policy-tile" onclick="myFunction('poll')"><span>Policy</span></div>
</div>
<div>
<div id="FAQ-tile" onclick ="myFunction('FAQQ')"><span>FAQ</span></div>
</div>

</div>


<div class="MiddleDiv">

<!--placing all the contents of the page in the middle div-->

<div id="poll">
<h1 id="policyhead">Company's policy inside policy head div</h1>
<p id="policyparagrph">
<!--	reading the data from the policy file and viewing it in the middle div of the policy page-->
<?php
//$myfile = fopen("Policy.txt", "r");
if(!file_exists('C:\xampp\htdocs\Policy.txt'))
{
	echo "<br><br>no policy yet";
}
else{
	if ( 0 != filesize('C:\xampp\htdocs\Policy.txt') )
	{
	$myfile = fopen("Policy.txt", "r");
echo fread($myfile,filesize("Policy.txt"));
fclose($myfile);}
	else{
		echo "<br><br>No policy yet";
	}
}
?>
</div>


<div id="FAQQ">

<h1 id= "FAQHEAD"> FAQ </h1>

<input type="text" name="search" id="search" onkeyup="getResult()" placeholder="Search"><br>

<div id="result"></div>

<p id="FAQText">

<!--reading all the questions and answers from the "faq" table in the data base and viewing it in the faq page -->
	
  <?php

$sql = "SELECT Question, Answer FROM faq";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
        echo "Question: " . $row["Question"]."<br>";
        echo "Answer: " . $row["Answer"]. "<br>";
        echo  "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
</p>

<script>

	/* ajax function to get the result of the search and place it in the screen by comparing the data in the search bar with the data in the data base*/
	
function getResult()
{

if(true){
  jQuery.ajax(
    {
url : "search.php",
data : "search="+$("#search").val(),
type :"POST",
success : function (data){
  $("#result").html(data);
  $("#FAQText").hide();
}
        
});   
}
  else{
       $("#result").html(search); 
    }  
}

</script>


</div>


    
    
    
</div>
</div>

<!-- jQuery (Bootstrap JS plugins depend on it) -->
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/script.js"></script>


</body>
</html>
