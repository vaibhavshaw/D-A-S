<?php
include "db_connect.php";
session_start();
if(!(isset($_SESSION['name'])))
  {
    header('location: adminlogin.html');
  }
?>

<html>
<head><link href="main5.css" rel="stylesheet">
<link href="../css/bootstrap.css" rel="stylesheet">
</head>
<body>

<!-- Navigation -->
				<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
				  <div class="container">
					<a class="navbar-brand js-scroll-trigger" href="../home.html">INDIA POST</a>
					<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
					  Menu
					  <i class="fa fa-bars"></i>
					</button>
					<div class="collapse navbar-collapse" id="navbarResponsive">
					  <ul class="navbar-nav ml-auto">
						<li class="nav-item">
						  <a class="nav-link js-scroll-trigger" href="logout.php">Log out</a>
						</li>
						
					  </ul>
					</div>
				  </div>
				</nav>	
				
				<div class="container">
					<table class="table table-hover" style="margin:100px";>
											  <thead class="thead-dark">
												<tr>
												  <th scope="col">LATITUDE</th>
												  <th scope="col">LONGITUDE</th>
												  <th scope="col">PHYSICAL ADDRESS</th>
												  <th scope="col">DIGITAL ADDRESS</th>
												  
												</tr>
											  </thead>
											  <tbody>
											  <?php

											            $query="SELECT * FROM `digital_addresses`";

											            $result=mysqli_query($connection,$query);

											            while($row=mysqli_fetch_assoc($result))
											                {
											                  echo '
											                          <tr>
											                            <td>'.$row['latitude'].'</td>
											                            <td>'.$row['longitude'].'</td>
											                            <td>'.$row['best_street_address'].'</td>
											                            <td><a href="view_location.php?s_no='.$row['S.No'].' class="btn btn-info btn-block">'.$row['code'].'</a></td>
											                          </tr>
											                        ';   
											                }
											            ?>
												
											  </tbody>
											</table>
											
											
				</div>
				
				
				
				
				
	<script src="../js/jquery-3.3.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</body>
</html>