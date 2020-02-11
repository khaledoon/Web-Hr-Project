<!<!DOCTYPE html>
<?php
include_once ("dbconnection.php");
include_once"Exception_file.php";
/*this is to make sure there is a stable connection*/
	try{if(!$conn){
throw new customExceptionFailedConnection();	
	
	
}}catch(customExceptionFailedConnection $e){
	$e->reroute($_SESSION['ID']);
}
	
	


if(isset($_POST['Submit']))
{ 
	/*this is the validations to make sure there is no sql injections or and no numbers in the first name or last name and that the username does use the allowed special characters*/
    if(!filter_var($_POST['FirstName'], FILTER_VALIDATE_INT) === false||preg_match('/[\'\/~`\!@#\$%\^&\*\(\)\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $_POST['FirstName'])|| preg_match_all('/\d+/', $_POST['FirstName'])||mb_strlen($_POST['FirstName'])<3) {
                echo('<script>alert("Please Enter valid name with more than 3 characters in the FirstName field")</script>');
    
} else if(!filter_var($_POST['LastName'], FILTER_VALIDATE_INT) === false||preg_match('/[\'\/~`\!@#\$%\^&\*\(\)\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $_POST['LastName'])|| preg_match_all('/\d+/', $_POST['LastName'])||mb_strlen($_POST['LastName'])<3) {
                echo('<script>alert("Please Enter valid name with more than 3 characters in the LastName field")</script>');
    
}
  else  if(!filter_var($_POST['UserName'], FILTER_VALIDATE_INT) === false||preg_match('/[\'\/~`\!@#\$%\^&\*\(\)\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $_POST['UserName'])||mb_strlen($_POST['UserName'])<3) {
                echo('<script>alert("Please Enter username with more than 3 characters in the UserName field")</script>');
    
  }else  if(preg_match('/;/', $_POST['Password'])||mb_strlen((string)$_POST['Password'])<3) {
                echo('<script>alert("Please do not use the ; or enter a password with 3 or more characters in the Password field ")</script>');
    
  }

    else {if ($_POST['Selectop']==="HR")
    {

/*to check on username and assign the directly to HR department*/
    $sql2 = "Select * from employees where Username = '".$_POST['UserName']."'"; 
    $sql3 = "Select * from requests where Username = '".$_POST['UserName']."'"; 
    $res = mysqli_query($conn,$sql2);
    $res1= mysqli_query($conn,$sql3);
    $rowcount=mysqli_num_rows($res);
    $rowcount1=mysqli_num_rows($res1);
        
        
        if($rowcount < 1 && $rowcount1 < 1){
            if($_POST['SelecGender']==="0")
            {
               echo '<script> alert("Please Select Gender")</script>';
            }
             //else if ($_POST['Selectdep']==="def"){
               //      echo '<script> alert("Please Select Departement")</script>';
             //}
            else{
				/*$sql6="select DepartementID from departements where Type ='Human Resources';";
                        $res6=mysqli_query($conn,$sql6);
                        $row= mysqli_fetch_row($res6);
                        $id=$row[0];*/
				/*assign the data to the request table in the database*/
        $sql = "INSERT INTO requests (FirstName,LastName,Username,Password,JOB,Gender,Request_type,Departement) VALUES ('".$_POST['FirstName']."','".$_POST['LastName']."','".$_POST['UserName']."','".$_POST['Password']."','".$_POST['Selectop']."','".$_POST['SelecGender']."','Register','Human Resources')";
        $result = mysqli_query($conn,$sql);
        if($result) 
        {
        echo '<script> alert("Your Register Has Been Submited Please Await Approve From ADMIN")</script>';
          //header("Location:login.php");
                
        }
            }
        }
        else { echo '<script> alert("Username Already Exists")</script>';}
      
    }
    else 
    {
		/*check that the username is not taken that the didn't request registeration before*/
         $sql2 = "Select * from employees where Username = '".$_POST['UserName']."'"; 
    $sql3 = "Select * from requests where Username = '".$_POST['UserName']."'"; 
    $res = mysqli_query($conn,$sql2);
    $res1= mysqli_query($conn,$sql3);
    $rowcount=mysqli_num_rows($res);
    $rowcount1=mysqli_num_rows($res1);
        
    
    
        if($rowcount < 1 && $rowcount1 < 1){
              if($_POST['SelecGender']==="0")
             {
               echo "<script> alert('Please Select Gender')</script>";
              }
              else if ($_POST['Selectdep']==="def"){
                    echo '<script> alert("Please Select Departement")</script>';
            }
            else{
			/*	assign the data to the the request table in the database*/
        $sql5 = "INSERT INTO requests (FirstName,LastName,Username,Password,JOB,Gender,Departement,Request_type) VALUES ('".$_POST['FirstName']."','".$_POST['LastName']."','".$_POST['UserName']."','".$_POST['Password']."','".$_POST['Selectop']."','".$_POST['SelecGender']."','".$_POST['Selectdep']."','Register')";
        $result1 = mysqli_query($conn,$sql5);
        if($result1) 
            {
                echo '<script> alert("Your Register Has Been Submited Please Await Approve From HR")</script>';
            }
          }
        }
        else { echo '<script> alert("Username Already Exists")</script>';}
        
    }

}}



?>
    <html lang="en" dir="tr">

    <head>
        <meta charset="utf-8">
        <title> SignUp Page </title>
        <link rel="stylesheet" href="css/Signup.css">
        
        
        <script>
        function changeopt(){
			/*if the selected job is HR then the department dropbox is hidden because the hr is assigned directly to HR department*/
            var x=document.getElementById("Empval").value;
            var z=document.getElementById("Select1");
            
            if (x=="HR")
                {
                    z.style.display="none";
                }
            else 
                {
                    z.style.display="block";
                    
                }
            
        }
            
            
        function show()
            {			/*if the selected job is Employees then the department dropbox is shown */

                var x=document.getElementById("Empval").value;
                var z=document.getElementById("Select1");
                
                if (x=="EM")
                    {
                        z.style.display="block";
                    }
            }
            setInterval(show,50);
        
        </script>
        
            </head>

    <body>
        <div class="wrapper">
            <form class="box" action="" method="post">
                <h1>HR System Signup</h1>

                <input type="text" name="FirstName" placeholder="First name" required>

                <input type="text" name="LastName" placeholder="Last name" required>

                <input type="text" name="UserName" placeholder="User name" required>

                <input type="password" name="Password" placeholder="Password" required>
                
              

                <select name="SelecGender" id="Select">
                   <option value="0"> Select Gender </option>
                    <option value="Male"> Male </option>
                    <option value="Female"> Female </option>
                 </select> 
              
                   <select name="Selectop" id="Empval" onchange="changeopt()">
                 <option value="HR">HR</option>
                 <option value="EM">Employee</option>
                 </select> 

                 <select name="Selectdep" id="Select1" >
                 <option value="def"> Select Departement </option>
                 <?php 
                        $sql33 = "SELECT Type FROM departements;";
                        $result = $conn->query($sql33);
/*getting the departments form the department table in the database*/
                        while ($row = $result->fetch_assoc()) {
							if($row['Type']==="Human Resources" || $row['Type']==="Quality Control")
							{
							}
							else{
                          echo "<option value=".$row['Type'].">  ".$row['Type']."</option>";
							}
                        }
                 ?>
                 </select> 
                <input type="submit" name="Submit" value="SignUp">
                <p style="color: white;">Already have an account?</p><a href="login.php" style="color: white;">login here!</a>
                


            </form>
        </div>
		<script src='js/refresh.js'></script>
    </body>
    </html>