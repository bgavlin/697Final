<?php
include_once 'header.php';
?>

<h2 class='subtitle'>My Family Tree</h2>

<!--http://thecodeplayer.com/walkthrough/css3-family-tree-->
<!--http://www.onlamp.com/pub/a/php/2000/11/02/next_previous.html?page=2-->

<div class="tree">
 
<?php
//query to retrieve 1 person from a pair of spouses, ordered from oldest to youngest
$query = "SELECT DISTINCT Family_Members.*,Lineage.Child FROM Family_Members Natural Join Marriages NATURAL JOIN Lineage WHERE Family_Members.Member_ID=Marriages.Spouse_1 AND (Family_Members.Member_ID=Lineage.Parent_1 OR Family_Members.Member_ID=Lineage.Parent_2) AND (Marriages.Spouse_2=Lineage.Parent_1 OR Marriages.Spouse_2=Lineage.Parent_2) ORDER BY Family_Members.Birth_Year asc";

$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;

//creating an array to capture the last family member added in order to avoid duplicate entries
$name=array(); 

    while ($row = $result->fetch_assoc()) {
        //checking to see if the family member has already been added
        if ((in_array($row['Member_ID'], $name))== FALSE){
			echo "<ul><li><a href=\"#\">". $row['First_Name']." ".$row['Last_Name']."</a></li>";    

//query to retrieve the spouses of the original family member
        $query_spouse = "SELECT Family_Members.First_Name, Family_Members.Last_Name,Family_Members.Member_ID, Marriages.* FROM Family_Members NATURAL JOIN Marriages WHERE Family_Members.Member_ID=Marriages.Spouse_2 AND Marriages.Spouse_1=".$row['Member_ID'];
        
        $result2 = $conn->query($query_spouse);
        if (!$result2) die ("Database access to spouse failed: " . $conn->error);
        $rows = $result2->num_rows;

        while ($row2 = $result2->fetch_assoc()) {
			echo "<li><a href=\"#\">". $row2['First_Name']." ".$row2['Last_Name']."</a></li>"; 

//query to retrieve any children from the returned marriage as well as any children from a previous marriage            
            $query_kids = "SELECT Family_Members.First_Name, Family_Members.Last_Name FROM Family_Members NATURAL JOIN Lineage WHERE Family_Members.Member_ID=Lineage.Child AND (Lineage.Parent_2=".$row2['Spouse_2']. " OR (Lineage.Parent_2 IS NULL AND Lineage.Parent_1=".$row2['Spouse_2']."))";
        
        $result3 = $conn->query($query_kids);
        if (!$result3) die ("Database access to child failed: " . $conn->error);
        $rows = $result2->num_rows;
        
        while ($row3 = $result3->fetch_assoc()) {

			echo "<ul><li><a href=\"#\">". $row3['First_Name']." ".$row3['Last_Name']."</a></li></ul>";     
        }
//Add the original family member to the array 
        array_push($name,$row['Member_ID']);
        echo"</ul><ul>";
        }
    }
echo"</ul>";
}

?>

</div>

<?php
include_once 'footer.php';
?>
