<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","patelhim-db","PASSWORD","patelhim-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CS340</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
    
<body>
    <h1>CS340 Final Project</h1>
    <h2>Game of Thrones Database (HTML WORK IN PROGRESS)</h2>
    <br>
    
<table>
    <h4>Game of Thrones Characters:</h4>
	<tbody>
            <tr>
                <td>
                    First Name
                </td>
                <td>
                    Last Name
                </td>
                <td>
                    Age
                </td>
            </tr>
			<!--
			<tr>
                <td>
                    <a href="__.php?id=__">John</a> <!-- update later with PHP
                </td>
                <td>
                    <a href=".php?id=">Snow</a>
                </td>
                <td>
                    <a href=".php?id=">24</a>
                </td>
            </tr>
			-->
			
<?php
if(! ($stmt = $mysqli->prepare( "SELECT first_name, last_name, age FROM `character`"))){
	echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->bind_result($firstName, $lastName, $age)){
	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
}

while($stmt->fetch()){
	echo "<tr>\n<td>\n" . $firstName . "\n</td>\n<td>\n" . $lastName . "\n</td>\n<td>\n" . $age . "\n</td>\n</tr>";
}
$stmt->close();

?>			
	</tbody>
</table>
    <br>
    <br>

    
<form method="post" action=".php"> <!-- post to page handling form-->    
    <fieldset>
        <legend> Characters </legend>
        <p>First Name: <input type="text" name="firstName" /> </p>
        <p>Last Name: <input type="text" name="lastName" /> </p>
        <p>Age: <input type="text" name="age" /> </p>
        <p>Rank: 
            <select>
                <option value="1">Unknown Title</option>
            </select>
        </p>
        
        <p>Place of Origin: 
            <select>
                <option value="1">Unknown City</option>
            </select>
        </p>
        
        <p>Family Name: 
            <select>
                <option value="1">Unknown</option>
            </select>
        </p>
        
        <p>Allegiance to: 
            <select>
                <option value="1">Unknown House</option>
            </select>
        </p>
        
        <p>
            <input type="submit" name="add" value="Insert into Table">
            <input type="submit" name="update" value="Update in Table">
        </p>
    </fieldset>
</form>
<br>
<br>
    
<form method="post" action=".php"> <!-- post to page handling form-->
    <fieldset>
        <legend> Origin </legend>
        <p>City: <input type="text" name="city" /> </p>
        <p>Country:
            <select>
                <option value="1">Unknown</option>
                <option value="2">Kingdom of the North</option>
                <option value="3">Kingdom of the Mountain and the Vale</option>
                <option value="4">Kingdom of the Isles and Rivers</option>
                <option value="5">Kingdom of the Rock</option>
                <option value="6">Kingdom of the Stormlands</option>
                <option value="7">Kingdom of the Reach</option>
                <option value="8">Principality of Dorne</option>
            </select>
        </p>

        <p>
            <input type="submit" value="Insert into Table">
            <input type="submit" name="update" value="Update in Table">
        </p>

    </fieldset>
</form>
<br>
<br>
    
<form method="post" action=".php"> <!-- post to page handling form-->
<fieldset>
	<legend> Family </legend>
	<p>Mother: <input type="text" name="mother" /> </p>
	<p>Father: <input type="text" name="father" /> </p>
	<p>Sibling: <input type="text" name="sibling" /> </p>
    <p>
        <input type="submit" value="Insert into Table">
        <input type="submit" name="update" value="Update in Table">
    </p>
</fieldset>
</form>
<br>
<br> 

<form method="post" action=".php"> <!-- post to page handling form-->
    <fieldset>
        <legend> Title </legend>
        <p>Character Title: <input type="text" name="title" /> </p>
        <p>
            <input type="submit" value="Insert into Table">
            <input type="submit" name="update" value="Update in Table">
        </p>
    </fieldset>
</form>
<br>
<br>
    
<form method="post" action=".php"> <!-- post to page handling form-->
    <fieldset>
        <legend> Allegiance </legend>
        <p>House: <input type="text" name="allegiance" /> </p>
        <p>
            <input type="submit" value="Insert into Table">
            <input type="submit" name="update" value="Update in Table">
        </p>
    </fieldset>
</form>
<br>
<br>

    
</body>
</html>
