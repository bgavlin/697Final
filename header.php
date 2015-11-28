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
<ul id="menu-bar">
    <li class="active"><a href="index.php">Home</a></li>
    <li><a href="search.php">Search Recipes</a></li> 
    <li><a href="allrecipes.php">All Recipes</a></li>
    <li><a href="allchefs.php">Chefs</a>
    <ul>
<!--Insert php here with SQL query to retrieve Chef Links-->
        <?php
        $query = "SELECT Family_Members.`Member_ID`,`First_Name`,`Last_Name`FROM Family_Members JOIN Chefs ON Family_Members.Member_ID=Chefs.Member_ID";
        $result = $conn->query($query);
        if (!$result) die ("Database access failed." . $conn->error);
        $rows = $result->num_rows;

        while ($row = $result->fetch_assoc()) {
            echo "<li><a href=\"viewchef.php?Member_ID=".$row['Member_ID']."\">".$row['First_Name']." ".$row['Last_Name'].'</a></li>';
//        print_r($row['Member_ID']);
        }

        ?>
        
    </ul>
    </li>
    <li><a href="tree.php">Family Tree</a></li>
</ul>
</head>
<body>
