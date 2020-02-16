<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Hr System</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" id="theme" href="css/employeesadmin.css">
	<link rel="stylesheet" href="css/animate.css">




	<script>
		
		/*This function toggles between different tiles and tables when they're clicked*/
		
		
		function myFunction(y) {
			var idarr = ["Register", "AllEmps", "TablesDiv"]

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
		session_start();
      include_once ("dbconnection.php");
include_once"Exception_file.php";

		/*These are the exception handling lines where it checks on several scenarios, It also has the file includes that are necessary*/
		
	try{
	if(!$conn){
		 throw new customExceptionFailedConnection();
	}	
    if($_SESSION['job']==null){
	throw new customExceptionLogin();	
	}
    if($_SESSION['job']!="ADMIN"){
        
        throw new customExceptionLoginADMIN();
    }
		
    }catch(customExceptionLogin|customExceptionLoginADMIN|customExceptionFailedConnection $e){
		
		echo $e->reroute($_SESSION['ID']);
		
	}		
      include "Header.php";
        
    ?>


		<div class="LeftDiv">
			<div>
				<div id="register-requests-tile" onclick="myFunction('Register')"><span>Register Requests</span></div>
			</div>


			<div>
				<div id="all-emps-tile" onclick="myFunction('AllEmps')"><span>All Employees</span></div>
			</div>

			<div>
				<div id="payroll-tile" onclick="myFunction('TablesDiv')"><span>Payroll</span></div>
			</div>



		</div> <!-- end of left div -->


		<div class="MiddleDiv">

			<?php


/*These lines execute SQL queries to approve register requests from applying HRs. It first searches for the department ID by comparing the selected type since table requests doesn't have the ID of the department it only has the type, Then it inserts the HR into the employee table and inserts also the department ID.*/


      if (isset($_POST['Approve1-submit']))
      {
          $sql6="select DepartementID from departements where Type='".$_POST['dep']."';";
          $res6=mysqli_query($conn,$sql6);
          $row= mysqli_fetch_row($res6);
          $id=$row[0];
           $sql2="INSERT INTO employees (FirstName,LastName,Password,Gender,Username,JOB,DepartementID)
        VALUES('".$_POST['firstname']."','".$_POST['lastname']."','".$_POST['password']."','".$_POST['gender']."','".$_POST['username']."','".$_POST['job']."',".$id.");";
              $res = mysqli_query($conn,$sql2);

           

          						if($res)
								{
									$sql3="delete from requests where RequestID=".$_POST['RequestID'];
									$res=mysqli_query($conn,$sql3);
									echo "<div class='alert alert-success animated fadeOut delay-1s'>
																		  <strong>Added Successfully</strong>
																		  </div>";
								}
					            else{
									 echo"<div class='alert alert-danger animated fadeOut delay-1s'>
                                            <strong>Error Adding</strong>
                                            </div>";
								}
      }
			
			/*Deletes the selected request from the request table thus removing the register request from the database.*/
			
      else if (isset($_POST['Reject-submit']))
      {
          $sql3="delete from requests where RequestID=".$_POST['RequestID'];
          $res=mysqli_query($conn,$sql3);
          								if($res)
								{
									echo "<div class='alert alert-success animated fadeOut delay-1s'>
																		  <strong>Reject Success</strong>
																		  </div>";
								}
					            else{
									 echo"<div class='alert alert-danger animated fadeOut delay-1s'>
                                            <strong>Error Rejecting</strong>
                                            </div>";
								}
      }
			/*Assigns the inserted salary and bonus into the payroll table to be shown later in the mainpage in the payroll-history section. Additionally it updates the selected employee's salary.*/
    else if(isset($_POST['Assign']))
    {if($_POST['bonus']==null ){
        $_POST['bonus']=0;
    }
	 if($_POST['salary']==NULL)
	 {
		 $_POST['salary']=0;
	 }
	 $net=0;
    $net = $_POST['salary'] + $_POST['bonus'] - 200;
    $sqlquery="INSERT INTO payroll (Employee_ID,Payroll_Amount,Bonus) VALUES ('".$_POST['EmpID']."','".$net."','".$_POST['bonus']."')";
    $sqlquery2="UPDATE employees SET Salary='".$_POST['salary']."' WHERE ID='".$_POST['EmpID']."'";
    $res = mysqli_query($conn,$sqlquery);
    $res2 = mysqli_query($conn,$sqlquery2);

        								if($res && $res2)
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
			/*Deletes the selected account from the employees table. But before that it searches for requests in the request table whether he has an edit request or not, then subsequently deletes every entry in the database that has the employee's ID.*/
			
    else if(isset($_POST['DeleteAcc']))
    {



        $sql="select * from requests where EmployeeID=".$_POST['empID'].";";
        $query = "DELETE FROM employees WHERE ID=".$_POST['empID'].";";
		$res1=mysqli_query($conn,$sql);
		$rowcount1=mysqli_num_rows($res1);
		
		if ($rowcount1==0)
		{
			$res = mysqli_query($conn,$query);

		if($res)
		{
		echo "<div class='alert alert-success animated fadeOut delay-1s'>
			<strong>Deleted Successfully</strong> </div>";
		}
		else{
		echo"<div class='alert alert-danger animated fadeOut delay-1s'>
			<strong>Error Deleting</strong>
		</div>";
		}
		
		}
		else{
			
			$sql2="delete from requests where EmployeeID=".$_POST['empID'].";";
		$res2=mysqli_query($conn,$sql2);
		$res = mysqli_query($conn,$query);

		if($res)
		{
		echo "<div class='alert alert-success animated fadeOut delay-1s'>
			<strong>Deleted Successfully</strong> </div>";
		}
		else{
		echo"<div class='alert alert-danger animated fadeOut delay-1s'>
			<strong>Error Deleting</strong>
		</div>";
		}
		
		}
    }
      ?>

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



						<?php
						
						/*Displays all the registered HR personnel and their submitted data in a modal*/

				        $sql = "SELECT * FROM requests where Request_type='Register' AND JOB='HR';";
						$result = $conn->query($sql);

						if ($result->num_rows > 0)
						{
                            echo "      <th>
                    Action
                    </th></tr>";
						// output data of each row
						while($row = $result->fetch_assoc())
						{
						echo "<tr><td>".$row["RequestID"]. "</td>
							      <td>".$row["FirstName"] . "</td>
							      <td>
						                <button type='button' id='view_emp' class='openmodal btn btn-warning'>View</button>
						                <!-- The Modal -->
										<div id='myModal' class='modal'>

										  <!-- Modal content -->
										  <div id='MC' class='modal-content' >
										    <span id='Close' style='position:absolute;margin-left: 96%;margin-top: 1%;' class='close'>&times;</span>
                                            <h4 style='float:center;'>Employee Info</h4>
										  <form class='form-content' method='post' action=''>
                                          <div class='first-coloumn'>
                                           
                                           Firstname :<input type='text' style='all:unset;margin-left:5px;'name='firstname' value='".$row["FirstName"]."' readonly><br><br>
                                           Lastname :<input type='text' style='all:unset;margin-left:5px;' name='lastname' value='".$row["LastName"]."' readonly><br><br>
                                           Gender :<input style='all:unset;margin-left:15px;' name='gender' value='".$row['Gender']."'readonly><br><br>
                                           Job:<input style='all:unset;margin-left:40px;' name='job' value='".$row['JOB']."'readonly><br><br>
                                           Department:<input style='all:unset;margin-left:15px;' name='dep' value='".$row['Departement']."'readonly><br><br>
										   <input type='hidden' style='margin-left:45px;' name='RequestID' value='".$row["RequestID"]."'><br><br>
                                           </div>
                                           <div class='second-coloumn'>
                                           Username :<input style='all:unset;margin-left:15px;' name='username' value='".$row['Username']."'readonly></label><br><br>
                                           Password :<input type='text' style='all:unset;margin-left:5px;' name='password' value='".$row["Password"]."'readonly><br><br>
                                           <input type='hidden' name='RequestID' value='".$row['RequestID']."'>




                                           </div>
                                           <input style='float:right; position:absolute;margin-left: 13%;margin-top:45%;' type='submit' name='Approve1-submit' value='Approve Register'>
                                           <input style='float:right; position:absolute;margin-left:30%;margin-top:45%;' type='submit' name='Reject-submit' value='Reject Register'>
                                          </form>
										  </div>

										</div>

						          </td>
							  </tr>";
                            $GLOBALS['RequestID']=$row['RequestID'];

						}
						} else { echo "<tr><td colspan=4>No registers found</td>";}

				?>
				</table>


			</div>

			<div id="AllEmps">
				<h3>All Employees</h3>
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
					
					/*Displays all the employees that exist in the employees table and presents an option to delete the desired employee*/
					
                    $query = "SELECT * from employees where JOB <> 'ADMIN';";
					$res = $conn->query($query);

                    while($arr = $res->fetch_assoc())
                    {
						 $sql6="select DepartementID from employees where ID ='".$arr["ID"]."';";
                        $res6=mysqli_query($conn,$sql6);
                        $row2= mysqli_fetch_row($res6);
                        $id=$row2[0];





							$sql7="select Type from departements where DepartementID ='".$id."';";
							  $res7=mysqli_query($conn,$sql7);
                        $row3= mysqli_fetch_row($res7);
							$id1=$row3[0];



                        echo "<tr>
                        <td>".$arr["ID"]."</td>
                        <td>".$arr["FirstName"]."</td>
                        <td>".$id1."</td>
						      <td>
						                <button type='button' class='openmodal btn btn-danger'>Delete Account</button>

										<div id='myModal2' class='modal'>

								        <div id='MC2' class='modal-content'>

								        <span id='Close' style='position:absolute;margin-left: 95%;' class='close'>&times;</span>
                                        <h4 style='float:center;'>Confimation</h4>
                                        <form method='post' action=''>
                                        <p id='dialog'>Are you sure you want to delete this employee?</p><br>
                                        <input type='hidden' name='empID' value='".$arr['ID']."'>
                                        <input style='float:right; position:absolute; margin-top: -10px;margin-left: -55px;' type='submit' name='DeleteAcc' value='Delete Account'>
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

			<div id="TablesDiv">
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
					
					/*Displays all the HR personnel to assign salary and bonus to them.*/
					
                    $query = "SELECT * from employees where JOB='HR';";
					$res = $conn->query($query);

                    while($arr = $res->fetch_assoc())
                    {
						 $sql6="select DepartementID from employees where ID ='".$arr["ID"]."';";
                        $res6=mysqli_query($conn,$sql6);
                        $row2= mysqli_fetch_row($res6);
                        $id=$row2[0];





							$sql7="select Type from departements where DepartementID ='".$id."';";
							  $res7=mysqli_query($conn,$sql7);
                        $row3= mysqli_fetch_row($res7);
							$id1=$row3[0];



                        echo "<tr><td>".$arr["ID"]."</td>
                        <td>".$arr["FirstName"]."</td>
                        <td>".$id1."</td>
                        <td><button type='button' id='add_payroll' class='openmodal btn btn-success'>Assign Payment</button>
                        <div id='myModal3' class='modal'>

                        <div id='MC3' class='modal-content' >
                        <span id='Close' style='position:absolute;margin-left: 94%;margin-top: 1%;' class='close'>&times;</span>

                        <h4 style='float:center;'>Assign Payment</h4>
                        <form class='form-content' method='post' action=''>

                        <div class='first-coloumn'>
                        Employee ID :<input type='text' style='all:unset;margin-left:5px;' name='EmpID' value='".$arr["ID"]."' readonly><br><br>
                        Firstname :<input type='text' style='all:unset;margin-left:5px;'name='firstname' value='".$arr["FirstName"]."' readonly><br><br>
                        Salary :<input type='number' style='margin-left:5px;' name='salary' value='".$arr["Salary"]."'><br><br>
                        Bonus :<input type='number' style='margin-left:5px;' name='bonus'><br><br>
                        </div>

                        <input style='margin-left: 74%; margin-top: 42%;' type='submit' name='Assign' value='Assign'>

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

	<script src="js/openmodal.js"></script>
	<script src="js/refresh.js"></script>

</body>

</html>
