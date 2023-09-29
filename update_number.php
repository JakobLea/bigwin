<?php
// Include your database connection code here
include 'station.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the new number from the form
    $newNumber = $_POST["new_number"];
    
    // Validate the new number (you can add more validation as needed)
    if (!is_numeric($newNumber)) {
        echo "Invalid input. Please enter a valid number.";
    } else {
        // Get the record's unique identifier (e.g., ID)
        $recordId = $_GET["id"]; // Replace with how you identify the record

        // Update the database with the new number
        $sql = "UPDATE your_table_name SET number_column = :newNumber WHERE id = :recordId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':newNumber', $newNumber, PDO::PARAM_INT);
        $stmt->bindParam(':recordId', $recordId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Number updated successfully.";
        } else {
            echo "Error updating number: " . $stmt->errorInfo()[2];
        }
    }
}
?>
