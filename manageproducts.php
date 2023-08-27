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
                <button class="btn btn-success btn-sm mt-1 ml-2" data-toggle="modal" data-target="#AddProduct"> Add Product </button>
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
  			<div class="col-md-3 shadow p-3 card">
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
  			<div class="col-md-7 ml-3 shadow p-3 card ">
           <h5 class="card-title text-primary text-center mt-2">Manage Products</h5>
          <!---UPPER CARDS -->
          <table class="table table-hover">
          <caption class="text-muted ml-2"><small>All products saved to this system are shown.</small></caption>
          <thead>
           <tr>
            <th>Product Name</th>
            <th>Category</th>
            <th>Item Count</th>
            <th>Department</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>

          <?php
            require_once'conn.php'; 
            $con = mysqli_connect('localhost', 'root');
            mysqli_select_db($con, 'equipment');

            $page = "SELECT * FROM `inventory`";
            $limit = 5;
            $res = mysqli_query($con, $page);
            $rows = mysqli_num_rows($res);

            $page_num = ceil($rows/$limit);

            if(!ISSET($_GET['page'])){
              $page = 1;
            }
            else{
              $page = $_GET['page'];
            }

            $pagefirst_res = ($page-1) * $limit;

             $sql = $conn->prepare("SELECT * FROM `inventory` ORDER BY(departmentname) ASC LIMIT ".$pagefirst_res.','.$limit);
            $sql->execute();

            while($fetch = $sql->fetch()){
          ?>
          <tr>
            <td><?php echo $fetch['productname']?></td>
            <td><?php echo $fetch['category']?></td>
            <td><?php echo $fetch['itemcount']?></td>
            <td><?php echo $fetch['departmentname']?></td>
            <td><button class="btn btn-warning btn-sm text-light" data-toggle="modal" data-target="#updateprod<?php echo $fetch['itemid']?>">&#9997;&#127995;</button> <a class="btn btn-danger btn-sm" id="btnDelete" href="admindeleteprod.php?id=<?php echo $fetch['itemid']?>">&times;</a></td>
          </tr>
          
        <?php } ?>

          </tbody>
          </table>
          <?php 
            $con = mysqli_connect('localhost', 'root');
            mysqli_select_db($con, 'equipment');

            $page = "SELECT * FROM `inventory`";
            $limit = 5;
            $res = mysqli_query($con, $page);
            $rows = mysqli_num_rows($res);

            $page_num = ceil($rows/$limit);

            if(!ISSET($_GET['page'])){
              $page = 1;
            }
            else{
              $page = $_GET['page'];
            }

            $pagefirst_res = ($page-1) * $limit;

            if($page < $page_num){
              $next = $page+1;
            }

            if($page > 1){
              $prev = $page-1;
            }
          ?>

          <div class="row justify-content-md-end mr-3">
          <a class="btn btn-link btn-sm mr-4" href="adminprev.php">Go Back</a>
          <nav aria-label="Page navigation">
          <ul class="pagination">
            <li class="page-item">
              <a class="page-link" href="manageproducts.php?page=<?= $prev; ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li class="page-item">
            <?php for($i = 1; $i<= $page_num; $i++) : ?>
              <li><a class="page-link" href="manageproducts.php?page=<?= $i; ?>"><?= $i; ?></a></li>
            <?php endfor; ?>
            <li class="page-item">
              <a class="page-link" href="manageproducts.php?page=<?= $next; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
          </nav>
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
      <!----- UPDATE PRODUCT MODAL ---->
      <?php
            require 'conn.php';

            $sqlinv = $conn->prepare("SELECT * FROM `inventory`");
            $sqlinv->execute();
            while($fetchitem = $sqlinv->fetch()){
        ?>
      <div class="modal fade show" id="updateprod<?php echo $fetchitem['itemid']?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="POST" action="adminprodupdate.php">
            <div class="modal-header">
              <h5 class="modal-title">Update Product</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>  
            <div class="modal-body">
              <div class="container">
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Product Name</label>
                <div class="col-sm-8">
                  <input class="form-control" type="text" required value="<?php echo $fetchitem['productname']?>" name="productname"/>
                  <input type="hidden" name="userid" value="Admin" />
                  <input type="hidden" name="itemid" value="<?php echo $fetchitem['itemid']?>" />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Product Count</label>
                <div class="col-sm-8">
                  <input class="form-control" type="text" required value="<?php echo $fetchitem['itemcount']?>" name="itemcount"/>
                </div>
              </div>
               <div class="form-group row">
                <label class="col-sm-4 col-form-label">Category</label> 
                <div class="col-sm-8">
                <select name ="category" required class="browser-default custom-select">
                  <?php
                  $currentcateg = $fetchitem['category'];
                  require 'conn.php';
                  

                  $sql = $conn->prepare("SELECT DISTINCT(categoryname) FROM `category`");
                  $sql->execute();
                  while($fetch = $sql->fetch()){
                  ?>
                  <option value="<?php echo $fetch['categoryname']?>" <?php if($fetch['categoryname'] === $currentcateg){ echo "selected"; } ?>><?php echo $fetch['categoryname']?></option>
                  <?php } ?>
                </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Department</label> 
                <div class="col-sm-8">
                <select name ="department" required class="browser-default custom-select">
                  <?php
                  $c_dep = $fetchitem['departmentname'];
                  require 'conn.php';
                  $sqldep = $conn->prepare("SELECT * FROM `department`");
                  $sqldep->execute();
                  while($fetchdep = $sqldep->fetch()){
                  ?>
                  <option value="<?php echo $fetchdep['departmentname']?>" <?php if($c_dep === $fetchdep['departmentname']){ echo "selected"; } ?>><?php echo $fetchdep['departmentname']?></option>
                  <?php } ?>
                </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-12 col-form-label text-danger ml-2"><small>All fields are required!</small></label>
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" id="btnUpdate" name="updateprod" class="btn btn-primary btn-sm">Update Product</button>
              </div>
              </div>
            </div>  
          </form>
        </div>
      </div>
      </div>
      <?php } ?>

      <!--- END OF UPDATE PRODUCT MODAL --->
      <!----- START OF ADD PRODUCT MODAL ---->
      <div class="modal fade" id="AddProduct" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="POST" action="adminaddprod.php">
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
                  $sql = $conn->prepare("SELECT * FROM `admin` WHERE `adminid` = '".$_SESSION['adminid']."'");
                  $sql->execute();
                  $fetchuser = $sql->fetch();

                  ?>
                  <input class="form-control" type="text" required name="productname"/>
                  <input type="hidden" name="userid" value="<?php echo $fetchuser['adminid'] ?>-<?php echo $fetchuser['firstname'] ?>"/>
                </div>
              </div>
               <div class="form-group row">
                <label class="col-sm-4 col-form-label">Department</label> 
                <div class="col-sm-8">
                <select name ="department" required class="browser-default custom-select">
                  <?php
                  require 'conn.php';
                  $sql = $conn->prepare("SELECT * FROM `department`");
                  $sql->execute();
                  while($fetch = $sql->fetch()){
                  ?>
                  <option value="<?php echo $fetch['departmentname']?>"><?php echo $fetch['departmentname']?></option>
                  <?php } ?>
                </select>
                </div>
              </div>
               <div class="form-group row">
                <label class="col-sm-4 col-form-label">Category</label> 
                <div class="col-sm-8">
                <select name ="category" required class="browser-default custom-select">
                  <?php
                   require 'conn.php';
                    $sql = $conn->prepare("SELECT DISTINCT(categoryname) FROM `category`");
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