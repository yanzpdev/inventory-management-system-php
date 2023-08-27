<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['adddep'])){
		try{
			$departmentname = $_POST['departmentname'];

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO `department` (`departmentname`) VALUES ('$departmentname')";
			$conn->exec($sql);

		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
		$conn = null;
		header("location:managedepartments.php?DepartmentAdded=Department Successfully Added!");
	}
	
?>

