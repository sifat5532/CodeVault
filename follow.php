<?php
// session_start();
// if(!isset($_SESSION["id"])){
//   header("Location: login.php");
//   exit();
// }

if(isset($_GET["type"])){
  $type = $_GET["type"];
}else{
  header("Location: feed.php");
  exit();
}
if($type != "Followers" && $type != "Followings"){
  header("Location: feed.php");
  exit();
}

require "php/config.php";
require "php/utility.php";
// $id = $_SESSION["id"];
$id = 1;
if($type === "Followers"){
  $query = "SELECT COUNT(follower.who_is_being_followed) as total FROM follower WHERE follower.who_is_being_followed = $id;";
  $query_user_list = "
    SELECT
      follower.who_is_following,
        user.id,
        user.user_name,
        user.name,
        user.profile_pic
    FROM follower
      JOIN user
        ON follower.who_is_following = user.id
    WHERE follower.who_is_being_followed = $id
    ORDER BY user.name ASC;
  ";
}else{
  $query = "SELECT COUNT(follower.who_is_following) AS total FROM follower WHERE follower.who_is_following = $id;";
  $query_user_list = "
    SELECT
      follower.who_is_being_followed,
        user.id,
        user.user_name,
        user.name,
        user.profile_pic
    FROM follower
      JOIN user
        ON follower.who_is_being_followed = user.id
    WHERE follower.who_is_following = $id
    ORDER BY user.name ASC;
  ";
}
$count = ($result = mysqli_query($conn, $query)) ? mysqli_fetch_assoc($result)["total"] : 0;
$result = mysqli_query($conn, $query_user_list);
//who to follow
$query="SELECT user.name,user.user_name,
        (SELECT COUNT(*) FROM repo WHERE repo.creator=user.id)AS total_repo,
        (SELECT COUNT(*) FROM stars JOIN repo ON stars.repo_id=repo.id WHERE repo.creator=user.id)AS total_stars,
        (SELECT COUNT(*) FROM follower WHERE follower.who_is_being_followed=user.id)AS total_follower
        FROM user  ORDER  BY total_stars DESC,total_repo ASC,total_follower DESC LIMIT 4";
$result_follow=mysqli_query($conn,$query);   

?>

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
          <a href="feed.php"><span class="nav-icon">🏠</span> Home</a>
          <a href="profile.php"><span class="nav-icon">📦</span> My Repos</a>
          <a href="starred.php"><span class="nav-icon">⭐</span> Starred</a>
          <a href="followers.php" class="active"><span class="nav-icon">👥</span> Followers</a>
          <a href="following.php"><span class="nav-icon">👥</span> Following</a>
          <a href="settings.php"><span class="nav-icon">⚙️</span> Settings</a>
        </nav>
      </aside>

      <!-- ===== MAIN CONTENT (Followers List) ===== -->
      <main class="feed-main">
        <div class="feed-header" style="margin-bottom: 3vh;">
          <h2><?php echo $type;?> (<?php echo $count;?>)</h2>
        </div>

        <div class="follower-list">
          <?php while($data = mysqli_fetch_assoc($result)){?>
          <div class="follower-card anim-fadeup" style="animation-delay:0.05s">
            <div class="avatar lg"><?php echo get_avatar($data["name"]);?></div>
            <div class="follower-info">
              <div class="follower-name"><?php echo $data["name"];?></div>
              <div class="follower-handle">@<?php echo $data["user_name"];?></div>
            </div>
            <a href="user_profile.php?user_id=<?php echo $data["id"];?>"><button class="btn btn-ghost btn-sm">View profile</button></a>
          </div>
         <?php } ?>
        </div>
      </main>

      <!-- ===== RIGHT SIDEBAR (Copied from feed.php) ===== -->
      <aside class="sidebar-right">
        <div class="sidebar-widget">
          <div class="widget-header">
            Top Developers
            <a href="#">See all</a>
          </div>
        <?php  
          while($data=mysqli_fetch_assoc($result_follow)){ ?>
          <div class="suggest-user">
            <div class="avatar"><?php echo get_avatar($data["name"]); ?></div>
            <a  href="user_profile.php?username=<?php  echo $data["user_name"]; ?>" class="info">
              <div class="name"><?php  echo $data["name"];     ?></div>
              <div class="handle">@<?php  echo $data["user_name"];     ?></div>
             </a>
            
          </div>
          <?php  } ?>
         
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