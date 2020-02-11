<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hr System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" id="theme" href="css/employeeshr.css">
    <link rel="stylesheet" href="css/animate.css">


   


    <script>
        function myFunction(y) {
            var idarr = ["TablesDiv", "Register","payroll"]

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
      include_once ("dbconnection.php");
      include_once"Exception_file.php";
		
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


        <div class="LeftDiv">
            <div>
                <div id="edit-requests-tile" onclick="myFunction('TablesDiv')"><span>Edit Requests</span></div>
            </div>

            <div>
                <div id="register-requests-tile" onclick="myFunction('Register')"><span>Register Requests</span></div>
            </div>


            <div>
                <div id="all-emps-tile" onclick="myFunction('payroll')"><span>Employees Payroll</span></div>
            </div>



        </div> <!-- end of left div -->


        <div class="MiddleDiv">
               <?php 
    
    
      
     
      
     if(isset($_POST['Approve-submit']))
      {
		 /*here we update the employees table by getting the data from the request table and approving it*/
          
           $sql4="UPDATE employees
             SET FirstName='".$_POST['firstname']."',LastName='".$_POST['lastname']."',Mobile=".$_POST['mobile'].",NationalID=".$_POST['NationalID'].",Password='".$_POST['password']."',MaritalStatus='".$_POST['marital-status']."',PassportImage='".$_POST['passport']."',NationalIDImage='".$_POST['nationalimage']."',ProfileImage='".$_POST['profileimage']."'
                WHERE ID=".$_POST['ID'].";";
               $res1 = mysqli_query($conn,$sql4);   
         
         
                   						if($res1)
								{
									echo "<div class='alert alert-success animated fadeOut delay-1s'>
																		  <strong>Approved</strong>
																		  </div>";
											 $sql3="delete from requests where RequestID=".$_POST['RequestID'].";";
											$res=mysqli_query($conn,$sql3);
								}
					            else{
									 echo"<div class='alert alert-danger animated fadeOut delay-1s'>
                                            <strong>Error</strong>
                                            </div>";
								}
          
      }
      else if (isset($_POST['Approve1-submit']))
      {
		  /*here we insert a new employee into employees table by accepting the signup request from requests table*/
          $sql6="select DepartementID from departements where Type='".$_POST['dep']."';";
          $res6=mysqli_query($conn,$sql6);
          $row= mysqli_fetch_row($res6);
          $id=$row[0];
           $sql2="INSERT INTO employees (FirstName,LastName,Password,Gender,Username,JOB,DepartementID)
        VALUES('".$_POST['firstname']."','".$_POST['lastname']."','".$_POST['password']."','".$_POST['gender']."','".$_POST['username']."','".$_POST['job']."',".$id.");";
              $res = mysqli_query($conn,$sql2);
          
                    if($res)
								{
									echo "<div class='alert alert-success animated fadeOut delay-1s'>
																		  <strong>Added Successfully</strong>
																		  </div>";
						$sql3="delete from requests where RequestID=".$_POST['RequestID'];
          $res1=mysqli_query($conn,$sql3);
								}
					            else{
									 echo"<div class='alert alert-danger animated fadeOut delay-1s'>
                                            <strong>Error Adding</strong>
                                            </div>";
								}
          
           
      }
      else if (isset($_POST['Reject-submit']))
      {   /*here we delete the record from request table when you reject an edit or a signup request */
          $sql3="delete from requests where RequestID=".$_POST['RequestID'];
          $res=mysqli_query($conn,$sql3);
      }
    else if(isset($_POST['Assign']))
    {if($_POST['bonus']==null ){
        $_POST['bonus']=0;
    }
	 /*here we assign the payroll to the employee we calculate the net salary then insert a new record into the payroll table saving the salary and bonus of current month then we update the salary of the employee in the employee table*/
	  if($_POST['salary']==NULL)
	 {
		 $_POST['salary']=0;
	 }
	 $net=0;
    $net = $_POST['salary'] + $_POST['bonus'] - 200;
    $sqlquery="INSERT INTO payroll (Employee_ID,Payroll_Amount,Bonus) VALUES ('".$_POST['EmpID']."','".$net."','".$_POST['bonus']."')";
    $sqlquery2="UPDATE employees SET Salary='".$_POST['salary']."' WHERE ID='".$_POST['EmpID']."'";
    $res = mysqli_query($conn,$sqlquery);
    $res1 = mysqli_query($conn,$sqlquery2);
        
                  						if($res && $res1)
								{
									echo "<div class='alert alert-success animated fadeOut delay-1s'>
																		  <strong>Assigned Successfully</strong>
																		  </div>";
								}
					            else{
									 echo"<div class='alert alert-danger animated fadeOut delay-1s'>
                                            <strong>Error Assigning</strong>
                                            </div>";
								}
    }
      ?>


            <div id="TablesDiv">
                <h3>Edit Requests</h3>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>
                            Id
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Departement
                        </th>



                        <?php
		               
				        $sql = "SELECT * FROM requests where Request_type='Edit';";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) 
						{
                            echo "      <th>
                    Action
                    </th> </tr>";
						// output data of each row
						while($row = $result->fetch_assoc()) 
						{
				        $sql6="select DepartementID from employees where ID ='".$row["EmployeeID"]."';";
                        $res6=mysqli_query($conn,$sql6);
                        $row2= mysqli_fetch_row($res6);
                        $id=$row2[0];
							
							
							
							/*here we view the data of all requests that comes from the table employees as they are already in the database so they are only updated no need for a new record by sending the data in the form to the isset of approve-submit of edits*/
							
							$sql7="select Type from departements where DepartementID ='".$id."';";
							  $res7=mysqli_query($conn,$sql7);
                        $row3= mysqli_fetch_row($res7);
							$id1=$row3[0];
							
							
							
							
						echo "<tr><td>".$row["EmployeeID"]."</td>
							      <td>".$row["FirstName"]. "</td>
							      <td>".$id1. "</td>
							      <td>
						                <button id='view_emp' class='openmodal btn btn-info'>View</button>
                                        <button id='view_emp' class='openmodal btn btn-danger'>Reject</button>
						                <!-- The Modal -->
										<div id='myModal' class='modal'>

										  <!-- Modal content -->
										  <div id='MC' class='modal-content'>
										    <span class='close'>&times;</span>
                                            <h4 style='float:center;'>Employee Info</h4>
										  <form class='form-content' method='post' action=''>
                                          <div class='first-coloumn'>
                                           <input type='hidden' style='margin-left:45px;' name='ID' value='".$row["EmployeeID"]."' readonly>
                                           Firstname :<input type='text' style='all:unset;margin-left:5px;'name='firstname' value='".$row["FirstName"]."' readonly><br><br>
                                           Lastname :<input type='text' style='all:unset;margin-left:5px;' name='lastname' value='".$row["LastName"]."' readonly><br><br>
                                           Mobile :<input type='text' style='all:unset;margin-left:18px;' name='mobile' value='0".$row["Mobile"]."'readonly><br><br>
                                           NationalID: <input type='text' style='all:unset;'name='NationalID' value='".$row["NationalID"]."'readonly><br><br>
                                           </div>
                                           <div class='second-coloumn'>
                                           Password :<input type='text' style='all:unset;margin-left:5px;' name='password' value='".$row["Password"]."'readonly><br><br>
                                           Marital Status: <input type='text' name='marital-status' style='all:unset;margin-left:5px;' value='".$row['MaritalStatus']."' readonly><br><br>
                                           <input type='hidden' name='RequestID' value='".$row['RequestID']."'>
										   <input type='hidden' name='passport' value='".$row['PassportImage']."'>
                                           <input type='hidden' name='nationalimage' value='".$row['NationalIDImage']."'>
										   <input type='hidden' name='profileimage' value='".$row['ProfileImage']."'>
                                            
                        
                                           </div>
                                           <input style='float:right; position:absolute; margin-top: 40%;border-radius: 6px; margin-left: 29%;' type='submit' name='Approve-submit' value='Approve Edit'>
                                          </form>
                                          
                                          <form method='post' action='ShowImageshr.php'>
                                           <input type='submit' style='position:absolute; margin-top: 12%;border-radius: 6px;margin-left:-84px' name='showimage' value='Show Uploaded Images'>
                                           <input type='hidden' name='PassportImage' value='".$row['PassportImage']."'>
                                           <input type='hidden' name='NationalImage' value='".$row['NationalIDImage']."'>
                                           <input type='hidden' name='ProfileImage' value='".$row['ProfileImage']."'>
                                           </form>
                                          
										  </div>

										</div>
                                        
                                        
                                                                                				  <!-- Modal -->
								<div id='myModal1' class='modal' role='dialog'>
								  <div class='modal-dialog'>

									<!-- Modal content-->
									<div id='MC2' class='modal-content'>
									  <div class='modal-header'>
										<button type='button' class='close' data-dismiss='modal'>&times;</button>
										<h4 class='modal-title' style='position:absolute;'>Confirmation</h4>
									  </div>
									  <div class='modal-body'>
                  <form action='' method='post'>
                  Are you sure you want to reject this edit?
                  <input type='submit' name='Reject-submit' value='Reject'>
				  <input type='hidden' name='RequestID' value='".$row['RequestID']."'>
				  </form>
                  </div>
                  </div>
                  </div>
                  </div>
						                
						          </td>
							  </tr>";
                           
                            /*There is a form to send the images of each employee as a post to the page showimageshr.php to view the uploaded images*/
						}
							
							
//						echo "</table>";
						} else { echo "<tr><td colspan=4>No Edits found</td>";}

				?>
						
                </table>

            </div> <!-- end approve-table div -->




            <div id="Register">
                <h3>Register Requests</h3>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>
                            Request Id
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Departement
                        </th>



                        <?php
		               
				        $sql = "SELECT * FROM requests where Request_type='Register' AND JOB='EM';";
						$result = $conn->query($sql);

						if ($result->num_rows > 0)
						{
                            echo "      <th>
                    Action
                    </th></tr>";
						// output data of each row
						while($row = $result->fetch_assoc()) 
						{	
							/*here we view the data of all requests that comes from the sign up (request table) since they arent found in the employees table we insert the data as a new record in the table by sending the data from the form to the isset of approve1-submit button */
							
						echo "<tr><td>".$row["RequestID"]. "</td>
							      <td>".$row["FirstName"] . "</td>
							      <td>".$row["Departement"]. "</td>
							      <td>
						                <button type='button' id='view_emp' class='openmodal btn btn-info'>View</button>
                                        <button type='button' id='view_emp' class='openmodal btn btn-danger'>Reject</button>
						                <!-- The Modal -->
										<div id='myModal' class='modal'>

										  <!-- Modal content -->
										  <div id='MC'class='modal-content'>
										    <span class='close'>&times;</span>
                                            <h4 style='float:center;'>Employee Info</h4>
										  <form class='form-content' method='post' action=''>
                                          <div class='first-coloumn'>
                                           
                                           Firstname :<input type='text' style='all:unset;margin-left:5px;'name='firstname' value='".$row["FirstName"]."' readonly><br><br>
                                           Lastname :<input type='text' style='all:unset;margin-left:5px;' name='lastname' value='".$row["LastName"]."' readonly><br><br>
                                           Gender :<input type='text'style='all:unset;margin-left:15px;' name='gender' value='".$row['Gender']."'readonly><br><br>
                                           Job:<input type='text' style='all:unset;margin-left:40px;' name='job' value='".$row['JOB']."'readonly><br><br>
                                           Department:<input type='text'style='all:unset;margin-left:8px;' name='dep' value='".$row['Departement']."'readonly><br><br>
										   <input type='hidden' style='margin-left:45px;' name='RequestID' value='".$row["RequestID"]."' readonly><br><br>
                                           </div>
                                           <div class='second-coloumn'>
                                           Username :<input style='all:unset;margin-left:15px;' name='username' value='".$row['Username']."'readonly></label><br><br>
                                           Password :<input type='text' style='all:unset;margin-left:5px;' name='password' value='".$row["Password"]."'readonly><br><br>
                                           <input type='hidden' name='RequestID' value='".$row['RequestID']."'>
                                           
                                           
                                            
                        
                                           </div>
                                           <input style='float:right; position:absolute; margin-top: 40%;border-radius: 6px; margin-left: 29%;' type='submit' name='Approve1-submit' value='Approve Register'>
                                          </form>
										  </div>

										</div>
                                        
                                        				  <!-- Modal -->
								<div id='myModal1' class='modal' role='dialog'>
								  <div class='modal-dialog'>

									<!-- Modal content-->
									<div id='MC-reject' class='modal-content'>
									  <div class='modal-header'>
										<button type='button' class='close' data-dismiss='modal'>&times;</button>
										<h4 class='modal-title' style='position:absolute;'>Confirmation</h4>
									  </div>
									  <div class='modal-body'>
                  <form action='' method='post'>
                  Are you sure you want to reject this account?
                  <input type='submit' name='Reject-submit' value='Reject'>
				  <input type='hidden' name='RequestID' value='".$row['RequestID']."'>
				  </form>
                  </div>
                  </div>
                  </div>
                  </div>
						                
						          </td>
							  </tr>";
                            $GLOBALS['RequestID']=$row['RequestID'];
                            
						}
//						echo "</table>";
						} else { echo "<tr><td colspan=4>No Edits found</td>";}

				?>
                </table>


            </div>

            <div id="payroll">
                <h3>Employees Payroll</h3>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>
                            Employee ID
                        </th>
                        <th>
                            Employee Name
                        </th>
                        <th>
                            Department
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                    <?php 
                    $query = "SELECT * from employees where JOB='EM';";
					$res = $conn->query($query);
					
                    while($arr = $res->fetch_assoc())
                    {
						 $sql6="select DepartementID from employees where ID ='".$arr["ID"]."';";
                        $res6=mysqli_query($conn,$sql6);
                        $row2= mysqli_fetch_row($res6);
                        $id=$row2[0];
							
						/*here we view all employees with flag EM to update the salary and bonus of the employee by sending the data in the form to the isset of assign*/
							
							
							
							
							$sql7="select Type from departements where DepartementID ='".$id."';";
							  $res7=mysqli_query($conn,$sql7);
                        $row3= mysqli_fetch_row($res7);
							$id1=$row3[0];
							
						
						
                        echo "<tr><td>".$arr["ID"]."</td>
                        <td>".$arr["FirstName"]."</td>
                        <td>".$id1."</td>
                        <td><button type='button' id='add_payroll' class='openmodal btn btn-success'>Assign Payment</button>
                        <div class='modal'>
                        
                        <div id='MC-Payroll' class='modal-content' id='payrollmodal'>
                        <span class='close'>&times;</span>
                        
                        <h4 style='float:center;'>Assign Payment</h4>
                        <form class='form-content' method='post' action=''>
                        
                        <div class='first-coloumn'>
                        Employee ID :<input type='text' style='all:unset;margin-left:5px;' name='EmpID' value='".$arr["ID"]."' readonly><br><br>
                        Firstname :<input type='text' style='all:unset;margin-left:5px;'name='firstname' value='".$arr["FirstName"]."' readonly><br><br>
                        Salary :<input type='number' style='margin-left:5px;' name='salary' value='".$arr["Salary"]."'><br><br>
                        Bonus :<input type='number' style='margin-left:5px;' name='bonus'><br><br>
                        </div>
                        
                        <input style='float:right; position:relative; margin-top: 31%;border-radius: 6px;margin-right: 5%;' type='submit' name='Assign' value='Assign'>
                        
                        </form>
                        </div>
                        </div>
                        
                        </td>
                        </tr>
                        ";   
                    }
                    
                    
                    ?>




                </table>

            </div>




        </div> <!-- end middle div -->

    </div> <!-- end of parent div -->





    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
      <script src="js/openmodal.js"></script>     
	<script src="js/refresh.js"></script>

</body>

</html>
