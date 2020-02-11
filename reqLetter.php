<html>

<head>
    <title>Request Letter</title>
    <link rel="stylesheet" id="theme" href="css/reqLetter.css">
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">

    
</head>

<body>
    <?php
	//		validation if the session is empty or the employee is trying to access hr or admin pages
   session_start();
	include_once"Exception_file.php";
	try{
		
    if($_SESSION['job']==null){
	throw new customExceptionLogin();	
	}
	if($_SESSION['job']!="EM"){
	throw new customExceptionLoginEM();	
	}
	
	}catch(customExceptionLoginEM|customExceptionLogin $e){
		$e->reroute($_SESSION['ID']);
		
	}
      include "Header.php";
    ?>



<div  class="MiddleDiv">

 <h1 id="head-title" class="animated fadeInLeftBig">Automated HR Letter</h1>





<!--content of filling the requested letter data-->
<span id="choose-span" class="animated fadeInUp delay-1s">Choose Data You Want to Include in your Hr Letter</span>

<div id="form-div" class="animated delay-2s fadeInRight">
             <form action="LetterEM.php" method="post">
                              <div id="letter_Priority">
                    <span>Priority</span>
                     <select name="Select_Priority" id="Select2">
                                    <option value="Urgent">Urgent</option>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                     </select> 
                </div>

                              <div id="letter_directed_to">
                  <span>Letter Directed to</span>
                   <select name="Select_Directed_to" id="Select">
                                  <option value="Embassy">Embassy</option>
                                  <option value="Gov">Governement Organization</option>
                                  <option value="Bank">Bank</option>
                                  <option value="General">General</option>
                   </select> 
              </div>
          <input type="checkbox" id="check-style" name="check_list[]" value="Mobile"> Mobile Number<br>
          <input type="checkbox" id="check-style" name="check_list[]" value="Passport"> Passport Image<br>
          <input type="checkbox" id="check-style" name="check_list[]" value="Martial"> Martial Status<br>
          <input type="checkbox" id="check-style" name="check_list[]" value="Hire"> Hire Date<br>
          <input type="checkbox" id="check-style" name="check_list[]" value="Salary"> Salary<br><br>
          Add Comment  <input type="text" id="check-style" name="comment"><br>
          <input type="submit" id="check-style" name="submit" value="Submit">
            </form>
</div>

 
</div>  <!-- end middle div -->


  <script src="js/jquery-2.1.4.min.js"></script>
  <script src="js/bootstrap.min.js"></script>     
  <script src="js/refresh.js"></script>
</body>
</html>