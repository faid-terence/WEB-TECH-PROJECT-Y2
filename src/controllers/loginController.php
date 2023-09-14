<?php
session_start();
require 'config/db.php';

if (isset($_POST['login-btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validation
    if (empty($email) || empty($password)) {
        $error = "Both email and password are required.";
    } else {
        // Check user credentials
        $sql = "SELECT id, userEmail, password, isAdmin, token FROM users WHERE userEmail=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Password is correct, set session variables
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['userEmail'];
                $_SESSION['loggedin'] = true;
                $_SESSION['token'] = $row['token'];

                if ($row['isAdmin']) {
                    // Redirect to the Admin Dashboard
                    header('location: src/pages/AdminDashboard.html');
                } else {
                    // Redirect to the Student Dashboard
                    header('location: src/pages/StudentDashboard.html');
                }
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "Email not found.";
        }

        $stmt->close();
    }
}

?>
