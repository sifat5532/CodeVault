<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Create New Repository — CodeVault</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body>

  <!-- ===== NAVBAR (Strictly from feed.php) ===== -->
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
        <h1 class="section-title">Create a new vault</h1>
        <p class="section-sub">A repository contains all your project files, including the version history.</p>
      </header>

      <form class="settings-card anim-fadeup" style="animation-delay: 0.1s;">
        <!-- Title -->
        <div class="form-group">
          <label for="repo-title">Repository Title</label>
          <input type="text" id="repo-title" placeholder="e.g. my-awesome-project" required />
          <p class="text-muted" style="font-size: 12px; mt-4">Great repository names are short and memorable.</p>
        </div>

        <!-- Description -->
        <div class="form-group">
          <label for="repo-desc">Description (optional)</label>
          <textarea id="repo-desc" rows="3" placeholder="What is your project about?"></textarea>
        </div>

        <div class="divider mb-24"></div>

        <!-- Versioning -->
        <div class="flex gap-12 mb-24">
          <div class="form-group" style="flex: 1;">
            <label for="version-number">Initial Version</label>
            <input type="text" id="version-number" placeholder="1.0.0" required />
          </div>
          <div class="form-group" style="flex: 2;">
            <label for="live-demo">Live Demo URL (optional)</label>
            <input type="url" id="live-demo" placeholder="https://example.com" />
          </div>
        </div>

        <div class="form-group">
          <label for="version-desc">Version Notes</label>
          <textarea id="version-desc" rows="3" placeholder="Initial release features..."></textarea>
        </div>

        <div class="divider mb-24"></div>

        <!-- File Uploads -->
        <div class="form-group">
          <label for="zip-file">Project Source (ZIP) <span class="text-red">*</span></label>
          <input type="file" id="zip-file" class="custom-file-input" accept=".zip" required />
        </div>

        <!-- Contributors -->
        <div class="form-group">
          <label for="contributors">Add Contributors (optional)</label>
          <input type="text" id="contributors" placeholder="Username or email, separated by commas" />
        </div>

        <div class="divider mb-24"></div>

        <!-- Visibility -->
        <div class="setting-item mb-24">
          <div>
            <label style="font-weight: 600;">Public Repository</label>
            <p class="text-muted">Anyone on the internet can see this repository.</p>
          </div>
          <label class="switch">
            <input type="checkbox" checked>
            <span class="slider round"></span>
          </label>
        </div>

        <div class="flex gap-12" style="justify-content: flex-end;">
          <button type="button" class="btn btn-ghost" onclick="window.history.back()">Cancel</button>
          <button type="submit" class="btn btn-primary">Create Repository</button>
        </div>
      </form>
    </main>

    <!-- ===== FOOTER (Strictly from index.php) ===== -->
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

  <!-- ===== SCRIPTS (Strictly from feed.php) ===== -->
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

    // Feed filter
    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', function () {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
      });
    });

    // Custom implementation: Version Number Restriction
    const versionInput = document.getElementById('version-number');
    if (versionInput) {
      versionInput.addEventListener('input', function (e) {
        // Restriction: only digits and dots
        this.value = this.value.replace(/[^0-9.]/g, '');
      });
    }

    // Custom implementation: Image Count Restriction (Max 5)
    const previewsInput = document.getElementById('previews');
    if (previewsInput) {
      previewsInput.addEventListener('change', function() {
        if (this.files.length > 5) {
          alert("You can only upload a maximum of 5 images.");
          this.value = ""; // Reset the input
        }
      });
    }
  </script>
</body>

</html>
```

<!--
[PROMPT_SUGGESTION]Add a JavaScript validation to ensure no more than 5 images are selected for previews.[/PROMPT_SUGGESTION]
[PROMPT_SUGGESTION]Style the file upload inputs in new_repo.php to match the custom file input style used in settings.php.[/PROMPT_SUGGESTION]
