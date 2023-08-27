<?php
	session_start();
	require_once 'conn.php';
	if(ISSET($_POST['Login'])){
		if(empty($_POST['username']) || empty($_POST['password'])){
			header("location:select.php?Empty= Please Fill in the fields");
		}
		else{

			// Query admin 
			$sql=$conn->prepare("SELECT * FROM `admin` WHERE `username` = '".$_POST['username']."' AND `password` = '".$_POST['password']."'");
			$sql->execute();
			$fetch = $sql->fetch();
			if($fetch){
				$_SESSION['Useradmin'] = $fetch['firstname'];
				$_SESSION['adminid'] = $fetch['adminid'];
				header("location:adminprev.php");
			}
			else{
				// Query User
				$sql=$conn->prepare("SELECT * FROM `user` WHERE `username` = '".$_POST['username']."' AND `password` = '".$_POST['password']."'");
				$sql->execute();
				$fetch = $sql->fetch();
				if($fetch){
					$_SESSION['User'] = $fetch['firstname'];
					$_SESSION['Role'] = $fetch['role'];
					$_SESSION['userid'] = $fetch['userid'];
					$_SESSION['departmentname'] = $fetch['departmentname'];
					// $_SESSION['departmentname'] = $fetch['department'];
					header("location:inventory.php");
				}
				else{
					header("location:select.php?Invalid= Username or Password Incorrect!");
				}
			}
	
			
		}
	}
	else{
		echo 'Not Working';
	}
?>