<html>

<head>
    <title>HR Letter</title>
    <link rel="stylesheet" id="theme" href="css/HRLetter.css">
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet"  href="css/bootstrap.min.css">

<!--	function to switch between the three tables the pending,approved and denied letters-->
    <script>
        function myFunction(y) {
            var idarr = ["TablesDiv", "DeniedDiv", "ApprovedDiv"];
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






    <div class="ParentDiv">
     
        <?php
include_once ("dbconnection.php");
		include_once"Exception_file.php";

session_start();
                       /* execptions thrown if the session is different from hr the hr is trying to access an employee or admin page*/
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
            <div id="pending" onclick="myFunction('TablesDiv')">
                <span>
                    Pending Letters
                </span>
            </div>
            <div id="denied" onclick="myFunction('DeniedDiv')">
                <span>
                    Denied Letters
                </span>
            </div>
            <div id="approved" onclick="myFunction('ApprovedDiv')">
                <span>
                    Approved Letters
                </span>
            </div>
        </div>

<!--		table of pending letters-->
        <div class="MiddleDiv">
            <div id="TablesDiv">
                <h3>Pending Letters</h3>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>
                            Letter Requested by
                        </th>
                        <th>
                            Letter Directed to
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>

                    <?php 
		                
//					isset on reject button inside modal to change letter from pending to denied
					if(isset($_POST['Reject'])){
								$sql55="UPDATE letters
						 SET Status='DENIED'
						 WHERE LETTER_ID='".$_POST['letterid1']."' ;";
						 $res1 = mysqli_query($conn,$sql55);
								if($res1)
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
//					validations on letter content getting from create letter page
					else if (isset($_POST['submit-letter']))
					{if(preg_match('/[\'\/~`\!#\$%\^\*\(\)\\+=\{\}\[\]\|;"\<\>\\?\\\]/', $_POST['lettercontent'])){
       
      echo "<script> alert('please write letter content without any special characters excluding: : & @ , .')</script>";
   }
                        else{
						$sql55="UPDATE letters
						 SET LetterContent='".$_POST['lettercontent']."',Status='APPROVED'
						 WHERE LETTER_ID='".$_POST['letterid']."' ;";
						 $res1 = mysqli_query($conn,$sql55);
								if($res1)
								{
									echo "<div class='alert alert-success animated fadeOut delay-1s'>
																		  <strong>Submitted Successfully</strong>
																		  </div>";
								}
					            else{
									 echo"<div class='alert alert-danger animated fadeOut delay-1s'>
                                            <strong>Error submitting</strong>
                                            </div>";
								}
					}
                    }
					
					
                //getting pending letters from letters table setting letters according to their sender
                $sql = "SELECT employees.*,letters.* FROM letters join employees on letters.SENDER_ID=employees.ID WHERE letters.Status = 'PENDING' Order by FIELD(Priority,'Urgent','High','Medium','Low')";
                
                $res = mysqli_query($conn,$sql);
                
                    while ($row = $res->fetch_assoc()) {
        $Firstname = $row["FirstName"];
        $Directed = $row["DirectedTo"];
 
        echo "<tr> 
                  <td>".$Firstname."</td> 
                  <td>".$Directed."</td> 
                  <td> 
                  <button type='button' class='btn btn-info openModal' id='Approve_Letter'> View </button>
                  <button type='button' class='btn btn-danger openModal' id='Deny_Letter'> Reject </button>

				  
				  <!-- Modal showing the content of the pending letter requested by an employee and preserving the other data of employee -->
								<div id='myModal' class='modal' role='dialog'>
								  <div class='modal-dialog'>

									<!-- Modal content-->
									<div id='MC' class='modal-content'>
									  <div class='modal-header'>
										<button type='button' class='close' data-dismiss='modal'>&times;</button>
										<h4 class='modal-title' style='position:absolute;'>Edit Letter</h4>
									  </div>
									  <div class='modal-body'>
										<form action='createLetter.php' method='post'>
										
					 				<select name='Select_Priority' id='Select2'>
					 				<option value='Selected'>Selected Priority : ".$row['Priority']."</option>
                     					</select> <br><br>
										
									<select name='Select_Directed_to' id='Select'>
									<option value='Selected'>Selected Direction : ".$row['DirectedTo']."</option>
                   					</select> 
									<br><br>
									
									
									
									<input type='checkbox' id='check-style' name='check_list[]' value='Mobile' onclick='return false;' ".(($row['MobileFlag'] == 'true')?'checked':' ')." > Mobile Number
									<br>
									<input type='checkbox' id='check-style' name='check_list[]' value='Passport'  onclick='return false;' ".(($row['PassportFlag'] == 'true')?'checked':' ')."> Passport Image<br>
          							<input type='checkbox' id='check-style' name='check_list[]' value='Martial' onclick='return false;' ".(($row['MartialFlag'] == 'true')?'checked':' ')."> Martial Status<br>
          							<input type='checkbox' id='check-style' name='check_list[]' value='Hire' onclick='return false;' ".(($row['HireFlag'] == 'true')?'checked':' ')."> Hire Date<br>
									<input type='checkbox' id='check-style' name='check_list[]' value='Salary' onclick='return false;' ".(($row['SalaryFlag'] == 'true')?'checked':' ')."> Salary<br><br>
									 Comment:<br><textarea style='all:unset;white-space:prewrap;text-align:left;border-width:1px;border-style:solid;border-color:black;' name='comment' rows='3' cols='50'readonly>".$row["COMMENTS"]."</textarea><br><br>
									 Admin Comment: <textarea style='all:unset;white-space:pre-wrap;text-align:left;border-width:1px;border-style:solid;border-color:black;' name='admincomm' rows='3' cols='50'readonly>".$row["AdminComment"]."</textarea><br><br>
									    
										
										<input type='hidden' name='letterid' value='".$row['LETTER_ID']."'>
										<input type='hidden' name='job' value='".$row['JOB']."'>
										<input type='hidden' name='firstname' value='".$row['FirstName']."'>
										<input type='hidden' name='lastname' value='".$row['LastName']."'>
										<input type='hidden' name='nationalid' value='".$row['NationalID']."'>
										<input type='hidden' name='mobile' value='".$row['Mobile']."'>
										<input type='hidden' name='marital' value='".$row['MaritalStatus']."'>
										<input type='hidden' name='salary' value='".$row['Salary']."'>
										<input type='hidden' name='hiredate' value='".$row['HireDate']."'>
										<input type='hidden' name='passportimage' value='".$row['PassportImage']."'>
										<input type='hidden' name='directedto' value='".$row['DirectedTo']."'>
										
										
								
										
										
									  </div>
									  <div class='modal-footer'>
										<input type='submit' style='border-radius: 6px;' name='Create' value='Create Letter'>
										</form>
										
									  </div>
									</div>
                                  
								  </div>
								</div>  
								<!--End Modal -->
                                
                                
                                                  
                  
				  <!-- Modal -->
								<div id='myModal1' class='modal' role='dialog'>
								  <div class='modal-dialog'>

									<!-- Modal of confirmation on reject button-->
									<div id='MC2' class='modal-content'>
									  <div class='modal-header'>
										<button type='button' class='close' data-dismiss='modal'>&times;</button>
										<h4 class='modal-title' style='position:absolute;'>Confirmation</h4>
									  </div>
									  <div class='modal-body'>
                  <form action='' method='post'>
                  Are you sure you want to reject this letter?
                  <input type='submit' name='Reject' value='Reject'>
				  <input type='hidden' name='letterid1' value='".$row['LETTER_ID']."'>
				  </form>
                  </div>
                  </div>
                  </div>
                  </div>
				  
				  
				  
                  
                  </td> 
              </tr>";
    }
                
                ?>
                    <!-- <tr>
                    <td>
                    test
                    </td>
                    <td>
                    test
                    </td>
                    <td>
                        <button id="Approve_Letter">Approve letter</button>
                        <button id="Deny_Letter">Deny letter</button>
                    </td>
                    <td>
                    <a href="">Letter</a>
                    </td>
                </tr> -->


                </table>


            </div>
            <div id="DeniedDiv">
<!--             denied letters tables-->
                <h3>Denied Letters</h3>
                <table class="table table-bordered table-hover">


                    <tr>
                        <th>
                            Letter Requested by
                        </th>
                        <th>
                            Letter Directed to
                        </th>
                        <th>
                            Status
                        </th>
                        <!--    <th>
                            Letter Content
                        </th> -->
                    </tr>
                    <?php
//                        showing the letters with status denied
                    $asdh = $_SESSION['ID'];
                    $sql = "SELECT employees.*,letters.* FROM letters join employees on letters.SENDER_ID=employees.ID WHERE 	 letters.Status = 'DENIED' ";    
                    $result = mysqli_query($conn,$sql);
                    while ($row = $result->fetch_assoc()) {
        $LetterReq = $row["FirstName"];
        $Direct = $row["DirectedTo"];
        $status = $row["Status"];
        echo '<tr> 
                  <td>'.$LetterReq.'</td> 
                  <td>'.$Direct.'</td> 
                  <td>'.$status.'</td> 
              </tr>';
                    }
                
                    
                    
                    
                  
                ?>
                </table>
            </div>
            
            
            
            <div id="ApprovedDiv">
<!--               table for approved letter-->
                <h3>Approved Letters</h3>
                <table class="table table-bordered table-hover">


                    <tr>
                        <th>
                            Letter Requested by
                        </th>
                        <th>
                            Letter Directed to
                        </th>
                        <th>
                            Status
                        </th>
                        <!--    <th>
                            Letter Content
                        </th> -->
                    </tr>
                    <?php
//                       getting each approved letter
                    $asdh = $_SESSION['ID'];
                    $sql = "SELECT employees.*,letters.* FROM letters join employees on letters.SENDER_ID=employees.ID WHERE letters.Status = 'APPROVED' ";    
                    $result = mysqli_query($conn,$sql);
                    while ($row = $result->fetch_assoc()) {
        $LetterReq = $row["FirstName"];
        $Direct = $row["DirectedTo"];
        $status = $row["Status"];
        echo '<tr> 
                  <td>'.$LetterReq.'</td> 
                  <td>'.$Direct.'</td> 
                  <td>'.$status.'</td> 
              </tr>';
                    }
                
                    
                    
                    
                  
                ?>


                </table>
            </div>
<!--
            <div class="buttons">
                <button type="button" class="btn btn-primary" id="New_Letter">Create Letter Form</button>
            </div>
-->
        </div>
    </div>


	
	 

  <script src="js/openmodal.js"></script>     
	<script src="js/refresh.js"></script>	
	
</body>

</html>
