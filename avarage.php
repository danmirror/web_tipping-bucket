<?php
  require "config.php";

  // =========================database query============
  if (isset($_GET['cari'])){
    $cari = $_GET['cari'];
  
    $data = mysqli_query($konek,"SELECT * FROM iot_try WHERE data_sensor like '%".$cari."%' ");
  }
  else{
    $data = mysqli_query($konek,"SELECT * FROM iot_try");
  }
  $sensor=[];
  $time = [];

  $rows=[];
	while($row=mysqli_fetch_assoc($data)){
		$rows[]=$row;
  }
  // var_dump($rows);
  // exit;

  $day_arr = [];
  $data_sensor = [];
  $data_time = [];

  foreach($rows as $row){
    $time_data = strtotime($row["time"]);
    $day = date("d", $time_data+7*60*60);
   
    
    if (!in_array($day,$day_arr)){
      if(!empty($day_arr)){
        $max =  max($data_sensor);
        $sensor[] = $max ;
        $time[] = end($data_time);
      }
      $day_arr [] = $day;
    }
    $data_sensor[] = $row["data_sensor"];
    $data_time[] = date(" d-M-Y", $time_data+7*60*60);
  }
// var_dump($day_arr);





?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Avarage | BMKG</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
    

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading">
        <img src="image/bmkg.png" alt="" style="width: 170px;">   
      </div>
      <div class="list-group list-group-flush">
        <a href="/" class="list-group-item list-group-item-action bg-light">
          <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="/avarage.php" class="list-group-item list-group-item-action bg-light">
          <i class="fas fa-chart-bar"></i> Avarage RR
        </a>
        <a href="/location.php" class="list-group-item list-group-item-action bg-light">
          <i class="fas fa-map-marker-alt"></i>  Location
        </a>
  
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn" id="menu-toggle">
          <i class="fa fa-bars" aria-hidden="true"></i>
        </button>

        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button> -->
        
        <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
          
          <ul class="navbar-nav ml-auto ">
            <form class="form-inline my-2 my-lg-0" action="" method="GET">
              <input class="form-control mr-sm-2" name="cari" type="search" placeholder="Cari berdasarkan jam" aria-label="Search">
              <button class="btn btn-outline-success my-2 "  type="submit">Search</button>
            </form>
           
          </ul>
        <!-- </div> --> 
      </nav>

      <div class="container">
        <h1 class="mt-2 title">Avarage in Day</h1>
          <div class="chart">
            <canvas id="chart"></canvas>
          </div>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>
  <!-- Bootstrap core JavaScript -->
 
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });



    // ================chart===========
    var barChartData_hour = 
        {
            labels:<?php echo json_encode($time) ?> ,
            datasets: [{
                type: 'line',
                label: 'sensor',
                id: "y-axis-0",
                borderColor: "blue",
                data: <?= json_encode($sensor) ?>
            },
            ]
        };
        var options = 
      {
          
        //   responsive: true,
          // maintainAspectRatio: false,
          title: {
                  display: true,
                  text: 'tipping bucket',
                  position: 'left'
              },
            // tooltips: {
            //   mode: 'label'
            // },
            
            scales: {
                yAxes: [{
                    stacked: true,
                    position: "left",
                    id: "y-axis-0",
                }],
                xAxes: [{
                }],
             }
      };
      Chart.Line('chart', {
          data: barChartData_hour,
          options: options,
        });
  </script>

</body>

</html>
