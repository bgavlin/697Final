<?php
include_once 'header.php';
?>

<h1 class='title'> My Family Recipes </h1>
<div id='aboutme'> 
<h3>About Me:</h3>
<div id='photo'>
<!--Using PHP to retrieve my photo's image path from the database-->
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
</div>

<p id='aboutme'>
I am this kind of person.
</p>
See my recipes <a href="/viewchef.php?Chef_ID=53">here</a>!
</div>

<div id='intro'> This site is a collection of my family's recipes.  Please take a look around!
</div>


<?php
include_once 'footer.php';
?>
