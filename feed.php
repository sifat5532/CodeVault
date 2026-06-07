<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Feed — CodeVault</title>
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
          <a href="feed.php" class="active"><span class="nav-icon">🏠</span> Home</a>
          <a href="#"><span class="nav-icon">📦</span> My Repos</a>
          <a href="#"><span class="nav-icon">⭐</span> Starred</a>
          <a href="#"><span class="nav-icon">👥</span> Followers</a>
          <a href="#"><span class="nav-icon">👥</span> Following</a>
          <a href="#"><span class="nav-icon">⚙️</span> Settings</a>
        </nav>
      </aside>

      <!-- ===== MAIN FEED ===== -->
      <main class="feed-main">
        <div class="feed-header">
          <h2>Feed</h2>
          <div class="feed-filters">
            <button class="filter-btn active">All</button>
            <button class="filter-btn">Following</button>
          </div>
        </div>

        <div class="feed-list">

          <!-- Card 1 -->
          <div class="feed-repo-card anim-fadeup" style="animation-delay:0.05s">
            <div class="frc-top">
              <div class="frc-meta">
                <div class="avatar">NJ</div>
                <div>
                  <div class="by"><strong>neeraj_dev</strong> uploaded a new version</div>
                  <div class="repo-name">neeraj_dev / react-dashboard-kit</div>
                </div>
              </div>
              <button class="star-btn" onclick="toggleStar(this)">☆ <span>142</span></button>
            </div>
            <p class="frc-desc">A lightweight, zero-dependency React dashboard component library. Now with dark mode
              support and improved chart rendering performance in v4.</p>
            <div class="frc-footer">
              <div class="version-chip">✦ v4</div>
              <span class="tag">react</span>
              <span class="tag">typescript</span>
              <span class="tag">dashboard</span>
              <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">2h ago</div>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="feed-repo-card anim-fadeup" style="animation-delay:0.1s">
            <div class="frc-top">
              <div class="frc-meta">
                <div class="avatar">SL</div>
                <div>
                  <div class="by"><strong>samon_liu</strong> created a new repo</div>
                  <div class="repo-name">samon_liu / fastapi-boilerplate</div>
                </div>
              </div>
              <button class="star-btn starred" onclick="toggleStar(this)">★ <span>89</span></button>
            </div>
            <p class="frc-desc">Production-ready FastAPI starter with JWT auth, PostgreSQL, Docker Compose, and
              auto-generated Swagger docs. Opinionated, minimal, fast.</p>
            <div class="frc-footer">
              <div class="version-chip">✦ v1</div>
              <span class="tag">python</span>
              <span class="tag">fastapi</span>
              <span class="tag">docker</span>
              <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">5h ago</div>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="feed-repo-card anim-fadeup" style="animation-delay:0.15s">
            <div class="frc-top">
              <div class="frc-meta">
                <div class="avatar">AM</div>
                <div>
                  <div class="by"><strong>alex_m</strong> uploaded a new version</div>
                  <div class="repo-name">alex_m / cli-toolbelt</div>
                </div>
              </div>
              <button class="star-btn" onclick="toggleStar(this)">☆ <span>34</span></button>
            </div>
            <p class="frc-desc">A collection of useful shell utilities for developers — directory cleaner, git alias
              manager, port killer, and bulk renamer. Now with Windows support.</p>
            <div class="frc-footer">
              <div class="version-chip">✦ v7</div>
              <span class="tag">bash</span>
              <span class="tag">cli</span>
              <span class="tag">tools</span>
              <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Yesterday</div>
            </div>
          </div>

          <!-- Card 4 -->
          <div class="feed-repo-card anim-fadeup" style="animation-delay:0.2s">
            <div class="frc-top">
              <div class="frc-meta">
                <div class="avatar">TK</div>
                <div>
                  <div class="by"><strong>tomas_k</strong> uploaded a new version</div>
                  <div class="repo-name">tomas_k / neural-style-lite</div>
                </div>
              </div>
              <button class="star-btn" onclick="toggleStar(this)">☆ <span>211</span></button>
            </div>
            <p class="frc-desc">Lightweight neural style transfer in pure PyTorch. Runs on CPU with acceptable speed. No
              CUDA required. Great for learning how NST works under the hood.</p>
            <div class="frc-footer">
              <div class="version-chip">✦ v2</div>
              <span class="tag">python</span>
              <span class="tag">ml</span>
              <span class="tag">pytorch</span>
              <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">2 days ago</div>
            </div>
          </div>

          <!-- Card 5 -->
          <div class="feed-repo-card anim-fadeup" style="animation-delay:0.25s">
            <div class="frc-top">
              <div class="frc-meta">
                <div class="avatar">PR</div>
                <div>
                  <div class="by"><strong>priya_r</strong> uploaded a new version</div>
                  <div class="repo-name">priya_r / markdown-to-pdf</div>
                </div>
              </div>
              <button class="star-btn starred" onclick="toggleStar(this)">★ <span>67</span></button>
            </div>
            <p class="frc-desc">Convert any Markdown file to a beautifully styled PDF with custom CSS themes. Supports
              tables, code blocks, and syntax highlighting out of the box.</p>
            <div class="frc-footer">
              <div class="version-chip">✦ v3</div>
              <span class="tag">nodejs</span>
              <span class="tag">markdown</span>
              <span class="tag">pdf</span>
              <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">3 days ago</div>
            </div>
          </div>

        </div>
      </main>

      <!-- ===== RIGHT SIDEBAR ===== -->
      <aside class="sidebar-right">

        <!-- Suggested Users -->
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
          <div class="suggest-user">
            <div class="avatar">YS</div>
            <div class="info">
              <div class="name">yui_sudo</div>
              <div class="handle">@yui_sudo</div>
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

        <!-- Trending Tags -->
        <div class="sidebar-widget">
          <div class="widget-header">
            Trending tags
            <a href="#">Browse all</a>
          </div>
          <div class="trending-tag"><span class="t-name">#python</span><span class="t-count">1.2k repos</span></div>
          <div class="trending-tag"><span class="t-name">#react</span><span class="t-count">980 repos</span></div>
          <div class="trending-tag"><span class="t-name">#typescript</span><span class="t-count">843 repos</span></div>
          <div class="trending-tag"><span class="t-name">#docker</span><span class="t-count">612 repos</span></div>
          <div class="trending-tag"><span class="t-name">#rust</span><span class="t-count">481 repos</span></div>
          <div class="trending-tag"><span class="t-name">#ml</span><span class="t-count">370 repos</span></div>
        </div>

      </aside>

    </div>
  </div>

  <!-- FAB: New Repo -->
  <div class="fab">
    <a href="new_repository.php"><button title="New Repository">＋</button></a>
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