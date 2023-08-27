<?php

   if(isset($_POST['search']))
   {
       $value = $_POST['value'];
       // search in all table columns
       // using concat mysql function
       $query = "SELECT * FROM `user` WHERE CONCAT(`firstname`, `lastname`, `gender`, `username`, `role`, `department`) LIKE '%".$value."%'";
       $search_result = filterTable($query);
    
   }
   else {
    $query = "SELECT * FROM `users`";
    $search_result = filterTable($query);
   }

   // function to connect and execute the query
   function filterTable($query)
   {
       $connect = mysqli_connect("localhost", "root", "", "equipment");
       $filter_Result = mysqli_query($connect, $query);
       return $filter_Result;
   }

?>