<?php
session_start();      // hidupkan session

session_unset();      // hapus semua data session
session_destroy();    // hancurkan session

// optionally hapus cookie session kalau ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// arahkan balik ke login
header("Location: login.php");
exit;
