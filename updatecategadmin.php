<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['updatecateg'])){
		try{
			$userid = $_POST['userid'];
			$categoryname = $_POST['categoryname'];
			$userid = $_POST['userid'];
			$categoryid = $_POST['categoryid'];
			$departmentname = $_POST['department'];
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE `category` SET `categoryname` = '$categoryname', `userid` = '$userid', `departmentname` = '$departmentname' WHERE `categoryid` = '$categoryid' ";
			$conn->exec($sql);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
		$conn = null;
		header('location:managecategory.php');
	}
?>
