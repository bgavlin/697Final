<?php
include_once 'header.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

echo '<h2 class=\'subtitle\'>Recipe Information</h2>';

if (isset($_GET['Recipe_ID'])) {
	$id = sanitizeMySQL($conn, $_GET['Recipe_ID']);
	$query = "SELECT Recipe_Information.*, Family_Members.First_Name, Family_Members.Last_Name FROM Recipe_Information LEFT JOIN Chefs ON Recipe_Information.Chef_ID=Chefs.Chef_ID INNER JOIN Family_Members ON Chefs.Member_ID = Family_Members.Member_ID WHERE Recipe_Information.Chef_ID=Chefs.Chef_ID AND Recipe_Information.Recipe_ID=".$id;
    
	$result = $conn->query($query);
	if (!$result) die ("Invalid recipe id.");
	$rows = $result->num_rows;
	if ($rows == 0) {
		echo "<p class=error> No recipe found with id of $id<br></p>";
	} else {
		while ($row = $result->fetch_assoc()) {
			echo "<p><strong>".$row["Title"],"</strong></p><div class=recipetext>";
            echo "<p>Chef: <a href=\"viewchef.php?Chef_ID=".$row['Chef_ID']."\">". $row['First_Name']." ".$row['Last_Name']."</a></p>";
            echo $row['Full_Recipe']. "<br>";
		}
        echo"</div>";
	}
    
} else {
	echo "<p class=error> No recipe id passed </p>";
}

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
