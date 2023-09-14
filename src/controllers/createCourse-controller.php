<?php
session_start();
require 'config/db.php'; 

// Check if the user is logged in as an admin
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
    // Redirect to a login page for non-admin users
    header('location: src/pages/login.html');
    exit();
}

$errors = array();

if (isset($_POST['create-course-btn'])) {
    $courseName = $_POST['course-name'];
    $courseLessons = $_POST['course-lessons'];
    $courseCategory = $_POST['course-category'];
    $courseDate = $_POST['course-date'];
    $courseDescription = $_POST['course-description'];

    // Validation
    if (empty($courseName) || empty($courseLessons) || empty($courseCategory) || empty($courseDate) || empty($courseDescription)) {
        $errors[] = "All fields are required.";
    } else {
        // Insert the course into the database
        $sql = "INSERT INTO courses (courseName, courseLessons, courseCategory, courseDate, courseDescription) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $courseName, $courseLessons, $courseCategory, $courseDate, $courseDescription);

        if ($stmt->execute()) {
            // Course creation successful, redirect to a course listing
            header('location: src/pages/AdminDashboard.html'); 
            exit();
        } else {
            $errors[] = "Course creation failed.";
        }

        $stmt->close();
    }
}

?>


