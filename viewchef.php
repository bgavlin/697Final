<?php
include_once 'header.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);
?>

<div id="chefpage">
<?php   

//Retrieve selected chef
if (isset($_GET['Chef_ID'])) {
	$chefid = sanitizeMySQL($conn, $_GET['Chef_ID']);
	$query = "SELECT Chefs.*,Family_Members.* FROM Chefs NATURAL JOIN Family_Members WHERE Chefs.Chef_ID=".$chefid;
	$result = $conn->query($query);
	if (!$result) die ("Invalid chef id.");
	$rows = $result->num_rows;
    
//checks to see if chef id is valid    
	if ($rows == 0) {
        echo "<p class=\'error\'> No chef found with id of $chefid<br></p>";
	} 
//If valid, return chef's name and photo
    elseif ($rows > 0){
		while ($row = $result->fetch_assoc()) {
			echo '<div class=\'chef\'><h2 class=\'subtitle\'>'.$row['First_Name']." ".$row['Last_Name'].'</h2>';
			echo "<div><img src=\"".$row['Image_Path']."\" alt=\"chef photo\"width=\"250\" height=\"250\"></img></div></div>";
            
            $query2 ="SELECT Recipe_ID, Title FROM Recipe_Information WHERE Chef_ID=".$chefid;
            
            $result2 = $conn->query($query2);
            if (!$result2) die ("Invalid chef id.");
	        $rows = $result2->num_rows;
            echo "<div class=\"recipes\">";
//            echo "<h4>Recipes:</h4>";
            echo"<ul>";
            while ($row = $result2->fetch_assoc()) {
                echo "<li><a href=\"viewrecipe.php?Recipe_ID=".$row['Recipe_ID']."\">".$row["Title"]."</a></li>";
		}
            echo"</ul></div>";
	}
} else {
	echo "<p class=\'error'\> No chef id passed </p>";
}
}
?>

</div>
    
<?php

include_once 'footer.php';

function sanitizeString($var)
{
	$var = stripslashes($var);
	$var = strip_tags($var);
	$var = htmlentities($var);
	return $var;
}
function sanitizeMySQL($connection, $var)
{
	$var = $connection->real_escape_string($var);
	$var = sanitizeString($var);
	return $var;
}
    
?>