<!doctype html>
<html lang="en">

<head>
	<?php
	// this is validation to make sure that whoever try to access the page must be logged in andd that the connection is active
    include_once"Exception_file.php";
    include_once "dbconnection.php";
     session_start();
        try{
    if($_SESSION['job']==null){
	throw new customExceptionLogin();	
	}
	if(!$conn){
	throw new customExceptionFailedConnection();	
	}		
    }catch(customExceptionLogin|customExceptionFailedConnection $e){
		
		echo $e->reroute($_SESSION['ID']);
		
	}
    ?>


	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!--    <meta name="viewport" content="width=device-width, initial-scale=1">-->
	<title>Hr System</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" id="theme" href="css/MainPage.css">
	<!-- <link href='https://fonts.googleapis.com/css?family=Oxygen:400,300,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lora' rel='stylesheet' type='text/css'> -->

	<!--function that switch between sections and the mainpage-->
	<script type="text/javascript">
		function showsec(y) {
			idarr = ["Profile-section", "Payroll-section", "PayrollHistory-section"]

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

	<!--
onclick="document.write('<//?php session_unset();
                                                session_destroy();
                                                header("Location:login.php")?>'
-->


	<div class="parentdiv">
		<?php
      include_once "Header.php";
	
?>

		<script>
			/*this to identify the type of employees that access the page to load the proper pages */
			$(document).ready(function() {
				$("#HRLetter").click(function() {
					/*this is used to allow each employee to access their assigned pages by searching the entire page for a line that has the id "HR" then changes its href attribute*/
					if ("<?php echo("{$_SESSION['job']}"); ?>" == "EM") {
						$('[id="hr"]').attr('href', 'LetterEM.php');
					} else if ("<?php echo("{$_SESSION['job']}"); ?>" == "ADMIN") {
						$('[id="hr"]').attr('href', 'LetterADMIN.php');
					}
				});
				$("#EmployeeFile").click(function() {
					if ("<?php echo("{$_SESSION['job']}"); ?>" == "EM") {
						$('[id="empfile"]').attr('href', 'employees.php');
					} else if ("<?php echo("{$_SESSION['job']}"); ?>" == "ADMIN") {
						$('[id="empfile"]').attr('href', 'employeesadmin.php');
					}
				});
				$("#HelpPage").click(function() {
					if ("<?php echo ("{$_SESSION['job']}"); ?>" == "HR") {
						$('[id="help"]').attr('href', 'helphr.php');
					}
				});
			});

		</script>

		<div class="LeftDiv">
			<div id="EmployeeFile">
				<a id="empfile" href="employeeshr.php">
					<div id="employees-files-tile"><span>Employee Files</span></div>
				</a>
			</div>

			<div id="HRLetter">
				<a id="hr" href="HRLetter.php">
					<div id="hr-letters-tile"><span>Hr Letters</span></div>
				</a>
			</div>

			<div id="HelpPage">
				<a id="help" href="help.php">
					<div id="help-page-tile"><span>Help Page</span></div>
				</a>
			</div>

		</div>


		<div class="MiddleDiv">
			'
			<div class="TopNavi">
				<div id="profile-glyph">
					<span class="glyphicon glyphicon-user"></span><input type="button" id="profile" class="button" value="Profile" onclick="showsec('Profile-section')">
				</div>

				<div id="payroll-glyph">
					<span class="glyphicon glyphicon-euro"></span><input type="button" id="payroll" class="button" value="Payroll" onclick="showsec('Payroll-section')">
				</div>

				<div id="payroll-history-glyph">
					<span class="glyphicon glyphicon-usd"></span><input type="button" id="payroll-history" class="button" value="Payroll History" onclick="showsec('PayrollHistory-section')">
				</div>





			</div>





			<div class="Sections" id="Profile-section">
				<section id="firstsec">
					<form>
						<!--this gets from sessions variables that has been set in login and display it in this section-->
						<label id="firstname">First name:<?php echo " ".$_SESSION["name"] ?> </label> <br>
						<label id="lastname">Last name:<?php echo  " ".$_SESSION["lastname"] ?></label><br>
						<label id="Mob">Mobile Number:<?php echo  " 0".$_SESSION["mobile"] ?></label><br>
						<label id="Marital">Marital Status:<?php echo  " ".$_SESSION["marStat"] ?></label><br>
						<label id="NationalID">National ID Number:<?php echo  " ".$_SESSION["natID"] ?></label><br>
					</form>
				</section>

				<section id="secondsec">
					<form>
						<label>Job title:<?php echo " ".$_SESSION["job"] ?> </label> <br>
						<label>Department:<?php
                            $sql="select Type from departements where DepartementID='".$_SESSION["depid"]."' ";
                            $result=mysqli_query($conn,$sql);
                            $row= mysqli_fetch_row($result);
                            echo " ".$row[0];
                            ?></label><br>
						<label>Hiring Date:<?php echo  " ".$_SESSION["hired"] ?></label><br>
					</form>
				</section>
			</div>




			<div class="Sections" id="Payroll-section">
				<section id="payrollsec">
					<form>
						<!--this is used to show the latest payroll and if not set it will be assigned to zero-->
						<label>Current Salary:<?php echo " ".$_SESSION["salary"]; ?></label><br>
						<label>Taxes: <?php 
                        $query = "SELECT Taxes FROM payroll WHERE Employee_ID ='".$_SESSION['ID']."'";
                        $res=mysqli_query($conn,$query);
                        $i = 0;
                        $Taxes = 0;
                        $rowcount = mysqli_num_rows($res);
                        while($row= mysqli_fetch_assoc($res))
                        {
                            if($i == $rowcount - 1)
                            {
                                $Taxes = $row['Taxes'];
                            }
                            else $i = $i + 1;
                        }
                        
                        echo " ".$Taxes;
                        ?> </label><br>
						<label>Bonus: <?php 
                        $query = "SELECT Bonus FROM payroll WHERE Employee_ID ='".$_SESSION['ID']."'";
                        $res=mysqli_query($conn,$query);
                        $i = 0;
                        $Bonus = 0;
                        $rowcount = mysqli_num_rows($res);
                            while($row= mysqli_fetch_assoc($res))
                            {
                                if($i == $rowcount - 1)
                                {
                                    $Bonus = $row['Bonus'];
                                }
                                else $i = $i + 1;
                            }
                        echo " ".$Bonus;
                            ?></label><br>
						<label>Net Salary: <?php 
                        $query = "SELECT Payroll_Amount FROM payroll WHERE Employee_ID ='".$_SESSION['ID']."'";
                        $res=mysqli_query($conn,$query);
					    $i = 0;
                        $Salary = 0;      
                        $rowcount = mysqli_num_rows($res);
                        while ($row= mysqli_fetch_assoc($res))
                        {
                            if($i == $rowcount - 1)
                            {
                                $Salary = $row['Payroll_Amount'];
                            }
                            else $i = $i + 1;
                        }
                                echo " ".$Salary;
                                ?></label><br>


					</form>
				</section>
			</div>

<!--this is to access the all the records of payements--> 
			<div class="Sections" id="PayrollHistory-section">
				<div id="payrollHistory">
					<table style='width:99%;margin-top:10px;' class="table table-bordered table-hover">
						<tr>
							<th>
								Payroll Amount
							</th>
							<th>
								Date Recieved
							</th>
						</tr>

						<?php
    $query = "SELECT Payroll_Amount,Date_Sent FROM payroll WHERE '".$_SESSION['ID']."' = Employee_ID;";
                            $res=mysqli_query($conn,$query);
                            if($res->num_rows > 0){
                            while($arr = $res->fetch_assoc())
                            {
                                echo "<tr><td>'".$arr['Payroll_Amount']."'</td>
                                <td> Date Recieved:'".$arr['Date_Sent']."'</td></tr>";
                            }
                            }
                            else echo "<tr><td colspan=2>No payments recieved</td></tr>";
                    ?>



					</table>

				</div>



			</div>










		</div>







		<!-- jQuery (Bootstrap JS plugins depend on it) -->
		<script src="js/jquery-2.1.4.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/refresh.js"></script>
	</div>
</body>

</html>
