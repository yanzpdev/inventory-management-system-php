<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['updatecateg'])){
		try{
			$categoryname = $_POST['categoryname'];
			$userid = $_POST['userid'];
			$departmentname = $_POST['department'];

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO `category` (`categoryname`, `userid`, `departmentname`) VALUES ('$categoryname', '$userid', '$departmentname')";
			$conn->exec($sql);

		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
		$conn = null;
		header("location:managecategory.php?CategoryAdded=Category Successfully Added!");
	}
	
?>
