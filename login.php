<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign in — CodeVault</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    .auth-container {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 60px 24px;
    }
    .auth-card {
      background: var(--bg-2);
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      padding: 40px;
      width: 100%;
      max-width: 400px;
    }
  </style>
</head>
<body>
  <nav class="navbar">
    <a href="index.php" class="nav-logo">
      <div class="logo-icon">⬡</div>
      Code<span class="dim">Vault</span>
    </a>
  </nav>

  <main class="page-wrap auth-container">
    <form method="POST" action="" class="auth-card">
      <h2 style="margin-bottom: 24px; text-align: center;">Login to CodeVault</h2>
      
      <div class="form-group">
        <label>Username or Email</label>
        <input type="text" name="username_email" placeholder="you@example.com" />
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" />
      </div>
        <input type="submit" name="login_btn" value="Login" class="btn btn-primary" style="width:100%; justify-content:center; padding:11px;">
      <p class="modal-footer-text">Don't have an account? <a href="signup.php">Sign up free</a></p>
    </form>
  </main>

  <footer>
    <div class="footer-logo">⬡ CodeVault</div>
    <div class="footer-links">
      <a href="#">About</a>
      <a href="#">Privacy</a>
      <a href="#">Terms</a>
      <a href="#">Contact</a>
    </div>
    <div class="footer-copy">© 2025 CodeVault</div>
  </footer>
</body>
</html>