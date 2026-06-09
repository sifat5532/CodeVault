<?php
session_start();
if (!isset($_SESSION["id"])) {
  header("Location: login.php");
  exit();
}
$user_id = $_SESSION["id"];
require "php/config.php";
require "php/utility.php";

$query = "SELECT * FROM(SELECT user.user_name,
         repo.id,repo.title,repo.creator,repo.description,version.version_number,version.created_at
        FROM follower
         JOIN repo  ON repo.creator=follower.who_is_being_followed 
         JOIN user ON user.id=repo.creator
         JOIN version ON version.id IN
          ( SELECT MAX(version.id) FROM version WHERE version.repo_id=repo.id
          ) 
          
          WHERE follower.who_is_following='$user_id' AND  repo.visibility='public'
         
          UNION
          SELECT  user.user_name,
          repo.id,repo.title,repo.creator,repo.description,version.version_number,version.created_at
          FROM stars
          JOIN  repo ON stars.repo_id=repo.id
          JOIN user ON user.id=repo.creator
          JOIN version ON version.id IN
          ( SELECT MAX(version.id) FROM version WHERE version.repo_id=repo.id
          ) 
           
          WHERE stars.user_id='$user_id' )AS feed
           ORDER BY created_at DESC 
          ";
$result = mysqli_query($conn, $query);

?>



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
          <a href="profile.php"><span class="nav-icon">📦</span> My Repos</a>
          <a href="starred.php"><span class="nav-icon">⭐</span> Starred</a>
          <a href="followers.php"><span class="nav-icon">👥</span> Followers</a>
          <a href="following.php"><span class="nav-icon">👥</span> Following</a>
          <a href="settings.php"><span class="nav-icon">⚙️</span> Settings</a>
        </nav>
      </aside>

      <!-- ===== MAIN FEED ===== -->
      <main class="feed-main">
        <div class="feed-header">
          <h2>Feed</h2>
          <div class="feed-filters">

          </div>
        </div>

        <div class="feed-list">
          <?php
          if ($result && mysqli_num_rows($result) > 0) {
            while ($data = mysqli_fetch_assoc(($result))) {
          ?>
              <!-- Card 1 -->
              <div class="feed-repo-card anim-fadeup" style="animation-delay:0.05s">
                <div class="frc-top">
                  <div class="frc-meta">
                    <div class="avatar"><?php echo get_avatar($data["user_name"]); ?></div>
                    <div>
                      <div class="by"><a href="user_profile.php?username=<?php echo $data['user_name']; ?>"><strong><?php echo $data['user_name'];    ?></strong></a> </div>
                      <a href="view_repo.php?repo_id=<?php echo $data["id"]; ?>" class="repo-name"><?php echo  $data['user_name'] . '/' . $data['title']; ?></a>
                    </div>
                  </div>
                  <!-- <button class="star-btn" onclick="toggleStar(this)">☆ <span>142</span></button> -->
                </div>
                <p class="frc-desc"><?php if (isset($data['description']))  echo $data['description'];      ?></p>
                <div class="frc-footer">
                  <div class="version-chip">✦ v<?php echo $data['version_number']; ?></div>
                  <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);"><?php echo timeAgo($data['created_at']);            ?></div>
                </div>
              </div>
          <?php
            }
          } ?>


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
    document.addEventListener('click', function(e) {
      const menu = document.querySelector('.user-menu');
      if (!menu.contains(e.target)) {
        document.getElementById('userDropdown').classList.remove('open');
      }
    });

   
    // Feed filter
    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
      });
    });
  </script>
</body>

</html>