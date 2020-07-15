<!<!DOCTYPE html>
<html lang ="en" dir="tr">
<head>
  <meta charset="utf-8">
  <title> HR PROJECT</title>
    <link rel = "stylesheet" href="css/login.css">
    </head>
    
    
    <body>
        
        <?php
		/*this is used to make sure there is a stable connection*/
        session_start();
		include_once "Exception_file.php";
        include_once ("dbconnection.php");
		try{
			if(!$conn)
			{
				throw new customExceptionFailedConnection();
			}
			
			
		}catch(customExceptionFailedConnection $e){
		$e->reroute($_SESSION['ID']);	
			
			
		}
		
        if(isset($_POST['submit'])){
            if (!filter_var($_POST['username'], FILTER_VALIDATE_INT) === false||preg_match('/[\'\/~`\!@#\$%\^&\*\(\)\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $_POST['username'])) {
                echo('<script>alert("Please Enter string in the username")</script>');
    
}
         else if (preg_match('/;/', $_POST['password'])) {
                echo('<script>alert("Please Enter string in the password")</script>');
    
}
            
            
        else{    
            $sql = "Select * from employees where Username = '".$_POST['username']."' and Password = '".$_POST['password']."'" ; 
            $result = mysqli_query($conn,$sql) ;
            if($row=mysqli_fetch_array($result))
            { 
				/*setting the session variables*/
                $_SESSION["ID"]=$row[0];
                $_SESSION["name"]=$row["FirstName"];
                $_SESSION["lastname"]=$row["LastName"];
                $_SESSION["username"]=$row["UserName"];
                $_SESSION["job"]=$row["JOB"];
                $_SESSION["salary"]=$row["Salary"];
                $_SESSION["mobile"]=$row["Mobile"];
                $_SESSION["natID"]=$row["NationalID"];
                $_SESSION["marStat"]=$row["MaritalStatus"];
                $_SESSION["hired"]=$row["HireDate"];
                $_SESSION["depid"]=$row["DepartementID"];
                
                header("Location:MainPage.php");
            }
            else
            {
                echo '<script>
                        alert("Invalid Username or Password")
                        </script>';
            }
        }
        }
        ?>
		<!--form to enter the username and password-->
        <div class="wrapper">
      <form class="box" action = "" method ="post">
        <h1>login</h1>
        <input type ="text" name= "username" placeholder ="username">
        <input type ="password" name= "password" placeholder ="password">
        <input type ="submit" name= "submit" value ="login">
         <p style="color: white;">Do not have an account?</p><a href="Signup.php" style="color: white;">Sign up here!</a>
        </form>
        </div>
		
		
	<script src='js/refresh.js'></script>
		
    </body>
        </html>
