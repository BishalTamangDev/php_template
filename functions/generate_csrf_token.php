<?php
function generateCsrfToken()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['csrf-token'])) {
        $_SESSION['csrf-token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf-token'];
}
