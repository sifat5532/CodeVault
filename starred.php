<?php 
session_start();
if(!isset($_SESSION["id"])){
  header("Location: login.php");
  exit();
}
  $user_id= $_SESSION["id"];
  require  "php/config.php";

  function timeAgo($datetime){
    $time=new DateTime($datetime);
    $now=new DateTime();
    $diff=$time->diff($now);
    if($diff->y) return $diff->y.'y ago';
    if($diff->m) return $diff->m.'m ago';
    if($diff->d) return $diff->d.'d ago';
    if($diff->h) return $diff->h.'h ago';
    if($diff->m) return $diff->m.'m ago';
    return 'Just now';

  }
?>
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
          <a href="starred.php" class="active"><span class="nav-icon">⭐</span> Starred</a>
          <a href="followers.php"><span class="nav-icon">👥</span> Followers</a>
          <a href="following.php"><span class="nav-icon">👥</span> Following</a>
          <a href="settings.php"><span class="nav-icon">⚙️</span> Settings</a>
        </nav>
      </aside>

      <!-- ===== MAIN CONTENT ===== -->
      <main class="feed-main">
        <div class="feed-header">
          <h2>Starred Repositories</h2>
        </div>

        <div class="feed-list">
          <?php  
            $query="SELECT repo.*,user.user_name,version.version_number ,version.created_at
            FROM stars
            JOIN repo ON repo.id=stars.repo_id
            JOIN version ON version.id=(
            SELECT MAX(version.id) FROM version WHERE version.repo_id=repo.id)
            JOIN user ON repo.creator=user.id
         
            WHERE stars.user_id='$user_id'";
             $result=mysqli_query($conn,$query);
             if($result && mysqli_num_rows($result)>0){
              while($data=mysqli_fetch_assoc($result)){


          ?>
          <!-- Starred Repo 1 -->
          <div class="feed-repo-card anim-fadeup" style="animation-delay:0.05s">
            <div class="frc-top">
              <div class="frc-meta">
          
                <div>
                  <div class="repo-name"><?php   if(isset($data["title"]))  echo $data["title"]; ?></div>
                  <div class="by">by <strong><?php  if(isset($data["username"]))  echo $data["username"];  ?></strong></div>
                </div>
              </div>
              <button class="star-btn starred" onclick="toggleStar(this)">★ <span><?php 
              $repoID=$data["id"];
              $query= "SELECT COUNT(*) FROM stars WHERE repo_id='$repoID'";
              $result=mysqli_query($conn,$query);
              $star_data=mysqli_fetch_assoc($result);
              echo $star_data["COUNT(*)"];
              
              ?></span></button>
            </div>
            <p class="frc-desc"><?php if(isset($data["description"])) echo $data["description"];?></p>
            <div class="frc-footer">
            
              <div class="version-chip"><?php  if(isset($data["version_number"])) echo '✦ '.$data["version_number"]  ; ?></div>
    
              <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);"><?php  echo "Updated ".timeAgo($data["created_at"]); ?></div>
             
              <a href="view_repo.php" class="btn btn-ghost btn-sm" style="margin-left: 12px;">View Repository</a>
            </div>
          </div>
                 <?php   } }
                 
                 
                 else       {?>
                    <div class="feed-repo-card anim-fadeup" style="animation-delay:0.05s">
            <div class="frc-top">
              <div class="frc-meta">
          
                <div>
                        <div class="frc-top" style="align-content: center";>
              <div class="frc-meta">
               
                 <p class="frc-desc" ><?php    echo "You have no starred repositories yet.";?></p>
                </div>
                    </div>  
                    </div>
                <?php  } ?>
         
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