<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Starred — CodeVault</title>
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
          <a href="feed.php"><span class="nav-icon">🏠</span> Home</a>
          <a href="#"><span class="nav-icon">📦</span> My Repos</a>
          <a href="starred.php" class="active"><span class="nav-icon">⭐</span> Starred</a>
          <a href="followers.php"><span class="nav-icon">👥</span> Followers</a>
          <a href="#"><span class="nav-icon">👥</span> Following</a>
          <a href="#"><span class="nav-icon">⚙️</span> Settings</a>
        </nav>
      </aside>

      <!-- ===== MAIN CONTENT ===== -->
      <main class="feed-main">
        <div class="feed-header">
          <h2>Starred Repositories</h2>
        </div>

        <div class="feed-list">

          <!-- Starred Repo 1 -->
          <div class="feed-repo-card anim-fadeup" style="animation-delay:0.05s">
            <div class="frc-top">
              <div class="frc-meta">
                <div class="avatar">SL</div>
                <div>
                  <div class="repo-name">samon_liu / fastapi-boilerplate</div>
                  <div class="by">by <strong>samon_liu</strong></div>
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
              <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Updated 5h ago</div>
            </div>
          </div>

          <!-- Starred Repo 1 -->
          <div class="feed-repo-card anim-fadeup" style="animation-delay:0.05s">
            <div class="frc-top">
              <div class="frc-meta">
                <div class="avatar">SL</div>
                <div>
                  <div class="repo-name">samon_liu / fastapi-boilerplate</div>
                  <div class="by">by <strong>samon_liu</strong></div>
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
              <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Updated 5h ago</div>
            </div>
          </div>


          <!-- Starred Repo 1 -->
          <div class="feed-repo-card anim-fadeup" style="animation-delay:0.05s">
            <div class="frc-top">
              <div class="frc-meta">
                <div class="avatar">SL</div>
                <div>
                  <div class="repo-name">samon_liu / fastapi-boilerplate</div>
                  <div class="by">by <strong>samon_liu</strong></div>
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
              <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Updated 5h ago</div>
            </div>
          </div>


          <!-- Starred Repo 1 -->
          <div class="feed-repo-card anim-fadeup" style="animation-delay:0.05s">
            <div class="frc-top">
              <div class="frc-meta">
                <div class="avatar">SL</div>
                <div>
                  <div class="repo-name">samon_liu / fastapi-boilerplate</div>
                  <div class="by">by <strong>samon_liu</strong></div>
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
              <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Updated 5h ago</div>
            </div>
          </div>


          <!-- Starred Repo 1 -->
          <div class="feed-repo-card anim-fadeup" style="animation-delay:0.05s">
            <div class="frc-top">
              <div class="frc-meta">
                <div class="avatar">SL</div>
                <div>
                  <div class="repo-name">samon_liu / fastapi-boilerplate</div>
                  <div class="by">by <strong>samon_liu</strong></div>
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
              <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Updated 5h ago</div>
            </div>
          </div>

          <!-- Starred Repo 1 -->
          <div class="feed-repo-card anim-fadeup" style="animation-delay:0.05s">
            <div class="frc-top">
              <div class="frc-meta">
                <div class="avatar">SL</div>
                <div>
                  <div class="repo-name">samon_liu / fastapi-boilerplate</div>
                  <div class="by">by <strong>samon_liu</strong></div>
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
              <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Updated 5h ago</div>
            </div>
          </div>

          <!-- Starred Repo 1 -->
          <div class="feed-repo-card anim-fadeup" style="animation-delay:0.05s">
            <div class="frc-top">
              <div class="frc-meta">
                <div class="avatar">SL</div>
                <div>
                  <div class="repo-name">samon_liu / fastapi-boilerplate</div>
                  <div class="by">by <strong>samon_liu</strong></div>
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
              <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Updated 5h ago</div>
            </div>
          </div>

          <!-- Starred Repo 2 -->
          <div class="feed-repo-card anim-fadeup" style="animation-delay:0.1s">
            <div class="frc-top">
              <div class="frc-meta">
                <div class="avatar">PR</div>
                <div>
                  <div class="repo-name">priya_r / markdown-to-pdf</div>
                  <div class="by">by <strong>priya_r</strong></div>
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
              <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Updated 3 days ago</div>
            </div>
          </div>

        </div>
      </main>

      <!-- ===== RIGHT SIDEBAR ===== -->
      <aside class="sidebar-right">
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