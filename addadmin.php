<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['save'])){
		try{
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$gender = $_POST['gender'];
			$username = $_POST['username'];
			$password = $_POST['password'];

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO `admin` (`firstname`, `lastname`, `gender`, `username`, `password`) VALUES ('$firstname', '$lastname', '$gender', '$username', '$password')";
			$conn->exec($sql);

			

		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
		$conn = null;
		header("location:adminprev.php?AdminSuccess=You can now Login");
	}
	
?>
