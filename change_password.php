<?php
// change_password.php

$host = 'localhost';
$dbname = 'jega_mytradebit';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// username and new password
$username = 'admin'; // change to your username
$newPassword = 'MyNewPassword123';

// generate password hash (compatible with Yii2)
$passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $stmt = $pdo->prepare("UPDATE user SET password = :hash WHERE username = :username");
    $stmt->execute([
        ':hash' => $passwordHash,
        ':username' => $username
    ]);

    echo "Password updated successfully for user: $username\n";

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}