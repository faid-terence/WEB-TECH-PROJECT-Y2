<?php
session_start();
require 'src/config/db.php'; 

// Check if the user is logged in as an admin
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
    // Redirect to a login page for non-admin users
    header('location: src/pages/login.html');
    exit();
}

// Initialize an empty array to store course data
$courseData = array();

// Fetch course data from the database
$sql = "SELECT * FROM courses";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Add each course's data to the $courseData array
        $courseData[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml"
        href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHoAAAB6CAMAAABHh7fWAAAAY1BMVEX///8AAABZWVnw8PBra2vFxcVgYGDMzMxjY2P8/PyKiork5OS3t7fT09OAgIDz8/Onp6eenp6wsLA4ODg/Pz9JSUnb29t5eXlRUVFEREQmJia9vb2RkZEQEBAuLi4gICAXFxdOuHmjAAADmklEQVRoge2Y2ZajIBBAS8EFUREXNHFJ//9XDookMWI63Sedl6n7lByQK4hlFQAIgiAIgiAIgiAIgiAIgjyBUf87OgnAn/eIHgYNu1vjqT9yS+9bOFcQPevQggg2g/Lq1phDwdxqMa1dxss0XUbzs6pP9TSuDQl0JUD2Zf5NXXPS1NXlOnhNgMrtqMT3rlfH0m22025KRYQg5fInZhqhEnMxK/35trPzOhRbECSTqz2Aod3NKLZmOhyZAeYehb7RoJBFvvSnUEpZBIR/LU0jX/ql61gpjeMwpG3BoV1uFIJ6v6TZ0tuHPD82g57cACJshjItrXoq0iI5tXoRLiDXKVl1W3JCCFdpQtXsVqJS+1HN5ggh5E/UyvviUKd3F1Bolmlkke9JGNVWnWfXVS2Ck9dB61pSq46fqaGLIV2XJbBqYf4XHg9COFJreeD1RG+z36oLvRfUVn1a1SoE3743LrWOCywpXIO+pua9aMCtZpyMtptTDQzOztf2NbXe3fRADdAnz9XAKbh4VX1lr4brnPZqsu3wdvWVnXqQ6jA+/15dv6AuvSLaRbGPqHW4KaLjUPVWdW/Vyt7Ih9RMmSAbpv5QlqUcP6Vmg+fgT9TVNjaKxmX+iLr1ZEaKpa3NFsoPqZXPdbRt121G+EwxfkStP8+0Tqw66SilcVL8kXraLjgL5ePLNffdqSN2DavvUsO84XeBNH1Qs6QCZePb29TgUgML7gMpb+akzmYsf6wGkW2bc8jLD6lvsMQ0xrbx1+rzD9XKpPwDdNZk1fSP1f1aqQzQbNUNo9Gu91vVag3xyeOsvWh4Uny8Qw1ATZQFavNXEwU8L5tenPav1ev6grRZ5FrB6urCc6Xpb1SDedqcV+vn1iyDLrpIdVDjvk1tvmvSlrtkrbB7cFcIx+rLXk3MPBqRONNQtnzSvwTplqdtqmVdhfLza2ZuUoKJ1LuZcXsEEEaV81XlS/3dMZboylGZ0rshEAauzjvW6l27+8fhA+9KmNbOq9WyxnUqOJfmCCIU7ip0T3kbfkw22RnLvTuaJHRe/5DAnXtg/nGifg8f5I3SnGLYQYm4Y390skB6wcq4WiZ8OeXBHOQOj1F2t72ZwuaG2QYxubYal4FOFbjKMkX0j8ivXw2i+usT0zsu6a1JxRtod3JutT6RvTKnHXnTlK+90MZN7hH3T1uQbRtxD8vmE5Y4DOM8VT8QIwiCIAiCIAiCIAiCIMj/zT+vAjZIqF5c6wAAAABJRU5ErkJggg==  " />
    <title>Admin Dashboard | Code with Faid</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/dash.css">
</head>

<body>
    <div class="container">
    <nav>
            <ul>
                <li><a href="" class="logo">
                        <img src="../../assets/images/mylogo.png" alt="">
                        <span class="nav-item">Dashboard</span>
                    </a></li>
                <li><a href="./AdminDashboard.html">
                        <i class="fas fa-home"></i>
                        <span class="nav-item">Home</span>
                    </a></li>
                <li><a href="">
                        <i class="fas fa-user"></i>
                        <span class="nav-item">Profiles</span>
                    </a></li>
                <li><a href="">
                        <i class="fas fa-tasks"></i>
                        <span class="nav-item">Courses</span>
                    </a></li>
                <li><a href="./AddNewCourses.html">
                        <i class="fas fa-plus-circle"></i>
                        <span class="nav-item">Add new Courses</span>
                    </a></li>
                <li><a href="../../index.html" class="logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="nav-item">Log Out</span>
                    </a></li>
            </ul>
        </nav>
        <div class="table-container">
            <div class="table-header">
                <h1>All Courses</h1>
                <a href="./AddNewCourses.html" class="create-button">
                    <i class="fas fa-plus"></i> Add Course
                </a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Course Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courseData as $course) : ?>
                        <tr>
                            <td><?php echo $course['id']; ?></td>
                            <td><?php echo $course['courseName']; ?></td>
                            <td><?php echo $course['courseDescription']; ?></td>
                            <td><?php echo $course['courseCategory']; ?></td>
                            <td>
                                <button>Edit</button>
                                <button>Delete</button>
                                <button>View</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
