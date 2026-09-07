<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/helpers.php';
if (!empty($_SESSION['user'])) redirect('dashboard.php');
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf($_POST['csrf'] ?? null);
    $stmt = $pdo->prepare('SELECT id, username, full_name, password_hash FROM users WHERE username = ? AND active = 1 LIMIT 1');
    $stmt->execute([trim($_POST['username'] ?? '')]);
    $user = $stmt->fetch();
    if ($user && password_verify($_POST['password'] ?? '', $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => $user['id'], 'username' => $user['username'], 'full_name' => $user['full_name']];
        redirect('dashboard.php');
    }
    $error = 'Invalid username or password.';
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Login · JM PADDY</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="assets/css/app.css"></head>
<body class="login-page"><div class="login-card"><div class="login-logo"><div class="brand-mark">JP</div><div><h1 class="login-title">JM PADDY</h1><p class="login-sub">Paddy & Farmer Bill Management System</p></div></div><?php if($error): ?><div class="alert error" style="margin:0 0 14px"><?=e($error)?></div><?php endif; ?><form class="stack" method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><div class="field"><label>Username</label><input name="username" autocomplete="username" placeholder="e.g. staff01" required></div><div class="field"><label>Password</label><input type="password" name="password" autocomplete="current-password" placeholder="••••••••" required></div><button class="btn btn-primary" type="submit">Login</button></form><div class="mini-note" style="margin-top:15px">Demo: <strong>admin</strong> / <strong>admin123</strong></div></div></body></html>
