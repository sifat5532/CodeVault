<?php
session_start();
require "php/config.php";
require "php/utility.php";


// get users

$query = "SELECT 
              u.name, 
              u.user_name AS username,
              (SELECT COUNT(*) FROM `repo` r WHERE r.creator = u.id) AS total_repo,
              (SELECT COUNT(*) FROM `stars` s JOIN `repo` r ON s.repo_id = r.id WHERE r.creator = u.id) AS total_star, 
              (SELECT COUNT(*) FROM `follower` f WHERE f.who_is_being_followed = u.id) AS total_follower
          FROM `user` u
          ORDER BY total_star DESC, total_repo ASC, total_follower DESC LIMIT 7;";

$dev_result = mysqli_query($conn, $query);

// get repos
$query = "SELECT
              DISTINCT(stars.repo_id) AS repo_id,
              COUNT(*) AS total_star,
              repo.title AS repo_title,
              repo.description AS repo_des,
              user.name AS name,
              user.user_name AS username
          FROM stars 
            LEFT JOIN repo
              ON stars.repo_id = repo.id
              LEFT JOIN user
              ON repo.creator = user.id
          WHERE repo.visibility = 'public'
          GROUP BY repo_id
          ORDER BY total_star DESC LIMIT 7;";
$repo_result = mysqli_query($conn, $query);

// get tags
$query = "SELECT
              tag.tag_name,
              COUNT(DISTINCT(tag.repo_id)) AS total_repo
          FROM tag
          GROUP BY tag.tag_name
          ORDER BY total_repo DESC LIMIT 7;";
$tag_result = mysqli_query($conn, $query);
?>

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
      <a href="explore.php">Explore</a>
    </div>

    <div class="nav-search">
      <span class="search-icon">🔍</span>
      <form method="get" action="search.php">
        <input type="text" name="search" placeholder="Search repos, developers…" />
      </form>
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
          <a href="php/logout.php" class="danger">🚪 Sign out</a>
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
          <?php while($data = mysqli_fetch_assoc($dev_result)){ ?>
          <div class="follower-list" style="margin-bottom: 30px;">
            <div class="follower-card anim-fadeup" style="animation-delay:0.1s">
              <div class="avatar lg"><?php echo get_avatar($data["name"]); ?></div>
              <div class="follower-info">
                <a href="user_profile.php?username=<?php echo $data["username"];?>"><div class="follower-name"><?php echo $data["name"];?></div></a>
                <div class="follower-handle">@<?php echo $data["username"];?></div>
                <div class="flex items-center gap-12 mt-4">
                  <span class="repo-meta">📦 <?php echo $data["total_repo"];?> repos</span>
                  <span class="repo-meta">👥 <?php echo $data["total_follower"];?> followers</span>
                </div>
              </div>
              <div class="flex gap-8">
                <a href="user_profile.php?username=<?php echo $data["username"];?>"><button class="btn btn-ghost btn-sm">View Profile</button></a>
              </div>
            </div>
          </div>
          <?php }?>
        </section>

        <!-- Top Repositories Section -->
        <section id="repos" class="explore-section">
          <div class="section-label">Top Repositories</div>
          <div class="feed-list">
            <?php while($data = mysqli_fetch_assoc($repo_result)){ ?>
            <div class="feed-repo-card anim-fadeup" style="animation-delay:0.2s">
              <div class="frc-top">
                <div class="frc-meta">
                  <div class="avatar"><?php echo get_avatar($data["name"]); ?></div>
                  <div>
                    <a href="view_repo.php?repo_id=<?php echo $data["repo_id"]; ?>"><div class="repo-name"><?php echo $data["repo_title"];?></div></a>
                    <div class="by">by <a href="user_profile.php?username=<?php echo $data["username"];?>"><strong><?php echo $data["username"];?></strong></a></div>
                  </div>
                </div>
                <button class="star-btn">☆ <span><?php echo $data["total_star"];?></span></button>
              </div>
              <p class="frc-desc"><?php echo substr($data["repo_des"], 0, 150);?>...</p>
              
            </div>
            <?php }?>
          </div>
        </section>

        <!-- Top Tags Section -->
        <section id="tags" class="explore-section">
          <div class="section-label">Top Tags</div>
            <?php while($data = mysqli_fetch_assoc($tag_result)){ ?>
            <div class="follower-list" style="margin-bottom: 20px;">
              <div class="follower-card anim-fadeup" style="animation-delay:0.3s">
                <div class="tag-icon-box">🏷️</div>
                <div class="follower-info">
                  <a href="view_tag.php?tag=<?php echo $data["tag_name"]; ?>"><div class="follower-name text-accent mono">#<?php echo $data["tag_name"]; ?></div></a>
                  <p class="text-muted" style="font-size: 13px; margin-top: 4px;"></p>
                  <div class="repo-meta mt-8">📦 <?php echo $data["total_repo"]; ?> repos</div>
                </div>
                <a href="view_tag.php?tag=<?php echo $data["tag_name"]; ?>"><button class="btn btn-ghost btn-sm">Browse Tag</button></a>
              </div>
            </div>
            <?php } ?>
        </section>
      </main>


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