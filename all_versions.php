<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Versions — neeraj_dev / react-dashboard-kit — CodeVault</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    .versions-container {
      max-width: 800px;
      margin: 0 auto;
      padding: 40px 24px 80px;
    }
    .version-header {
      margin-bottom: 32px;
    }
    .mb-16 { margin-bottom: 16px; }
  </style>
</head>

<body>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar">
    <a href="feed.html" class="nav-logo">
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
      <a href="new_repository.html"><button class="btn btn-primary btn-sm new-repo-btn">+ New Repo</button></a>

      <a href="notification.html">
        <div class="notif-btn">
          🔔
          <div class="notif-dot"></div>
        </div>
      </a>

      <div class="user-menu">
        <div class="avatar" onclick="toggleDropdown()">RK</div>
        <div class="user-dropdown" id="userDropdown">
          <a href="#">👤 My Profile</a>
          <a href="settings.html">⚙️ Settings</a>
          <div class="dd-divider"></div>
          <a href="index.html" class="danger">🚪 Sign out</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- ===== PAGE ===== -->
  <div class="page-wrap">
    <main class="versions-container">
      
      <div class="version-header anim-fadeup">
        <div class="repo-path mb-16">
          <span class="owner">neeraj_dev</span>
          <span class="sep">/</span>
          <span class="name">react-dashboard-kit</span>
        </div>
        <h1>Release History</h1>
        <p class="text-muted mt-8">Browse and download previous versions of this project.</p>
        <div class="mt-16">
            <a href="view_repo.html" class="text-accent">← Back to latest version</a>
        </div>
      </div>

      <div class="feed-list">
        <!-- Version Card 4 -->
        <div class="feed-repo-card anim-fadeup" style="animation-delay:0.05s">
          <div class="frc-top">
            <div class="version-chip" style="font-size: 14px; padding: 4px 12px;">v4.0</div>
            <button class="btn btn-primary btn-sm">⬇ Download ZIP</button>
          </div>
          <p class="frc-desc">Official React 18 support, dark mode components, and bundle size optimizations.</p>
          <div class="frc-footer">
            <span class="tag">latest</span>
            <span class="tag">stable</span>
            <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Uploaded Oct 24, 2024</div>
          </div>
        </div>

        <!-- Version Card 3 -->
        <div class="feed-repo-card anim-fadeup" style="animation-delay:0.1s">
          <div class="frc-top">
            <div class="version-chip" style="font-size: 14px; padding: 4px 12px; background: var(--bg-3); border-color: var(--border); color: var(--text-dim);">v3.2</div>
            <button class="btn btn-ghost btn-sm">⬇ Download ZIP</button>
          </div>
          <p class="frc-desc">Minor bug fixes for grid layout on Safari and updated peer dependencies.</p>
          <div class="frc-footer">
            <span class="tag">maintenance</span>
            <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Uploaded Sep 12, 2024</div>
          </div>
        </div>

        <!-- Version Card 2 -->
        <div class="feed-repo-card anim-fadeup" style="animation-delay:0.15s">
          <div class="frc-top">
            <div class="version-chip" style="font-size: 14px; padding: 4px 12px; background: var(--bg-3); border-color: var(--border); color: var(--text-dim);">v3.0</div>
            <button class="btn btn-ghost btn-sm">⬇ Download ZIP</button>
          </div>
          <p class="frc-desc">Complete rewrite in TypeScript and migration to CSS Modules for better scoping.</p>
          <div class="frc-footer">
            <span class="tag">major-update</span>
            <span class="tag">typescript</span>
            <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Uploaded July 05, 2024</div>
          </div>
        </div>

        <!-- Version Card 1 -->
        <div class="feed-repo-card anim-fadeup" style="animation-delay:0.2s">
          <div class="frc-top">
            <div class="version-chip" style="font-size: 14px; padding: 4px 12px; background: var(--bg-3); border-color: var(--border); color: var(--text-dim);">v1.0</div>
            <button class="btn btn-ghost btn-sm">⬇ Download ZIP</button>
          </div>
          <p class="frc-desc">Initial release including Basic Sidebar, Stats Cards, and Line Charts.</p>
          <div class="frc-footer">
            <span class="tag">initial</span>
            <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Uploaded Jan 20, 2024</div>
          </div>
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
    // Dropdown toggle
    function toggleDropdown() {
      document.getElementById('userDropdown').classList.toggle('open');
    }
    document.addEventListener('click', function (e) {
      const menu = document.querySelector('.user-menu');
      if (menu && !menu.contains(e.target)) {
        document.getElementById('userDropdown').classList.remove('open');
      }
    });

    // // Star toggle
    // function toggleStar(btn) {
    //   const starred = btn.classList.contains('starred');
    //   const countEl = btn.querySelector('span');
    //   let count = parseInt(countEl.textContent);
    //   if (starred) {
    //     btn.classList.remove('starred');
    //     btn.innerHTML = '☆ <span>' + (count - 1) + '</span>';
    //   } else {
    //     btn.classList.add('starred');
    //     btn.innerHTML = '★ <span>' + (count + 1) + '</span>';
    //   }
    // }

    // // Follow toggle
    // function toggleFollow(btn) {
    //   if (btn.classList.contains('following')) {
    //     btn.classList.remove('following');
    //     btn.textContent = 'Follow';
    //   } else {
    //     btn.classList.add('following');
    //     btn.textContent = 'Following';
    //   }
    // }

    // Feed filter
  </script>
</body>

</html>