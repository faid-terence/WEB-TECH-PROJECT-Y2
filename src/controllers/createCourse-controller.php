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
    $courseName = $_POST['course-title'];
    $courseLessons = $_POST['course-lessons'];
    $courseCategory = $_POST['course-category'];
    $courseDate = $_POST['course-date'];
    $courseDescription = $_POST['course-description'];

    // Handle Course Image Upload
    $targetDirectory = "course_images/";
    $targetFile = $targetDirectory . basename($_FILES["course-image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["create-course-btn"])) {
        $check = getimagesize($_FILES["course-image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $errors[] = "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check file size
    if ($_FILES["course-image"]["size"] > 5000000) {
        $errors[] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    $allowedFormats = array("jpg", "jpeg", "png", "gif"); 
    if (!in_array($imageFileType, $allowedFormats)) {
        $errors[] = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $errors[] = "Sorry, your file was not uploaded.";
    } else {
        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES["course-image"]["tmp_name"], $targetFile)) {
            // Image upload successful
            // Insert the course into the database along with the image file name
            $sql = "INSERT INTO courses (courseName, courseLessons, courseCategory, courseDate, courseDescription, courseImage) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $courseName, $courseLessons, $courseCategory, $courseDate, $courseDescription, $targetFile);

            if ($stmt->execute()) {
                // Course creation successful, redirect to a course listing
                header('location: src/pages/AdminDashboard.html'); 
                exit();
            } else {
                $errors[] = "Course creation failed.";
            }

            $stmt->close();
        } else {
            $errors[] = "Sorry, there was an error uploading your file.";
        }
    }
}

?>
