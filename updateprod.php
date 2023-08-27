<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['updateprod'])){
		try{
			$userid = $_POST['userid'];
			$itemid = $_POST['itemid'];
			$productname = $_POST['productname'];
			$category = $_POST['category'];
			$itemcount = $_POST['itemcount'];
			$department = $_POST['departmentname'];
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE `inventory` SET `productname` = '$productname', `category` = '$category', `itemcount` = '$itemcount', `userid` = '$userid', `departmentname` = '$department' WHERE `itemid` = '$itemid' ";
			$conn->exec($sql);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
		$conn = null;
		header('location:manageprod.php?ProductUpdated=Product has been updated!');
	}
?>
