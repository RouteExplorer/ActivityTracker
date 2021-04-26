<?php
session_start();

if(!(isset($_SESSION['username'])))
{
    header("Location: login.php");
}
require('connect.php');

$loggedInUsername = $_SESSION['username'];



 
?>
<!DOCTYPE html>
<meta charset="UTF-8">
<html lang="en">
    <head>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <title>Progress</title>
        <link rel="stylesheet" href="mystyle.css">
<?php

# Grab the data2 from the database
$query = "SELECT * FROM `userdata` WHERE username ='$loggedInUsername' ORDER BY timestamp DESC";

$result = mysqli_query($connection, $query);
$calChartData = [['timestamp','calories'],];
$disChartData = [['timestamp','distance',],]; 
$speedChartData = [['timestamp','speed',],];
$lenArr = 0;
$stampArr = array();
$timeArr = array();
$disArr = array();
$speedArr = array();
$caloriesArr = array();

if ($result->num_rows > 0) {
	while ($row =  mysqli_fetch_array($result))
	{
		$calChartData[] = [$row['timestamp'],(int)$row['calories']];
		$disChartData[] = [$row['timestamp'],(int)$row['distance']];
		$speedChartData[] = [$row['timestamp'],(int)$row['speed']];
		
		array_push($stampArr,$row['timestamp']);
		array_push($timeArr,$row['time']);
		array_push($disArr,$row['distance']);
		array_push($speedArr,$row['speed']);
		array_push($caloriesArr,$row['calories']);
		
		$lenArr = count($stampArr);
	}
}
?>


        
    <script type="text/javascript">
            var timeArray = <?php echo json_encode($timeArr); ?>;
			var stampArray = <?php echo json_encode($stampArr); ?>;
			var disArray = <?php echo json_encode($disArr); ?>;
			var speedArray = <?php echo json_encode($speedArr); ?>;
			var caloriesArray = <?php echo json_encode($caloriesArr); ?>;
			var len = <?php echo $lenArr; ?>;
    </script>
	<script type="text/javascript" src="Scripts/progressNextPrev.js"></script>
		 
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" >
		var calChartData =  <?php echo json_encode($calChartData);?>;
		var disChartData = <?php echo json_encode($disChartData);?>;
		var speedChartData = <?php echo json_encode($speedChartData);?>;
	</script>
	<script type="text/javascript" src="Scripts/googlechart.js"></script>

    </head>

    <body>
        <h2 id="historyHeading">History</h2>
		
	<div id="container"> 
	
	    <div class="boxes" id="calorieChart"></div>
		<div class="boxes" id="distanceChart"></div> 
		<div class "boxes" id="speedChart"></div>   
        
     </div>

	<div class="runInfoBody">
            <div class="runInfoButtons">
               <script src="https://unpkg.com/tlx/browser/tlx.js"></script>
               <div id="historyBtn">

                <p id="result">Time:</p>
                <p id="result1">Date Time:</p>
                <p id="result3">Average Speed(kph):</p>
                <p id="result2">Distance(km):</p>
                <p id="result4">Calories Burnt:</p>


                <input type="button" class="cycle" id="prev" value="Previous">
                <input type="button" class="cycle" id="next" value="Next">
                </div>
            </div>

               


  </head>
 
    

	</div>
    </body>

    <div class="navBar">
  <button id="weight" onclick="window.location.href='exercise.html'"><img id="weightButton" src="Assets\Images\weightButton.svg" alt="weightButton" width="100%" height="100%"></button>
  <button id="overallProgress" onclick="window.location.href='progress.php'"><img id="progressbutton" src="Assets/Images/graphButton.svg" alt="overallProgress" width="100%" height="100%"></button>
  <button id="home" onclick="window.location.href='home.php'"><img id="homeButton" src="Assets\Images\homeButton.svg" alt="Home" width="100%" height="100%"></button>
  <button id="runInfo" onclick="window.location.href='runInfo.php'"><img id="runButton" src="Assets/Images/runInfoButton.svg" alt="Run Info"  width="100%" height="100%"></button>
  <button id="settings" onclick="window.location.href='settings.html'"><img id="settingsButton" src="Assets/Images/settingsButton.svg" alt="Settings"  width="100%" height="100%"></button>
</div>

	
</html>