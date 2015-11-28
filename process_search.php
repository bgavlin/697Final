<?php 
include_once 'header.php';

//Checks if user entered text in the search bar
if (isset($_GET['userinput'])) { 
	$search_string = sanitizeString($_GET['userinput']);
    
    echo "<p>You searched for: " .$search_string. "</p>";
    
    $query = "SELECT * FROM Recipe_Information WHERE MATCH (Full_Recipe) AGAINST (\"$search_string\")";
    
    $result = $conn->query($query); 
    if (!$result) die ("Database access failed: " . $conn->error);
    $rows = $result->num_rows;
    
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo "<a href=\"viewrecipe.php?Recipe_ID=".$row['Recipe_ID']."\">".$row["Title"]."</a><br></tr>";
    }?>
</table>
<?php
} else { 
	$search_string = "(Not entered)";
}


//Checks if user selected a meal course
if (isset($_GET['course'])) { 
	$course = sanitizeString($_GET['course']);
    echo "<p>Course Selected: " .$course. "</p>";

    $query = "SELECT * FROM Recipe_Information WHERE Meal_Course = \"$course\"";
    
    $result = $conn->query($query); 
    if (!$result) die ("Database access failed: " . $conn->error);
    $rows = $result->num_rows;
    
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo "<a href=\"viewrecipe.php?Recipe_ID=".$row['Recipe_ID']."\">".$row["Title"]."</a><br></tr>";
    }?>
</table>

<?php
    
} else { 
	$method = "(None selected)";

}


//Checks if user selected a cooking method
if (isset($_GET['method'])) { 
	$method = sanitizeString($_GET['method']);
    echo "<p>Cooking Method Selected: " .$ingredient. "</p>";

    $query = "SELECT Cooking_Methods.Method_ID, Method_Junction.Recipe_ID, Recipe_Information.* FROM Cooking_Methods NATURAL JOIN Method_Junction NATURAL JOIN Recipe_Information WHERE Method = \"$method\"";
    
    $result = $conn->query($query); 
    if (!$result) die ("Database access failed: " . $conn->error);
    $rows = $result->num_rows;
    
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo "<a href=\"viewrecipe.php?Recipe_ID=".$row['Recipe_ID']."\">".$row["Title"]."</a><br></tr>";
    }?>
</table>

<?php
} else { 
	$method = "(None selected)";
}

if (isset($_GET['diet'])) { 
	$diet = sanitizeString($_GET['diet']);
    echo "<p>Dietary Restriction Selected: " .$diet. "</p>";

    $query = "SELECT Dietary_Concerns.Diet_ID, Diet_Junction.Recipe_ID, Recipe_Information.* FROM Dietary_Concerns NATURAL JOIN Diet_Junction NATURAL JOIN Recipe_Information WHERE Diet_Type = \"$diet\"";
    
    $result = $conn->query($query); 
    if (!$result) die ("Database access failed: " . $conn->error);
    $rows = $result->num_rows;
    
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo "<a href=\"viewrecipe.php?Recipe_ID=".$row['Recipe_ID']."\">".$row["Title"]."</a><br></tr>";
    }?>
</table>
<?php
} else { 
	$method = "(None selected)";
}

//Checks if user selected an ingredient
if (isset($_GET['ingredient'])) { 
	$ingredient = sanitizeString($_GET['ingredient']);
    echo "<p>Ingredient Selected: " .$ingredient. "</p>";

    $query = "SELECT Ingredients.Ingredient_ID, Ingredient_Junction.Recipe_ID, Recipe_Information.* FROM Ingredients NATURAL JOIN Ingredient_Junction NATURAL JOIN Recipe_Information WHERE Ingredient = \"$ingredient\"";
    
    $result = $conn->query($query); 
    if (!$result) die ("Database access failed: " . $conn->error);
    $rows = $result->num_rows;
    
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo "<a href=\"viewrecipe.php?Recipe_ID=".$row['Recipe_ID']."\">".$row["Title"]."</a><br></tr>";
    }?>
</table>
<?php
} else { 
	$method = "(None selected)";
}

//Sanitize string function
function sanitizeString($var)
{
	$var = stripslashes($var);
	$var = strip_tags($var);
	$var = htmlentities($var);
	return $var;
}

?>
