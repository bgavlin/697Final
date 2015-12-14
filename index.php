<?php
include_once 'header.php';
?>

<div id='aboutme'> 
<!--<h2 class='subtitle'> Welcome to the Gavlish family recipe site!</h2>-->

<div id='leftside'>
    
<!--Using PHP to retrieve my photo's image path from the database-->
<?php
$query = "SELECT Chefs.Member_ID, Image_Path, Family_Members.First_Name,Last_Name FROM Family_Members JOIN Chefs ON Family_Members.Member_ID=Chefs.Member_ID WHERE Family_Members.First_Name='Bridget'";

$result = $conn->query($query);

if (!$result) die ("Database access failed." . $conn->error);
$rows = $result->num_rows;

while ($row = $result->fetch_assoc()) {
echo "<img src=\"".$row["Image_Path"]."\" alt=\"my photo\"width=\"210\" height=\"210\">";
echo "</img>";
}
?>    
</div>
    
<div id='rightside'>
<h2> Welcome!</h2>
<p><br>Hi! I'm Bridget - a 2nd year grad student, an avid proponent of drinking while cooking, and a lover of homemade tomato sauce, going heavy on the spices, and eggs on everything. This site is a collection of my family's favorite recipes.I believe that cooking is a way for families to connect across generations.  I have lots of great memories of the food on this site and I hope you'll love it too. Please take a look around!
</p>
    
<p><br>See my recipes <a href="viewchef.php?Chef_ID=1">here</a>!</p>
</div>
</div>

<?php
include_once 'footer.php';
?>
