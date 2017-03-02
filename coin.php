<?php
//coin.php - shows details of a single coin
?>
<?php include 'includes/config.php';?>
<?php

//process querystring here
if(isset($_GET['id']))
{//process data
	//cast the data to an an interger, for security purposes
	$id = (int)$_GET['id'];

}else{//redirect ot safe page (if data is wrong)
	header('Location:coins.php');

}

$sql = "select * from Coins where CoinID = $id";
//we connect to the db here
$iConn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

//we extract the data here
$result = mysqli_query($iConn,$sql);

if(mysqli_num_rows($result) > 0)
{//show records

    while($row = mysqli_fetch_assoc($result))
    {	
		$coin = stripslashes($row['Coin']);
		$dateStarted = stripslashes($row['DateStarted']);
		$dateEnded = stripslashes($row['DateEnded']);
		$pictureName = stripslashes($row['PictureName']);
		$title = "Title Page for " . $coin;
		$pageID = $coin;
		$Feedback =''; //no feedbasck necessary
    }   
}else{//inform there are no records
    $Feedback = '<p>A penny saved is a penny earned.</p>';
}
?>

<?php include 'includes/header.php';?>
<h1><?=$pageID?></h1>
<?php

if($Feedback==""){//data exists, show  it
	echo '<p>';
	echo '<img src = "coinpics/' . $pictureName . '" alt = "picture" ><br />';
	echo 'Coin: <b>' . $coin . '</b> <br />';
	echo 'First Minted: <b>' . $dateStarted . '</b> <br />';
	echo 'Last Minted: <b>' . $dateEnded . '</b> <br />';
	echo '</p>';		
}else{//no data showing up-deal with it
	echo $Feedback;
}

	echo'</p><a href="coins.php">Go Back</a></p>';

//Release web server resources
@mysqli_free_result($result);

mysqli_close($iConn);

?>
<?php include 'includes/footer.php';?>


