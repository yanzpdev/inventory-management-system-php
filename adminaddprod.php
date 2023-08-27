<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['addprod'])){
		try{
			$productname = $_POST['productname'];
			$category = $_POST['category'];
			$departmentname = $_POST['department'];
			$itemcount = $_POST['itemcount'];
			$userid = $_POST['userid'];

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO `inventory` (`productname`, `category`, `itemcount`, `userid`, `departmentname`) VALUES ('$productname', '$category', '$itemcount', '$userid', '$departmentname')";
			$conn->exec($sql);

		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
		$conn = null;
		header("location:manageproducts.php?ProductAdded=Product Successfully Added!");
	}
	
?>
