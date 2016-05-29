<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","ohya-db","7lNrX1pybWv6MFTO","ohya-db");
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
    <h2>Game of Thrones Database</h2>
    <br>
    
<table>
    <h4>Game of Thrones Characters:</h4>
	<tbody>
            <tr>
                <td>
                ID
                </td>
                <td>
                    First Name
                </td>
                <td>
                    Last Name
                </td>
                <td>
                    Age
                </td>
                <td>
                    Origin ID
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
// shows all character attributes with view button
if(isset($_POST["view"])){
	if(! ($stmt = $mysqli->prepare( "SELECT id, first_name, last_name, age, oid FROM `character`"))){
		echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
	}
}
// only used for filter, selects characters older than posted age
if(isset($_POST["filter"])){
	if(! ($stmt = $mysqli->prepare( "SELECT id, first_name, last_name, age, oid FROM `character` WHERE age > ?"))){
		echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
	}
	if(!($stmt->bind_param("i",$_POST['age']))){
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
}
// only used for add, inserts posted first name, last name , age and selected origin id into character table
if(isset($_POST["add"])){
	
	if(!($stmt = $mysqli->prepare("INSERT INTO `character`(first_name, last_name, age, oid) VALUES (?,?,?,?)"))){
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	
	if(!($stmt->bind_param("ssii",$_POST['firstName'],$_POST['lastName'],$_POST['age'],$_POST['origin']))){
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
}
        
// only if form is not posted with update
if(!(isset($_POST["update"]))){
	if(!$stmt->execute()){
		echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
	}else if(isset($_POST["add"])){
		echo "Added " . $stmt->affected_rows . " row(s) to character table.";
	}
}
// only for add, displays sucessfully entered table data
if(isset($_POST["add"])){
	if(! ($stmt = $mysqli->prepare( "SELECT id, first_name, last_name, age, oid FROM `character`"))){
		echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
	}
	
	if(!$stmt->execute()){
		echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
	}
}
// only if not update
if(!(isset($_POST["update"]))){
	if(!$stmt->bind_result($id, $firstName, $lastName, $age, $oid)){
		echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
	}
	while($stmt->fetch()){
		echo "<tr>\n<td>\n" . $id . "\n</td>\n<td>\n" . $firstName . "\n</td>\n<td>\n" . $lastName . "\n</td>\n<td>\n" . $age . "\n</td>\n<td>\n" . $oid . "\n</td>\n</tr>";
	}
	$stmt->close();
}
        
        
        
// updates character table ********************************UNDERCONSTRUCT************
if(isset($_POST["update"])){
	
	if(!($stmt = $mysqli->prepare("UPDATE `character` SET first_name=?, last_name=?, age=?, oid=? WHERE id=?"))){
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	
	//var_dump($_POST['charIDs']);
	//var_dump($_POST['origin']);
	$id = $_POST['charIDs'];
	$oid = $_POST['origin'];
	
	if(!($stmt->bind_param("ssiii",$_POST['firstName'],$_POST['lastName'],$_POST['age'],$oid,$id))){
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
    
	if(!$stmt->execute()){
		echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
	}else{
		echo "Updated " . $stmt->affected_rows . " row(s) to character table.";
	}
	
	if(! ($stmt = $mysqli->prepare( "SELECT id, first_name, last_name, age, oid FROM `character` WHERE id = ?"))){
		echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
	}
	
	if(!($stmt->bind_param("i",$id))){
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}
	
	if(!$stmt->execute()){
		echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
	}
	
    if(!$stmt->bind_result($id, $firstName, $lastName, $age, $oid)){
		echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
	}
	while($stmt->fetch()){
		echo "<tr>\n<td>\n" . $id . "\n</td>\n<td>\n" . $firstName . "\n</td>\n<td>\n" . $lastName . "\n</td>\n<td>\n" . $age . "\n</td>\n<td>\n" . $oid . "\n</td>\n</tr>";
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
            <div>Select the ID of the character you wish to update:
            </div>
            <select name="charIDs">
                <?php
                    //creates option for characters' IDs
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
                        echo '<option value=" '. $id . ' "> ' . $id . '</option>\n';
                    }
                    $stmt->close();
                    ?>	
            </select>
            
            <input type="submit" name="update" value="Update in Table">
		</p>
		<p>
			<div>Run filter by Age only. Shows characters older than entered age. </div>
			<input type="submit" name="filter" value="Run Filter">
		</p>
        <p>
            <input type="submit" name="view" value="View Full Character Table">
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
                <option value="The Shadowlands">The Shadowlands</option>
                <option value="Essos">Essos</option>
            </select>
        </p>

        <p>
            <input type="submit" name="add" value="Insert into Table">
			<input type="submit" name="view" value="View Entire Origin Table">
        </p>
		<p>
			<div> Filter by Country - Shows cities in a country </div>
			<input type="submit" name="filter" value="Run Filter">
		</p>
    </fieldset>
</form>
<br>
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
    
<form method="post" action="page_6.php"> <!-- post to page handling form-->
    <fieldset>
        <legend> Allegiance </legend>
        <p>House: <input type="text" name="allegiance" /> </p>
        <p>
			<input type="submit" name="add" value="Insert into Table">
			<input type="submit" name="view" value="View Entire Allegiance Table">
        </p>
		<p>
			<div> Swears selected Character with selected House - ADD to sworn table </div>
			<p>
				House
				<select name="house">
<?php
if(!($stmt = $mysqli->prepare("SELECT id, house FROM `allegiance`"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->bind_result($id, $house)){
	echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $house . '</option>\n';
}
$stmt->close();
?>				
				</select>
			</p>
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
			<input type="submit" name="add_to_sworn" value="Swear Allegiance">
			<input type="submit" name="view_sworn" value="View All Sworn">
		</p>
		<p> <div>Shows total number of characters sworn depending on selected House</div>
			<input type="submit" name="total_sworn" value="View Total Sworn">
		</p>
    </fieldset>
</form>
<br>

    
</body>
</html>