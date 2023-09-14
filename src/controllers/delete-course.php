<?php
session_start();
require 'src/config/db.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
    // Redirect to a login page
    header('location: src/pages/login.html');
    exit();
}

if (isset($_GET['course_id'])) {
    $courseId = $_GET['course_id'];

    // Delete the course from the database based on its ID
    $sql = "DELETE FROM courses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $courseId);

    if ($stmt->execute()) {
        // Course deletion successful, redirect to the course listing page
        header('location: src/pages/AdminDashboard.html');
        exit();
    } else {
        // Course deletion failed, handle the error
        echo "Course deletion failed.";
    }

    $stmt->close();
}

$conn->close();
?>
