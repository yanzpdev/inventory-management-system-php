<?php
	require_once 'conn.php';
	
	if(ISSET($_POST['admincred'])){
		try{
			$adminid = $_POST['adminid'];
			$username = $_POST['username'];
			$oldpass = $_POST['oldpass'];
			$newpass = $_POST['newpass'];
			$confirmpass = $_POST['confirmpass'];

			$sql = $conn->prepare("SELECT * FROM `admin` WHERE `password` = '$oldpass' AND `adminid` = '$adminid'");
			$sql->execute();
            $fetch = $sql->fetch();
            echo $fetch;
			if($fetch){
			  if($newpass === $confirmpass){
			  	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "UPDATE `admin` SET `username` = '$username', `password` = '$newpass' WHERE `adminid` = '$adminid' ";
				$conn->exec($sql);

				$conn = null;
				header('location:adminprev.php?Success=Account credentials has been updated!');
			  }
			  else{
			  	header('location:adminprev.php?Error=Password did not Match');
			  }
			}
			else{
				header('location:adminprev.php?WrongPass=Old Password is Incorrect');
			}

			
			
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}

?>
