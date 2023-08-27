<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['addcount'])){
		try{
			$itemid = $_POST['itemid'];
			$productname = $_POST['productname'];
			$category = $_POST['category'];
			$departmentname = $_POST['departmentname'];
			$itemcount = $_POST['itemcount'];
			$itemcount2 = $_POST['itemcount2'];
			$userid = $_POST['userid'];
			$itemcount3 = intval($itemcount) + intval($itemcount2);


			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE `inventory` SET  `productname` = '$productname', `category` = '$category', `itemcount` = '$itemcount3', `userid` = '$userid', `departmentname` = '$departmentname' WHERE `itemid` = '$itemid' ";
			$conn->exec($sql);
			$sql2 = "UPDATE `sales` SET  `itemcountx` = '$itemcount3' WHERE `itemid` = '$itemid' ";
			$conn->exec($sql2);
		}

		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		$conn = null;
		header("location:manageprod.php");
	}
	
?>
