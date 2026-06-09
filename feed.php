<?php
session_start();
if (!isset($_SESSION["id"])) {
  header("Location: login.php");
  exit();
}
$user_id = $_SESSION["id"];
require "php/config.php";
require "php/utility.php";

$query = "SELECT * FROM (

              -- repos from people you follow
              SELECT user.user_name, user.name,
                    repo.id, repo.title, repo.creator, repo.description,
                    version.version_number, version.created_at,
                    CASE
                        WHEN repo.file != version.file_zip THEN 'uploaded a new version'
                        ELSE 'created a new repo'
                    END AS in_feed_des
              FROM follower
              JOIN repo    ON repo.creator = follower.who_is_being_followed
              JOIN user    ON user.id = repo.creator
              JOIN version ON version.id IN (
                  SELECT MAX(version.id) FROM version WHERE version.repo_id = repo.id
              )
              WHERE follower.who_is_following = '$user_id'
                AND repo.visibility = 'public'

              UNION

              -- repos you starred
              SELECT user.user_name, user.name,
                    repo.id, repo.title, repo.creator, repo.description,
                    version.version_number, version.created_at,
                    'you starred this repo' AS in_feed_des
              FROM stars
              JOIN repo    ON stars.repo_id = repo.id
              JOIN user    ON user.id = repo.creator
              JOIN version ON version.id IN (
                  SELECT MAX(version.id) FROM version WHERE version.repo_id = repo.id
              )
              WHERE stars.user_id = '$user_id'

              UNION

              -- repos you contribute to (but didn't create)
              SELECT user.user_name, user.name,
                    repo.id, repo.title, repo.creator, repo.description,
                    version.version_number, version.created_at,
                    CASE
                        WHEN repo.file != version.file_zip THEN 'uploaded a new version'
                        ELSE 'created a new repo'
                    END AS in_feed_des
              FROM contributor
              JOIN repo    ON contributor.repo_id = repo.id
              JOIN user    ON user.id = repo.creator
              JOIN version ON version.id IN (
                  SELECT MAX(version.id) FROM version WHERE version.repo_id = repo.id
              )
              WHERE contributor.user_id = '$user_id'
                AND repo.creator != '$user_id'

              UNION

              -- your own repos
              SELECT user.user_name, user.name,
                    repo.id, repo.title, repo.creator, repo.description,
                    version.version_number, version.created_at,
                    CASE
                        WHEN repo.file != version.file_zip THEN 'uploaded a new version'
                        ELSE 'created a new repo'
                    END AS in_feed_des
              FROM repo
              JOIN user    ON user.id = repo.creator
              JOIN version ON version.id IN (
                  SELECT MAX(version.id) FROM version WHERE version.repo_id = repo.id
              )
              WHERE repo.creator = '$user_id'

          ) AS feed
          ORDER BY created_at DESC
          ";
$result = mysqli_query($conn, $query);
//who to follow
$query = "SELECT user.name,user.user_name,
                  (SELECT COUNT(*) FROM repo WHERE repo.creator=user.id)AS total_repo,
                  (SELECT COUNT(*) FROM stars JOIN repo ON stars.repo_id=repo.id WHERE repo.creator=user.id)AS total_stars,
                  (SELECT COUNT(*) FROM follower WHERE follower.who_is_being_followed=user.id)AS total_follower
          FROM user  ORDER  BY total_stars DESC,total_repo ASC,total_follower DESC LIMIT 4";
$result_follow = mysqli_query($conn, $query);
//top tags
$query = "SELECT tag.tag_name,
                  COUNT(DISTINCT (tag.repo_id)) AS total_repo
          FROM tag 
          GROUP BY tag.tag_name
          ORDER BY total_repo DESC LIMIT 6 ";
$result_tag = mysqli_query($conn, $query);
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
                    <div class="avatar"><?php echo get_avatar($data["name"]); ?></div>
                    <div>
                      <div class="by"><a
                          href="user_profile.php?username=<?php echo $data['user_name']; ?>"><strong><?php echo $data['name']; ?></strong></a> <?php echo $data['in_feed_des']; ?>
                      </div>
                      <a href="view_repo.php?repo_id=<?php echo $data["id"]; ?>"
                        class="repo-name"><?php echo $data['user_name'] . '/' . $data['title']; ?></a>
                    </div>
                  </div>
                  <!-- <button class="star-btn" onclick="toggleStar(this)">☆ <span>142</span></button> -->
                </div>
                <p class="frc-desc"><?php if (isset($data['description']))
                  echo $data['description']; ?></p>
                <div class="frc-footer">
                  <div class="version-chip">✦ v<?php echo $data['version_number']; ?></div>
                  <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">
                    <?php echo timeAgo($data['created_at']); ?>
                  </div>
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
            Top Developers
            <a href="explore.php">See all</a>
          </div>
          <?php
          while ($data = mysqli_fetch_assoc($result_follow)) { ?>
            <div class="suggest-user">
              <div class="avatar"><?php echo get_avatar($data["name"]); ?></div>
              <a href="user_profile.php?username=<?php echo $data["user_name"]; ?>" class="info">
                <div class="name"><?php echo $data["name"]; ?></div>
                <div class="handle">@<?php echo $data["user_name"]; ?></div>
              </a>

            </div>
          <?php } ?>


        </div>

        <!-- Trending Tags -->
        <div class="sidebar-widget">
          <div class="widget-header">
            Trending tags
            <a href="explore.php">Browse all</a>
          </div>
          <?php while ($data = mysqli_fetch_assoc($result_tag)) { ?>
            <a href="view_tag.php?tag=<?php echo $data["tag_name"] ?>" class="trending-tag"><span
                class="t-name">#<?php echo $data["tag_name"]; ?></span><span
                class="t-count"><?php echo $data["total_repo"]; ?> repos</span></a>
          <?php } ?>
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