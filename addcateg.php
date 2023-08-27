<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['update'])){
		try{
			$categoryname = $_POST['categoryname'];
			$userid = $_POST['userid'];
			$departmentname = $_POST['departmentname'];

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO `category` (`categoryname`, `userid`, `departmentname`) VALUES ('$categoryname', '$userid', '$departmentname')";
			$conn->exec($sql);

		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
		$conn = null;
		header("location:inventory.php?CategoryAdded=Category Successfully Added!");
	}
	
?>
