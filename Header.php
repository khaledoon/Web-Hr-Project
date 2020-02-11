<html>

<head>
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="JSCOOKIES/js-cookie-latest/src/js.cookie.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .HeaderDiv {
            background-color: #2B3856;
            width: 100%;
            min-width: 100%;
            height: 18%;
            overflow: hidden;
            position: absolute;
        }

        #SignOut_btn {
            float: right;
            color: white;
            margin-left: 93%;
            margin-top: 6%;
            
            width: auto;
            font-size: 15px;
            position: absolute;
        }

        #word {
            position: absolute;
            margin-top: 3%;
            margin-left: 2%;
            text-shadow: 3px 2px #212f3c;
            color: #bfc9ca;
            text-align: left;
            font-size: 40px;
            font-family: Helvetica, sans-serif;
            font-style: italic;
        }

        #Theme {
            position: absolute;
            margin-left: 83.8%;
            margin-top: 6%;
            
            width: auto;
            font-size: 15px;
            position: absolute;
            float: right;
            color: white;
        }

        #OriginalTheme {
            position: absolute;
            margin-left: 75%;
            margin-top: 6%;
            
            width: auto;
            font-size: 15px;
            position: absolute;
            float: right;
            color: white;
        }

        #timestamp {
            position: absolute;
            margin-top: 95px;
            margin-left: 2%;
            color: blueviolet;
            border-color: cornflowerblue;
        }

    </style>
<?php
	
	include_once "Exception_file.php";
	include_once "dbconnection.php";
	
	/*Checks if the user tries to enter this page through using it's URL then it redirects the user to the login page*/
	
	if($_SERVER['PHP_SELF'] == '/header.php' || $_SERVER['PHP_SELF'] == '/Header.php')
	{
		header("Location:login.php");
	}
    
?>

	</head>

<body>


    <div class="HeaderDiv">
        <a href="MainPage.php">
            <h1 id="word"> HR System</h1>
        </a>
        <div id="timestamp"></div>
        <button type="button" class="btn btn-secondary" id="Theme">Alternate Theme</button>
        <button type="button" class="btn btn-primary" id="OriginalTheme">Original Theme</button>
        <a href="SignOut.php"><button type="button" class="btn btn-danger" id="SignOut_btn">Sign Out</button></a>

        <script>
			
			/*This function searches for the saved cookie by the user that determines the website theme. Then it searches for the link tag that has the id of 'Theme' in the current PHP page and changes it's href attribute with the assigned theme by getting the current page's name excluding the extension part '.php' and adding the extension '.css' along with it's number as the original theme has no number and the alternate has number '2' after the page's name.*/
			
            $(document).ready(function() {
                if (Cookies.get("Theme") == "1") {
                    $("link[id='theme']").attr('href', 'css/' + "<?php echo ucfirst(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME)) ?>" + '.css');
                } else {
                    $("link[id='theme']").attr('href', 'css/' + "<?php echo ucfirst(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME)) ?>" + '2.css');
                }
                
				/*This segment sets a cookie with the number of the selected theme as mentioned in the comment above and toggles to the clicked theme button with the same functionality that's explained above.*/
				
                $("#Theme").click(function() {
                    $("link[id='theme']").attr('href', 'css/' + "<?php echo ucfirst(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME)) ?>" + '2.css');
                    Cookies.set("Theme", "2");
                });
                
                $("#OriginalTheme").click(function() {
                    $("link[id='theme']").attr('href', 'css/' + "<?php echo ucfirst(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME)) ?>" + '.css');
                    Cookies.set("Theme", "1");
                });
            });
            
            /*This function calls the clock page if it returns success it puts the result in the div with the ID 'timestamp' then we set an interval on the function that is invoked every second.*/
                function timestamp() {
                    $.ajax({
                        url: 'http://localhost/clock.php',
                        success: function(data) {
                            $('#timestamp').html(data);
                        },
                    });
                }

                setInterval(timestamp, 1000);

        </script>

    </div>

</body>

</html>
