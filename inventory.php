<?php
	session_start();
	// $_SESSION['departmentname'] = $fetch['departmentname'];
?>

<?php if(ISSET($_SESSION['User'])) { 

  ?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
	</head>
	<body data-spy="scroll" data-target="#navbar">
			<nav id="navbar" class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
  			<a class="navbar-brand lead" href="index.php">Inventory Management System</a>
  			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
  			</button>
  			<div class="collapse navbar-collapse" id="navbarNav">
  				<div class="container-fluid">
    			<ul class="navbar-nav justify-content-end">
      				<li class="nav-item">
        				<a class="nav-link text-primary"><?php echo 'Welcome, '.$_SESSION['User']; ?>!</a>
     	 			</li>
     	 			<li class="nav-item">
        				<a class="btn btn-primary btn-sm mt-1 ml-2" href="select.php?logout"> Log-Out </a>
     	 			</li>
    			</ul>
    			</div>
  			</div>
		</nav>
		<br>
		<div class="container-fluid">
		<div class="row justify-content-md-center mt-5">
			<?php
						require 'conn.php';
						$sql = $conn->prepare("SELECT * FROM `user` WHERE `userid` = '".$_SESSION['userid']."'");
						$sql->execute();
						$fetch = $sql->fetch()
			?>
			<div class="col-lg-3 shadow-sm p-3 mb-5 card" style="width: 18rem;">
				<img class="card-img-top mx-auto mt-2" src="<?php if($fetch['gender']==="Male"){ echo 'images/loginuser.png'; } else if($fetch['gender']==="Female") { echo 'images/girluser.png'; } ?>" data-holder-rendered=true; alt="Card image cap" style="height:190px; width:190px; display:block;">
				<h4 class="card-title text-center lead mt-4">User Information</h4>
				<div class="card-body">
					<a class="lead ml-3 mt-4 text-muted"><small><?php echo "Today is " . date("m-d-Y"); ?></small></a><br>
					<a class="lead ml-3 mt-4"><small>Full Name:  <?php echo $fetch['firstname'] ?> <?php echo $fetch['lastname'] ?></small></a><br>
					<a class="lead ml-3 mt-4"><small>Gender:  <?php echo $fetch['gender'] ?></small></a><br>
          <a class="lead ml-3 mt-4"><small>Role:  <?php echo $fetch['role'] ?></small></a><br>
					<a class="lead ml-3 mt-4"><small>Department:  <?php echo $fetch['department'] ?></small></a><br><br>
					<button class="btn btn-primary btn-sm ml-3 mt-1" data-toggle="modal" data-target="#update<?php echo $fetch['userid']?>">Edit Profile</button>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="row">
				<div class="col-md-10 shadow-sm p-3 mb-3 ml-3 card">
					<?php if(@$_GET['Success'] == true){ ?>
          			<div class="alert alert-success text-center text-dark" role="alert">
            			Your Account has been updated!
            			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            				<span aria-hidden="true">&times;</span>
           				</button>
          			</div>

          			<?php } ?>

          			<?php if(@$_GET['CategoryAdded'] == true){ ?>
          			<div class="alert alert-success text-center text-dark" role="alert">
            			Category Added!
            			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            				<span aria-hidden="true">&times;</span>
           				</button>
          			</div>

          			<?php } ?>

                <?php if(@$_GET['ProductAdded'] == true){ ?>
                <div class="alert alert-success text-center text-dark" role="alert">
                  Product Added!
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <?php } ?>

                <?php if(@$_GET['ProductExisting'] == true){ ?>

                <div class="alert alert-danger text-center text-dark" role="alert">
                 Product already exists in the database!
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <?php } ?>

          <?php if($_SESSION['Role'] == 'Inventory Clerk'){?>
					<h5 class="card-title ml-3 text-primary">Summary</h5>
					<h5 class="card-title font-weight-light text-center font-italic text-primary">"Hello, <?php echo $fetch['firstname'] ?>. Here is the summary for your department."</h5>
          <?php
           require 'conn.php';
            $sql = $conn->prepare("SELECT * FROM `user` WHERE `userid` = '".$_SESSION['userid']."'");
            $sql->execute();
            $fetchuser = $sql->fetch();

            $con = mysqli_connect('localhost', 'root');
            mysqli_select_db($con, 'equipment');


            $page = "SELECT * FROM `inventory` WHERE `departmentname` = '".$fetchuser['department']."'";
            $low_s_count = 0;
            $most_s_count = 0;
            $out_s_count = 0;
            $res = mysqli_query($con, $page);

            $rows = mysqli_num_rows($res);

            $datacheck = $conn->prepare("SELECT * FROM `inventory` WHERE `departmentname` = '".$fetchuser['department']."'");
            $datacheck->execute();
            while($fetch = $datacheck->fetch()){
              if($fetch['itemcount'] < 3){
                $low_s_count = $low_s_count + 1;
              }
              if($fetch['itemcount'] > 10){
                $most_s_count = $most_s_count + 1;
              }
              if($fetch['itemcount'] == 0){
                $out_s_count = $out_s_count + 1;
              }
            }
          ?>
					   <div class="card-body" >
						    <div class="row mx-auto">
        				<div class="col-sm-5 card border-info" data-toggle="tooltip" data-placement="top" title="Total Count of Products">
        					<h6 class="card-title mt-2 text-muted text-center">Total Products: <?php echo $rows ?></h6>
        				</div>
        				<div class="col-sm-5 ml-4 card border-danger" data-toggle="tooltip" data-placement="top" title="Count as low if item count is less than 3">
        					<div class="row">
        						<h6 class="card-title mt-2 text-muted mx-auto">Low Stock Products: <?php echo $low_s_count ?></h6>
                    <h4 class="card-title mt-2 text-muted text-center"></h4>
        					</div>
        				</div>
        				</div>
        				<div class="row mx-auto mt-3">
        				<div class="col-sm-5 card border-success">
        					<h6 class="card-title mt-2 text-muted mx-auto">Most Stock Products: <?php echo $most_s_count ?></h6>
        				</div>
        				<div class="col-sm-5 ml-4 card border-danger">
        					<div class="row">
        						<h6 class="card-title mt-2 text-muted mx-auto">Out of Stock Products: <?php echo $out_s_count ?></h6>
        					</div>
        				</div>
        				</div>
      				</div>
				</div>
				</div>
        <?php }?>

        <?php if($_SESSION['Role'] == 'Sales Clerk'){?>
          <h5 class="card-title ml-3 text-primary">Summary</h5>
          <h5 class="card-title font-weight-light text-center font-italic text-primary">"Hello, <?php echo $fetch['firstname'] ?>. Here is the summary for your department."</h5>
          <?php
           require 'conn.php';
            $sql = $conn->prepare("SELECT * FROM `user` WHERE `userid` = '".$_SESSION['userid']."'");
            $sql->execute();
            $fetchuser = $sql->fetch();

            $con = mysqli_connect('localhost', 'root');
            mysqli_select_db($con, 'equipment');


            $page = "SELECT * FROM `sales` WHERE `departmentname` = '".$fetchuser['department']."'";
            $low_s_count = 0;
            $most_s_count = 0;
            $out_s_count = 0;
            $res = mysqli_query($con, $page);

            $rows = mysqli_num_rows($res);

            $datacheck = $conn->prepare("SELECT * FROM `sales` WHERE `departmentname` = '".$fetchuser['department']."'");
            $datacheck->execute();
            while($fetch = $datacheck->fetch()){
              if($fetch['itemcount'] < 3){
                $low_s_count = $low_s_count + 1;
              }
              if($fetch['itemcount'] > 10){
                $most_s_count = $most_s_count + 1;
              }
              if($fetch['itemcount'] == 0){
                $out_s_count = $out_s_count + 1;
              }
            }
          ?>
             <div class="card-body" >
                <div class="row mx-auto">
                <div class="col-sm-5 card border-info" data-toggle="tooltip" data-placement="top" title="Total Count of Products">
                  <h6 class="card-title mt-2 text-muted text-center">Total Products: <?php echo $rows ?></h6>
                </div>
                <div class="col-sm-5 ml-4 card border-danger" data-toggle="tooltip" data-placement="top" title="Count as low if item count is less than 3">
                  <div class="row">
                    <h6 class="card-title mt-2 text-muted mx-auto">Low Stock Products: <?php echo $low_s_count ?></h6>
                    <h4 class="card-title mt-2 text-muted text-center"></h4>
                  </div>
                </div>
                </div>
                <div class="row mx-auto mt-3">
                <div class="col-sm-5 card border-success">
                  <h6 class="card-title mt-2 text-muted mx-auto">Most Stock Products: <?php echo $most_s_count ?></h6>
                </div>
                <div class="col-sm-5 ml-4 card border-danger">
                  <div class="row">
                    <h6 class="card-title mt-2 text-muted mx-auto">Out of Stock Products: <?php echo $out_s_count ?></h6>
                  </div>
                </div>
                </div>
              </div>
        </div>
        </div>
        <?php }?>

				<div class="row">
  					<div class="col-sm-5">
    					<div class="card shadow-sm p-3 mb-5">
      						<div class="card-body" >
        						<h5 class="card-title text-primary">Add Category</h5>
        						<p class="card-text text-muted">Add and Manage your Categories here.</p>
       						    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCategory">Add Category</button>
       						    <a href="managecateg.php" class="btn btn-warning btn-sm">Manage </a>
      						</div>
    					</div>
  					</div>
            <?php if($_SESSION['Role'] == 'Inventory Clerk'){?>
  					<div class="col-sm-5" style="height:80px">
    					<div class="card shadow-sm p-3 mb-5">
      						<div class="card-body">
        						<h5 class="card-title text-primary">Add Product</h5>
        						<p class="card-text text-muted">Add and Manage your Products here.</p>
        						<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#AddProduct">Add Product</button>
       						   <a href="manageprod.php" class="btn btn-warning btn-sm">Manage </a>
      						</div>
    					</div>
  					</div>
            <?php }?>
            <?php if($_SESSION['Role'] == 'Sales Clerk'){?>
            <div class="col-sm-5" style="height:80px">
              <div class="card shadow-sm p-3 mb-5">
                  <div class="card-body" >
                    <h5 class="card-title text-primary">Transferred Products</h5>
                    <p class="card-text text-muted">Add and Manage transferred Products here.</p>
                      <a href="managedeletedprods.php" class="btn btn-warning btn-sm">Manage </a>
                  </div>
              </div>
            </div>
            <?php }?>
				</div>
				
			</div>
		</div>
		</div>
     <?php
           require 'conn.php';
            $sql = $conn->prepare("SELECT * FROM `user` WHERE `userid` = '".$_SESSION['userid']."'");
            $sql->execute();
            while($fetch = $sql->fetch()){

    ?>
		<div class="modal fade" id="update<?php echo $fetch['userid']?>" aria-hidden="true">
      	<div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="POST" action="update.php">
            <div class="modal-header">
              <h5 class="modal-title">Update User Information</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>  
            <div class="modal-body">
              <div class="container">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Firstname</label>
                <div class="col-sm-8">
                  <input class="form-control" type="text" required value="<?php echo $fetch['firstname'] ?>" name="firstname"/>
                  <input type="hidden" name="userid" value="<?php echo $fetch['userid'] ?>"/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Lastname</label>
                <div class="col-sm-8">
                  <input class="form-control" type="text" required value="<?php echo $fetch['lastname'] ?>"  name="lastname"/>
                </div>
              </div>
              <div class="form-group row">
              <label class="col-sm-3 col-form-label">Gender</label>
              <div class="col-sm-8">
              <div class="radio">
                <label><input type="radio" name="gender" value="Male" <?php if($fetch['gender'] === "Male"){ echo "checked"; } ?>> Male</label>
              </div>
              <div class="radio">
                <label><input type="radio" name="gender" value="Female" <?php if($fetch['gender'] === "Female"){ echo "checked"; } ?>> Female</label>
              </div>
              </div>
              </div>
              <div class="form-group row">
              <label class="col-sm-3 col-form-label">Role</label>
              <div class="col-sm-8">
                <input class="form-control" type="text" required value="<?php echo $fetch['role'] ?>"  name="role" readonly/>
              </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-8">
                  <input class="form-control" type="text" value="<?php echo $fetch['username'] ?>" required name="username"/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Department</label> 
                <div class="col-sm-8">
                <select name ="department" disabled class="browser-default custom-select">
                  <?php
                  require 'conn.php';
                  $sql = $conn->prepare("SELECT * FROM `user` WHERE `userid` = '".$_SESSION['userid']."'");
                  $sql->execute();
                  $fetchuser = $sql->fetch();

                  $sql = $conn->prepare("SELECT * FROM `department`");
                  $sql->execute();
                  while($fetch = $sql->fetch()){
                  ?>
                  <option value="<?php echo $fetch['departmentname']?>" <?php if($fetchuser['department'] === $fetch['departmentname']){ echo "selected"; }?>><?php echo $fetch['departmentname']?></option>
                  <?php } ?>
                </select>
                <input type="hidden" name="departmentname" value="<?php echo $fetchuser['department'] ?>"/>
                </div>
              </div>
              </div>
              <div class="form-group row">
              	<label class="col-lg-10 col-form-label text-danger ml-3"><small>Contact the administrator to change your password, re-assign your department, or change your role.</small></label>
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" id="btnUpdate" name="update" class="btn btn-primary btn-sm">Update</button>
              </div>
            </div>  
          </form>
        </div>
      </div>
      </div>
      <?php } ?>
      <div class="modal fade" id="addCategory" aria-hidden="true">
      	<div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="POST" action="addcateg.php">
            <div class="modal-header">
              <h5 class="modal-title">Add Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>  
            <div class="modal-body">
              <div class="container">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Category</label>
                <div class="col-sm-8">
                  <?php

                  require 'conn.php';
                  $sql = $conn->prepare("SELECT * FROM `user` WHERE `userid` = '".$_SESSION['userid']."'");
                  $sql->execute();
                  $fetchuser = $sql->fetch();

                  ?>
                  <input class="form-control" type="text" required name="categoryname"/>
                  <input type="hidden" name="userid" value="<?php echo $fetchuser['userid'] ?>"/>
                  <input type="hidden" name="departmentname" value="<?php echo $fetchuser['department'] ?>"/>
                </div>
              </div>
              <div class="form-group row">
              	<label class="col-lg-12 col-form-label text-danger ml-2"><small>Products and Categories will be saved according to your department.</small></label>
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" id="btnUpdate" name="update" class="btn btn-primary btn-sm">Add Category</button>
              </div>
              </div>
            </div>  
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="AddProduct" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="POST" action="addprod.php">
            <div class="modal-header">
              <h5 class="modal-title">Add Product</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>  
            <div class="modal-body">
              <div class="container">
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Product Name</label>
                <div class="col-sm-8">
                  <?php

                  require 'conn.php';
                  $sql = $conn->prepare("SELECT * FROM `user` WHERE `userid` = '".$_SESSION['userid']."'");
                  $sql->execute();
                  $fetchuser = $sql->fetch();

                  ?>
                  <input class="form-control" type="text" required name="productname"/>
                  <input type="hidden" name="userid" value="<?php echo $fetchuser['userid'] ?>"/>
                  <input type="hidden" name="departmentname" value="<?php echo $fetchuser['department'] ?>"/>
                </div>
              </div>
               <div class="form-group row">
                <label class="col-sm-4 col-form-label">Category</label> 
                <div class="col-sm-8">
                <select name ="category" required class="browser-default custom-select">
                  <?php
                   require 'conn.php';

                  $sql = $conn->prepare("SELECT * FROM `user` WHERE `userid` = '".$_SESSION['userid']."'");
                  $sql->execute();
                  $fetchuser = $sql->fetch();

                  $sql = $conn->prepare("SELECT * FROM `category` WHERE `departmentname` = '".$fetchuser['department']."'");
                  $sql->execute();
                  while($fetch = $sql->fetch()){
                  ?>
                  <option value="<?php echo $fetch['categoryname']?>"><?php echo $fetch['categoryname']?></option>
                  <?php } ?>
                </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Product Count</label>
                <div class="col-sm-8">
                  <input class="form-control" type="text" required name="itemcount"/>
                </div>
              </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-12 col-form-label text-danger ml-2"><small>Products and Categories will be saved according to your department.</small></label>
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" id="btnUpdate" name="addprod" class="btn btn-primary btn-sm">Save Product</button>
              </div>
              </div>
            </div>  
          </form>
        </div>
      </div>
    </div>
	</body>
	<script src="js/jquery-3.2.1.min.js"></script>  
  <script src="js/bootstrap.js"></script>
  <script src="js/rellax.min.js"></script>
</html>

	<?php 
		}
	else {
		header("location:select.php");
	} 
	?>
