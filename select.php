<?php 
  session_start(); 

  if(ISSET($_GET['logout'])){
    session_destroy();
  }

  if(ISSET($_GET['logoutadmin'])){
    session_destroy();
  }

  if(ISSET($_SESSION['User'])){
    header("location:inventory.php");
  }

    if(ISSET($_SESSION['Useradmin'])){
    header("location:adminprev.php");
  }

?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    <link rel="stylesheet" href="css/animate.css">
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
	</head>
	<body>
		<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
  			<a class="navbar-brand lead" href="index.php">Inventory Management System</a>
  			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
  			</button>
  			<div class="collapse navbar-collapse" id="navbarNav">
  				<div class="container-fluid">
    			<ul class="navbar-nav justify-content-end">
             
        			<li class="nav-item">
                <!-- <a class="btn btn-primary btn-sm text-white" data-toggle="collapse" data-target="#AdminLogin">Admin Log-in</a> -->
        				<a class="btn btn-primary btn-sm text-white" href="index.php">Go Back</a>
      				</li>
    			</ul>
    			</div>
  			</div>
		</nav>
    <br><br><br>
    <div class="container mt-2">
      <div class="row justify-content-md-center">
        <!---- USER INFORMATION ---->
        <div class="col-lg-3 shadow-sm p-3 mb-5 card" style="width: 18rem;">
        <img class="card-img-top mx-auto mt-2 rounded" src="images/unkown.png" data-holder-rendered=true; alt="Card image cap" style="height:190px; width:190px; display:block;">
        <h4 class="card-title text-center lead mt-4">User Information</h4>
        <div class="card-body">
          <a class="lead ml-3 mt-4 text-muted"><small><?php echo "Today is " . date("m-d-Y"); ?></small></a><br>
          <a class="lead ml-3 mt-4"><small>Full Name: </small></a><br>
          <a class="lead ml-3 mt-4"><small>Gender:  </small></a><br>
          <a class="lead ml-3 mt-4"><small>Department:  </small></a><br><br>
          <button class="btn btn-primary btn-sm ml-3 mt-1" data-toggle="modal" disabled data-target="#update<?php echo $fetch['userid']?>">Edit Profile</a>
        </div>
        </div>
          <div class="col-lg-3 ml-5 shadow-sm p-3 mb-5 card">
          <h3 class="card-title text-center lead mt-3">Please Log-in</h3>
          <?php if(@$_GET['Empty'] == true){ ?>

          <div class="alert alert-danger text-center" role="alert">
            Please fill-in the fields!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <?php } else if(@$_GET['Success'] == true) { ?>

          <div class="alert alert-success text-center" role="alert">
            Success! You can now Log-in.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <?php } ?>

          <?php if(@$_GET['Invalid'] == true) { ?>

          <div class="alert alert-danger text-center" role="alert">
            Username or Password Incorrect!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <?php } ?>

          <hr><br>
          <form method="POST" action="process.php">
          <div class="form-group">
              <label for="Email">Username</label>
              <input type="text" class="form-control form-control-sm" id="Email" name="username" placeholder="Enter Username">
          </div>
          <div class="form-group">
              <label for="Password">Password</label>
              <input type="password" class="form-control form-control-sm" name="password" id="Password" placeholder="Enter Password">
          </div><br><br><br>
          <a class="btn text-primary font-italic font-weight-light" data-toggle="modal" data-target="#SignUp"><small>Don't have an account? Sign-Up</small></a>
          <hr>
          <div class="row justify-content-end">
              <button type="submit" name="Login" class="btn btn-primary btn-sm mb-4 mr-4">Log-In</button>
          </div>
          </form>
          </div>
          <!--- ADMIN LOGIN --->
          <div class="col-lg-3 ml-5 shadow-sm p-3 mb-5 card collapse" id="AdminLogin">
              <img class="card-img-top mx-auto mt-2" src="images/unkown.png" data-holder-rendered=true; alt="Card image cap" style="height:150px; width:150px; display:block;">
          <h3 class="card-title text-center lead mt-3">Admin Log-in</h3>
          <?php if(@$_GET['AdminEmpty'] == true){ ?>

          <div class="alert alert-danger text-center" role="alert">
            Please fill-in the fields!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <?php } else if(@$_GET['AdminInvalid'] == true) { ?>

          <div class="alert alert-warning text-center" role="alert">
            Invalid Username or Password.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <?php } ?>

          <?php  if(@$_GET['AdminAccountDeleted'] == true) { ?>

          <div class="alert alert-danger text-center" role="alert">
            Admin Account Deleted.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <?php } ?>

          <hr>
          <form method="POST" action="adminprocess.php">
          <div class="form-group">
              <label for="Email">Username</label>
              <input type="text" class="form-control form-control-sm" id="Email" name="username" placeholder="Enter Username">
          </div>
          <div class="form-group">
              <label for="Password">Password</label>
              <input type="password" class="form-control form-control-sm" name="password" id="Password" placeholder="Enter Password">
          </div>
          <hr>
          <div class="row justify-content-end">
              <button type="submit" name="AdminLogin" class="btn btn-primary btn-sm mb-4 mr-4">Log-In</button>
          </div>
          </form>
          </div>
        </div>
    </div>
    <div class="modal fade" id="SignUp" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="POST" action="add.php">
            <div class="modal-header">
              <h5 class="modal-title">Sign-Up</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>  
            <div class="modal-body">
              <div class="container">
              <?php if(@$_GET['Error'] == true) { ?>
                <div class="alert alert-danger text-center" role="alert">
                   Error! Password confirmation incorrect.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <?php } ?>
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
                <label class="col-sm-3 col-form-label">Role</label>
                <div class="col-sm-8">
                  <select name ="role" required class="browser-default custom-select">
                    <option value="Inventory Clerk">Inventory Clerk</option>
                    <option value="Sales Clerk">Sales Clerk</option>
                  </select>
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
                  <input class="form-control" type="password" required id="password" name="password"/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Confirm Password</label> 
                <div class="col-sm-8">
                  <input class="form-control" type="password" required id="confirm_password" name="confirm_password"/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Department</label> 
                <div class="col-sm-8">
                  <input class="form-control" type="text" required name="department"/>
<!--                 <select name ="department" required class="browser-default custom-select">
                  <?php
                  //require 'conn.php';
                  //$sql = $conn->prepare("SELECT * FROM `department`");
                  //$sql->execute();
                  //while($fetch = $sql->fetch()){
                  ?>
                  <option value="<?php //echo $fetch['departmentname']?>"><?php //echo $fetch['departmentname']?></option>
                  <?php //} ?>
                </select> -->
                </div>
              </div>
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="btnSave" name="save" class="btn btn-primary" disabled="disabled">Save</button>
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

  <script type="text/javascript">
  (function ($, window, document) {
      $(function () { 
          $("form input").on({
              "keyup": function () {
                  var pass = $('#password').val();
                  var confirmPass = $('#confirm_password').val();
                  var saveButton = $("#btnSave");
                  var dialog = $("#dialog");
                  if (pass == confirmPass && pass != "" && confirmPass != "") {
                      saveButton.removeAttr('disabled');
                      dialog.removeAttr('value');
                  } 
                  else {
                      saveButton.attr('disabled', 'disabled');
                  }
              }
          });
      });
  }(window.jQuery, window, document));
  </script>
</html>