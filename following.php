<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Following — CodeVault</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body>

  <!-- ===== NAVBAR (Copied from feed.php) ===== -->
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
          <a href="settings.php">⚙️ Settings</a>
          <div class="dd-divider"></div>
          <a href="index.php" class="danger">🚪 Sign out</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- ===== PAGE ===== -->
  <div class="page-wrap">
    <div class="feed-layout">

      <!-- ===== LEFT SIDEBAR (Reference from followers.php) ===== -->
      <aside class="sidebar-left">
        <div class="sidebar-profile">
          <div class="avatar xl">RK</div>
          <div class="profile-name">Rafid Khan</div>
          <div class="profile-handle">@rafidkhan</div>
          <div class="profile-stats">
            <div class="profile-stat">
              <div class="n">14</div>
              <div class="l">Repos</div>
            </div>
            <div class="profile-stat">
              <div class="n">86</div>
              <div class="l">Followers</div>
            </div>
            <div class="profile-stat">
              <div class="n">53</div>
              <div class="l">Stars</div>
            </div>
          </div>
        </div>

        <nav class="sidebar-nav">
          <a href="feed.php"><span class="nav-icon">🏠</span> Home</a>
          <a href="profile.php"><span class="nav-icon">📦</span> My Repos</a>
          <a href="starred.php"><span class="nav-icon">⭐</span> Starred</a>
          <a href="followers.php"><span class="nav-icon">👥</span> Followers</a>
          <a href="following.php" class="active"><span class="nav-icon">👥</span> Following</a>
          <a href="settings.php"><span class="nav-icon">⚙️</span> Settings</a>
        </nav>
      </aside>

      <!-- ===== MAIN CONTENT (Following List) ===== -->
      <main class="feed-main">
        <div class="feed-header" style="margin-bottom: 3vh;">
          <h2>Following (42)</h2>
        </div>

        <div class="follower-list">
          <!-- Following 1 -->
          <div class="follower-card anim-fadeup" style="animation-delay:0.05s">
            <div class="avatar lg">MZ</div>
            <div class="follower-info">
              <div class="follower-name">man_zhang</div>
              <div class="follower-handle">@man_zhang</div>
              <p class="text-muted" style="font-size: 13px; margin-top: 4px;">Frontend Architect building React dashboards.</p>
            </div>
            <button class="follow-btn following" onclick="toggleFollow(this)">Following</button>
          </div>

          <!-- Following 2 -->
          <div class="follower-card anim-fadeup" style="animation-delay:0.1s">
            <div class="avatar lg">NJ</div>
            <div class="follower-info">
              <div class="follower-name">neeraj_dev</div>
              <div class="follower-handle">@neeraj_dev</div>
              <p class="text-muted" style="font-size: 13px; margin-top: 4px;">Building open source UI kits since 2022.</p>
            </div>
            <button class="follow-btn following" onclick="toggleFollow(this)">Following</button>
          </div>

          <!-- Following 3 -->
          <div class="follower-card anim-fadeup" style="animation-delay:0.15s">
            <div class="avatar lg">YS</div>
            <div class="follower-info">
              <div class="follower-name">yui_sudo</div>
              <div class="follower-handle">@yui_sudo</div>
            </div>
            <button class="follow-btn following" onclick="toggleFollow(this)">Following</button>
          </div>

          <!-- Empty State (Hidden by default) -->
          <div class="notif-empty anim-fadein" style="display: none;">
            <div class="notif-empty-icon">👥</div>
            <h3>Not following anyone yet</h3>
            <p>Follow other developers to see their latest work in your feed.</p>
            <div class="mt-16">
              <button class="btn btn-primary btn-sm">Explore Developers</button>
            </div>
          </div>
        </div>
      </main>

      <!-- ===== RIGHT SIDEBAR (Copied from feed.php) ===== -->
      <aside class="sidebar-right">
        <div class="sidebar-widget">
          <div class="widget-header">
            Who to follow
            <a href="#">See all</a>
          </div>
          <div class="suggest-user">
            <div class="avatar">DK</div>
            <div class="info">
              <div class="name">dev_kabir</div>
              <div class="handle">@dev_kabir</div>
            </div>
            <button class="follow-btn" onclick="toggleFollow(this)">Follow</button>
          </div>
          <div class="suggest-user">
            <div class="avatar">OB</div>
            <div class="info">
              <div class="name">olumide_b</div>
              <div class="handle">@olumide_b</div>
            </div>
            <button class="follow-btn" onclick="toggleFollow(this)">Follow</button>
          </div>
        </div>
      </aside>
    </div>

    <!-- ===== FOOTER (Copied from index.php) ===== -->
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

  <!-- ===== SCRIPTS (Copied from feed.php) ===== -->
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
    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', function () {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
      });
    });
  </script>
</body>

</html>