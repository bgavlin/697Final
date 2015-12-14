<?php
include_once 'header.php';
?>

<h2 class='subtitle'> Family Chefs </h2>
<div id='intro'> </div>

<?php
//query to retrieve images and names of all chefs
$query = "SELECT Chefs.Image_Path,Chefs.Chef_ID, Family_Members.First_Name, Last_Name, Birth_Year, Death_Year FROM Chefs  JOIN Family_Members ON Chefs.Member_ID=Family_Members.Member_ID ORDER BY Family_Members.First_Name";

$result = $conn->query($query);      
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;

echo "<table class='allbutchef'><tr> <th>Photo</th> <th>Chef</th> <th>Recipes</th><tr>";
    
while ($row = $result->fetch_assoc()) {
    echo "<td><img src=\"".$row['Image_Path']."\" alt=\"chef photo\"width=\"128\" height=\"128\"></img></td>";
    echo "<td><a href=\"viewchef.php?Chef_ID=".$row['Chef_ID']."\">".$row["First_Name"]." ".$row["Last_Name"]."</a></td>";
    echo "<td>";    
        //Loop through a second query to retrieve the chef's recipes
        $query_recipes="SELECT Title, Recipe_ID FROM Recipe_Information WHERE         Chef_ID=".$row['Chef_ID'];
            
        $result2 = $conn->query($query_recipes);
            
        if (!$result2) die ("Database access failed: " . $conn->error);
        $rows = $result2->num_rows;          
        while ($row = $result2->fetch_assoc()) {
            echo "<li><a href=\"viewrecipe.php?Recipe_ID=".$row['Recipe_ID']."\">".$row["Title"]."</a></li>";
            }
            
    echo "</td></tr>";
}

?>
</table>

<?php
include_once 'footer.php';
?>