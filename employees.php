<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hr System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" id="theme" href="css/employees.css">
    <link rel="stylesheet" href="css/animate.css">


    <?php 
	  
      
     include_once "dbconnection.php";
      include_once"Exception_file.php";
      session_start();
    
	
	
	
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
?>



    <script>
        function myFunction(y) {
            var idarr = ["TablesDiv", "myDepartment"]

            // document.getElementById("poll").style.display="none";
            y += "";
            var x = document.getElementById(y);
            var count = 0;

            for (var i = 0; i < idarr.length; i++) {
                var l = document.getElementById(idarr[count] + '');
                l.style.display = "none";
                count++;
            }

            x.style.display = "block";

        }

    </script>


</head>


<body>



    <div class="parentdiv">


        <?php
      
      include "Header.php";
    ?>


        <div class="LeftDiv">
            <div>
                <div id="my-profile-tile" onclick="myFunction('TablesDiv')"><span>My Profile</span></div>
            </div>

            <div>
                <div id="my-departement-tile" onclick="myFunction('myDepartment')"><span>My Departement</span></div>
            </div>

            <!--Department:<label style='margin-left:4px;color:black;'>".$row['Departement']."</label><br><br>-->

        </div> <!-- end of left div -->


        <div class="MiddleDiv">
		
		 
        <?php        if(isset($_POST['Submit'])) /* Validating of first name,last name and password as strings and removing special characters and mobile and national id as Integers */
      { if(!filter_var($_POST['firstname'], FILTER_VALIDATE_INT) === false||preg_match('/[\'\/~`\!@#\$%\^&\*\(\)\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $_POST['firstname'])|| preg_match_all('/\d+/', $_POST['firstname'])||mb_strlen($_POST['firstname'])<3) {
                echo('<script>alert("Please Enter valid name with more than 3 characters in the FirstName")</script>');
    
} 
       else if(!filter_var($_POST['lastname'], FILTER_VALIDATE_INT) === false||preg_match('/[\'\/~`\!@#\$%\^&\*\(\)\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $_POST['lastname'])|| preg_match_all('/\d+/', $_POST['lastname'])||mb_strlen($_POST['lastname'])<3) {
                echo('<script>alert("Please Enter valid name with more than 3 characters in the LastName")</script>');
       }
        else if(!filter_var($_POST['mobile'], FILTER_VALIDATE_INT)===false||mb_strlen((string)$_POST['mobile'])!=11||
               preg_match('/[a~z,A~Z]/',$_POST['mobile'])||preg_match('/^(011|012|010)\d{9}$/ ',$_POST['mobile'])) {
                echo('<script>alert("Please Enter valid mobile number in the Mobile text field")</script>');
       }
          else  if(preg_match('/;/', $_POST['password'])||mb_strlen((string)$_POST['password'])<3) {
                echo('<script>alert("Please do not use the ; or a password with three or less characters in the Password")</script>');
    
  }else if(!filter_var($_POST['NationalID'], FILTER_VALIDATE_INT)===false||mb_strlen((string)$_POST['NationalID'])!=22||
               preg_match('/[a~z,A~Z]/',$_POST['NationalID'])) {
                echo('<script>alert("Please Enter valid NationalID in the NationalID text field")</script>');
       }
		 else{ 
		 

			 
			 
			 /*This is the part of uploading an image to the database in the modal of the first edit*/
			 
  $name = $_FILES['PassportImage']['name'];
  $name2 = $_FILES['NationalImage']['name'];
  $name3 = $_FILES['ProfileImage']['name'];
  $target_dir = "upload/";
  $target_dir2 = "upload/";
  $target_dir3 = "upload/";
  $target_file = $target_dir. basename($_FILES["PassportImage"]["name"]);
  $target_file2 = $target_dir2. basename($_FILES["NationalImage"]["name"]);
  $target_file3 = $target_dir3. basename($_FILES["ProfileImage"]["name"]);

  // Select file type
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
  $imageFileType3 = strtolower(pathinfo($target_file3,PATHINFO_EXTENSION));

  // Valid file extensions
  $extensions_arr = array("jpg","jpeg","png","gif");

  $image;
  $image2;		  
  $image3;
  $image1found=false;
  $image2found=false;
  $image3found=false;
		  
  // Check extension
		  if ($_FILES['PassportImage']['error'] == 0)
		  {
				if( in_array($imageFileType,$extensions_arr) ){
				$image_base64 = base64_encode(file_get_contents($_FILES['PassportImage']['tmp_name']) );
				$image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
				move_uploaded_file($_FILES['PassportImage']['tmp_name'],$target_dir.$name);
               $image1found=true;
			  }
		  }
		  
		  if ($_FILES['NationalImage']['error'] == 0)
		  {
				if( in_array($imageFileType2,$extensions_arr) ){
				$image2_base64 = base64_encode(file_get_contents($_FILES['NationalImage']['tmp_name']) );
				$image2 = 'data:image/'.$imageFileType2.';base64,'.$image2_base64;
				move_uploaded_file($_FILES['NationalImage']['tmp_name'],$target_dir2.$name2);
               $image2found=true;
			  }
		  }
		  if ($_FILES['ProfileImage']['error'] == 0)
		  {
				if( in_array($imageFileType3,$extensions_arr) ){
				$image3_base64 = base64_encode(file_get_contents($_FILES['ProfileImage']['tmp_name']) );
				$image3 = 'data:image/'.$imageFileType3.';base64,'.$image3_base64;
				move_uploaded_file($_FILES['ProfileImage']['tmp_name'],$target_dir3.$name3);
               $image3found=true;
			  }
		  }
		  
			 /* check if the marital status is selected as a new value or already selected value  */
		  
		  if($_POST['Selectop']=="Selected") /*if marital status is the value selected then it means it remains unchanged so everything inserted into the db except marital status*/
		  {
			 $sql2="INSERT INTO requests (EmployeeID,FirstName,LastName,Mobile,Password,NationalID,MaritalStatus,Request_type,PassportImage,NationalIDImage,ProfileImage) VALUES(".$_POST['ID'].",'".$_POST['firstname']."','".$_POST['lastname']."',".$_POST['mobile'].",'".$_POST['password']."',".$_POST['NationalID'].",'".$_POST['defaultmarital']."','Edit','".$_POST['passport']."','".$_POST['nationalimage']."','".$_POST['profileimage']."');";
              $res = mysqli_query($conn,$sql2);
                        if($res)
								{
									echo "<div class='alert alert-success animated fadeOut delay-1s'>
																		  <strong>Updated Successfully</strong>
																		  </div>";
								}
					            else{
									 echo"<div class='alert alert-danger animated fadeOut delay-1s'>
                                            <strong>Error Updating</strong>
                                            </div>";
								}
		  }
		  else{ /*else insert into database with the new value of marital status along with everything else*/
			  $sql2="INSERT INTO requests (EmployeeID,FirstName,LastName,Mobile,Password,NationalID,MaritalStatus,Request_type,PassportImage,NationalIDImage,ProfileImage) VALUES(".$_POST['ID'].",'".$_POST['firstname']."','".$_POST['lastname']."',".$_POST['mobile'].",'".$_POST['password']."',".$_POST['NationalID'].",'".$_POST['Selectop']."','Edit','".$_POST['passport']."','".$_POST['nationalimage']."','".$_POST['profileimage']."');";
              $res = mysqli_query($conn,$sql2);
              
                        if($res)
								{
									echo "<div class='alert alert-success animated fadeOut delay-1s'>
																		  <strong>Updated Successfully</strong>
																		  </div>";
								}
					            else{
									 echo"<div class='alert alert-danger animated fadeOut delay-1s'>
                                            <strong>Error Updating</strong>
                                            </div>";
								}
		  }
		  
		  	  
		  
		  /* we check is every uploaded image from the edit modal threw and error or not if it threw and error then it wont update its value in the database else if the image is found = true the image was uploaded successfully and will be updated into the database */	 
			 
		  if ($image1found==true)
		  {
			  $sql4="UPDATE requests
				 SET PassportImage='".$image."'
					WHERE EmployeeID=".$_POST['ID'].";";
				   $res1 = mysqli_query($conn,$sql4);
		  }
		    if ($image2found==true)
		  {
			  $sql4="UPDATE requests
				 SET NationalIDImage='".$image2."'
					WHERE EmployeeID=".$_POST['ID'].";";
				   $res1 = mysqli_query($conn,$sql4);
		  }
		    if ($image3found==true)
		  {
			  $sql5="UPDATE requests
				 SET ProfileImage='".$image3."'
					WHERE EmployeeID=".$_POST['ID'].";";
				   $res1 = mysqli_query($conn,$sql5);
		  }
            
		  
		  
		  
          }
          
      }
			/* here is the is set of the updating of the edits modal we start by validating the values of firstname,lastname,password,mobile and nationalid as before then we check if images was uploaded successfully then we update the database */
	  else if(isset($_POST['Submit-edits']))
	  {
          if(!filter_var($_POST['firstname'], FILTER_VALIDATE_INT) === false||preg_match('/[\'\/~`\!@#\$%\^&\*\(\)\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $_POST['firstname'])|| preg_match_all('/\d+/', $_POST['firstname'])||mb_strlen($_POST['firstname'])<3) {
                echo('<script>alert("Please Enter valid name with more than 3 characters in the FirstName")</script>');
    
} 
       else if(!filter_var($_POST['lastname'], FILTER_VALIDATE_INT) === false||preg_match('/[\'\/~`\!@#\$%\^&\*\(\)\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $_POST['lastname'])|| preg_match_all('/\d+/', $_POST['lastname'])||mb_strlen($_POST['lastname'])<3) {
                echo('<script>alert("Please Enter valid name with more than 3 characters in the LastName")</script>');
       }
        else if(!filter_var($_POST['mobile'], FILTER_VALIDATE_INT)===false||mb_strlen((string)$_POST['mobile'])!=11||
               preg_match('/[a~z,A~Z]/',$_POST['mobile'])||preg_match('/^(011|012|010)\d{9}$/ ',$_POST['mobile'])) {
                echo('<script>alert("Please Enter valid mobile number in the Mobile text field")</script>');
       }
          else  if(preg_match('/;/', $_POST['password'])||mb_strlen((string)$_POST['password'])<3) {
                echo('<script>alert("Please do not use the ; or a password with less than three characters in the Password")</script>');
    
  }else if(!filter_var($_POST['NationalID'], FILTER_VALIDATE_INT)===false||mb_strlen((string)$_POST['NationalID'])!=22||
               preg_match('/[a~z,A~Z]/',$_POST['NationalID'])) {
                echo('<script>alert("Please Enter valid NationalID in the NationalID text field")</script>');
       }
          else{
		  
	  $name = $_FILES['PassportImage1']['name'];
	  $name2 = $_FILES['NationalImage1']['name'];
	  $name3 = $_FILES['ProfileImage1']['name'];
	  $target_dir = "upload/";
	  $target_dir2 = "upload/";
	  $target_dir3 = "upload/";
	  $target_file = $target_dir . basename($_FILES["PassportImage1"]["name"]);
	  $target_file2 = $target_dir2 . basename($_FILES["NationalImage1"]["name"]);
	  $target_file3 = $target_dir3 . basename($_FILES["ProfileImage1"]["name"]);

	  // Select file type
	  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	  $imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
	  $imageFileType3 = strtolower(pathinfo($target_file3,PATHINFO_EXTENSION));

	  // Valid file extensions
	  $extensions_arr = array("jpg","jpeg","png","gif");

	  $image;
	  $image2;		  
	  $image3;
	  $image1found=false;
	  $image2found=false;
	  $image3found=false;

	  // Check extension
			  if ($_FILES['PassportImage1']['error'] == 0)
			  {
					if(in_array($imageFileType,$extensions_arr) ){
					$image_base64 = base64_encode(file_get_contents($_FILES['PassportImage1']['tmp_name']) );
					$image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
					move_uploaded_file($_FILES['PassportImage1']['tmp_name'],$target_dir.$name);
				   $image1found=true;
				  }
			  }

			  if ($_FILES['NationalImage1']['error'] == 0)
			  {
					if( in_array($imageFileType2,$extensions_arr) ){
					$image2_base64 = base64_encode(file_get_contents($_FILES['NationalImage1']['tmp_name']) );
					$image2 = 'data:image/'.$imageFileType2.';base64,'.$image2_base64;
					move_uploaded_file($_FILES['NationalImage1']['tmp_name'],$target_dir2.$name2);
				   $image2found=true;
				  }
			  }
			  if ($_FILES['ProfileImage1']['error'] == 0)
			  {
					if( in_array($imageFileType3,$extensions_arr) ){
					$image3_base64 = base64_encode(file_get_contents($_FILES['ProfileImage1']['tmp_name']) );
					$image3 = 'data:image/'.$imageFileType3.';base64,'.$image3_base64;
					move_uploaded_file($_FILES['ProfileImage1']['tmp_name'],$target_dir2.$name3);
				   $image3found=true;
				  }
			  }

		       
		       if($_POST['Selectop']=="Selected") /*here we update the data base with every value except marital status as it remain unchecked */
			   {
				$sql4="UPDATE requests
				 SET FirstName='".$_POST['firstname']."',LastName='".$_POST['lastname']."',Mobile=".$_POST['mobile'].",NationalID=".$_POST['NationalID'].",Password='".$_POST['password']."'
				 WHERE EmployeeID=".$_POST['ID'].";";
				 $res1 = mysqli_query($conn,$sql4);
          
          						if($res1)
								{
									echo "<div class='alert alert-success animated fadeOut delay-1s'>
																		  <strong>Updated Successfully</strong>
																		  </div>";
								}
					            else{
									 echo"<div class='alert alert-danger animated fadeOut delay-1s'>
                                            <strong>Error Updating</strong>
                                            </div>";
								}

			   }
		  		else { /*we update the database with everything along with the marital status*/
				$sql4="UPDATE requests
				 SET FirstName='".$_POST['firstname']."',LastName='".$_POST['lastname']."',Mobile=".$_POST['mobile'].",NationalID=".$_POST['NationalID'].",Password='".$_POST['password']."',MaritalStatus='".$_POST['Selectop']."'
				 WHERE EmployeeID=".$_POST['ID'].";";
				 $res1 = mysqli_query($conn,$sql4);
                            if($res1)
								{
									echo "<div class='alert alert-success animated fadeOut delay-1s'>
																		  <strong>Updated Successfully</strong>
																		  </div>";
								}
					            else{
									 echo"<div class='alert alert-danger animated fadeOut delay-1s'>
                                            <strong>Error Updating</strong>
                                            </div>";
								}

				}

		  
  		  if ($image1found==true)
		  {
			  $sql5="UPDATE requests
				 SET PassportImage='".$image."'
					WHERE EmployeeID=".$_POST['ID'].";";
				   $res2 = mysqli_query($conn,$sql5);
		  }
		    if ($image2found==true)
		  {
			  $sql5="UPDATE requests
				 SET NationalIDImage='".$image2."'
					WHERE EmployeeID=".$_POST['ID'].";";
				   $res2 = mysqli_query($conn,$sql5);
		  }
		    if ($image3found==true)
		  {
			  $sql5="UPDATE requests
				 SET ProfileImage='".$image3."'
					WHERE EmployeeID=".$_POST['ID'].";";
				   $res1 = mysqli_query($conn,$sql5);
		  }
      }
	  }
      
     
      
      ?>
            <div id="TablesDiv">
                <h3>My Profile</h3>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Departement
                        </th>
                        <th>

                        </th>
                    </tr>

                    <?php
				
				 $sql = "SELECT * FROM requests where EmployeeID=".$_SESSION['ID'];
						$result = $conn->query($sql);
				
				
                        $sql6="select Type from departements where DepartementID ='".$_SESSION["depid"]."';";
				 $res6=mysqli_query($conn,$sql6);
                        $row= mysqli_fetch_row($res6);
                        $id=$row[0];

						if ($result->num_rows > 0) 
						{
							
						/*here is the modal of the updating of edits  we start by saving the passport image national image profile image to send it to the page of showimages.php using session variable then we use form to send the data of the updates to the request table in database in the isset of submit-edits */ 	
						
						while($row = $result->fetch_assoc()) 
						{
							$_SESSION['PassportImage']=$row['PassportImage'];
							$_SESSION['NationalImage']=$row['NationalIDImage'];
							$_SESSION['ProfileImage']=$row['ProfileImage'];
							
							
						echo "<tr><td>".$row["EmployeeID"] ."</td>
							      <td>".$row["FirstName"]."</td>
							      <td>".$id. "</td>
							      <td>
						                <button type='button' id='view_emp' class='openmodal btn btn-warning'>View</button>
						                <!-- The Modal -->
										<div id='myModal' class='modal'>

										  <!-- Modal content -->
										  <div id='MC'class='modal-content'>
										    <span class='close'>&times;</span>
                                            <h4 style='float:center;'>Employee Info</h4>
										  <form class='form-content' method='post' action='' enctype='multipart/form-data'>
                                          <div class='first-coloumn'>
                                           ID :<input type='text' style='all:unset;margin-left:45px;' name='ID' value='".$row["EmployeeID"]."' readonly ><br><br>
                                           Firstname :<input type='text' style='margin-left:5px;'name='firstname' value='".$row["FirstName"]."' ><br><br>
                                           Lastname :<input type='text' style='margin-left:5px;' name='lastname' value='".$row["LastName"]."' ><br><br>
                                           Mobile :<input type='text' style='margin-left:18px;' name='mobile' value='0".$row["Mobile"]."'><br><br>
                                           NationalID: <input type='text' name='NationalID' value='".$row["NationalID"]."'><br><br>
                                           </div>
                                           <div class='second-coloumn'>
                                           Password :<input type='text' style='margin-left:5px;' name='password' value='".$row["Password"]."'><br><br>
                                           Marital Status: <select name='Selectop' style='border-radius: 6px;margin-left:5px;' id='Select'>
										   		<option value='Selected'>Selected status:".$row['MaritalStatus']."</option>
                                                <option value='Single'>Single</option>
                                                <option value='Married'>Married</option>
                                                <option value='Divorced'>Divorced</option>
                                            </select>
											
                                           <input type='hidden' name='RequestID' value='".$row['RequestID']."'>
										   <br><br>
										  Upload Passport: <input type='file' style='border-radius: 6px;' name='PassportImage1'>
										  <br><br>
										  Upload NationalID: <input type='file' style='border-radius: 6px;'name='NationalImage1'>
										  <br><br>
										  Upload Profile Picture: <input type='file' style='border-radius:6px;' name='ProfileImage1'>
										  <br><br>
										  <a href='ShowImages.php'>Show Uploaded Images</a>
                                          
                                           </div>
										   <input style='float:right; position:absolute; margin-top: 30%;border-radius: 6px; margin-left: 30%;' type='Submit' name='Submit-edits' value='Submit Edit'>
                                          </form>
										  </div>

										</div>
						                
						          </td>
							  </tr>";
                           
                            
						}
//						echo "</table>";
						} else { 
						
									
				        $sql = "SELECT * FROM employees where ID ='".$_SESSION["ID"]."';";
                        $sql6="select Type from departements where DepartementID ='".$_SESSION["depid"]."';";
                        $res6=mysqli_query($conn,$sql6);
                        $row= mysqli_fetch_row($res6);
                        $id=$row[0];
						$result = $conn->query($sql);

						if ($result->num_rows > 0) 
						{
						/*here is the modal of the first time editing we save the passportimage nationalimage and profile image to show already uploaded images in the database in the page showimages.php then we use a form to send the data to the isset of submit from the employees table to the requests table for creating a new life cycle of edits */
						while($row = $result->fetch_assoc()) 
						{
							$_SESSION['PassportImage']=$row['PassportImage'];
							$_SESSION['NationalImage']=$row['NationalIDImage'];
							$_SESSION['ProfileImage']=$row['ProfileImage'];
							
						echo "<tr><td>".$row["ID"]. "</td>
							      <td>".$row["FirstName"] . "</td>
							      <td>".$id. "</td>
							      <td>
						                <button type='button' id='edit_emp' class='openmodal btn btn-warning'>Edit</button>
						                <!-- The Modal -->
										<div id='myModal' class='modal'>

										  <!-- Modal content -->
										  <div id='MC' class='modal-content'>
										    <span class='close'>&times;</span>
                                            <h4 style='float:center;'>Employee Info</h4>
										  <form class='form-content' method='post' action=''  enctype='multipart/form-data'>
                                          <div class='first-coloumn'>
                                           ID :<input type='text' style='all:unset;margin-left:45px;' name='ID' value='".$row["ID"]."' readonly><br><br>
                                           Firstname :<input type='text' style='margin-left:5px;'name=firstname value='".$row["FirstName"]."'><br><br>
                                           Lastname :<input type='text' style='margin-left:5px;' name=lastname value='".$row["LastName"]."'><br><br>
                                           Mobile :<input type='text' style='margin-left:18px;' name=mobile value='0".$row["Mobile"]."'><br><br>
                                           Gender :<label style='margin-left:15px;'>".$row['Gender']."</label><br><br>
                                           Job:<label style='margin-left:40px;'>".$row['JOB']."</label><br><br>
                                           Job Status:<label style='margin-left:4px;color:green;'>".$row['JobStatus']."</label><br><br>
                                           NationalID: <input type='text' name='NationalID' value='".$row["NationalID"]."'><br><br>
                                           </div>
                                           <div class='second-coloumn'>
                                           Username :<label style='margin-left:15px;'>".$row['Username']."</label><br><br>
                                           Password :<input type='text' style='margin-left:5px;' name='password' value='".$row["Password"]."'><br><br>
                                           Marital Status: <select name='Selectop' style='margin-left:5px;' id='Select'>
										   		<option value='Selected'>Selected status:".$row['MaritalStatus']."</option>
                                                <option value='Single'>Single</option>
                                                <option value='Married'>Married</option>
                                                <option value='Divorced'>Divorced</option>
                                            </select>
											<input type='hidden' name='defaultmarital' value='".$row['MaritalStatus']."'>
                                            <br><br>
                                            Upload Passport: <input type='file' style='border-radius: 6px;' name='PassportImage'>
											<br><br>
											Upload NationalID: <input type='file'style='border-radius: 6px;' name='NationalImage'>
											<br><br>
											Upload Profile Picture : <input type='file'style='border-radius: 6px;' name='ProfileImage'>
											<br><br>
											<input type='hidden' name='passport' value='".$row['PassportImage']."'>
                                           <input type='hidden' name='nationalimage' value='".$row['NationalIDImage']."'>
										   <input type='hidden' name='profileimage' value='".$row['ProfileImage']."'>
											
											<a href='ShowImages.php'>Show Uploaded Images</a>
                                            
                        
                                           </div>
                                           <input style='float:right; position:absolute; margin-top: 30%;border-radius:6px; margin-left: 30%;' type='Submit' name='Submit' value='Submit Edit'>
                                          </form>
										  </div>

										</div>
						                
						          </td>
							  </tr>";
						}
						}
//						echo "</table>";

						}

				
				
				?>
                </table>



            </div> <!-- end table div -->

            <div id="myDepartment">

                <h3 id="h3dep">My Department</h3>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            Hire Date
                        </th>
                        <th>
                            Departement
                        </th>

                    </tr>

                    <?php
		                /*here we show all employees from the same department*/
				        $sql = "SELECT * FROM employees where DepartementID ='".$_SESSION["depid"]."';";
                        $sql6="select Type from departements where DepartementID ='".$_SESSION["depid"]."';";
                        $res6=mysqli_query($conn,$sql6);
                        $row= mysqli_fetch_row($res6);
                        $id=$row[0];
               
						$result = $conn->query($sql);

						if ($result->num_rows > 0) 
						{
						// output data of each row
						while($row = $result->fetch_assoc()) 
						{
						echo "<tr><td>".$row["FirstName"]. "</td>
							      <td>".$row["HireDate"] . "</td>
							      <td>".$id. "</td>
							  </tr>";
						}
//						echo "</table>";
						} else { echo "0 results"; }

				?>
                </table>
            </div>
        </div> <!-- end middle div -->

    </div> <!-- end of parent div -->


    <!-- begining of script tag inside body tag -->




    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/openmodal.js"></script>
    <script src="js/refresh.js"></script>





</body>

</html>
