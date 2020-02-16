<html>

<head>
    <title>HR zeft Letter 3la dma3'ko</title>
    <link rel="stylesheet" id="theme" href="css/LetterADMIN.css">
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet"  href="css/bootstrap.min.css">
	<link rel="stylesheet"  href="css/animate.css">

    <script>
		/*This function toggles between different tiles and tables when they're clicked*/
		
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
        <!--    <div class="HeadDiv">
        <h1>HR Letter</h1>
        </div> -->
     	<?php				
	include_once ("dbconnection.php");
		include_once"Exception_file.php";
		
		/*These are the exception handling lines where it checks on several scenarios, It also has the file includes that are necessary*/

	session_start(); 
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

					/*Filters the text area from special characters to avoid SQL Injections*/

                    if(isset($_POST['Submit_Comment']))
                    {if(preg_match('/[\'\/~`\!#\$%\^\*\(\)\-\+=\{\}\[\]\|;"\<\>\\?\\\]/', $_POST['admincomm'])){
       
      echo "<script> alert('please write a comment without any special characters excluding: : & @ , .')</script>";
   }
                        
					 /*Sets an admin comment into the letters table to be read by the HR later on.*/
					 
                        else{
                        $sql = "UPDATE letters SET AdminComment='".$_POST['admincomm']."' WHERE LETTER_ID = ".$_POST['letterid'].";";
                        $res = mysqli_query($conn,$sql);
                        if($res)
                        {
                          echo "<div class='alert alert-success animated fadeOut delay-1s'>
																		  <strong>Submit Sucess</strong>
																		  </div>";
                        }
                    }

                    }
					
					/*Displays all the pending letters submitted by the employees and where they are directed to along with the content that the employee chose to send.*/

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


				  <!-- Modal -->
								<div id='myModal' class='modal' role='dialog'>
								  <div class='modal-dialog'>

									<!-- Modal content-->
									<div id='MC' class='modal-content'>
									  <div class='modal-header'>
										<button type='button' id= 'close' class='close' data-dismiss='modal'>&times;</button>
										<h4 class='modal-title' style='position:absolute;'>View Letter</h4>
									  </div>
									  <div class='modal-body'>
										<form action='' method='post'>

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
									 Comment:<br> <textarea style='all:unset;white-space:pre-wrap;text-align:left;border-width:1px;border-style:solid;border-color:black;' name='comment' rows='3' cols='50'readonly>".$row["COMMENTS"]."</textarea><br><br>

                                     <input type='hidden' name='letterid' value='".$row['LETTER_ID']."'>


									 Admin Comment: <textarea style='all:unset;white-space:pre-wrap;text-align:left;border-width:1px;border-style:solid;border-color:black;' name='admincomm' rows='3' cols='50'>".$row["AdminComment"]."</textarea><br><br>

									  </div>
									  <div class='modal-footer'>
										<input type='submit' name='Submit_Comment' value='Submit Comment'></input>
										</form>

									  </div>
									</div>

								  </div>
								</div>
								<!--End Modal -->
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
					
					/*Displays all the denied letters*/

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
                            Letter Content
                        </th>
                    </tr>
                    <?php
					
					/*Displays all the approved letters and it's sent content.*/

                    $asdh = $_SESSION['ID'];
                    $sql = "SELECT employees.*,letters.* FROM letters join employees on letters.SENDER_ID=employees.ID WHERE letters.Status = 'APPROVED' ";
                    $result = mysqli_query($conn,$sql);
                    while ($row = $result->fetch_assoc()) {
        $LetterReq = $row["FirstName"];
        $Direct = $row["DirectedTo"];
        $status = $row["Status"];
        echo "<tr>
                  <td>".$LetterReq."</td>
                  <td>".$Direct."</td>
				  <td><button type='button' class='btn btn-info openModal' id='Approve_Letter'> View </button>

				  <!-- Modal -->
								<div id='myModal' class='modal' role='dialog'>
								  <div class='modal-dialog'>

									<!-- Modal content-->
									<div id='MC' class='modal-content' style='height:50%;width:160%;'>
									  <div  class='modal-header'>
										<button type='button' id='Close' class='close' data-dismiss='modal'>&times;</button>
										<h4 class='modal-title' style='position:absolute;'>Letter Content</h4>
									  </div>
									  <div class='modal-body'>
									<textarea style='all:unset;scrollbar-width:none;text-align:left;width:100%;height:100%;white-space:pre-wrap;' rows='14' cols='100' readonly>".$row['LetterContent']."</textarea>
									  </div>
									</div>

								  </div>
								</div>
								<!--End Modal -->

				  </td>
              </tr>";
                    }





                ?>


                </table>
            </div>
        </div>
    </div>

  <script src="js/openmodal.js"></script>
	<script src="js/refresh.js"></script>





</body>

</html>
