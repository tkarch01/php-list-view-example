<?php
//coinview.php - shows details of a single coin
?>
<?php include 'includes/config.php';?>
<?php

//process querystring here
if(isset($_GET['id']))
{//process data
	//cast the data to an an interger, for security purposes
	$id = (int)$_GET['id'];

}else{//redirect ot safe page (if data is wrong)
	header('Location:coinlist.php');

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
	echo '<img src = "uploads/coin' . $id . '.jpg" alt = "' . $pictureName . '" /><br />';
	
	
	//START CODE SNIPPET #1 (goes into view page) --------------
//<?php

    if(startSession() && isset($_SESSION["AdminID"]))
        {# only admins can see 'peek a boo' link:
            echo '<p align="center"><a href="' . VIRTUAL_PATH . 'upload_form.php?' . $_SERVER['QUERY_STRING'] . '">UPLOAD IMAGE</a></p>';
            /*
            # if you wish to overwrite any of these options on the view page, 
            # you may uncomment this area, and provide different parameters:						
            echo '<div align="center"><a href="' . VIRTUAL_PATH . 'upload_form.php?' . $_SERVER['QUERY_STRING']; 
            echo '&imagePrefix=customer';
            echo '&uploadFolder=upload/';
            echo '&extension=.jpg';
            echo '&createThumb=TRUE';
            echo '&thumbWidth=50';
            echo '&thumbSuffix=_thumb';
            echo '&sizeBytes=100000';
            echo '">UPLOAD IMAGE</a></div>';
            */						

        }
        if(isset($_GET['msg']))
        {# msg on querystring implies we're back from uploading new image
            $msgSeconds = (int)$_GET['msg'];
            $currSeconds = time();
            if(($msgSeconds + 2)> $currSeconds)
            {//link only visible once, due to time comparison of qstring data to current timestamp
                echo '<p align="center"><script type="text/javascript">';
                echo 'document.write("<form><input type=button value=\'IMAGE UPLOADED! CLICK TO REFRESH PAGE!\' onClick=history.go()></form>")</scr';
                echo 'ipt></p>';
            }
        }
//? >      

	
	
	
	
	
	echo 'Coin: <b>' . $coin . '</b> <br />';
	echo 'First Minted: <b>' . $dateStarted . '</b> <br />';
	echo 'Last Minted: <b>' . $dateEnded . '</b> <br />';
	echo '</p>';		
}else{//no data showing up-deal with it
	echo $Feedback;
}

	echo'</p><a href="coins.php"><h2>Go Back</h2></a></p>';

//Release web server resources
@mysqli_free_result($result);

mysqli_close($iConn);

?>
<?php include 'includes/footer.php';?>


