<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['save'])){
		try{
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$gender = $_POST['gender'];
			$role = $_POST['role'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$confirm_password = $_POST['confirm_password'];
			$department = $_POST['department'];

			if($password !== $confirm_password) {
				return header("location:select.php?Error=Confirm Password is incorrect!");
			}

			$sql=$conn->prepare("SELECT * FROM `department` WHERE `departmentname` = '".$_POST['department']."'");
			$sql->execute();
			$fetch = $sql->fetch();
		
			$departmentid = $fetch['departmentid'];
					
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO `user` (`firstname`, `lastname`, `gender`, `role`, `username`, `password`, `department`, `departmentid`) VALUES ('$firstname', '$lastname', '$gender', '$role', '$username', '$password', '$department', '$departmentid')";
			$conn->exec($sql);

			

		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
		$conn = null;
		header("location:select.php?Success=You can now Login");
	}
	
?>
