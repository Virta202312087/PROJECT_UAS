<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_BCRYPT);
    echo "<h3>Password yang di-hash:</h3>";
    echo "<textarea rows='3' cols='80'>" . htmlspecialchars($hash) . "</textarea>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Generator Hash Password</title>
</head>
<body>
    <h2>Generate Bcrypt Password Hash</h2>
    <form method="POST">
        <label>Masukkan Password:</label><br>
        <input type="text" name="password" required><br><br>
        <button type="submit">Generate Hash</button>
    </form>
</body>
</html>
