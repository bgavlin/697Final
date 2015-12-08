<?php
include_once 'header.php';
?>

<h2 class='subtitle'> Recipe Gallery </h2>

<table class='allbutchef'>
<?php
$query = "SELECT Recipe_Information.*, Family_Members.First_Name, Family_Members.Last_Name, Ingredients.Ingredient FROM Recipe_Information LEFT JOIN Ingredients ON Recipe_Information.Main_Ingredient=Ingredients.Ingredient_ID LEFT JOIN Chefs ON Recipe_Information.Chef_ID=Chefs.Chef_ID INNER JOIN Family_Members ON Chefs.Member_ID = Family_Members.Member_ID WHERE Recipe_Information.Chef_ID=Chefs.Chef_ID AND Recipe_Information.Main_Ingredient=Ingredients.Ingredient_ID ORDER BY Recipe_Information.Recipe_ID";

$result = $conn->query($query);      
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;
    
echo "<th>Title</th> <th>Chef</th> <th>Main Ingredient</th><th>Meal Type</th>";
while ($row = $result->fetch_assoc()) {
//    print_r($row['Recipe_ID']);
	echo '<tr>';
    echo "<td><a href=\"viewrecipe.php?Recipe_ID=".$row['Recipe_ID']."\">".$row["Title"]."</a></td><td>";
    echo $row["First_Name"]." ".$row["Last_Name"]."</td>";
    echo "<td>".$row["Ingredient"]."</td>";
    echo "<td>". $row["Meal_Course"]."</td>";
	echo "</td></tr>";}
?>

</table>

<?php
include_once 'footer.php';
?>