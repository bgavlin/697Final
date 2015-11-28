<?php
include_once 'header.php';
?>

<h1 class='title'>Family Recipes</h1>
<h2 class='subtitle'>Search the Recipes</h2>

<div id = 'searchbox'>
<form action="process_search.php" method="GET"> 
Search the recipe text: <input type="text" name="userinput"> 
<input type="submit" value="Submit"> 
</form>
</div>
<br>

Filter by Meal Course:
<form action="process_search.php" method="GET"> 
<select name="course">
<!--Using PHP to cycle through ingredients to create form-->
<?php
$query = "SELECT DISTINCT Meal_Course FROM Recipe_Information";
$result = $conn->query($query);      
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;
while ($row = $result->fetch_assoc()) {
    echo "<option value=\"".$row['Meal_Course']."\"selected>".$row['Meal_Course']."</option>";
}
?>
<input type="submit" name="submit" value="Send">
</select> 
</form> 
<br>

Filter by Cooking Method:
<form action="process_search.php" method="GET"> 
<select name="method">
<!--Using PHP to cycle through ingredients to create form-->
<?php
$query = "SELECT Method FROM Cooking_Methods";
$result = $conn->query($query);      
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;
while ($row = $result->fetch_assoc()) {
    echo "<option value=\"".$row['Method']."\"selected>".$row['Method']."</option>";
}
?>
<input type="submit" name="submit" value="Send">
</select> 
</form> 
<br>

Filter by Dietary Concern:
<form action="process_search.php" method="GET"> 
<select name="diet">
<!--Using PHP to cycle through ingredients to create form-->
<?php
$query = "SELECT Diet_Type FROM Dietary_Concerns";
$result = $conn->query($query);      
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;
while ($row = $result->fetch_assoc()) {
    echo "<option value=\"".$row['Diet_Type']."\"selected>".$row['Diet_Type']."</option>";
}
?>
<input type="submit" name="submit" value="Send">
</select> 
</form> 
<br>

Filter by Ingredient:
<form action="process_search.php" method="GET"> 
<select name="ingredient">
<!--Using PHP to cycle through ingredients to create form-->
<?php
$query = "SELECT Ingredient FROM Ingredients ORDER BY Ingredient DESC";
$result = $conn->query($query);      
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;
while ($row = $result->fetch_assoc()) {
    echo "<option value=\"".$row['Ingredient']."\"selected>".$row['Ingredient']."</option>";
}
?>
<input type="submit" name="submit" value="Send">
</select> 
</form> 
<br>

<?php
include_once 'footer.php';
?>