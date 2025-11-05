<?php
include 'connect.php';

// Get form data from AJAX POST request
$ign = $_POST['ign'];
$role = $_POST['role'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$gender = $_POST['gender'];

// 1️⃣ Check if the exact same submission already exists
$checkSql = "SELECT * FROM players WHERE ign = ? AND role = ? AND firstname = ? AND lastname = ? AND gender = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("sssss", $ign, $role, $firstname, $lastname, $gender);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if($checkResult->num_rows > 0){
    // Exact same submission already exists
    echo "Already submitted!";
} else {
    // 2️⃣ Insert new data
    $sql = "INSERT INTO players (ign, role, firstname, lastname, gender) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $ign, $role, $firstname, $lastname, $gender);

    if($stmt->execute()){
        echo "Application submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Close connections
$checkStmt->close();
$conn->close();
?>