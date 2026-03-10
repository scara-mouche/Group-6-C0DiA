<?php
session_start();

// Connect to database
$conn = new mysqli("localhost", "root", "", "codia_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form submitted
if(!isset($_POST['username'], $_POST['password'])){
    $_SESSION['error'] = "Please fill in all fields.";
    header("Location: index.php");
    exit();
}

// Get POST data
$user = trim($_POST['username']);
$password = trim($_POST['password']);

// Prepare statement to check user by username or email
$stmt = $conn->prepare("SELECT id, first, last, username, password FROM users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $user, $user);
$stmt->execute();
$result = $stmt->get_result();

$error = "";

// Check if user exists
if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $row['password'])) {

        session_regenerate_id(true); // secure session

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['first'] = $row['first'];

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();

    } else {
        $error = "Incorrect password.";
    }
} else {
    $error = "Account not found.";
}

$stmt->close();
$conn->close();

// Send error back to login page using SESSION
if ($error !== "") {
    $_SESSION['error'] = $error;
    header("Location: index.php");
    exit();
}
?>