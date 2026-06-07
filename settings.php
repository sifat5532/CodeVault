<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Settings — CodeVault</title>
  <link rel="stylesheet" href="style.css" />
  <!-- Assuming Font Awesome is linked globally if icons are to be used -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> -->
</head>

<body>

  <!-- ===== NAVBAR ===== -->
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
          <a href="profile.php">👤 My Profile</a>
          <a href="#">⚙️ Settings</a>
          <div class="dd-divider"></div>
          <a href="index.php" class="danger">🚪 Sign out</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- ===== PAGE ===== -->
  <div class="page-wrap">
    <div class="settings-layout">

      <!-- ===== LEFT SIDEBAR (Settings Navigation) ===== -->
      <aside class="sidebar-left">
        <nav class="sidebar-nav">
          <a href="#profile-settings" class="active"><span class="nav-icon">👤</span> Profile</a>
          <a href="#account-settings"><span class="nav-icon">⚙️</span> Account</a>
          <a href="#notification-preferences"><span class="nav-icon">🔔</span> Notifications</a>
          <a href="#repository-defaults"><span class="nav-icon">📦</span> Repositories</a>
          <a href="#danger-zone"><span class="nav-icon">⚠️</span> Danger Zone</a>
        </nav>
      </aside>

      <!-- ===== MAIN SETTINGS CONTENT ===== -->
      <main class="settings-main">

        <!-- Profile Settings -->
        <section id="profile-settings" class="settings-section anim-fadeup" style="animation-delay:0.05s">
          <h2 class="section-title">Profile Settings</h2>
          <p class="section-sub">Update your public profile information.</p>

          <div class="settings-card">
            <div class="form-group profile-avatar-upload">
              <label for="profile-picture">Profile Picture</label>
              <div class="avatar xl" style="margin-bottom: 10px;">RK</div>
              <input type="file" id="profile-picture" accept="image/*" aria-label="Upload new profile picture">
            </div>
            <div class="form-group">
              <label for="full-name">Full Name</label>
              <input type="text" id="full-name" placeholder="Rafid Khan" value="Rafid Khan" />
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" id="username" placeholder="rafidkhan" value="rafidkhan" />
            </div>
            <div class="form-group">
              <label for="bio">Bio</label>
              <textarea id="bio" rows="4" placeholder="A passionate developer building awesome things.">Frontend Architect building React dashboards and data viz tools. Passionate about DX.</textarea>
            </div>
            <div class="form-group">
              <label for="location">Location</label>
              <input type="text" id="location" placeholder="e.g. Dhaka, Bangladesh" value="Dhaka, Bangladesh" />
            </div>
            <div class="form-group">
              <label for="website">Website</label>
              <input type="text" id="website" placeholder="e.g. rafidkhan.dev" value="rafidkhan.dev" />
            </div>
            <button class="btn btn-primary">Save Profile</button>
          </div>
        </section>

        <!-- Account Settings -->
        <section id="account-settings" class="settings-section anim-fadeup" style="animation-delay:0.1s">
          <h2 class="section-title">Account Settings</h2>
          <p class="section-sub">Manage your email and password.</p>

          <div class="settings-card">
            <div class="form-group">
              <label for="email">Email Address</label>
              <input type="email" id="email" placeholder="you@example.com" value="rafid@example.com" />
            </div>
            <div class="form-group">
              <label for="current-password">Current Password</label>
              <input type="password" id="current-password" placeholder="••••••••" />
            </div>
            <div class="form-group">
              <label for="new-password">New Password</label>
              <input type="password" id="new-password" placeholder="••••••••" />
            </div>
            <div class="form-group">
              <label for="confirm-password">Confirm New Password</label>
              <input type="password" id="confirm-password" placeholder="••••••••" />
            </div>
            <button class="btn btn-primary">Update Account</button>
          </div>
        </section>

        <!-- Notification Preferences -->
        <section id="notification-preferences" class="settings-section anim-fadeup" style="animation-delay:0.15s">
          <h2 class="section-title">Notification Preferences</h2>
          <p class="section-sub">Choose what you want to be notified about.</p>

          <div class="settings-card">
            <div class="setting-item">
              <label for="notif-stars">Repository stars notifications</label>
              <label class="switch">
                <input type="checkbox" id="notif-stars" checked>
                <span class="slider round"></span>
              </label>
            </div>
            <div class="setting-item">
              <label for="notif-followers">New follower notifications</label>
              <label class="switch">
                <input type="checkbox" id="notif-followers" checked>
                <span class="slider round"></span>
              </label>
            </div>
            <div class="setting-item">
              <label for="notif-versions">Version update notifications</label>
              <label class="switch">
                <input type="checkbox" id="notif-versions">
                <span class="slider round"></span>
              </label>
            </div>
            <div class="setting-item">
              <label for="notif-system">System alert notifications</label>
              <label class="switch">
                <input type="checkbox" id="notif-system" checked>
                <span class="slider round"></span>
              </label>
            </div>
          </div>
        </section>

        <!-- Repository Defaults -->
        <section id="repository-defaults" class="settings-section anim-fadeup" style="animation-delay:0.25s">
          <h2 class="section-title">Repository Defaults</h2>
          <p class="section-sub">Set default options for new repositories.</p>

          <div class="settings-card">
            <div class="form-group">
              <label for="default-visibility">Default repository visibility</label>
              <select id="default-visibility">
                <option value="public">Public</option>
                <option value="private">Private</option>
              </select>
            </div>
          </div>
        </section>

        <!-- Danger Zone -->
        <section id="danger-zone" class="settings-section anim-fadeup" style="animation-delay:0.3s">
          <h2 class="section-title text-red">Danger Zone</h2>
          <p class="section-sub">Irreversible actions for your account.</p>

          <div class="settings-card danger-card">
            <p class="text-red" style="margin-bottom: 15px;">
              <span class="nav-icon">⚠️</span> Be careful! These actions cannot be undone.
            </p>

            <div class="setting-item" style="border-top: 1px solid var(--border-soft); padding-top: 10px; margin-top: 0px;">
              <div>
                <h3>Delete Account</h3>
                <p class="text-muted">Permanently delete your account and all associated data.</p>
              </div>
              <button class="btn btn-red">Delete Account</button>
            </div>
          </div>
        </section>

      </main>
    </div>

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

  <!-- ===== SCRIPTS ===== -->
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

    // // Star toggle (commented out as it's not relevant for settings page)
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

    // Follow toggle (commented out as it's not relevant for settings page)
    // function toggleFollow(btn) {
    //   if (btn.classList.contains('following')) {
    //     btn.classList.remove('following');
    //     btn.textContent = 'Follow';
    //   } else {
    //     btn.classList.add('following');
    //     btn.textContent = 'Following';
    //   }
    // }

    // Settings sidebar navigation active state
    document.querySelectorAll('.sidebar-nav a').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelectorAll('.sidebar-nav a').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const targetId = this.getAttribute('href').substring(1);
        const targetSection = document.getElementById(targetId);
        if (targetSection) {
          targetSection.scrollIntoView({ behavior: 'smooth' });
        }
      });
    });

    // Optional: Highlight sidebar nav item on scroll
    const sections = document.querySelectorAll('.settings-section');
    const navLinks = document.querySelectorAll('.sidebar-nav a');

    window.addEventListener('scroll', () => {
      let current = '';
      sections.forEach(section => {
        const sectionTop = section.offsetTop - document.querySelector('.navbar').offsetHeight - 20; // Adjust for navbar height and some offset
        const sectionHeight = section.clientHeight;
        if (pageYOffset >= sectionTop && pageYOffset < sectionTop + sectionHeight) {
          current = section.getAttribute('id');
        }
      });

      navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href').includes(current)) {
          link.classList.add('active');
        }
      });
    });

  </script>
</body>

</html>