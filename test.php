<?php
session_start();
if(ISSET($_SESSION['User'])) {
    require 'conn.php';

    $sql = $conn->prepare("SELECT * FROM `user` WHERE `userid` = '".$_SESSION['userid']."'");
    $sql->execute();
    $fetchuser = $sql->fetch();

    $sql = $conn->prepare("SELECT * FROM `sales` WHERE `departmentname` = '".$fetchuser['department']."'");
    $sql->execute();
    $fetch = $sql->fetch();
    if ($fetch == null) {
        echo "null";
    }

    else {
        echo "not null";
    }
    while($fetch = $sql->fetch()){
        $arr = array();
        array_push($arr, $fetch['itemid']);
        print_r($arr);
    }
}
                  <?php
                   require 'conn.php';

                    $sql = $conn->prepare("SELECT * FROM `user` WHERE `userid` = '".$_SESSION['userid']."'");
                    $sql->execute();
                    $fetchuser = $sql->fetch();

                    $sql = $conn->prepare("SELECT * FROM `sales` WHERE `departmentname` = '".$fetchuser['department']."'");
                    $sql->execute();
                    while($fetch = $sql->fetch()){

                    }

                  ?>
?>