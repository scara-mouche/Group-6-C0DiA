<?php
$conn = new mysqli("localhost", "root", "", "codia_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$first = trim($_POST['first']);
$last = trim($_POST['last']);
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];

// Check password match
if ($password !== $confirm) {
    die("Passwords do not match!");
}

// Password validation: exactly 8 chars + at least 1 number/special char
$pattern = "/^(?=.*[\d\W]).{8}$/";
if (!preg_match($pattern, $password)) {
    die("Password must be exactly 8 characters and contain at least one number or special character.");
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check for duplicate username or email
$check = $conn->prepare("SELECT id FROM users WHERE username=? OR email=?");
$check->bind_param("ss", $username, $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    die("Username or Email already exists!");
}
$check->close();

// INSERT statement (correct column names)
$stmt = $conn->prepare("INSERT INTO users (first, last, username, email, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $first, $last, $username, $email, $hashed_password);

// Execute
if ($stmt->execute()) {
    header("Location: index.html"); // redirect to login
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>