<?php
require_once __DIR__ . '/includes/auth-check.php';
session_destroy();
header('Location: /admin/login.php');
exit;
