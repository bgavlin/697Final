<?php
include_once 'header.php';
?>

<h1 class='title'> Bridget's Family Recipes </h1>
<h2 class='subtitle'> Family Chefs </h2>
<div id='intro'> </div>

<table>
<?php

$query = "SELECT Chefs.Image_Path, Family_Members.First_Name, Last_Name, Birth_Year, Death_Year, Recipe_Information.Recipe_ID, Recipe_Information.Title FROM Chefs  JOIN Family_Members ON Chefs.Member_ID=Family_Members.Member_ID JOIN Recipe_Information On Recipe_Information.Chef_ID=Chefs.Chef_ID";

$result = $conn->query($query);      
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;

print_r($result);
    
echo "<table class='display_contents'><tr> <th>Photo</th> <th>Chef</th> <th>Recipes</th><tr>";

while ($row = $result->fetch_assoc()) {
    echo "<td><img src=\"".$row['Image_Path']."\" alt=\"chef photo\"width=\"128\" height=\"128\"></img></td>";
    echo "<td>".$row["First_Name"]." ".$row["Last_Name"]."</td>";
    echo "<td>".$row["Title"]."</td></tr>";
}
    
?>
</table>

<?php
include_once 'footer.php';
?>