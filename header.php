<!DOCTYPE html>
<html>
<head>
<?php    
$hn = 'localhost';
$un = 'site_user';
$db = 'BGavlin';
$pw= 'pass';

$conn = new mysqli($hn,$un,$pw,$db);
if ($conn->connect_error) die($conn->connect_error);

?>  
<title>Bridget's Family Recipes</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>    
    
<body>
<div class="wrapper">
<div class="header">
    <div class="innerheader">
<h1 class='title'> My Family Recipes </h1>
    </div>
</div>
    
<ul id="menu-bar">
    <li class="active"><a href="index.php">Home</a></li>
    <li><a href="search.php">Search Recipes</a></li> 
    <li><a href="allrecipes.php">All Recipes</a></li>
    <li><a href="allchefs.php">Chefs</a>
    <ul>
<!--Use a SQL query to retrieve Chef Links-->
        <?php
        $query = "SELECT Family_Members.`Member_ID`, First_Name, Last_Name, Chefs.Chef_ID FROM Family_Members JOIN Chefs ON Family_Members.Member_ID=Chefs.Member_ID ORDER BY First_Name ASC";
        $result = $conn->query($query);
        if (!$result) die ("Database access failed." . $conn->error);
        $rows = $result->num_rows;

//Using the chef links to form the Chefs menu
        while ($row = $result->fetch_assoc()) {
            echo "<li><a href=\"viewchef.php?Chef_ID=".$row['Chef_ID']."\">".$row['First_Name']." ".$row['Last_Name'].'</a></li>';
//        print_r($row['Member_ID']);
        }

        ?>
        
    </ul>
    </li>
    <li><a href="tree.php">Family Tree</a></li>
</ul>
<div class="content">
