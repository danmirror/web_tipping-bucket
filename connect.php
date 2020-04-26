<?php
   include 'config.php';
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $var1 =$_POST["data1"];
      $var2 =$_POST["data2"];
      mysqli_query($konek, "INSERT INTO iot_try(data_sensor,data_real) VALUES('$var1','$var2')");
      echo "post";
   }
   else{
      $var1 = $_GET['data1'];
      $var2 = $_GET['data2'];
      mysqli_query($konek, "INSERT INTO iot_try(data_sensor,data_real) VALUES('$var1','$var2')");
      echo "get";
   }
?>