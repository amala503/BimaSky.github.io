<?php
require_once __DIR__ . '/../helpers/AuthHelper.php';

// Memeriksa apakah user sudah login dan memiliki akses
// Jika tidak, redirect ke halaman login
AuthHelper::requireLogin(true);
