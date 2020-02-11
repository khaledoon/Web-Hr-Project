<?php
include_once"Exception_file.php";
$conn = mysqli_connect("localhost","root","","hr_system");
try{if(!$conn){
throw new customExceptionFailedConnection();	
	
}/*if($_POST['search']==null){
throw new customExceptionFailedConnection();		
		
	}*/
	
}catch(customExceptionFailedConnection $e){
	$e->reroute();
}
$search = $_POST['search'];
$sql = "select faq.Question, faq.Answer from faq";
if($search!=""){
	
	/* search in the form for the simillar word written in the search bar*/
   $sql = $sql." WHERE Question LIKE '%$search%'
   or Answer LIKE '%$search%'";
}

/* shows the result of the search in the page and when deleted from the search bar it gets back to its normal form again */
if($result = mysqli_query($conn,$sql)){
  if(mysqli_num_rows($result)>0){
    while($row = $result->fetch_assoc()) {
        
        echo "Question: " . $row["Question"]."<br>";
        echo "Answer: " . $row["Answer"]. "<br>";
        echo  "<br>";
        
        
    }
 }
	/* when there is no result found No Matches appeares instead*/
	
  else {
    echo "No Matches";
  }
}
  else {
    echo "Could not execute $sql.".mysqli_error($conn);
  }

    mysqli_close($conn);
 ?>
