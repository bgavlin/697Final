<?php
include_once 'header.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

if (isset($_GET['Chef_ID'])) {
	$chefid = sanitizeMySQL($conn, $_GET['Chef_ID']);
	$query = "SELECT Chefs.*,Family_Members.* FROM Chefs NATURAL JOIN Family_Members WHERE Chefs.Chef_ID=".$chefid;
	$result = $conn->query($query);
	if (!$result) die ("Invalid chef id.");
	$rows = $result->num_rows;
    
	if ($rows == 0) {
        echo "<p class=\'error\'> No chef found with id of $chefid<br></p>";
	} elseif ($rows > 0){
		while ($row = $result->fetch_assoc()) {
			echo '<h2 class=\'subtitle\'>'.$row['First_Name']." ".$row['Last_Name'].'</h2>';
			echo "<table class=\'chefpage\'><tr><td><img src=\"".$row['Image_Path']."\" alt=\"chef photo\"width=\"200\" height=\"200\"></img></td><td><h3>Recipes:</h3>";
            
            $query2 ="SELECT Recipe_ID, Title FROM Recipe_Information WHERE Chef_ID=".$chefid;
            
            $result2 = $conn->query($query2);
            if (!$result2) die ("Invalid chef id.");
	        $rows = $result2->num_rows;
            echo "<ul>";
            while ($row = $result2->fetch_assoc()) {
                echo "<li><a href=\"viewrecipe.php?Recipe_ID=".$row['Recipe_ID']."\">".$row["Title"]."</a></li>";
		}
            echo"</ul></td></tr></table>";
	}
} else {
	echo "<p class=\'error'\> No chef id passed </p>";
}
}
echo "<div></div>";

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