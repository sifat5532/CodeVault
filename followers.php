<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Followers — CodeVault</title>
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

      <!-- ===== LEFT SIDEBAR ===== -->
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
          <a href="#"><span class="nav-icon">📦</span> My Repos</a>
          <a href="#"><span class="nav-icon">⭐</span> Starred</a>
          <a href="followers.php" class="active"><span class="nav-icon">👥</span> Followers</a>
          <a href="#"><span class="nav-icon">👥</span> Following</a>
          <a href="#"><span class="nav-icon">⚙️</span> Settings</a>
        </nav>
      </aside>

      <!-- ===== MAIN CONTENT (Followers List) ===== -->
      <main class="feed-main">
        <div class="feed-header" style="margin-bottom: 3vh;">
          <h2>Followers (86)</h2>
        </div>

        <div class="follower-list">
          <!-- Follower 1 -->
          <div class="follower-card anim-fadeup" style="animation-delay:0.05s">
            <div class="avatar lg">MZ</div>
            <div class="follower-info">
              <div class="follower-name">man_zhang</div>
              <div class="follower-handle">@man_zhang</div>
            </div>
            <button class="follow-btn following" onclick="toggleFollow(this)">Following</button>
          </div>

          <!-- Follower 2 -->
          <div class="follower-card anim-fadeup" style="animation-delay:0.1s">
            <div class="avatar lg">DK</div>
            <div class="follower-info">
              <div class="follower-name">dev_kabir</div>
              <div class="follower-handle">@dev_kabir</div>
            </div>
            <button class="follow-btn" onclick="toggleFollow(this)">Follow</button>
          </div>

          <!-- Follower 3 -->
          <div class="follower-card anim-fadeup" style="animation-delay:0.15s">
            <div class="avatar lg">YS</div>
            <div class="follower-info">
              <div class="follower-name">yui_sudo</div>
              <div class="follower-handle">@yui_sudo</div>
            </div>
            <button class="follow-btn following" onclick="toggleFollow(this)">Following</button>
          </div>

          <!-- Follower 4 -->
          <div class="follower-card anim-fadeup" style="animation-delay:0.2s">
            <div class="avatar lg">NJ</div>
            <div class="follower-info">
              <div class="follower-name">neeraj_dev</div>
              <div class="follower-handle">@neeraj_dev</div>
            </div>
            <button class="follow-btn following" onclick="toggleFollow(this)">Following</button>
          </div>

          <!-- Follower 4 -->
          <div class="follower-card anim-fadeup" style="animation-delay:0.2s">
            <div class="avatar lg">NJ</div>
            <div class="follower-info">
              <div class="follower-name">neeraj_dev</div>
              <div class="follower-handle">@neeraj_dev</div>
            </div>
            <button class="follow-btn following" onclick="toggleFollow(this)">Following</button>
          </div>

          <!-- Follower 4 -->
          <div class="follower-card anim-fadeup" style="animation-delay:0.2s">
            <div class="avatar lg">NJ</div>
            <div class="follower-info">
              <div class="follower-name">neeraj_dev</div>
              <div class="follower-handle">@neeraj_dev</div>
            </div>
            <button class="follow-btn following" onclick="toggleFollow(this)">Following</button>
          </div>

          <!-- Follower 4 -->
          <div class="follower-card anim-fadeup" style="animation-delay:0.2s">
            <div class="avatar lg">NJ</div>
            <div class="follower-info">
              <div class="follower-name">neeraj_dev</div>
              <div class="follower-handle">@neeraj_dev</div>
            </div>
            <button class="follow-btn following" onclick="toggleFollow(this)">Following</button>
          </div>

          <!-- Follower 4 -->
          <div class="follower-card anim-fadeup" style="animation-delay:0.2s">
            <div class="avatar lg">NJ</div>
            <div class="follower-info">
              <div class="follower-name">neeraj_dev</div>
              <div class="follower-handle">@neeraj_dev</div>
            </div>
            <button class="follow-btn following" onclick="toggleFollow(this)">Following</button>
          </div>

          <!-- Follower 4 -->
          <div class="follower-card anim-fadeup" style="animation-delay:0.2s">
            <div class="avatar lg">NJ</div>
            <div class="follower-info">
              <div class="follower-name">neeraj_dev</div>
              <div class="follower-handle">@neeraj_dev</div>
            </div>
            <button class="follow-btn following" onclick="toggleFollow(this)">Following</button>
          </div>

          <!-- Follower 4 -->
          <div class="follower-card anim-fadeup" style="animation-delay:0.2s">
            <div class="avatar lg">NJ</div>
            <div class="follower-info">
              <div class="follower-name">neeraj_dev</div>
              <div class="follower-handle">@neeraj_dev</div>
            </div>
            <button class="follow-btn following" onclick="toggleFollow(this)">Following</button>
          </div>

          <!-- Follower 4 -->
          <div class="follower-card anim-fadeup" style="animation-delay:0.2s">
            <div class="avatar lg">NJ</div>
            <div class="follower-info">
              <div class="follower-name">neeraj_dev</div>
              <div class="follower-handle">@neeraj_dev</div>
            </div>
            <button class="follow-btn following" onclick="toggleFollow(this)">Following</button>
          </div>

          <!-- Follower 5 -->
          <div class="follower-card anim-fadeup" style="animation-delay:0.25s">
            <div class="avatar lg">SL</div>
            <div class="follower-info">
              <div class="follower-name">samon_liu</div>
              <div class="follower-handle">@samon_liu</div>
            </div>
            <button class="follow-btn" onclick="toggleFollow(this)">Follow</button>
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
            <div class="avatar">MZ</div>
            <div class="info">
              <div class="name">man_zhang</div>
              <div class="handle">@man_zhang</div>
            </div>
            <button class="follow-btn" onclick="toggleFollow(this)">Follow</button>
          </div>
          <div class="suggest-user">
            <div class="avatar">DK</div>
            <div class="info">
              <div class="name">dev_kabir</div>
              <div class="handle">@dev_kabir</div>
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
    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', function () {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
      });
    });
  </script>
</body>

</html>