<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","USER-db","PASS","USER-db");
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
			
			<tr>
                <td>
                    <a href="__.php?id=__">John</a> 
                </td>
                <td>
                    <a href=".php?id=">Snow</a>
                </td>
                <td>
                    <a href=".php?id=">24</a>
                </td>
            </tr>
			
	</tbody>
</table>
    <br>
    <br>

    
<form method="post" action="page_2.php"> <!-- post to page handling form-->    
    <fieldset>
        <legend> Characters </legend>
        <p>First Name: <input type="text" name="firstName" /> </p>
        <p>Last Name: <input type="text" name="lastName" /> </p>
        <p>Age: <input type="text" name="age" /> </p>
<!-- Move to another fieldset		
        <p>Rank: 
            <select>
                <option value="1">Unknown Title</option>
            </select>
        </p>
        -->
        <p>Place of Origin: 
            <select name="origin">
                <!-- <option value="1">Unknown City</option> -->
<?php
if(!($stmt = $mysqli->prepare("SELECT id, city, country FROM `origin`"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $city, $country)){
	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $city . ", " . $country . '</option>\n';
}
$stmt->close();
?>					
            </select>
        </p>
		<!-- Move to another fieldset
        
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
        -->
        <p>
            <input type="submit" name="add" value="Insert into Table">
            <input type="submit" name="update" value="Update in Table">
			<input type="submit" name="view" value="View Full Character Table">
		</p>
		<p>
			<div>Run filter by Age only. Shows characters older than entered age. </div>
			<input type="submit" name="filter" value="Run Filter">
		</p>
    </fieldset>
</form>


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

    
</body>
</html>

