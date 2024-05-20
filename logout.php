<?php
session_start();

if (isset($_SESSION['email'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    echo json_encode(['status' => 'success', 'message' => 'Logout successful']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
}
?>
