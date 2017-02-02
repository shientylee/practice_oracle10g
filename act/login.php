<?php
	session_start();
	$conn = oci_connect("cmdr", "cmdr", "localhost/XE");

	if (!$conn){
		$e = oci_error();
		trigger_error("Could not connect to database: " . $e['message'], E_USER_ERROR);
	}

	if (isset($_SESSION['username'])){
		header("Location: index.php");
	}

	if (isset($_POST['btnLogin'])){
		$username = addslashes($_POST['username']);
		$password = addslashes(md5($_POST['password']));
		if (empty($username)){
			echo "<script>alert('Username is empty');</script>";
		}else if(empty($password)){
			echo "<script>alert('Password is empty');</script>";
		}else{
			$query = "SELECT * FROM users WHERE username = '".$username."' AND password = '".$password."'";
			//echo $query;
			$s = oci_parse($conn, $query);
			if (!$s){
				$e = oci_error($conn);
				trigger_error("Could not parse statement: " . $e['message'], E_USER_ERROR);
			}else{
				$r = oci_execute($s);	
					if (!$r){
						$e = oci_error($s);
						trigger_error("Could not execute statement: " . $e['message'], E_USER_ERROR);
					}else{
						$counter = 0;
						while (($row = oci_fetch_array($s, OCI_ASSOC + OCI_RETURN_NULLS)) != FALSE){
						$counter = oci_num_rows($s);
						}
						if ($counter == 1){
							$_SESSION['username'] = $username;
							header("Location: index.php");
						}else{
							echo "<script>alert('Username or password is invalid');</script>";
						}
					}
			}
		}

	}

?>

 <html>
    <head>
      	<!--Import Google Icon Font-->
      	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      	<!--Import materialize.css-->
      	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      	<!--Let browser know website is optimized for mobile-->
      	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

      	<style>

      	body{
      		background-color: #4fc3f7;
      	}

      	</style>
    </head>

    <body>
    	<!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>

	  	<nav>
	    	<div class="nav-wrapper light-blue">
	      	<ul id="nav-mobile" class="right hide-on-med-and-down">
	        	<li><a href="login.php">Login</a></li>
	      	</ul>
	    	</div>
	  	</nav>

        <main>

        <div class='container'>
	      <div class="row">
	        <div class="col s12" style='margin-top: 10%;'>
	          <div class="card">
	            <div class="card-content black-text">
	              <span class="card-title">Login</span>
				      <form method='post' action='#' class="row">
				        <div class="input-field col s6">
				          <input id="username" name='username' type="text" class="validate" required>
				          <label for="username">Username</label>
				        </div>
				        <div class="input-field col s6">
				          <input id="password" name='password' type="password" class="validate" required>
				          <label for="password">Password</label>
				        </div>
				        <center>
				        <button name='btnLogin' class="waves-effect waves-light btn"><i class="material-icons left">send</i>Login</button>
				        </center>
				      </form>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>

        </main>

    </body>
</html>