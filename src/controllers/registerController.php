<?php
session_start();
require 'src/config/db.php';
$errors = array();
$username = "";
$email = "";

// If the user clicks the Register Button
if (isset($_POST['register-btn'])) {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password1 = $_POST['password'];
    $password2 = $_POST['confirm-password'];

    // Validation
    if (empty($username)) {
        $errors['username'] = "Username is required";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Enter a valid Email";
    }

    if (empty($password1)) {
        $errors['password'] = "Password is required";
    } elseif ($password1 !== $password2) {
        $errors['password'] = "Passwords must match";
    }

    // Email must be Unique
    $emailQuery = "SELECT id FROM users WHERE userEmail=? LIMIT 1";
    $stmtEmail = $conn->prepare($emailQuery);
    $stmtEmail->bind_param("s", $email);
    $stmtEmail->execute();
    $stmtEmail->store_result(); // Store the result in our database
    if ($stmtEmail->num_rows > 0) {
        $errors['email'] = "Email already exists";
    }
    $stmtEmail->close();

    // Check errors
    if (empty($errors)) {
        // Hash or Encrypt our Password
        $password1 = password_hash($password1, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(20));
        $isAdmin = false;

        // Save User into our Database
        $sql = "INSERT INTO users (userName, userEmail, isAdmin, token, password) VALUES(?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($sql);
        $stmtInsert->bind_param("ssbss", $username, $email, $isAdmin, $token, $password1);

        if ($stmtInsert->execute()) {
            // Registration successful, set sessions and redirections
            $_SESSION['id'] = $stmtInsert->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['isAdmin'] = $isAdmin;
            header('location: src/pages/login.html');
            exit();
        }
        // Incase of unsuccessful login
         else {
            $errors["db_error"] = "Registration not successful";
        }
    }
}
?>
