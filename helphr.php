<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Hr System</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" id="theme"  href="helphr.css">
<link  src="js/jquery-2.1.4.min.js">
<!-- <link href='https://fonts.googleapis.com/css?family=Oxygen:400,300,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lora' rel='stylesheet' type='text/css'> -->



<script>
function myFunction(y) {
var idarr=["poll","FAQQ"];

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
	
include "Header.php";
?>
			
 <?php
    if(isset($_POST['Submit']))
    {
        
        
        $i=1;
        while($i<$_POST['number'])
        {
         		/* takes "number" of variables as to make question and answer from POST work like an array */
			
			/* updates the data in the data base by changing the data in the modal by comparing the ID of the questions  */
         $sql="UPDATE faq
               set Question='".$_POST['Question'.$i]."' , Answer='".$_POST['Answer'.$i]."'
               Where QuestionID='".$_SESSION['quesid'.$i]."';";
         $res4=mysqli_query($conn,$sql);
            $i=$i+1;
        
        }
    }
    ?>
<div class="LeftDiv">


<div>
<div id="Policy-tile" onclick="myFunction('poll')"><span>Policy</span></div>
</div>
<div>
<div id="FAQ-tile" onclick ="myFunction('FAQQ')"><span>FAQ</span></div>
</div>

</div>



<div class="MiddleDiv">



<div id="poll">
<h1 id="policyhead">Company's policy</h1>
<p id="policyparagrph">
<?php
$myfile = fopen("Policy.txt", "r") or die("Unable to open file!");
echo fread($myfile,filesize("Policy.txt"));
fclose($myfile);
?>
</div>


<div id="FAQQ">

<h1 id= "FAQHEAD"> FAQ </h1>

<input type="text" name="search" id="search" onkeyup="getResult()" placeholder="Search"><br>

<div id="result"></div>

<p id="FAQText">
  <?php

// Check connection

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
    echo "0 results<br><br><br>";
}
?>
   
</p>
	
<!--	opens the modal for editing the questions and answers the modal and when submitted it changes the data in the faq page and the data base-->
<button id='edit_faq' style='white-space:pre-wrap;' class='openmodal'>   Edit   </button>
            <!-- The Modal -->

            <div id='myModal' class='modal'>
            <!-- Modal content -->
            <div id="MC" class='modal-content'>
            <span class='close'>&times;</span>
            <h4 style='float:center;'>Employee Info</h4>
            <form class='form-content' method='post' action='' enctype='multipart/form-data'>
            <div class='first-coloumn'>
            <?php
                
                 
                $count1=1;
                $sql = "SELECT * FROM faq";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
				
				/* questions and answers concatinate using count1 so that it would be sent to the ISSet of the form it would be considered as an array of questions and answers  */
				
            echo  "Question :<textarea rows='5' cols='50' style='all:unset;border-width:1px;border-color:black;border-style:solid;white-space:prewrap;text-align:left;margin-left:5px;' name='Question".$count1."'>".$row['Question']."</textarea><br><br>";
                
            echo "Answer :<textarea rows='5' cols='50' style='all:unset;border-width:1px;border-color:black;border-style:solid;white-space:prewrap;text-align:left;margin-left:16px;' name='Answer".$count1."'>".$row['Answer']."</textarea><br><br>";
                
                
                
               /* sent to the form as array of question ID */
				
				
                $_SESSION['quesid'.$count1]=$row['QuestionID'];
                $count1=$count1+1;
                }
                echo "<input type='hidden' name='number' value='".$count1."'>"; 
            }
                
                
            ?>
            </div>
           <input style="float:right;position: absolute;margin-left: 125%;margin-top:auto;" type="Submit" name="Submit" value="Submit Edit">
            </form>
            </div>
            </div>

<script>

function getResult()
{


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

    
    
</script>
    
    
    
 
    

</div>



</div>
</div>

<!-- jQuery (Bootstrap JS plugins depend on it) -->
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/openmodal.js"></script>
<script src="js/script.js"></script>
<script src='js/refresh.js'></script>

</body>
</html>
