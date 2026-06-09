<?php
session_start();

$repo_id = -1;
if (isset($_GET["repo_id"])) {
  $repo_id = $_GET["repo_id"];
} else {
  header("Location: feed.php");
  exit();
}

require "php/config.php";
require "php/utility.php";
require "php/user_info.php";
$logged_in_user = null;
if (isset($_SESSION["id"])) {
  $logged_in_user = new User($_SESSION["id"], $conn);
}

$query = "SELECT * FROM repo WHERE id='$repo_id'";
if ($result = mysqli_query($conn, $query)) {
  // someone might input a repo id that does not even exit. so check the num of rows of $result
  if (mysqli_num_rows($result) == 0) {
    header("Location: feed.php");
    exit();
  }
  $data1 = mysqli_fetch_assoc($result);
  // repo public na private check kora lagbe
  if ($data1["visibility"] == "private") {
    if (!isset($_SESSION["id"])) {
      header("Location: index.php");
      exit();
    } else {
      if ($data1["creator"] != $_SESSION["id"]) {
        if (!is_a_contributor($_SESSION["id"], $repo_id, $conn)) {
          header("Location: index.php");
          exit();
        }
      }
    }
  }

  $repo_title = $data1["title"];
  $creator_id = $data1["creator"];
  $query = "SELECT * FROM user WHERE id='$creator_id'";

  if ($result = mysqli_query($conn, $query)) {
    $data2 = mysqli_fetch_assoc($result);
    $creator_name = $data2["user_name"];

  }
}


function is_a_contributor($user_id, $repo_id, $conn)
{
  $query = "SELECT * FROM contributor WHERE user_id = '$user_id' AND repo_id = '$repo_id';";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) > 0) {
    return true;
  }
  return false;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Versions — <?php echo isset($repo_title) ? $repo_title : 'Unknown Repo'; ?></title>
  <link rel="stylesheet" href="style.css" />
  <style>
    .versions-container {
      max-width: 800px;
      margin: 0 auto;
      padding: 40px 24px 80px;
    }

    .version-header {
      margin-bottom: 32px;
    }

    .mb-16 {
      margin-bottom: 16px;
    }
  </style>
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
      <form method="get" action="search.php">
        <input type="text" name="search" placeholder="Search repos, developers…" />
      </form>
    </div>

    <div class="nav-right">
      <a href="new_repository.php"><button class="btn btn-primary btn-sm new-repo-btn">+ New Repo</button></a>

      <a href="notification.php">
        <div class="notif-btn">
          🔔<?php if (isset($logged_in_user) && $logged_in_user->getTotalUnread() > 0): ?>
            <div class="notif-badge"><?php echo $logged_in_user->getTotalUnread(); ?></div>
          <?php endif; ?>
        </div>
      </a>

      <div class="user-menu">
        <div class="avatar" onclick="toggleDropdown()"><?php if(isset($logged_in_user)){ echo get_avatar($logged_in_user->getName()); } else { echo "null"; } ?></div>
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
    <main class="versions-container">

      <div class="version-header anim-fadeup">
        <div class="repo-path mb-16">
          <a href="user_profile.php?username=<?php echo isset($creator_name) ? $creator_name : ''; ?>"><span class="owner"><?php if (isset($creator_name)) {
            echo $creator_name;
          } ?></span></a>
          <span class="sep">/</span>
          <a href="view_repo.php?repo_id=<?php echo $repo_id; ?>"><span class="name"><?php if (isset($repo_title)) {
            echo $repo_title;
          } ?></span></a>
        </div>
        <h1>Release History</h1>
        <p class="text-muted mt-8">Browse and download previous versions of this project.</p>
        <div class="mt-16">
          <a href="view_repo.php?repo_id=<?php echo $repo_id; ?>" class="text-accent">← Back to latest version</a>
        </div>
      </div>

      <div class="feed-list">
        <?php
        $query = "SELECT * FROM version WHERE repo_id='$repo_id' ORDER BY id DESC";
        if ($result = mysqli_query($conn, $query)) {
          $not_latest = false;
          while ($data = mysqli_fetch_assoc($result)) { ?>
            <!-- Version Card 4 -->
            <div class="feed-repo-card anim-fadeup" style="animation-delay:0.05s">
              <div class="frc-top">
                <div class="version-chip" <?php if ($not_latest) {
                  echo 'style="background: var(--bg-3); border-color: var(--border); color: var(--text-dim);"';
                } $not_latest = true;?>>
                  <?php if (isset($data["version_number"])) {
                    echo "v" . $data["version_number"];
                  } ?></div>
                <a href="repo_files/<?php echo $data["file_zip"]; ?>" class="btn btn-primary btn-sm">⬇ Download ZIP</a>
              </div>
              <p class="frc-desc"><?php if (isset($data["description"])) {
                echo $data["description"];
              } ?> </p>
              <div class="frc-footer">

                <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Added
                  <?php echo timeAgo($data["created_at"]); ?></div>
              </div>
            </div>

          <?php }
        } ?>



      </div>

    </main>

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
  </script>
</body>

</html>