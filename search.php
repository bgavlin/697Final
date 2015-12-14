<?php
include_once 'header.php';
?>

<h2 class='subtitle'>Search the Recipes</h2>

<!--Search will perform text search on the Full_Recipe column in the Recipe_Information Table-->
<div id = 'searchbox'>
<form action="process_search.php" method="GET"> 
Search the recipe text: <input type="text" name="userinput"> 
<input type="submit" value="Submit"> 
</form>
</div>
<br>

<!--Create a dropdown menu to allow users to select a course to search by-->
Filter by Meal Course:
<form action="process_search.php" method="GET"> 
<select name="course">
<!--Using PHP to cycle through ingredients to create form-->
<?php
$query = "SELECT DISTINCT Meal_Course FROM Recipe_Information ORDER BY Meal_Course ASC";
$result = $conn->query($query);      
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;

if ($rows == 0) {
		echo "<p class=error> No Recipes Identified under that Meal Course </p>";
	} else {
while ($row = $result->fetch_assoc()) {
    echo "<option value=\"".$row['Meal_Course']."\"selected>".$row['Meal_Course']."</option>";
}
}
?>
<input type="submit" name="submit" value="Send">
</select> 
</form> 
<br>

<!--Create another dropdown menu to allow users to search by cooking method-->
Filter by Cooking Method:
<form action="process_search.php" method="GET"> 
<select name="method">
<!--Using PHP to cycle through ingredients to create form-->
<?php
$query = "SELECT Method FROM Cooking_Methods ORDER BY Method ASC";
$result = $conn->query($query);      
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;

if ($rows == 0) {
		echo "<p class=error> No Recipes Identified under that Cooking Method </p>";
	} 
    else{
        while ($row = $result->fetch_assoc()) {
            echo "<option value=\"".$row['Method']."\"selected>".$row['Method']."</option>";
        }
}
?>
<input type="submit" name="submit" value="Send">
</select> 
</form> 
<br>

<!--Create another dropdown menu to allow users to select dietary option-->
Filter by Dietary Concern:
<form action="process_search.php" method="GET"> 
<select name="diet">
<!--Using PHP to cycle through ingredients to create form-->
<?php
$query = "SELECT Diet_Type FROM Dietary_Concerns ORDER BY Diet_Type ASC";
$result = $conn->query($query);      
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;

if ($rows == 0) {
		echo "<p class=error> No Recipes Identified under that Dietary Concern</p>";
	} 
    else{
        while ($row = $result->fetch_assoc()) {
            echo "<option value=\"".$row['Diet_Type']."\"selected>".$row['Diet_Type']."</option>";
}
}
?>
<input type="submit" name="submit" value="Send">
</select> 
</form> 
<br>

<!--Create final dropdown menu to allow users to select main ingredients-->
Filter by Ingredient:
<form action="process_search.php" method="GET"> 
<select name="ingredient">
<!--Using PHP to cycle through ingredients to create form-->
<?php
$query = "SELECT Ingredient FROM Ingredients ORDER BY Ingredient ASC";
$result = $conn->query($query);      
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;

if ($rows == 0) {
		echo "<p class=error> No Recipes Identified with that Ingredient</p>";
	} else{
while ($row = $result->fetch_assoc()) {
    echo "<option value=\"".$row['Ingredient']."\"selected>".$row['Ingredient']."</option>";
}
}
?>
<input type="submit" name="submit" value="Send">
</select> 
</form> 
<br>

<?php
include_once 'footer.php';
?>