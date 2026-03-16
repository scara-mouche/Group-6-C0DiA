<?php
session_start();

// Only admin can access
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: dashboard.php");
    exit();
}

// Connect to database
$conn = new mysqli("localhost", "root", "", "codia_db");
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

// Get all login records from login_logs
$result = $conn->query("SELECT username, login_time FROM login_logs ORDER BY login_time DESC");
if(!$result){
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        body{
            margin:0;
            font-family: Arial, sans-serif;
            background:#0f172a;
            color:white;
        }

        .container{
            padding:40px;
        }

        h1{
            font-size:36px;
            color:#38bdf8;
        }

        h2{
            font-size:28px;
            margin-top:30px;
            color:#60a5fa;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
            background:#020617;
            border-radius:8px;
            overflow:hidden;
        }

        table th, table td{
            border:1px solid #334155;
            padding:12px;
            text-align:left;
        }

        table th{
            background:#1e293b;
            color:#f1f5f9;
        }

        table tr:nth-child(even){
            background:#111827;
        }

        table tr:hover{
            background:#1e293b;
        }
    </style>
</head>
<body>

<h1>Admin Panel</h1>

<h2>User Login Logs</h2>

<table border="1">
    <tr>
        <th>Username</th>
        <th>Login Time</th>
    </tr>

    <?php while($row = $result->fetch_assoc()){ ?>
        <tr>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo $row['login_time']; ?></td>
        </tr>
    <?php } ?>

</table>

</body>
</html>