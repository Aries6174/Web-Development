<?php
$servername = "localhost";
$username = "username";
$password = "";
$database = "db_name"; // Define the database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully!<br>";

// Database Creation
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql_create_db) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select the database
$conn->select_db($database);

// Table Creation
$sql_create_table = "
    CREATE TABLE IF NOT EXISTS characters (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        class VARCHAR(30) NOT NULL,
        email VARCHAR(50),
        regdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )
";
if ($conn->query($sql_create_table) === TRUE) {
    echo "Table created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error;
}

// Insert data into the table
$name = "John Doe";
$class = "Warrior";
$email = "john.doe@example.com";

$sql_insert_data = "
    INSERT INTO characters (name, class, email)
    VALUES ('$name', '$class', '$email')
";
if ($conn->query($sql_insert_data) === TRUE) {
    echo "Data inserted successfully<br>";
} else {
    echo "Error inserting data: " . $conn->error;
}

// Select data from the table
$sql_select_data = "SELECT * FROM characters";
$result = $conn->query($sql_select_data);

if ($result->num_rows > 0) {
    echo "Data retrieved successfully<br>";
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["name"]. " - Class: " . $row["class"]. " - Email: " . $row["email"]. "<br>";
    }
} else {
    echo "No data found";
}

// Update data in the table
$id_to_update = 1; // Assuming you want to update the record with ID 1
$new_name = "Jane Doe";
$new_email = "jane.doe@example.com";

$sql_update_data = "
    UPDATE characters
    SET name='$new_name', email='$new_email'
    WHERE id=$id_to_update
";
if ($conn->query($sql_update_data) === TRUE) {
    echo "Data updated successfully<br>";
} else {
    echo "Error updating data: " . $conn->error;
}

// Delete data from the table
$id_to_delete = 2; // Assuming you want to delete the record with ID 2

$sql_delete_data = "
    DELETE FROM characters
    WHERE id=$id_to_delete
";
if ($conn->query($sql_delete_data) === TRUE) {
    echo "Data deleted successfully";
} else {
    echo "Error deleting data: " . $conn->error;
}

$conn->close();
?>
