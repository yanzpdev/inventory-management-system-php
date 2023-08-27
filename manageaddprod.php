<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['addprod'])){
		try{
			$productname = $_POST['productname'];
			$category = $_POST['category'];
			$departmentname = $_POST['departmentname'];
			$itemcount = $_POST['itemcount'];
			$userid = $_POST['userid'];
			$itemcountx = '0';

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$sql = "SELECT productname, itemcount FROM sales";
			$result = $conn->query($sql);


			if ($result->rowCount() > 0) {
				while($row = $result->fetch(PDO::FETCH_ASSOC)) {
					$stmt = $conn->prepare("SELECT * FROM inventory WHERE productname=?");
					$stmt->execute([$productname]); 
					$user = $stmt->fetch();
					if($user) {
						$headerlink = "location:manageprod.php?ProductExisting=Product already exists in the database!";
						echo "a";
						break;
					}

					else {
						$sql = "INSERT INTO `inventory` (`productname`, `category`, `itemcount`, `userid`, `departmentname`, `itemcountx`) VALUES ('$productname', '$category', '$itemcount', '$userid', '$departmentname', '$itemcountx')";
						$conn->exec($sql);
						$headerlink = "location:manageprod.php?ProductAdded=Product Successfully Added!";
						echo "b";
						break;
					}
				}
			}

			else {
				$sql = "INSERT INTO `inventory` (`productname`, `category`, `itemcount`, `userid`, `departmentname`, `itemcountx`) VALUES ('$productname', '$category', '$itemcount', '$userid', '$departmentname', '$itemcountx')";
				$conn->exec($sql);
				$headerlink = "location:manageprod.php?ProductAdded=Product Successfully Added!";
				echo "c";
			}

		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
		$conn = null;
		header($headerlink);
	}
	
?>
