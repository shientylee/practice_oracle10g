<?php
	session_start();
	$conn = oci_connect("cmdr", "cmdr", "localhost/XE");

	if (!$conn){
		$e = oci_error();
		trigger_error("Could not connect to database: " . $e['message'], E_USER_ERROR);
	}

	if (!isset($_SESSION['username'])){
		header("Location: login.php");
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
	      	<?php

	      		if (isset($_SESSION['username'])){
	      			echo "<li>Welcome, ".$_SESSION['username']."!&nbsp;&nbsp;&nbsp;</li>";
	      			echo "<li><a href='logout.php'>Logout</a></li>";
	      		}else{
	      			echo "<li><a href='login.php'>Login</a></li>";
	      		}

	      	?>
	      	</ul>
	    	</div>
	  	</nav>

        <main>

        <div class='container'>
	        <div style='margin-top: 12%;'>
			      <table class='stripped centered'>
			        <thead>
			          <tr>
			              <th data-field="id">Book ID</th>
			              <th data-field="title">Title</th>
			              <th data-field="author">Author</th>
			              <th data-field="section">Section</th>
			              <th data-field="yearpub">Year Published</th>
			          </tr>
			        </thead>

			        <tbody>
			          <?php

						$s = oci_parse($conn, "SELECT * FROM books ORDER BY Bookid ASC");
						if (!$s){
							$e = oci_error($conn);
							trigger_error("Could not parse statement: " . $e['message'], E_USER_ERROR);
						}
						$r = oci_execute($s);
						if (!$r){
							$e = oci_error($s);
							trigger_error("Could not execute statement: " . $e['message'], E_USER_ERROR);
						}
						$ncols = oci_num_fields($s);

						while (($row = oci_fetch_array($s, OCI_ASSOC + OCI_RETURN_NULLS)) != FALSE){
							echo "<tr>\n";
							foreach ($row as $item){
								echo "<td>" . ($item !== null?htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
							}
							echo "</tr>\n";
						}

			          ?>
			        </tbody>
			      </table>

		    </div>
	    </div>
        </main>

    </body>
</html>