<?php
include 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Fans Electronics IOT</title>
</head>
<body>
<button onclick="window.location.href='connect.php?data=1&nilai=1'">ON</button>
<button onclick="window.location.href='connect.php?data=1&nilai=0'">OFF</button>
<?php
$data = mysqli_query($mysqli, "SELECT nilai FROM led WHERE data='1'");
if($val=mysqli_fetch_array($data)){
$hasil = $val['nilai'];
if($hasil == 1){
$status = "ON";
}
else {
$status = "OFF";
}
echo "LED1 ";
echo $status;
}
?>
</body>
</html>