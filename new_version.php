<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add New Version — CodeVault</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar">
    <a href="feed.php" class="nav-logo">
      <div class="logo-icon">⬡</div>
      Code<span class="dim">Vault</span>
    </a>

    <div class="nav-links">
      <a href="#">Explore</a>
    </div>

    <div class="nav-search">
      <span class="search-icon">🔍</span>
      <input type="text" placeholder="Search repos, developers…" />
    </div>

    <div class="nav-right">
      <a href="new_repository.php"><button class="btn btn-primary btn-sm new-repo-btn">+ New Repo</button></a>

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

  <!-- ===== PAGE ===== -->
  <div class="page-wrap">
    <main class="create-repo-container">
      <header class="create-repo-header anim-fadeup">
        <h1 class="section-title">Upload a new version</h1>
        <p class="section-sub">Updating <span class="text-accent">react-dashboard-kit</span>. All previous versions will remain available in the archive.</p>
      </header>

      <form class="settings-card anim-fadeup" style="animation-delay: 0.1s;">
        <!-- Version Info -->
        <div class="flex gap-12 mb-24">
          <div class="form-group" style="flex: 1;">
            <label for="version-number">New Version Tag</label>
            <input type="text" id="version-number" placeholder="e.g. 5.0.1" required />
            <p class="text-muted" style="font-size: 12px; margin-top: 4px;">Latest is currently v4.0</p>
          </div>
        </div>

        <!-- Version Description -->
        <div class="form-group">
          <label for="version-desc">What's new in this version?</label>
          <textarea id="version-desc" rows="5" placeholder="Describe fixes, new features, or breaking changes..."></textarea>
        </div>

        <div class="divider mb-24"></div>

        <!-- File Upload -->
        <div class="form-group">
          <label for="zip-file">Project Source (ZIP) <span class="text-red">*</span></label>
          <input type="file" id="zip-file" class="custom-file-input" accept=".zip" required />
        </div>

        <div class="divider mb-24"></div>

        <div class="flex gap-12" style="justify-content: flex-end;">
          <button type="button" class="btn btn-ghost" onclick="window.history.back()">Cancel</button>
          <button type="submit" class="btn btn-primary">Publish New Version</button>
        </div>
      </form>
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
    // Dropdown toggle
    function toggleDropdown() {
      document.getElementById('userDropdown').classList.toggle('open');
    }
    document.addEventListener('click', function (e) {
      const menu = document.querySelector('.user-menu');
      if (!menu.contains(e.target)) {
        document.getElementById('userDropdown').classList.remove('open');
      }
    });

    // Version number validation
    document.getElementById('version-number').addEventListener('input', function (e) {
      this.value = this.value.replace(/[^0-9.]/g, '');
    });
  </script>
</body>
</html>