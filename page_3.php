<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","?-db","?","?-db");
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
    <h4>Game of Thrones Origins:</h4>
	<tbody>
            <tr>             
                <td>
                    City
                </td>
                <td>
                    Country
                </td>
            </tr>
			
<?php
if(isset($_POST["view"])){

	if(!($stmt = $mysqli->prepare("SELECT city, country FROM `origin`"))){
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}

	if(!$stmt->execute()){
		echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
	}
	if(!$stmt->bind_result($city, $country)){
		echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
	}
	while($stmt->fetch()){
		echo "<tr>\n<td>\n" . $city . "\n</td>\n<td>\n" . $country . "\n</td>\n</tr>";
	}
	$stmt->close();
}

if(isset($_POST["add"])){
	
	if(!($stmt = $mysqli->prepare("INSERT INTO `origin`(city, country) VALUES (?,?)"))){
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	
	if(!($stmt->bind_param("ss",$_POST['city'],$_POST['country']))){
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
	
	if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
	}else{
		echo "Added " . $stmt->affected_rows . " row(s) to Origin table.";
	}

	if(!($stmt = $mysqli->prepare("SELECT city, country FROM `origin`"))){
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}

	if(!$stmt->execute()){
		echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
	}
	if(!$stmt->bind_result($city, $country)){
		echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
	}
	while($stmt->fetch()){
		echo "<tr>\n<td>\n" . $city . "\n</td>\n<td>\n" . $country . "\n</td>\n</tr>";
	}
	$stmt->close();

}

if(isset($_POST["filter"])){

	if(!($stmt = $mysqli->prepare("SELECT city, country FROM `origin` WHERE country = ?"))){
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}

	if(!($stmt->bind_param("s",$_POST['country']))){
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
	
	if(!$stmt->execute()){
		echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
	}
	if(!$stmt->bind_result($city, $country)){
		echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
	}
	while($stmt->fetch()){
		echo "<tr>\n<td>\n" . $city . "\n</td>\n<td>\n" . $country . "\n</td>\n</tr>";
	}
	$stmt->close();
}
?>				
			
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


   
<form method="post" action="page_3.php"> <!-- post to page handling form-->
    <fieldset>
        <legend> Origin </legend>
        <p>City: <input type="text" name="city" /> </p>
        <p>Country:
            <select name="country">
				<option value="Unknown">Unknown</option>
                <option value="The North">The North</option>
                <option value="The Iron Islands">The Iron Islands</option>
                <option value="The Vale of Arynn">The Vale of Arynn</option>
                <option value="The Riverlands">The Riverlands</option>
                <option value="The Crownlands">The Crownlands</option>
                <option value="The Stormlands">The Stormlands</option>
                <option value="The Reach">The Reach</option>
                <option value="Dorne">Dorne</option>
            </select>
        </p>

        <p>
            <input type="submit" name="add" value="Insert into Table">
            <input type="submit" name="update" value="Update in Table">
			<input type="submit" name="view" value="View Entire Origin Table">			
        </p>
		<p>
			<div> Filter by Country - Shows cities in a country </div>
			<input type="submit" name="filter" value="Run Filter">
		</p>
    </fieldset>
</form>
<br>
    
<form method="post" action="page_4.php"> <!-- post to page handling form-->
<fieldset>
	<legend> Family </legend>
	<p>Mother: <input type="text" name="mother" /> </p>
	<p>Father: <input type="text" name="father" /> </p>
	<p>Sibling: <input type="text" name="sibling" /> </p>
	<p>
		Character
		<select name="character">
<?php
if(!($stmt = $mysqli->prepare("SELECT id, first_name, last_name FROM `character`"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $first_name, $last_name)){
	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $first_name . " " . $last_name . '</option>\n';
}
$stmt->close();
?>				
		</select>
	</p>
    <p>
            <input type="submit" name="add" value="Insert into Table">
            <input type="submit" name="update" value="Update in Table">
			<input type="submit" name="view" value="View Entire Family Table">			
        </p>
		<p>
			<div> Filter by Mother's name - Shows father or sibling depending on Mother entered </div>
			<input type="submit" name="filter" value="Run Filter">
		</p>
</fieldset>
</form>
<br>

<form method="post" action="page_5.php"> <!-- post to page handling form-->
    <fieldset>
        <legend> Title </legend>
        <p>Character Title: <input type="text" name="title" /> </p>
        <p>
            <input type="submit" name="add" value="Insert into Table">
            <input type="submit" name="update" value="Update in Table">
			<input type="submit" name="view" value="View Entire Title Table">
        </p>
		<p>Title:
			<select name="char_title_id">
<?php
if(!($stmt = $mysqli->prepare("SELECT id,character_title FROM `title`"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id,$character_title)){
	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value="'. $id . '"> ' . $character_title  . '</option>\n';
}
$stmt->close();
?>						
				
			</select>
		</p>
		<p>
		Character
		<select name="character">
<?php
if(!($stmt = $mysqli->prepare("SELECT id, first_name, last_name FROM `character`"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $first_name, $last_name)){
	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $first_name . " " . $last_name . '</option>\n';
}
$stmt->close();
?>				
		</select>
	   </p>		
		<p>
			<div> Filter by Title - Shows characters with selected title </div>
			<input type="submit" name="filter" value="Run Filter">
		</p>
		<p>
			<div> Promote selected Character with selected Title - ADD to holds_rank table </div>
			<input type="submit" name="promote" value="Give Title">
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

