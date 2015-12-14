<?php
include_once 'header.php';
?>

<h2 class='subtitle'>My Family's Genealogy</h2>

<!--http://thecodeplayer.com/walkthrough/css3-family-tree-->

<div class="tree">
<div class="gen1">
<h3 class="subtitle">First Generation:</h3>
<?php
//query to retrieve 1 person from a pair of spouses, ordered from oldest to youngest
$query = "SELECT DISTINCT Family_Members.* FROM Family_Members Natural Join Marriages NATURAL JOIN Lineage WHERE Family_Members.Member_ID=Marriages.Spouse_1 AND (Family_Members.Member_ID=Lineage.Parent_1 OR Family_Members.Member_ID=Lineage.Parent_2) AND (Marriages.Spouse_2=Lineage.Parent_1 OR Marriages.Spouse_2=Lineage.Parent_2) AND Family_Members.Generation=1";

$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;

//creating an array to capture the last family member added in order to avoid duplicate entries
$name=array(); 
    while ($row = $result->fetch_assoc()) {
        //checking to see if the family member has already been added
        if ((in_array($row['Member_ID'], $name))== FALSE){
            
            //echo if a member's death year is populated, else, only echo birth date
            if ($row['Death_Year']>0){
			echo "<ul><li><div class='parent1'>".$row['First_Name']." ". $row['Last_Name']."<br>".$row['Birth_Year']."-".$row['Death_Year']."</div></li>";}
            else{
            echo "<ul><li><div class='parent1'>".$row['First_Name']." ". $row['Last_Name']."<br>".$row['Birth_Year']."</div></li>";}
            
//query to retrieve the spouses of the original family member
        $query_spouse = "SELECT Family_Members.*, Marriages.* FROM Family_Members NATURAL JOIN Marriages WHERE Family_Members.Member_ID=Marriages.Spouse_2 AND Marriages.Spouse_1=".$row['Member_ID'];
        
        $result2 = $conn->query($query_spouse);
        if (!$result2) die ("Database access to spouse failed: " . $conn->error);
        $rows = $result2->num_rows;
        
         while ($row2 = $result2->fetch_assoc()) {
            //check for death year
            if ($row2['Death_Year']>0){
			echo "<li><div class='parent2'>".$row2['First_Name']." ". $row2['Last_Name']."<br>".$row2['Birth_Year']."-".$row2['Death_Year']."</div></li>";} 
            else{
                echo "<li><div class='parent2'>".$row2['First_Name']." ". $row2['Last_Name']."<br>".$row2['Birth_Year']."</div></li>";}
            
//query to retrieve any children from the returned marriage as well as any children from a previous marriage
            $query_kids = "SELECT Family_Members.* FROM Family_Members NATURAL JOIN Lineage WHERE Family_Members.Member_ID=Lineage.Child AND (Lineage.Parent_2=".$row2['Spouse_2']. " OR (Lineage.Parent_2 IS NULL AND Lineage.Parent_1=".$row2['Spouse_2']."))";
        
        $result3 = $conn->query($query_kids);
        if (!$result3) die ("Database access to child failed: " . $conn->error);
        $rows = $result3->num_rows;
        if ($rows>0){
        echo "<ul>";    
            while ($row3 = $result3->fetch_assoc()) {
            //check for death year
			     if ($row3['Death_Year']>0){
                    echo "<li><div class='child'>".$row3['First_Name']." ". $row3['Last_Name']."<br>".$row3['Birth_Year']."-".$row3['Death_Year']."</div></li>";}
                else {
                    echo "<li><div class='child'>".$row3['First_Name']." ". $row3['Last_Name']."<br>".$row3['Birth_Year']."</a></li>";
                }
            }
        }
            echo"</ul>";
        }
        echo"</ul></ul><ul></ul>";
        //Add the original family member to the array 
        array_push($name,$row['Member_ID']);
    }
}
?>
</div>
    
<div class="gen2">
<h3 class="subtitle">Second Generation:</h3>
<?php
//query to retrieve 1 person from a pair of spouses, ordered from oldest to youngest
$query = "SELECT DISTINCT Family_Members.* FROM Family_Members Natural Join Marriages NATURAL JOIN Lineage WHERE Family_Members.Member_ID=Marriages.Spouse_1 AND (Family_Members.Member_ID=Lineage.Parent_1 OR Family_Members.Member_ID=Lineage.Parent_2) AND (Marriages.Spouse_2=Lineage.Parent_1 OR Marriages.Spouse_2=Lineage.Parent_2) AND Family_Members.Generation=2";

$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;

//creating an array to capture the last family member added in order to avoid duplicate entries
$name=array(); 
    while ($row = $result->fetch_assoc()) {
        //checking to see if the family member has already been added
        if ((in_array($row['Member_ID'], $name))== FALSE){
            
            //echo if a member's death year is populated, else, only echo birth date
            if ($row['Death_Year']>0){
			echo "<ul><li><div class='parent1'>".$row['First_Name']." ". $row['Last_Name']."<br>".$row['Birth_Year']."-".$row['Death_Year']."</div></li>";}
            else{
            echo "<ul><li><div class='parent1'>".$row['First_Name']." ". $row['Last_Name']."<br>".$row['Birth_Year']."</div></li>";}
            
//query to retrieve the spouses of the original family member
        $query_spouse = "SELECT Family_Members.*, Marriages.* FROM Family_Members NATURAL JOIN Marriages WHERE Family_Members.Member_ID=Marriages.Spouse_2 AND Marriages.Spouse_1=".$row['Member_ID'];
        
        $result2 = $conn->query($query_spouse);
        if (!$result2) die ("Database access to spouse failed: " . $conn->error);
        $rows = $result2->num_rows;
        
         while ($row2 = $result2->fetch_assoc()) {
            //check for death year
            if ($row2['Death_Year']>0){
			echo "<li><div class='parent2'>".$row2['First_Name']." ". $row2['Last_Name']."<br>".$row2['Birth_Year']."-".$row2['Death_Year']."</div></li>";} 
            else{
                echo "<li><div class='parent2'>".$row2['First_Name']." ". $row2['Last_Name']."<br>".$row2['Birth_Year']."</div></li>";}
            
//query to retrieve any children from the returned marriage as well as any children from a previous marriage
            $query_kids = "SELECT Family_Members.* FROM Family_Members NATURAL JOIN Lineage WHERE Family_Members.Member_ID=Lineage.Child AND (Lineage.Parent_2=".$row2['Spouse_2']. " OR (Lineage.Parent_2 IS NULL AND Lineage.Parent_1=".$row2['Spouse_2'].") OR Lineage.Parent_1=".$row2['Spouse_2'].")";
        
        $result3 = $conn->query($query_kids);
        if (!$result3) die ("Database access to child failed: " . $conn->error);
        $rows = $result3->num_rows;
        if ($rows>0){
        echo "<ul>";    
            while ($row3 = $result3->fetch_assoc()) {
            //check for death year
			     if ($row3['Death_Year']>0){
                    echo "<li><div class='child'>".$row3['First_Name']." ". $row3['Last_Name']."<br>".$row3['Birth_Year']."-".$row3['Death_Year']."</div></li>";}
                else {
                    echo "<li><div class='child'>".$row3['First_Name']." ". $row3['Last_Name']."<br>".$row3['Birth_Year']."</a></li>";
                }
            }
        }
            echo"</ul>";
        }
        echo"</ul></ul><ul></ul>";
        //Add the original family member to the array 
        array_push($name,$row['Member_ID']);
    }
}
?>
</div>
    
<div class="gen3">
<h3 class="subtitle">Third Generation:</h3>
<?php
//query to retrieve 1 person from a pair of spouses, ordered from oldest to youngest
$query = "SELECT DISTINCT Family_Members.* FROM Family_Members Natural Join Marriages NATURAL JOIN Lineage WHERE Family_Members.Member_ID=Marriages.Spouse_1 AND (Family_Members.Member_ID=Lineage.Parent_1 OR Family_Members.Member_ID=Lineage.Parent_2) AND (Marriages.Spouse_2=Lineage.Parent_1 OR Marriages.Spouse_2=Lineage.Parent_2) AND Family_Members.Generation=3";

$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;

//creating an array to capture the last family member added in order to avoid duplicate entries
$name=array(); 
    while ($row = $result->fetch_assoc()) {
        //checking to see if the family member has already been added
        if ((in_array($row['Member_ID'], $name))== FALSE){
            
            //echo if a member's death year is populated, else, only echo birth date
            if ($row['Death_Year']>0){
			echo "<ul><li><div class='parent1'>".$row['First_Name']." ". $row['Last_Name']."<br>".$row['Birth_Year']."-".$row['Death_Year']."</div></li>";}
            else{
            echo "<ul><li><div class='parent1'>".$row['First_Name']." ". $row['Last_Name']."<br>".$row['Birth_Year']."</div></li>";}
            
//query to retrieve the spouses of the original family member
        $query_spouse = "SELECT Family_Members.*, Marriages.* FROM Family_Members NATURAL JOIN Marriages WHERE Family_Members.Member_ID=Marriages.Spouse_2 AND Marriages.Spouse_1=".$row['Member_ID'];
        
        $result2 = $conn->query($query_spouse);
        if (!$result2) die ("Database access to spouse failed: " . $conn->error);
        $rows = $result2->num_rows;
        
         while ($row2 = $result2->fetch_assoc()) {
            //check for death year
            if ($row2['Death_Year']>0){
			echo "<li><div class='parent2'>".$row2['First_Name']." ". $row2['Last_Name']."<br>".$row2['Birth_Year']."-".$row2['Death_Year']."</div></li>";} 
            else{
                echo "<li><div class='parent2'>".$row2['First_Name']." ". $row2['Last_Name']."<br>".$row2['Birth_Year']."</div></li>";}
            
//query to retrieve any children from the returned marriage as well as any children from a previous marriage
            $query_kids = "SELECT Family_Members.* FROM Family_Members NATURAL JOIN Lineage WHERE Family_Members.Member_ID=Lineage.Child AND (Lineage.Parent_2=".$row2['Spouse_2']. " OR (Lineage.Parent_2 IS NULL AND Lineage.Parent_1=".$row2['Spouse_2'].") OR Lineage.Parent_1=".$row2['Spouse_2'].")";
        
        $result3 = $conn->query($query_kids);
        if (!$result3) die ("Database access to child failed: " . $conn->error);
        $rows = $result3->num_rows;
        if ($rows>0){
        echo "<ul>";    
            while ($row3 = $result3->fetch_assoc()) {
            //check for death year
			     if ($row3['Death_Year']>0){
                    echo "<li><div class='child'>".$row3['First_Name']." ". $row3['Last_Name']."<br>".$row3['Birth_Year']."-".$row3['Death_Year']."</div></li>";}
                else {
                    echo "<li><div class='child'>".$row3['First_Name']." ". $row3['Last_Name']."<br>".$row3['Birth_Year']."</a></li>";
                }
            }
        }
            echo"</ul>";
        }
        echo"</ul></ul><ul></ul>";
        //Add the original family member to the array 
        array_push($name,$row['Member_ID']);
    }
}
?>
</div>
<div class="gen4">
<h3 class="subtitle">Fourth Generation:</h3>
<?php
//query to retrieve 1 person from a pair of spouses, ordered from oldest to youngest
$query = "SELECT DISTINCT Family_Members.* FROM Family_Members Natural Join Marriages NATURAL JOIN Lineage WHERE Family_Members.Member_ID=Marriages.Spouse_1 AND (Family_Members.Member_ID=Lineage.Parent_1 OR Family_Members.Member_ID=Lineage.Parent_2) AND (Marriages.Spouse_2=Lineage.Parent_1 OR Marriages.Spouse_2=Lineage.Parent_2) AND Family_Members.Generation=4";

$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;

//creating an array to capture the last family member added in order to avoid duplicate entries
$name=array(); 
    while ($row = $result->fetch_assoc()) {
        //checking to see if the family member has already been added
        if ((in_array($row['Member_ID'], $name))== FALSE){
            
            //echo if a member's death year is populated, else, only echo birth date
            if ($row['Death_Year']>0){
			echo "<ul><li><div class='parent1'>".$row['First_Name']." ". $row['Last_Name']."<br>".$row['Birth_Year']."-".$row['Death_Year']."</div></li>";}
            else{
            echo "<ul><li><div class='parent1'>".$row['First_Name']." ". $row['Last_Name']."<br>".$row['Birth_Year']."</div></li>";}
            
//query to retrieve the spouses of the original family member
        $query_spouse = "SELECT Family_Members.*, Marriages.* FROM Family_Members NATURAL JOIN Marriages WHERE Family_Members.Member_ID=Marriages.Spouse_2 AND Marriages.Spouse_1=".$row['Member_ID'];
        
        $result2 = $conn->query($query_spouse);
        if (!$result2) die ("Database access to spouse failed: " . $conn->error);
        $rows = $result2->num_rows;
        
         while ($row2 = $result2->fetch_assoc()) {
            //check for death year
            if ($row2['Death_Year']>0){
			echo "<li><div class='parent2'>".$row2['First_Name']." ". $row2['Last_Name']."<br>".$row2['Birth_Year']."-".$row2['Death_Year']."</div></li>";} 
            else{
                echo "<li><div class='parent2'>".$row2['First_Name']." ". $row2['Last_Name']."<br>".$row2['Birth_Year']."</div></li>";}
            
//query to retrieve any children from the returned marriage as well as any children from a previous marriage
            $query_kids = "SELECT Family_Members.* FROM Family_Members NATURAL JOIN Lineage WHERE Family_Members.Member_ID=Lineage.Child AND (Lineage.Parent_2=".$row2['Spouse_2']. " OR (Lineage.Parent_2 IS NULL AND Lineage.Parent_1=".$row2['Spouse_2'].") OR Lineage.Parent_1=".$row2['Spouse_2'].")";
        
        $result3 = $conn->query($query_kids);
        if (!$result3) die ("Database access to child failed: " . $conn->error);
        $rows = $result3->num_rows;
        if ($rows>0){
        echo "<ul>";    
            while ($row3 = $result3->fetch_assoc()) {
            //check for death year
			     if ($row3['Death_Year']>0){
                    echo "<li><div class='child'>".$row3['First_Name']." ". $row3['Last_Name']."<br>".$row3['Birth_Year']."-".$row3['Death_Year']."</div></li>";}
                else {
                    echo "<li><div class='child'>".$row3['First_Name']." ". $row3['Last_Name']."<br>".$row3['Birth_Year']."</a></li>";
                }
            }
        }
            echo"</ul>";
        }
        echo"</ul></ul><ul></ul>";
        //Add the original family member to the array 
        array_push($name,$row['Member_ID']);
    }
}
?>
</div>
    
    
</div>

<?php
include_once 'footer.php';
?>
