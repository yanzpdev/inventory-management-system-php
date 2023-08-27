<?php
	session_start();
?>

<?php if(ISSET($_SESSION['adminid'])) { ?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    <link rel="stylesheet" href="css/animate.css">
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
	</head>
	<body>
		<nav id="navbar" class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
  			<a class="navbar-brand lead" href="index.php">Inventory Management System</a>
  			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
  			</button>
  			<div class="collapse navbar-collapse" id="navbarNav">
  				<div class="container-fluid">
    			<ul class="navbar-nav justify-content-end">

            <li class="nav-item">
                <a class="nav-link text-primary" href="#" data-toggle="modal" data-target="#SignUp"> Create Admin Account </a>
            </li>
     	 			<li class="nav-item">
        				<a class="btn btn-primary btn-sm mt-1 ml-2" href="select.php?logout"> Log-Out </a>
     	 			</li>
    			</ul>
    			</div>
  			</div>
		</nav>
		<br>
		<!---- START OF THE BODY --->
		<div class="container-fluid mt-5">
			<div class="row justify-content-md-center">
			<!------ CARD FOR THE USER ----->
			<?php
				require 'conn.php';
				$sql = $conn->prepare("SELECT * FROM `admin` WHERE `adminid` = '".$_SESSION['adminid']."'");
				$sql->execute();
				$fetch = $sql->fetch()
			?>
  			<div class="col-md-3 shadow-sm p-3 card">
  			 <img class="card-img-top mx-auto mt-1" src="<?php if($fetch['gender']==="Male"){ echo 'images/loginuser.png'; } else if($fetch['gender']==="Female") { echo 'images/girluser.png'; } ?>" data-holder-rendered=true; alt="Card image cap" style="height:190px; width:190px; display:block;">
				<h4 class="card-title text-center lead mt-4">Admin Information</h4>
				<div class="card-body">
					<a class="lead ml-3 mt-4 text-muted"><small><?php echo "Today is " . date("m-d-Y"); ?></small></a><br>
					<a class="lead ml-3 mt-4 text-muted"><small>Admin ID:  <?php echo $fetch['adminid'] ?></small></a><br>
					<a class="lead ml-3 mt-4"><small>Full Name:  <?php echo $fetch['firstname'] ?> <?php echo $fetch['lastname'] ?></small></a><br>
					<a class="lead ml-3 mt-4"><small>Gender:  <?php echo $fetch['gender'] ?></small></a><br>
					<a class="lead ml-3 mt-4"><small>Type: Admin</small></a><br><br>
					<!---<a class="lead ml-3 mt-4"><small>Department:  <?php echo $fetch['department'] ?></small></a><br><br>-->
					<button class="btn btn-primary btn-sm ml-3 mb-1 mt-1" data-toggle="modal" data-target="#update<?php echo $fetch['adminid']?>">Profile</button>
					<button class="btn btn-link btn-sm ml-3 mb-1 mt-1" data-toggle="modal" data-target="#credentials<?php echo $fetch['adminid']?>">Log-in Credentials</button>
				</div>
  			</div>

        <!---RIGHT SIDE CARD--->
  			<div class="col-md-6 ml-3 shadow-sm p-3 card ">
           <h5 class="card-title text-primary text-center mt-2">Admin Dashboard</h5>
          <!---UPPER CARDS -->
          <div class="row justify-content-md-center">
            
            <div class="col-sm-5 card border-light">
              <div class="card-header text-primary">Manage Users</div>
              <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted"><small>System Accounts</small></h6>
                <p class="card-text"><small>You can access and edit all the informations of the registered users on this system.</small></p>
                <a href="manageusers.php" class="card-link">Proceed</a>
              </div>
            </div>

            <div class="col-sm-5 ml-2 card border-light">
              <div class="card-header text-primary">Manage Departments</div>
              <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted"><small>Departments</small></h6>
                <p class="card-text"><small>You can access and edit all the departments registered on this system.</small></p>
                <a href="managedepartments.php" class="card-link">Proceed</a>
              </div>
            </div>
          </div>
          <!---- LOWER CARDS --->
          <div class="row justify-content-md-center">
            <div class="col-sm-5 mt-3 card border-light">
              <div class="card-header text-primary">Manage Products</div>
              <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted"><small>Products</small></h6>
                <p class="card-text"><small>You can access all the products saved by the users on this system.</small></p>
                <a href="manageproducts.php" class="card-link">Proceed</a>
              </div>
            </div>
            <div class="col-sm-5 mt-3 ml-2 card border-light">
              <div class="card-header text-primary">Manage Categories</div>
              <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted"><small>Categories</small></h6>
                <p class="card-text"><small>You can access all the categories saved by the users on this system.</small></p>
                <a href="managecategory.php" class="card-link">Proceed</a>
              </div>
            </div>
          </div>
  			</div>

  			</div>
  		</div>

  		<!--- START OF MODAL ---->

  		<!---- PROFILE UPDATE MODAL ---->
  		<?php
            require 'conn.php';

            $sql = $conn->prepare("SELECT * FROM `admin` WHERE `adminid` = '".$_SESSION['adminid']."'");
            $sql->execute();
            $fetch = $sql->fetch();
        ?>
      <div class="modal fade show" id="update<?php echo $fetch['adminid']?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="POST" action="adminprofileupdate.php">
            <div class="modal-header">
              <h5 class="modal-title">Update Profile</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>  
            <div class="modal-body">
              <div class="container">
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">First Name</label>
                <div class="col-sm-8">
                  <input class="form-control" type="text" required value="<?php echo $fetch['firstname']?>" name="firstname"/>
                  <input class="form-control" type="hidden" required value="<?php echo $fetch['adminid']?>" name="adminid"/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Last Name</label>
                <div class="col-sm-8">
                  <input class="form-control" type="text" required value="<?php echo $fetch['lastname']?>" name="lastname"/>
                </div>
              </div>
              <div class="form-group row">
              	<label class="col-sm-4 col-form-label">Gender</label>
              	<div class="col-sm-8 mt-2">
              	<div class="radio-inline" required>
                	<label><input type="radio" name="gender" value="Male" <?php if($fetch['gender'] === "Male"){ echo "checked"; } ?>> Male</label>
                	<label><input type="radio" class="ml-2" name="gender" value="Female" <?php if($fetch['gender'] === "Female"){ echo "checked"; } ?>> Female</label>
              	</div>
              	</div>
              </div>
              <div class="form-group row">
                <label class="col-lg-12 col-form-label text-danger ml-2"><small>All fields are required!</small></label>
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?php echo $fetch['adminid']?>" data-dismiss="modal">Delete Profile</button>
                <button type="submit" id="btnUpdate" name="updateadminprof" class="btn btn-primary btn-sm">Update Profile</button>
              </div>
              </div>
            </div>  
          </form>
        </div>
      </div>
      </div>

      <!--- END OF PROFILE MODAL --->

      <!--- START OF CONFIRM DELETE PROFILE MODAL ---->
      <div class="modal" role="dialog" id="delete<?php echo $fetch['adminid'] ?>">
  	  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this admin account? Note: You cannot undo this action!</p>
      </div>
      	<div class="modal-footer">
      		<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
        	<a class="btn btn-danger btn-sm" id="AdminProfDelete" href="adminprofdelete.php?adminid=<?php echo $fetch['adminid']?>">Delete Profile</a>
      	</div>
    	</div>
  	  </div>
	  </div>

    <!---- CREDENTIALS MODAL ---->
      <?php
            require 'conn.php';

            $sql = $conn->prepare("SELECT * FROM `admin` WHERE `adminid` = '".$_SESSION['adminid']."'");
            $sql->execute();
            $fetch = $sql->fetch();
        ?>
      <div class="modal fade show" id="credentials<?php echo $fetch['adminid']?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="POST" action="admincredupdate.php">
            <div class="modal-header">
              <h5 class="modal-title">Update Profile</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>  
            <div class="modal-body">
              <div class="container">
              <div class="form-group row">
                <label class="col-sm-5 col-form-label">Username</label>
                <div class="col-sm-7">
                  <input class="form-control" type="text" required value="<?php echo $fetch['username']?>" name="username"/>
                  <input class="form-control" type="hidden" required value="<?php echo $fetch['adminid']?>" name="adminid"/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-5 col-form-label">Old Password</label>
                <div class="col-sm-7">
                  <input class="form-control" type="text" required value="" placeholder="Enter your old password" name="oldpass"/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-5 col-form-label">New Password</label>
                <div class="col-sm-7">
                  <input class="form-control" type="password" required value="" placeholder="Enter your new password" name="newpass"/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-5 col-form-label">Confirm Pass</label>
                <div class="col-sm-7">
                  <input class="form-control" type="password" required value="" placeholder="Confirm Password" name="confirmpass"/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-12 col-form-label text-danger ml-2"><small>All fields are required!</small></label>
              </div>
              <div class="modal-footer">
                <button type="submit" id="btnUpdate" name="admincred" class="btn btn-primary btn-sm">Update Profile</button>
              </div>
              </div>
            </div>  
          </form>
        </div>
      </div>
      </div>

      <!--- CREDENTIALS MODAL --->
      <!---- ADMIN CREATE --->
      <div class="modal fade" id="SignUp" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="POST" action="addadmin.php">
            <div class="modal-header">
              <h5 class="modal-title">Create Admin Account</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>  
            <div class="modal-body">
              <div class="container">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Firstname</label>
                <div class="col-sm-8">
                  <input class="form-control" type="text" required name="firstname"/>
                  <input type="hidden" name="userid"/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Lastname</label>
                <div class="col-sm-8">
                  <input class="form-control" type="text" required name="lastname"/>
                </div>
              </div>
              <div class="form-group row">
              <label class="col-sm-3 col-form-label">Gender</label>
              <div class="col-sm-8">
              <div class="radio">
                <label><input type="radio" name="gender" value="Male" checked> Male</label>
              </div>
              <div class="radio">
                <label><input type="radio" name="gender" value="Female"> Female</label>
              </div>
              </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-8">
                  <input class="form-control" type="text" required name="username"/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Password</label> 
                <div class="col-sm-8">
                  <input class="form-control" type="password" required name="password"/>
                </div>
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="btnSave" name="save" class="btn btn-danger">Save Account</button>
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