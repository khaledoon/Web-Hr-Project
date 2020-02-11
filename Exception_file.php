<?php
 date_default_timezone_set('Africa/Cairo');

class customExceptionLogin extends Exception{
public function reroute(){
	
	$path="C:\Users\khaledoon\Desktop\project_errors.log";
error_log("[". date("d/m/y : h:i:s A")."]"." Error:Unauthorized access to the system.
",3,$path);
	
	header("Location:login.php");     
}        
} 
class customExceptionLoginEM extends Exception{
public function reroute($ID){
 header("Location:UNOEM.php");  
		$path="C:\Users\khaledoon\Desktop\project_errors.log";
error_log("[". date("d/m/y : h:i:s A")."]"."Error:Unauthorized access by employee number ".$ID." to an Employee page.
",3,$path);
}        
}
class customExceptionLoginHR extends Exception{
public function reroute($ID){
	$path="C:\Users\khaledoon\Desktop\project_errors.log";
error_log("[". date("d/m/y : h:i:s A")."]"."Error:Unauthorized access by employee number ".$ID." to an Hr page.
",3,$path);
	header("Location:UNOHR.php");     
} 
}        

class customExceptionLoginADMIN extends Exception{
public function reroute($ID){
 	$path="C:\Users\khaledoon\Desktop\project_errors.log";
error_log("[". date("d/m/y : h:i:s A")."]"."Error:Unauthorized access by employee number ".$ID." to an ADMIN page.
",3,$path);
	header("Location:UNOADMIN.php");     
} 
}        
 
class customExceptionFailedConnection extends Exception{
public function reroute($ID){
	$path="C:\Users\khaledoon\Desktop\project_errors.log";
error_log("[". date("d/m/y : h:i:s A")."]"."Error:employee number ".$ID." cannot access the database.
",3,$path);
	header("Location:Maintenance.php");     
} 
}        


?>