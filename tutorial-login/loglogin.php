<?php
session_start();

// Fungsi untuk mencatat aktivitas login
function logLogin($username) {
    $logMessage = date("Y-m-d H:i:s") . " - User $username logged in." . PHP_EOL;
    file_put_contents('activity.log', $logMessage, FILE_APPEND);
}

// Contoh penggunaan logLogin
$username = "user123"; // Ganti dengan username yang sebenarnya
logLogin($username);

// Lakukan proses login Anda di sini
?>
