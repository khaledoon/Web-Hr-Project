<html>

<head>
    <title>EM Letter</title>

    <link rel="stylesheet" id="theme" href="css/LetterEM.css">
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet"  href="css/bootstrap.min.css">
<!--      function to switch between tables of the employees's pending,denied and approved tables-->
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
        <!--    <div class="HeadDiv">
        <h1>HR Letter</h1>
        </div> -->
        <?php
			include_once"Exception_file.php";
   include_once ("dbconnection.php");
session_start();
//		validation if the session is empty or the employee is trying to access hr or admin pages
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
		
		
		include "Header.php";





    ?>
        <div class="LeftDiv">
            <div id="pending" onclick="myFunction('TablesDiv')">
                <span>
                    My Pending Letters
                </span>
            </div>
            <div id="denied" onclick="myFunction('DeniedDiv')">
                <span>
                    My Denied Letters
                </span>
            </div>
            <div id="approved" onclick="myFunction('ApprovedDiv')">
                <span>
                    My Approved Letters
                </span>
            </div>
        </div>

        <div class="MiddleDiv">
            <div id="TablesDiv">
                <h3>Pending Letters</h3>
                <table class="table table-bordered table-hover">


                    <tr>
						<th>
                            Letter ID
                        </th>
                        <th>
                            Letter Requested by
                        </th>
                        <th>
                            Letter Directed to alice in wonderland m3 ayman van boreen
                        </th>
                         <th>
                           Action
                        </th>
                    </tr>
                    <?php

//					array to hold flag values and boolean variables to check the checkboxes
						$a=array();
						$mobilex="false";
						$Passportx="false";
						$Martialx="false";
						$Hirex="false";
						$Salaryx="false";

//validation on comment in order not to input any special characters

                    if(isset($_POST['submit']))
   {if(preg_match('/[\'\/~`\!#\$%\^\*\(\)\-\+=\{\}\[\]\|;"\<\>\\?\\\]/', $_POST['comment'])){
       
      echo "<script> alert('please write a comment without any special characters excluding: : & @ , .')</script>";
   }

    else{                
				      if(!empty($_POST['check_list']))   
				     {
							    foreach($_POST['check_list'] as $check)
							    {
							            array_push($a,$check); 
//									check what is checked in checkboxes
							    }

				     }

//                  fill the array of checks with the checked values from the checkboxes
					for($i=0;$i<count($a);$i++)
					{
							if($a[$i]=="Mobile")
						 	{
						 	 $mobilex="true";
						 	}
						    else if ($a[$i]=="Passport")
							{
                              $Passportx="true";
							}
							else if ($a[$i]=="Martial")
							{
                              $Martialx="true";
							}
							else if ($a[$i]=="Hire")
							{
                              $Hirex="true";
							}
							else if ($a[$i]=="Salary")
							{
                              $Salaryx="true";
							}
					}

//insert into letters with type pending the data coming from form in the reqletter page
		if($_SESSION['mobile']=='')
		{echo"<div class='alert alert-danger animated fadeOut delay-2s'>
                                            <strong>Fill your data first in employee files tab or await approval on edit from HR Manager</strong>
                                            </div>";}
		else if ($_SESSION['natID']==''){echo"<div class='alert alert-danger animated fadeOut delay-2s'>
                                            <strong>Fill your data first in employee files tab or await approval on edit from HR</strong>
                                            </div>";}
		else if ($_SESSION['marStat']=='')
		{echo"<div class='alert alert-danger animated fadeOut delay-2s'>
                                            <strong>Fill your data first in employee files tab or await approval on edit from HR</strong>
                                            </div>";}
		else{
      $sql="INSERT INTO letters (SENDER_ID,DirectedTo,Priority,Status,MobileFlag,PassportFlag,MartialFlag,HireFlag,SalaryFlag,COMMENTS) VALUES ('".$_SESSION["ID"]."','".$_POST["Select_Directed_to"]."','".$_POST['Select_Priority']."','PENDING','$mobilex','$Passportx','$Martialx','$Hirex','$Salaryx','".$_POST["comment"]."')";
      $result = mysqli_query($conn,$sql);
      if($result)
      {
     // echo '<script> alert("Submit Success")</script>';
      //header("Location:LetterEM.php");

    echo "<div class='alert alert-success animated fadeOut delay-2s'>
																		  <strong>Created Successfully</strong>
																		  </div>";

      }
      else
      {
                                            echo"<div class='alert alert-danger animated fadeOut delay-2s'>
                                            <strong>Error Creating</strong>
                                            </div>";
      }
   }
	}
   }

                   //the employee can delete his requested lettter
                            if(isset($_POST['delete_btn']))
                             {
                                // $result="";
                                // echo "<script> $result = window.confirm('Are You Sure You Want To Delete Letter ?');</script>";
                                 $sql="delete from letters where SENDER_ID='".$_SESSION["ID"]."' AND LETTER_ID='".$_POST["letterid"]."';";
                                     $res = mysqli_query($conn,$sql);
                                     if($res){
                                        echo "<div class='alert alert-success animated fadeOut delay-2s'>
                                              <strong>Delete Success</strong>
                                              </div>";
                                     }else{
                                        echo"<div class='alert alert-danger animated fadeOut delay-3s'>
                                            <strong>Error Deleting</strong>
                                            </div>";
                                     }


                             }
					// the employee is saving the changes he has done to his letter using update statments
					else if (isset($_POST['save']))
					{
                        if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $_POST['comment'])){
                            
                            echo "<script> alert('please write a comment without any special characters excluding: : & @ , .')</script>";
       ;
                            
                        }
                        else {if ($_POST['Select_Priority']==="Selected")
						{}
						else{
					      $sql4="UPDATE letters
						 SET Priority='".$_POST['Select_Priority']."'
						 WHERE SENDER_ID='".$_SESSION['ID']."' AND LETTER_ID='".$_POST['letterid']."' ;";
						 $res1 = mysqli_query($conn,$sql4);

						}

						if ($_POST['Select_Directed_to']==="Selected")
						{}
						else{
					      $sql4="UPDATE letters
						 SET DirectedTo='".$_POST['Select_Directed_to']."'
						 WHERE SENDER_ID='".$_SESSION['ID']."' AND LETTER_ID='".$_POST['letterid']."' ;";
						 $res1 = mysqli_query($conn,$sql4);
							    

						}
                    


					if(!empty($_POST['check_list']))
				     {
							    foreach($_POST['check_list'] as $check)
							    {

							            array_push($a,$check);
							    }

				     }

					for($i=0;$i<count($a);$i++)
					{
							if($a[$i]=="Mobile")
						 	{
						 	 $mobilex="true";
						 	}
						    else if ($a[$i]=="Passport")
							{
                              $Passportx="true";
							}
							else if ($a[$i]=="Martial")
							{
                              $Martialx="true";
							}
							else if ($a[$i]=="Hire")
							{
                              $Hirex="true";
							}
							else if ($a[$i]=="Salary")
							{
                              $Salaryx="true";
							}
					}
						$sql4="UPDATE letters
						 SET MobileFlag='".$mobilex."',PassportFlag='".$Passportx."',MartialFlag='".$Martialx."',HireFlag='".$Hirex."',SalaryFlag='".$Salaryx."', COMMENTS='".$_POST['comment']."'
						 WHERE SENDER_ID='".$_SESSION['ID']."' AND LETTER_ID='".$_POST['letterid']."' ;";
						 $res1 = mysqli_query($conn,$sql4);
							       if($res1)
      {
     // echo '<script> alert("Submit Success")</script>';
      //header("Location:LetterEM.php");

    echo "<div class='alert alert-success animated fadeOut delay-1s'>
																		  <strong>Edit Successfully</strong>
																		  </div>";

      }
      else
      {
                                            echo"<div class='alert alert-danger animated fadeOut delay-3s'>
                                            <strong>Error Editing</strong>
                                            </div>";
      }


					}
                    }


                         
                    $asdh = $_SESSION['ID'];
                    $sql = "SELECT employees.*,letters.* FROM letters join employees on letters.SENDER_ID=employees.ID WHERE letters.SENDER_ID=".$_SESSION['ID']." AND letters.Status = 'PENDING' Order by FIELD(Priority,'Urgent','High','Medium','Low') ";
                    $result = mysqli_query($conn,$sql);




                    if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc())
                    {
                        $LetterReq = $row["FirstName"];
                        $Direct = $row["DirectedTo"];
                        $letterid = $row["LETTER_ID"];
//                         table of pending letters of the employee



                        echo "<tr>
							  <td>".$letterid."</td>
                              <td>".$LetterReq."</td>
                              <td>".$Direct."</td>

                              <td> <button type='button' class='btn btn-info openmodal'  data-target='#myModal' id='edit_btn'>Edit</button>
                            <button type='button' class='btn btn-danger openmodal' name='delete_btn' id='delete_btn'>Delete</button>





								<!-- Modal of editing letter after requesting it -->
								<div id='myModal' class='modal' role='dialog'>
								  <div class='modal-dialog'>

									<!-- Modal content-->
									<div id='MC' class='modal-content'>
									  <div class='modal-header'>
										<button type='button' class='close' data-dismiss='modal'>&times;</button>
										<h4 class='modal-title' style='position:absolute;'>Edit Letter</h4>
									  </div>
									  <div class='modal-body'>
										<form action='' method='post'>

					 				<select name='Select_Priority' id='Select2'>
					 				<option value='Selected'>Selected Priority : ".$row['Priority']."</option>
                                    <option value='Urgent'>Urgent</option>
                                    <option value='High'>High</option>
                                    <option value='Medium'>Medium</option>
                                    <option value='Low'>Low</option>
                     					</select> <br><br>

									<select name='Select_Directed_to' id='Select'>
									<option value='Selected'>Selected Direction : ".$row['DirectedTo']."</option>
									<option value='Embassy'>Embassy</option>
									<option value='Gov'>Governement Organization</option>
									<option value='Bank'>Bank</option>
									<option value='General'>General</option>
                   					</select>
									<br><br>

                                   <!-- using ternany if and getting from letters table the specified letter we check which check box was checked when the employee requested this letter-->

									<input type='checkbox' id='check-style' name='check_list[]' value='Mobile' ".(($row['MobileFlag'] == 'true')?'checked':' ')." > Mobile Number
									<br>
									<input type='checkbox' id='check-style' name='check_list[]' value='Passport' ".(($row['PassportFlag'] == 'true')?'checked':' ')."> Passport Image<br>
          							<input type='checkbox' id='check-style' name='check_list[]' value='Martial' ".(($row['MartialFlag'] == 'true')?'checked':' ')."> Martial Status<br>
          							<input type='checkbox' id='check-style' name='check_list[]' value='Hire' ".(($row['HireFlag'] == 'true')?'checked':' ')."> Hire Date<br>
									<input type='checkbox' id='check-style' name='check_list[]' value='Salary' ".(($row['SalaryFlag'] == 'true')?'checked':' ')."> Salary<br><br>
									 Comment: <br><textarea style='all:unset;white-space:prewrap;text-align:left;border-width:1px;border-style:solid;border-color:black;' name='comment' rows='10' cols='50'>".$row["COMMENTS"]."</textarea><br><br>

										<input type='hidden' name='letterid' value='".$row['LETTER_ID']."'>






									  </div>
									  <div class='modal-footer'>
										<input type='submit' name='save' value='Save Changes'>
									  </div>
									</div>
                                   </form>
								  </div>
								</div>
								<!--End Modal -->



                                				  <!-- Modal of confirmation on deleting a specific letter -->
								<div id='myModal1' class='modal' role='dialog'>
								  <div class='modal-dialog'>

									<!-- Modal content-->
									<div id='MC' class='modal-content'>
									  <div class='modal-header'>
										<button type='button' id='Close' class='close' data-dismiss='modal'>&times;</button>
										<h4 class='modal-title' style='position:absolute;'>Confirmation</h4>
									  </div>
									  <div class='modal-body'>
                  <form action='' method='post'>
                  Are you sure you want to delete this letter?
                  <input type='submit' name='delete_btn' value='Delete'>
				  <input type='hidden' name='letterid' value='".$row['LETTER_ID']."'>
				  </form>
                  </div>
                  </div>
                  </div>
                  </div>

                              </td>
                          </tr>";
                    }
                } else { echo "<tr><td colspan=4>No Letters found</td>";}







                ?>
                    <!-- <tr>
                    <td>
                    test
                    </td>
                    <td>
                    test
                    </td>
                    <td>
                status
                    </td>
                    <td>
                    <a href="">Letter</a>
                    </td>
                </tr>

                -->




                </table>
				<div id="New_Letter">
                <a href="reqLetter.php"><button type="button" class="btn btn-primary">Request Letter</button></a>
            </div>

            </div>
<!--               table of denied letters-->
            <div id="DeniedDiv">

                <h3>Denied Letters</h3>
                <table class="table table-bordered table-hover">


                    <tr>
                        <th>
                            Letter ID
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

                    $asdh = $_SESSION['ID'];
                    $sql = "SELECT employees.*,letters.* FROM letters join employees on letters.SENDER_ID=employees.ID WHERE letters.SENDER_ID=".$_SESSION['ID']." AND letters.Status = 'DENIED' ";
                    $result = mysqli_query($conn,$sql);
                     if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
        $LetterReq = $row["LETTER_ID"];
        $Direct = $row["DirectedTo"];
        $status = $row["Status"];
        echo '<tr>
                  <td>'.$LetterReq.'</td>
                  <td>'.$Direct.'</td>
                  <td>'.$status.'</td>
              </tr>';
                    }
                } else { echo "<tr><td colspan=4>No Letters found</td>";}





                ?>
                </table>
            </div>

<!--			-->



            <div id="ApprovedDiv">
<!--            table of approved letters-->
                <h3>Approved Letters</h3>
                <table class="table table-bordered table-hover">


                    <tr>
						<th>
                            Letter ID
                        </th>
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

                    $asdh = $_SESSION['ID'];
                    $sql = "SELECT employees.*,letters.* FROM letters join employees on letters.SENDER_ID=employees.ID WHERE letters.SENDER_ID=".$_SESSION['ID']." AND letters.Status = 'APPROVED' ";
                    $result = mysqli_query($conn,$sql);
                    if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
        $LetterReq = $row["FirstName"];
        $Direct = $row["DirectedTo"];
        $letterid = $row["LETTER_ID"];

       echo "<tr> <td>".$letterid."</td>
                  <td>".$LetterReq."</td>
                  <td>".$Direct."</td>
                  <td>
                  <button type='button' class='btn btn-info openModal' id='Approve_Letter'> View </button>

				  <!-- Modal of getting the content of letter after its being approved or in other words the final form of the letter -->
								<div id='myModal' class='modal' role='dialog'>
								  <div  class='modal-dialog'>

									<!-- Modal content-->
									<div id='MC' class='modal-content' style='height:50%;width:160%;'>
									  <div  class='modal-header'>
										<button type='button' id='Close' class='close' data-dismiss='modal'>&times;</button>
										<h4 class='modal-title' style='position:absolute;'>Letter Content</h4>
									  </div>
									  <div class='modal-body'>
									<textarea style='all:unset;text-align:left;white-space:pre-wrap;width:100%;height:100%;scrollbar-width: none;' rows='14' cols='100' readonly>".$row['LetterContent']."</textarea>
									  </div>
									</div>

								  </div>
								</div>
								<!--End Modal -->




                  </td>
              </tr>";
                    }
                } else { echo "<tr><td colspan=4>No Letters found</td>";}





                ?>


                </table>
            </div>


<!--         the button that directs the emp to the page of requesting the letter-->
            

        </div> <!-- end middle div -->
    </div> <!-- end parent div -->












	<script src="js/openmodal.js"></script>
    <script src="js/refresh.js"></script>
</body>

</html>
