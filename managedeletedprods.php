<?php
	session_start();
  echo "<br>";
  echo "<br>";
?>

<?php if(ISSET($_SESSION['User'])) { ?>

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
		<div class="row justify-content-md-center">
			<?php
						require 'conn.php';
						$sql = $conn->prepare("SELECT * FROM `user` WHERE `userid` = '".$_SESSION['userid']."'");
						$sql->execute();
						$fetch = $sql->fetch()
			?>
			<div class="col-lg-3 shadow p-3 mb-5 card" style="width: 18rem;">
				<img class="card-img-top mx-auto mt-2" src="<?php if($fetch['gender']==="Male"){ echo 'images/loginuser.png'; } else if($fetch['gender']==="Female") { echo 'images/girluser.png'; } ?>" data-holder-rendered=true; alt="Card image cap" style="height:190px; width:190px; display:block;">
				<h4 class="card-title text-center lead mt-4">User Information</h4>
				<div class="card-body">
					<a class="lead ml-3 mt-4 text-muted"><small><?php echo "Today is " . date("m-d-Y"); ?></small></a><br>
					<a class="lead ml-3 mt-4"><small>Full Name:  <?php echo $fetch['firstname'] ?> <?php echo $fetch['lastname'] ?></small></a><br>
					<a class="lead ml-3 mt-4"><small>Gender:  <?php echo $fetch['gender'] ?></small></a><br>
          <a class="lead ml-3 mt-4"><small>Role:  <?php echo $fetch['role'] ?></small></a><br>
					<a class="lead ml-3 mt-4"><small>Department:  <?php echo $fetch['department'] ?></small></a><br><br>
					<button class="btn btn-primary btn-sm ml-3 mt-1" data-toggle="modal" data-target="#update<?php echo $fetch['userid']?>">Edit Profile</a>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="row">
				<div class="col-md-10 shadow p-3 mb-3 ml-3 card">
					<h5 class="card-title text-center mt-2 text-primary">Sold Products</h5>
                <?php if(@$_GET['ProductAdded'] == true){ ?>

                <div class="alert alert-success text-center text-dark" role="alert">
                  Product has been added!
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <?php } ?>

                <?php if(@$_GET['ProductUpdated'] == true){ ?>

                <div class="alert alert-success text-center text-dark" role="alert">
                 Product Updated Successfully!
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <?php } ?>

                <?php if(@$_GET['ProductDeleted'] == true){ ?>

                <div class="alert alert-success text-center text-dark" role="alert">
                 Succesfully marked as sold.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <?php } ?>
					<div class="card-body" >
					<div class="row">
          <table class="table table-striped">
          <caption class="text-muted ml-2"><small>Items shown are from your Department only.</small></caption>
          <thead>
          <tr>
            <th>Product Name</th>
            <th>Category</th>
            <th>Item Count</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>

           <?php
            require_once'conn.php'; 
            $con = mysqli_connect('localhost', 'root');
            mysqli_select_db($con, 'equipment');

            $sql = $conn->prepare("SELECT * FROM `user` WHERE `userid` = '".$_SESSION['userid']."'");
            $sql->execute();
            $fetchuser = $sql->fetch();
            
            $page = "SELECT * FROM `sales` WHERE `departmentname` = '".$fetchuser['department']."'";
            $limit = 3;
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

             $sql = $conn->prepare("SELECT * FROM `sales` WHERE `departmentname` = '".$fetchuser['department']."' LIMIT ".$pagefirst_res.','.$limit);
            $sql->execute();

            while($fetch = $sql->fetch()){
          ?>
          <tr>
            <td><?php echo $fetch['productname']?></td>
            <td><?php echo $fetch['category']?></td>
            <td><?php echo $fetch['itemcount']?></td>
            <td>

<!--               <a class="btn btn-danger btn-sm" id="btnDelete" href="deleteprod.php?id=<?php echo $fetch['itemid']?>">&times; Remove Product</a> -->
              <button class="btn btn-danger btn-sm text-light" data-toggle="modal" data-target="#delete<?php echo $fetch['itemid']?>">&times; Mark as Sold
              </button>
            </td>
          </tr>
          
        <?php } ?>

          </tbody>
          </table>
          <?php 
            $con = mysqli_connect('localhost', 'root');
            mysqli_select_db($con, 'equipment');

            $page = "SELECT * FROM `sales` WHERE `departmentname` = '".$fetchuser['department']."'";
            $limit = 3;
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

          <div class="col-md-10">
          <nav aria-label="Page navigation">
          <ul class="pagination">
            <li class="page-item">
              <a class="page-link" href="managedeletedprods.php?page=<?= $prev; ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li class="page-item">
            <?php for($i = 1; $i<= $page_num; $i++) : ?>
              <li><a class="page-link" href="managedeletedprods.php?page=<?= $i; ?>"><?= $i; ?></a></li>
            <?php endfor; ?>
            <li class="page-item">
              <a class="page-link" href="managedeletedprods.php?page=<?= $next; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
          </nav>
          </div>
          <div class="container">
            <hr>
            <a class="btn btn-primary btn-sm" href="inventory.php">Go Back</a>
          </div>
      		</div>
				  </div>
				</div>
			</div>
		</div>
    <?php
            require 'conn.php';
            $sql = $conn->prepare("SELECT * FROM `user` WHERE `userid` = '".$_SESSION['userid']."'");
            $sql->execute();
            $fetch = $sql->fetch()
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

      <?php
            require 'conn.php';

            $sql = $conn->prepare("SELECT * FROM `user` WHERE `userid` = '".$_SESSION['userid']."'");
            $sql->execute();
            $fetchuser = $sql->fetch();

            $sqldep = $conn->prepare("SELECT * FROM `sales` WHERE `departmentname` = '".$fetchuser['department']."'");
            $sqldep->execute();
            while($fetch = $sqldep->fetch()){
        ?>
      <div class="modal fade show" id="delete<?php echo $fetch['itemid']?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="POST" action="deleteprod.php">
            <div class="modal-header">
              <h5 class="modal-title">Are you sure you want to mark this product as sold?</h5>
            </div>  
            <div class="modal-body">
              <div class="container">
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Product Name</label>
                <div class="col-sm-8">
                  <?php
                   $sql = $conn->prepare("SELECT * FROM `user` WHERE `userid` = '".$_SESSION['userid']."'");
                   $sql->execute();
                   $fetchuser = $sql->fetch();
                  ?>
                  <input class="form-control" type="text" required value="<?php echo $fetch['productname']?>" name="productname" readonly/>
                  <input type="hidden" name="userid" value="<?php echo $fetchuser['userid']?>" />
                  <input type="hidden" name="itemid" value="<?php echo $fetch['itemid']?>" />
                  <input type="hidden" name="departmentname" value="<?php echo $fetch['departmentname']?>" />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Product Count</label>
                <div class="col-sm-8">
                  <input class="form-control" type="number" min="1" max="<?php echo $fetch['itemcount']?>" required value="<?php echo $fetch['itemcount']?>" name="itemcount"/>
                  <input class="form-control" type="hidden" required value="<?php echo $fetch['itemcount']?>" name="itemcount2"/>
                  <input class="form-control" type="hidden" required value="<?php echo $fetch['itemcountx']?>" name="itemcountx"/>
                </div>
              </div>
               <div class="form-group row">
                <label class="col-sm-4 col-form-label" hidden>Category</label> 
                <div class="col-sm-8">
                <select name ="category" hidden required class="browser-default custom-select">
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
              <div class="modal-footer">
                 <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">No</button>
                <button type="submit" id="btnDelete" name="deleteprod" class="btn btn-primary btn-sm">Yes</button>
              </div>
              </div>
            </div>  
          </form>
        </div>
      </div>
      </div>
      <?php } ?>
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
