<?php
include_once 'header.php';
?>

<div id='aboutme'> 
<!--<h2 class='subtitle'> Welcome to the Gavlish family recipe site!</h2>-->
<!--Using PHP to retrieve my photo's image path from the database-->
<p>
<h3> Welcome!</h3>
Hi! I'm Bridget - a 2nd year grad student, an avid proponent of drinking while cooking, and a lover of homemade tomato sauce, going heavy on the spices, and eggs on everything. This site is a collection of my family's favorite recipes. Please take a look around!
</p>

<?php
$query = "SELECT Chefs.Member_ID, Image_Path, Family_Members.First_Name,Last_Name FROM Family_Members JOIN Chefs ON Family_Members.Member_ID=Chefs.Member_ID WHERE Family_Members.First_Name='Bridget'";

$result = $conn->query($query);

if (!$result) die ("Database access failed." . $conn->error);
$rows = $result->num_rows;

while ($row = $result->fetch_assoc()) {
//print_r($row);
echo "<img src=\"".$row["Image_Path"]."\" alt=\"my photo\"width=\"128\" height=\"128\">";
echo "</img>";
}
?>    



<p>See my recipes <a href="viewchef.php?Chef_ID=1">here</a>!</p>

</div>

<?php
include_once 'footer.php';
?>
