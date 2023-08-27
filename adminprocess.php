<?php
	session_start();
	require_once 'conn.php';
	if(ISSET($_POST['AdminLogin'])){
		if(empty($_POST['username']) || empty($_POST['password'])){
			header("location:select.php?AdminEmpty= Please Fill in the fields");
		}
		else{
			$sql=$conn->prepare("SELECT * FROM `admin` WHERE `username` = '".$_POST['username']."' AND `password` = '".$_POST['password']."'");
			$sql->execute();
			$fetch = $sql->fetch();
			if($fetch){
				$_SESSION['Useradmin'] = $fetch['firstname'];
				$_SESSION['adminid'] = $fetch['adminid'];
				header("location:adminprev.php");
			}
			else{
				header("location:select.php?AdminInvalid= Username or Password Incorrect!");
			}
			
		}
	}
	else{
		echo 'Not Working';
	}
?>