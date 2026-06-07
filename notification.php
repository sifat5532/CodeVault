<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notifications — CodeVault</title>
  <link rel="stylesheet" href="style.css"/>
</head>
<body>

<!-- ===== NAVBAR (Shared from feed.php) ===== -->
<nav class="navbar">
  <a href="feed.php" class="nav-logo">
    <div class="logo-icon">⬡</div>
    Code<span class="dim">Vault</span>
  </a>

  <div class="nav-links">
    <a href="explore.php">Explore</a>
  </div>

  <div class="nav-search">
    <span class="search-icon">🔍</span>
    <input type="text" placeholder="Search repos, developers…"/>
  </div>

  <div class="nav-right">
    <a href="#"><button class="btn btn-primary btn-sm new-repo-btn">+ New Repo</button></a>

    <a href="notification.php">
        <div class="notif-btn">
          🔔
          <div class="notif-dot"></div>
        </div>
      </a>

    <div class="user-menu">
      <div class="avatar" onclick="toggleDropdown()">RK</div>
      <div class="user-dropdown" id="userDropdown">
        <a href="#">👤 My Profile</a>
        <a href="#">⚙️ Settings</a>
        <div class="dd-divider"></div>
        <a href="index.php" class="danger">🚪 Sign out</a>
      </div>
    </div>
  </div>
</nav>

<!-- ===== NOTIFICATION CONTENT ===== -->
<div class="page-wrap">
  <main class="notif-container">
    <header class="notif-header anim-fadeup">
      <h1>Notifications</h1>
      <div class="notif-controls">
        <button class="btn btn-ghost btn-sm">Mark all as read</button>
      </div>
    </header>

    <div class="notif-list">
      
      <!-- Notification Item 1 -->
      <div class="notif-item unread anim-fadeup" style="animation-delay: 0.05s">
        <div class="avatar">MZ</div>
        <div class="notif-content">
          <p class="notif-text"><strong>man_zhang</strong> started following you</p>
          <span class="notif-time">2m ago</span>
        </div>
        <div class="notif-action-icon">👤</div>
      </div>

      <!-- Notification Item 2 -->
      <div class="notif-item unread anim-fadeup" style="animation-delay: 0.1s">
        <div class="avatar">NJ</div>
        <div class="notif-content">
          <p class="notif-text"><strong>neeraj_dev</strong> starred your repository <span class="repo-link">vault-cli-tools</span></p>
          <span class="notif-time">45m ago</span>
        </div>
        <div class="notif-action-icon">⭐</div>
      </div>

      <!-- Notification Item 3 -->
      <div class="notif-item anim-fadeup" style="animation-delay: 0.15s">
        <div class="avatar">SL</div>
        <div class="notif-content">
          <p class="notif-text"><strong>sara_liu</strong> uploaded a new version <span class="badge badge-green">v5</span> to <span class="repo-link">fastapi-boilerplate</span></p>
          <span class="notif-time">3h ago</span>
        </div>
        <div class="notif-action-icon">📦</div>
      </div>

      <!-- Notification Item 4 -->
      <div class="notif-item anim-fadeup" style="animation-delay: 0.2s">
        <div class="avatar" style="background: var(--accent); color: white;">CV</div>
        <div class="notif-content">
          <p class="notif-text"><strong>System:</strong> Your account security check was successful.</p>
          <span class="notif-time">Yesterday</span>
        </div>
        <div class="notif-action-icon">🛡️</div>
      </div>

    </div>
  </main>

  <!-- ===== FOOTER ===== -->
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
</div>

<script>
  function toggleDropdown() {
    document.getElementById('userDropdown').classList.toggle('open');
  }
  document.addEventListener('click', function(e) {
    const menu = document.querySelector('.user-menu');
    if (menu && !menu.contains(e.target)) {
      document.getElementById('userDropdown').classList.remove('open');
    }
  });
</script>
</body>
</html>
