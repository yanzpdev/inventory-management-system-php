<?php
	// if(ISSET($_GET['id'])){
	// 	require_once 'conn.php';
	// 	$itemid = $_GET['id'];
	// 	$sql = $conn->prepare("DELETE from `deleted_items` WHERE `itemid`='$itemid'");
	// 	$sql->execute();
	// 	header('location:managedeletedprods.php');
	$productname = $_POST['productname'];
	$category = $_POST['category'];
	$departmentname = $_POST['departmentname'];
	$itemcount = $_POST['itemcount'];
	$itemcount2 = $_POST['itemcount2'];
	$itemcountx = $_POST['itemcountx'];
	$userid = $_POST['userid'];
	$itemid = $_POST['itemid'];
	$itemcount3 = intval($itemcount2) - intval($itemcount);
	$itemcount4 = intval($itemcountx) - intval($itemcount);
	require_once 'conn.php';
	if(ISSET($_POST['deleteprod'])){
		try{
			if ($itemcount4 <= 0) {
				echo "a";
				$productname = $_POST['productname'];
				$itemid = $_POST['itemid'];
				$sql = "DELETE FROM `sales` WHERE `productname` = '$productname' AND  `itemid` = '$itemid' ";
				$sql2 = "DELETE FROM `inventory` WHERE `productname` = '$productname' AND  `itemid` = '$itemid' ";
				$conn->exec($sql);
				$conn->exec($sql2);
			}

			else {
				if($itemcount3 <= 0) {
					$productname = $_POST['productname'];
					$itemid = $_POST['itemid'];
					$sql = "DELETE FROM `sales` WHERE `productname` = '$productname' AND  `itemid` = '$itemid' ";
					$sql2 = "UPDATE `inventory` SET `productname` = '$productname', `category` = '$category', `itemcount` = '$itemcount4', `itemcountx` = '$itemcount3', `userid` = '$userid', `departmentname` = '$departmentname' WHERE `productname` = '$productname' ";
					$conn->exec($sql);
					$conn->exec($sql2);
				}
				
				else {
					$itemcnt = $itemcountx - $itemcount;
					$sql = "UPDATE `sales` SET `productname` = '$productname', `category` = '$category', `itemcount` = '$itemcount3', `userid` = '$userid', `departmentname` = '$departmentname', `itemcountx` = '$itemcnt'  WHERE `productname` = '$productname' ";
					$sql2 = "UPDATE `inventory` SET `productname` = '$productname', `category` = '$category', `itemcount` = '$itemcount4', `itemcountx` = '$itemcount3', `userid` = '$userid', `departmentname` = '$departmentname' WHERE `productname` = '$productname' ";
					$conn->exec($sql);
					$conn->exec($sql2);
				}
			}
		}

		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		$conn = null;
		header("location:managedeletedprods.php?ProductDeleted=Product Successfully Marked as Sold");
	}
?>


