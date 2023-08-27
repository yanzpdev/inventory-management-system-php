<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['adddeletedprod'])){
		try{
			$productname = $_POST['productname'];
			$category = $_POST['category'];
			$departmentname = $_POST['departmentname'];
			$itemcount = $_POST['itemcount'];
			$itemcountx = $_POST['itemcountx'];
			//$itemcountx2 = intval($_POST['itemcount']) + intval($_POST['itemcountx2']);
			$itemcount2 = $_POST['itemcount2'];
			$userid = $_POST['userid'];
			$itemid = $_POST['itemid'];
			$itemcount3 = intval($itemcount2) - intval($itemcount);


			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$sql = "SELECT itemid, productname, itemcount FROM sales";
			$result = $conn->query($sql);

			if ($result->rowCount() > 0) {
			  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
					//$stmt = $conn->prepare("SELECT * FROM sales WHERE productname=?");
					//$stmt->execute([$productname]); 
					$stmt = $conn->prepare("SELECT * FROM sales WHERE itemid=?");
					$stmt->execute([$itemid]); 
					$user = $stmt->fetch();
					if ($user) {
						//if($productname == $row['productname']) {
						if($itemid == $row['itemid']) {
							$itemcount4 = intval($row['itemcount']) + intval($itemcount);
						}

					    if($itemcount3 == 0) {
							$sql = "UPDATE `sales` SET `itemid` = '$itemid', `productname` = '$productname', `category` = '$category', `itemcount` = '$itemcount4', `userid` = '$userid', `departmentname` = '$departmentname', `itemcountx` = '$itemcountx' WHERE `itemid` = '$itemid' ";
							//$sql2 = "DELETE FROM `inventory` WHERE `productname` = '$productname' AND  `itemid` = '$itemid' ";
							$conn->exec($sql);
							$sql2 = "UPDATE `inventory` SET `itemid` = '$itemid', `productname` = '$productname', `category` = '$category', `itemcount` = '$itemcountx', `userid` = '$userid', `departmentname` = '$departmentname', `itemcountx` = '$itemcount4' WHERE `itemid` = '$itemid' ";
							$conn->exec($sql2);
							
							//$conn->exec($sql2);
						}

						else {
							$sql = "UPDATE `sales` SET `itemid` = '$itemid', `productname` = '$productname', `category` = '$category', `itemcount` = '$itemcount4', `userid` = '$userid', `departmentname` = '$departmentname', `itemcountx` = '$itemcountx' WHERE `itemid` = '$itemid' ";
							//$sql2 = "UPDATE `inventory` SET `productname` = '$productname', `category` = '$category', `itemcount` = '$itemcount3', `userid` = '$userid', `departmentname` = '$departmentname' WHERE `itemid` = '$itemid' ";
							$conn->exec($sql);
							$sql2 = "UPDATE `inventory` SET `itemid` = '$itemid', `productname` = '$productname', `category` = '$category', `itemcount` = '$itemcountx', `userid` = '$userid', `departmentname` = '$departmentname', `itemcountx` = '$itemcount4' WHERE `itemid` = '$itemid' ";
							$conn->exec($sql2);
							
							//$conn->exec($sql2);
						}
					}

					else {
					    if($itemcount3 == 0) {
							$sql = "INSERT INTO `sales` (`itemid`, `productname`, `category`, `itemcount`, `userid`, `departmentname`, `itemcountx`) VALUES ('$itemid', '$productname', '$category', '$itemcount', '$userid', '$departmentname', '$itemcountx')";
							//$sql2 = "DELETE FROM `inventory` WHERE `productname` = '$productname' AND  `itemid` = '$itemid' ";
							$conn->exec($sql);
							//$conn->exec($sql2);
							$sql2 = "UPDATE `inventory` SET `itemid` = '$itemid', `productname` = '$productname', `category` = '$category', `itemcount` = '$itemcountx', `userid` = '$userid', `departmentname` = '$departmentname', `itemcountx` = '$itemcount4' WHERE `itemid` = '$itemid' ";
							$conn->exec($sql2);
							break;
						}

						else {
							echo "d";
							$sql = "INSERT INTO `sales` (`itemid`, `productname`, `category`, `itemcount`, `userid`, `departmentname`, `itemcountx`) VALUES ('$itemid', '$productname', '$category', '$itemcount', '$userid', '$departmentname', '$itemcountx')";
							//$sql2 = "UPDATE `inventory` SET `productname` = '$productname', `category` = '$category', `itemcount` = '$itemcount3', `userid` = '$userid', `departmentname` = '$departmentname' WHERE `itemid` = '$itemid' ";
							$conn->exec($sql);
							$sql2 = "UPDATE `inventory` SET `itemid` = '$itemid', `productname` = '$productname', `category` = '$category', `itemcount` = '$itemcountx', `userid` = '$userid', `departmentname` = '$departmentname', `itemcountx` = '$itemcount4' WHERE `itemid` = '$itemid' ";
							$conn->exec($sql2);
							echo $itemid;
							//$conn->exec($sql2);
							break;
						}
					} 
				}
			} 

			else {
			  	if($itemcount3 == 0) {

					$sql = "INSERT INTO `sales` (`itemid`, `productname`, `category`, `itemcount`, `userid`, `departmentname`, `itemcountx`) VALUES ('$itemid', '$productname', '$category', '$itemcount', '$userid', '$departmentname', '$itemcountx')";
					//$sql2 = "DELETE FROM `inventory` WHERE `productname` = '$productname' AND  `itemid` = '$itemid' ";
					$conn->exec($sql);
					$sql2 = "UPDATE `inventory` SET `itemid` = '$itemid', `productname` = '$productname', `category` = '$category', `itemcount` = '$itemcountx', `userid` = '$userid', `departmentname` = '$departmentname', `itemcountx` = '$itemcount' WHERE `itemid` = '$itemid' ";
					$conn->exec($sql2);
					echo "e";	
					//$conn->exec($sql2);
				}

				else{
					$sql = "INSERT INTO `sales` (`itemid`, `productname`, `category`, `itemcount`, `userid`, `departmentname`, `itemcountx`) VALUES ('$itemid', '$productname', '$category', '$itemcount', '$userid', '$departmentname', '$itemcountx')";
					//$sql2 = "UPDATE `inventory` SET `productname` = '$productname', `category` = '$category', `itemcount` = '$itemcount3', `userid` = '$userid', `departmentname` = '$departmentname' WHERE `itemid` = '$itemid' ";
					$conn->exec($sql);
					$sql2 = "UPDATE `inventory` SET `itemid` = '$itemid', `productname` = '$productname', `category` = '$category', `itemcount` = '$itemcountx', `userid` = '$userid', `departmentname` = '$departmentname', `itemcountx` = '$itemcount' WHERE `itemid` = '$itemid' ";
					$conn->exec($sql2);

					echo "f";
					//$conn->exec($sql2);
				}
			}

		}

		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		$conn = null;
		//header("location:manageprod.php?ProductTransferred=Product Successfully Transferred");
	}
	
?>
