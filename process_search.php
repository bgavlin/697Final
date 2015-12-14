<?php 
include_once 'header.php';
?>

<h2 class="subtitle"> Search Results </h2>

<?php 
//Checks if user entered text in the search bar and sanitizes the text as a safety measure
if (isset($_GET['userinput'])) { 
	$search_string = sanitizeString($_GET['userinput']);
    
    if ($search_string != ""){
    echo "<p>You searched for: " .$search_string. "</p>";
    
    $query = "SELECT * FROM Recipe_Information WHERE MATCH (Full_Recipe) AGAINST (\"$search_string\")";
    
    $result = $conn->query($query); 
    if (!$result) die ("Database access failed: " . $conn->error);
    $rows = $result->num_rows;
    
//    Message if search returns no results 
    if ($rows == 0) {
		echo "<p class=error> No recipes identified that match ".$search_string.".</p>";
        echo "<form action=\"search.php\"><input type=\"submit\" value=
        \"Try Another Search!\"></form>";
	} 
//    if search returns results, display a list of recipes
    else{
    while ($row = $result->fetch_assoc()) {
        echo "<div class=\'results\'><li><a href=\"viewrecipe.php?Recipe_ID=".$row['Recipe_ID']."\">".$row["Title"]."</a></li><div>";
    }
        echo "<br> <i>Didn't find what you're looking for?</i><br><br><form action=\"search.php\"><input type=\"submit\" value=
        \"Try Another Search!\"></form>";
    }
}
//if user has not entered text, give error
    else{
        echo "You didn't enter a value!<br>";
        echo "<br><form action=\"search.php\"><input type=\"submit\" value=
        \"Try Another Search!\"></form>";
    }
}
else { 
	$search_string = "(Not entered)";
}


//Checks if user selected a meal course and returns matching recipes in a list
if (isset($_GET['course'])) { 
	$course = sanitizeString($_GET['course']);
    echo "<p>Course Selected: " .$course. "</p>";

    $query = "SELECT * FROM Recipe_Information WHERE Meal_Course = \"$course\"";
    
    $result = $conn->query($query); 
    if (!$result) die ("Database access failed: " . $conn->error);
    $rows = $result->num_rows;
    if ($rows == 0) {
		echo "<p class=error> No recipes identified that match ".$course.".</p>";
        echo "<form action=\"search.php\"><input type=\"submit\" value=
        \"Try A Different Filter\"></form>";
	} else{
    while ($row = $result->fetch_assoc()) {
        echo "<li><a href=\"viewrecipe.php?Recipe_ID=".$row['Recipe_ID']."\">".$row["Title"]."</a></li>";
    }
        echo "<br> <i>Didn't find what you're looking for?</i><br><br><form action=\"search.php\"><input type=\"submit\" value=
        \"Try Another Search!\"></form>";
}?>

<?php
    
} else { 
	$method = "(None selected)";

}


//Checks if user selected a cooking method
if (isset($_GET['method'])) { 
	$method = sanitizeString($_GET['method']);
    echo "<p>Cooking Method Selected: " .$method. "</p>";

    $query = "SELECT Cooking_Methods.Method_ID, Method_Junction.Recipe_ID, Recipe_Information.* FROM Cooking_Methods NATURAL JOIN Method_Junction NATURAL JOIN Recipe_Information WHERE Method = \"$method\"";
    
    $result = $conn->query($query); 
    if (!$result) die ("Database access failed: " . $conn->error);
    $rows = $result->num_rows;
    if ($rows == 0) {
        echo "<p class=error> No recipes identified that match ".$method.".</p>";
        echo "<form action=\"search.php\"><input type=\"submit\" value=
        \"Try A Different Filter\"></form>";
	} else{
    while ($row = $result->fetch_assoc()) {
        echo "<li><a href=\"viewrecipe.php?Recipe_ID=".$row['Recipe_ID']."\">".$row["Title"]."</a></li>";
    }
        echo "<br> <i>Didn't find what you're looking for?</i><br><br><form action=\"search.php\"><input type=\"submit\" value=
        \"Try Another Search!\"></form>";
    }?>

<?php
} else { 
	$method = "(None selected)";
}

if (isset($_GET['diet'])) { 
	$diet = sanitizeString($_GET['diet']);
    echo "<p>Dietary Restriction Selected: " .$diet. ".</p>";

    $query = "SELECT Dietary_Concerns.Diet_ID, Diet_Junction.Recipe_ID, Recipe_Information.* FROM Dietary_Concerns NATURAL JOIN Diet_Junction NATURAL JOIN Recipe_Information WHERE Diet_Type = \"$diet\"";
    
    $result = $conn->query($query); 
    if (!$result) die ("Database access failed: " . $conn->error);
    $rows = $result->num_rows;
    
    if ($rows == 0) {
		echo "<p class=error> No recipes identified that match ".$diet."</p>";
        echo "<form action=\"search.php\"><input type=\"submit\" value=
        \"Try A Different Filter\"></form>";
	} else{
    while ($row = $result->fetch_assoc()) {
        echo "<li><a href=\"viewrecipe.php?Recipe_ID=".$row['Recipe_ID']."\">".$row["Title"]."</a></li>";
    }
        echo "<br> <i>Didn't find what you're looking for?</i><br><br><form action=\"search.php\"><input type=\"submit\" value=
        \"Try Another Search!\"></form>";
    }?>
</table>
<?php
} else { 
	$method = "(None selected)";
}

//Checks if user selected an ingredient
if (isset($_GET['ingredient'])) { 
	$ingredient = sanitizeString($_GET['ingredient']);
    echo "<p>Ingredient Selected: " .$ingredient. ".</p>";

    $query = "SELECT Ingredients.Ingredient_ID, Ingredient_Junction.Recipe_ID, Recipe_Information.* FROM Ingredients NATURAL JOIN Ingredient_Junction NATURAL JOIN Recipe_Information WHERE Ingredient = \"$ingredient\"";
    
    $result = $conn->query($query); 
    if (!$result) die ("Database access failed: " . $conn->error);
    $rows = $result->num_rows;
        if ($rows == 0) {
		echo "<p class=error> No recipes identified with ".$ingredient."</p>";
        echo "<form action=\"search.php\"><input type=\"submit\" value=
        \"Try A Different Filter\"></form>";
	} else{
    while ($row = $result->fetch_assoc()) {
        echo "<li><a href=\"viewrecipe.php?Recipe_ID=".$row['Recipe_ID']."\">".$row["Title"]."</a></li>";
    }
        echo "<br> <i>Didn't find what you're looking for?</i><br><br><form action=\"search.php\"><input type=\"submit\" value=
        \"Try Another Search!\"></form>";
    }?>
</table>
<?php
} else { 
	$method = "(None selected)";
}

echo"<br>";

//Sanitize string function
function sanitizeString($var)
{
	$var = stripslashes($var);
	$var = strip_tags($var);
	$var = htmlentities($var);
	return $var;
}

include_once 'footer.php';
?>
