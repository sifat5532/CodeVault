<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Explore — CodeVault</title>
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
    <div class="feed-layout">

      <!-- ===== LEFT SIDEBAR (Category Navigation) ===== -->
      <aside class="sidebar-left">
        <div class="section-label" style="margin-left: 16px; margin-bottom: 8px;">Explore</div>
        <nav class="sidebar-nav">
          <a href="#devs" class="active"><span class="nav-icon">👥</span> Top Developers</a>
          <a href="#repos"><span class="nav-icon">📦</span> Top Repositories</a>
          <a href="#tags"><span class="nav-icon">🏷️</span> Top Tags</a>
        </nav>
      </aside>

      <!-- ===== MAIN CONTENT ===== -->
      <main class="feed-main">
        <header class="feed-header anim-fadeup"
          style="flex-direction: column; align-items: flex-start; margin-bottom: 40px;">
          <div>
            <h1 style="font-size: 28px; margin-bottom: 8px;">Discover CodeVault</h1>
            <p class="text-muted" style="max-width: 500px;">Discover the most popular creators, projects, and
              technologies trending across the vault today.</p>
          </div>
        
          <nav class="mobile-search-filters" style="margin-top: 24px;">
            <a href="#devs" class="active"><span class="nav-icon">👥</span> Top Developers</a>
            <a href="#repos"><span class="nav-icon">📦</span> Top Repositories</a>
            <a href="#tags"><span class="nav-icon">🏷️</span> Top Tags</a>
          </nav>
        </header>

        <!-- Top Developers Section -->
        <section id="devs" class="explore-section">
          <div class="section-label">Top Developers</div>
          <div class="follower-list">
            <div class="follower-card anim-fadeup" style="animation-delay:0.05s">
              <div class="avatar lg">MZ</div>
              <div class="follower-info">
                <div class="follower-name">man_zhang</div>
                <div class="follower-handle">@man_zhang</div>
                <div class="flex items-center gap-12 mt-4">
                  <span class="repo-meta">📦 24 repos</span>
                  <span class="repo-meta">👥 1.2k followers</span>
                </div>
              </div>
              <div class="flex gap-8">
                <button class="follow-btn following" onclick="toggleFollow(this)">Following</button>
                <button class="btn btn-ghost btn-sm">View Profile</button>
              </div>
            </div>

            <div class="follower-card anim-fadeup" style="animation-delay:0.1s">
              <div class="avatar lg">NJ</div>
              <div class="follower-info">
                <div class="follower-name">neeraj_dev</div>
                <div class="follower-handle">@neeraj_dev</div>
                <div class="flex items-center gap-12 mt-4">
                  <span class="repo-meta">📦 18 repos</span>
                  <span class="repo-meta">👥 980 followers</span>
                </div>
              </div>
              <div class="flex gap-8">
                <button class="follow-btn" onclick="toggleFollow(this)">Follow</button>
                <button class="btn btn-ghost btn-sm">View Profile</button>
              </div>
            </div>
          </div>
        </section>

        <!-- Top Repositories Section -->
        <section id="repos" class="explore-section">
          <div class="section-label">Top Repositories</div>
          <div class="feed-list">
            <div class="feed-repo-card anim-fadeup" style="animation-delay:0.15s">
              <div class="frc-top">
                <div class="frc-meta">
                  <div class="avatar">SL</div>
                  <div>
                    <div class="repo-name">samon_liu / fastapi-boilerplate</div>
                    <div class="by">by <strong>samon_liu</strong></div>
                  </div>
                </div>
                <button class="star-btn starred" onclick="toggleStar(this)">★ <span>892</span></button>
              </div>
              <p class="frc-desc">Production-ready FastAPI starter with JWT auth, PostgreSQL, and Docker Compose.</p>
              <div class="frc-footer">
                <div class="version-chip">✦ v5</div>
                <span class="tag">python</span>
                <span class="tag">fastapi</span>
                <button class="btn btn-ghost btn-sm" style="margin-left: auto;">View Repository</button>
              </div>
            </div>

            <div class="feed-repo-card anim-fadeup" style="animation-delay:0.2s">
              <div class="frc-top">
                <div class="frc-meta">
                  <div class="avatar">AM</div>
                  <div>
                    <div class="repo-name">alex_m / admin-panel-react</div>
                    <div class="by">by <strong>alex_m</strong></div>
                  </div>
                </div>
                <button class="star-btn" onclick="toggleStar(this)">☆ <span>531</span></button>
              </div>
              <p class="frc-desc">Professional admin panel template built with React, Tailwind, and Recharts.</p>
              <div class="frc-footer">
                <div class="version-chip">✦ v12</div>
                <span class="tag">react</span>
                <span class="tag">tailwind</span>
                <button class="btn btn-ghost btn-sm" style="margin-left: auto;">View Repository</button>
              </div>
            </div>
          </div>
        </section>

        <!-- Top Tags Section -->
        <section id="tags" class="explore-section">
          <div class="section-label">Top Tags</div>
          <div class="follower-list">
            <div class="follower-card anim-fadeup" style="animation-delay:0.25s">
              <div class="tag-icon-box">🏷️</div>
              <div class="follower-info">
                <div class="follower-name text-accent mono">#python</div>
                <p class="text-muted" style="font-size: 13px; margin-top: 4px;">General-purpose programming language. Used for ML, Backends, and Scripting.</p>
                <div class="repo-meta mt-8">📦 1,240 repos</div>
              </div>
              <button class="btn btn-ghost btn-sm">Browse Tag</button>
            </div>

            <div class="follower-card anim-fadeup" style="animation-delay:0.3s">
              <div class="tag-icon-box">🏷️</div>
              <div class="follower-info">
                <div class="follower-name text-accent mono">#react</div>
                <p class="text-muted" style="font-size: 13px; margin-top: 4px;">A JavaScript library for building user interfaces.</p>
                <div class="repo-meta mt-8">📦 980 repos</div>
              </div>
              <button class="btn btn-ghost btn-sm">Browse Tag</button>
            </div>
          </div>
        </section>
      </main>

      <!-- ===== RIGHT SIDEBAR (Statistics) ===== -->
      <aside class="sidebar-right">
        <div class="sidebar-widget">
          <div class="widget-header">Global Statistics</div>
          <div class="profile-stats" style="border: none; padding: 20px;">
            <div class="profile-stat">
              <div class="n">4k+</div>
              <div class="l">Devs</div>
            </div>
            <div class="profile-stat">
              <div class="n">12k+</div>
              <div class="l">Repos</div>
            </div>
            <div class="profile-stat">
              <div class="n">500+</div>
              <div class="l">Tags</div>
            </div>
          </div>
        </div>
      </aside>
    </div>

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

    // Category Navigation active state
    const navLinks = document.querySelectorAll('.sidebar-nav a, .mobile-search-filters a');
    navLinks.forEach(link => {
      link.addEventListener('click', function () {
        navLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
      });
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

  </script>
</body>

</html>