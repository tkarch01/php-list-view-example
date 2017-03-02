<?php
//Coinlist.php - shows a list of customer data
?>
<?php include 'includes/config.php';?>
<?php include 'includes/header.php';?>
<h1><?=$pageID?></h1>
<?php
$sql = "select * from Coins";
//we connect to the db here
$iConn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

//we extract the data here
$result = mysqli_query($iConn,$sql);

if(mysqli_num_rows($result) > 0)
{//show records

    while($row = mysqli_fetch_assoc($result))
    {
        echo '<p>';
            echo '<a href="coinview.php?id=' . $row[CoinID] . '"><img src = "coinpics/' . $row[PictureName] . '" alt = "picture" width=50px heigth=50px> <b>' . $row['Coin'] . ' </a></b> ';
			
        echo 'Minted from ' . $row['DateStarted'] . ' to ' . $row['DateEnded'] . ' ';
	
		echo '</p>';
    }    

}else{//inform there are no records
    echo '<p>A Penny Saved is a Penny Earned</p>';
}
//Release web server resources
@mysqli_free_result($result);

mysqli_close($iConn);

?>
