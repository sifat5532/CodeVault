<?php 
session_start();
if(isset($_SESSION["id"])){
    header("Location: feed.php");
    exit();
}

require "php/config.php";

if(isset($_POST["sign_in_btn"])){
    $name = $_POST["name"];
    $user_name = $_POST["user_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

    $default_bio = "No bio added yet.";
    $default_dp = "default_dp.jpg";
    $default_location = "No Location";
    $default_web = "";
    // $created_at = date("Y-m-d H:i:s");
    $default_notification_settings = "1$1$1$1";
    $default_repo_visibility = "public";

    $query = "INSERT INTO `user`(`user_name`, `name`, `email`, `password`, `profile_pic`, `bio`, `location`, `web`, `notification_settings`, `default_repo_visibility`) 
              VALUES ('$user_name', '$name', '$email', '$hashed_pass', '$default_dp', '$default_bio', '$default_location', '$default_web', '$default_notification_settings', '$default_repo_visibility')";

    if(mysqli_query($conn, $query)){
        $msg = "<div style='color: #28a745'>Account Created Successfully.</div>";
    }else{
        $msg = "<div style='color: #dc3545'>Error! Please Try Again Later.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign up — CodeVault</title>
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

    .border-success{
        border: !important 1px solid #198754;
    }

    .border-danger{
        border: !important 1px solid #dc3545;
    }
  </style>
  <script src="script.js" defer></script>
</head>
<body>
  <nav class="navbar">
    <a href="index.php" class="nav-logo">
      <div class="logo-icon">⬡</div>
      Code<span class="dim">Vault</span>
    </a>
  </nav>

  <main class="page-wrap auth-container">
    <form class="auth-card" method="POST" action="">
      <h2 style="margin-bottom: 24px; text-align: center;">Create your account</h2>
        <?php if(isset($msg)){ echo $msg; }?>
      <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" placeholder="Jhon Doe" required/>
      </div>
      <div class="form-group">
        <label id="usernameLabel">Username</label>
        <input type="text" name="user_name" id="username" placeholder="cooldev42" required/>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" placeholder="you@example.com" required/>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" required/>
      </div>
        <input type="submit" name="sign_in_btn" id="sign_in_btn" value="Create account" class="btn btn-primary" style="width:100%; justify-content:center; padding:11px;">
      <p class="modal-footer-text">Already have an account? <a href="login.php">Sign in</a></p>
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

  <script>
    const uname_input = document.getElementById("username");
    const uname_label = document.getElementById("usernameLabel");
    const signup_btn = document.getElementById("sign_in_btn");
    uname_input.addEventListener("input", (e) =>{
      validate_username(uname_input, uname_label, signup_btn);
    });
  </script>
</body>
</html>