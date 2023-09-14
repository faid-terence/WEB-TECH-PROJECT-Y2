<?php
session_start();
require 'src/config/db.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
    // Redirect to a login page
    header('location: src/pages/login.html');
    exit();
}

if (isset($_POST['update-course-btn'])) {
    $courseId = $_POST['course-id'];
    $courseName = $_POST['course-title'];
    $courseDescription = $_POST['course-description'];
    $courseCategory = $_POST['course-category'];

    // Update the course in the database based on its ID
    $sql = "UPDATE courses SET courseName = ?, courseDescription = ?, courseCategory = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $courseName, $courseDescription, $courseCategory, $courseId);

    if ($stmt->execute()) {
        // Course update successful, redirect to the course listing page
        header('location: src/pages/AdminDashboard.html');
        exit();
    } else {
        // Course update failed, handle the error
        echo "Course update failed.";
    }

    $stmt->close();
}

$conn->close();
?>
