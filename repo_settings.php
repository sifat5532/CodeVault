<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Repo Settings — CodeVault</title>
  <link rel="stylesheet" href="style.css" />
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
    <div class="settings-layout">
      <aside class="sidebar-left">
        <nav class="sidebar-nav">
          <a href="#general" class="active"><span class="nav-icon">📦</span> General</a>
          <a href="#contributors"><span class="nav-icon">👥</span> Contributors</a>
          <a href="#versions"><span class="nav-icon">📜</span> Versions</a>
          <a href="profile.html"><span class="nav-icon">⬅️</span> Back to Profile</a>
        </nav>
      </aside>

      <main class="settings-main">
        <section id="general" class="settings-section anim-fadeup">
          <h2 class="section-title">Repository Settings</h2>
          <p class="section-sub">Manage visibility and core details for <strong class="text-accent">react-dashboard-kit</strong>.</p>

          <div class="settings-card">
            <div class="form-group">
              <label>Repository Name</label>
              <input type="text" value="react-dashboard-kit" />
            </div>
            <div class="form-group">
              <label>Project Description</label>
              <textarea rows="3">A lightweight, zero-dependency React dashboard component library.</textarea>
            </div>
            <div class="form-group">
              <label>Visibility</label>
              <select>
                <option value="public">Public</option>
                <option value="private">Private</option>
              </select>
              <p class="text-muted mt-4">Public repositories are visible to everyone.</p>
            </div>
            <button class="btn btn-primary">Save Changes</button>
          </div>
        </section>

        <section id="contributors" class="settings-section anim-fadeup" style="animation-delay: 0.1s;">
          <h2 class="section-title">Manage Contributors</h2>
          <p class="section-sub">Add or remove users who can contribute to this project.</p>

          <div class="settings-card">
            <div class="form-group">
              <label>Add Contributor</label>
              <div class="search-input-group">
                <input type="text" placeholder="Search by username or email..." style="flex: 1;" />
                <button class="btn btn-primary">Add</button>
              </div>
            </div>

            <div class="divider"></div>

            <div class="contributor-list mt-16">
              <div class="contributor-item">
                <div class="flex items-center gap-12">
                  <div class="avatar">NJ</div>
                  <div>
                    <div class="name">neeraj_dev <strong>(Owner)</strong></div>
                  </div>
                </div>
              </div>
              <div class="contributor-item">
                <div class="flex items-center gap-12">
                  <div class="avatar">RK</div>
                  <div>
                    <div class="name">rafidkhan</div>
                  </div>
                </div>
                <button class="btn btn-ghost btn-sm text-red">Remove</button>
              </div>
            </div>
          </div>
        </section>

        <section id="versions" class="settings-section anim-fadeup" style="animation-delay: 0.15s;">
          <h2 class="section-title">Manage Versions</h2>
          <p class="section-sub">Review and delete specific versions of your project archive.</p>

          <div class="settings-card">
            <div class="contributor-list">
              <div class="contributor-item">
                <div class="flex items-center gap-12">
                  <div class="version-chip">v4.0</div>
                  <div>
                    <div class="name">Latest Version</div>
                    <div class="repo-meta">Uploaded Jan 20, 2025</div>
                  </div>
                </div>
                <button class="btn btn-outline-red btn-sm">Delete</button>
              </div>
              <div class="contributor-item">
                <div class="flex items-center gap-12">
                  <div class="version-chip" style="background: var(--bg-3); border-color: var(--border); color: var(--text-dim);">v3.2</div>
                  <div>
                    <div class="name">Previous Version</div>
                    <div class="repo-meta">Uploaded Sep 12, 2024</div>
                  </div>
                </div>
                <button class="btn btn-outline-red btn-sm">Delete</button>
              </div>
            </div>
          </div>
        </section>

        <section id="danger-zone" class="settings-section anim-fadeup" style="animation-delay: 0.2s;">
            <h2 class="section-title text-red">Danger Zone</h2>
            <div class="settings-card danger-card">
                <div class="setting-item">
                    <div>
                        <h3>Delete Repository</h3>
                        <p class="text-muted">Once deleted, there is no going back. Please be certain.</p>
                    </div>
                    <button class="btn btn-red">Delete Repo</button>
                </div>
            </div>
        </section>
      </main>
    </div>

    <!-- ===== FOOTER ===== -->
    <footer>
      <div class="footer-logo">⬡ CodeVault</div>
      <div class="footer-links"><a href="#">About</a><a href="#">Privacy</a><a href="#">Terms</a><a href="#">Contact</a></div>
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
  </script>
</body>

</html>