<?php 
session_start();
require "php/config.php";
require "php/utility.php";
$logged_in_user_id = -1;
if(isset($_SESSION["id"])) $logged_in_user_id = $_SESSION["id"];

$repo_id = $_GET["repo_id"];
$query = "SELECT
              repo.title,
              repo.description,
              repo.created_at,
              repo.demo,
              repo.visibility,
              user.id AS user_id,
              user.name,
              user.user_name,
              user.bio,
              (SELECT COUNT(*) FROM stars WHERE stars.repo_id = repo.id) AS total_stars,
              (SELECT COUNT(*) FROM contributor WHERE contributor.repo_id = repo.id) AS total_contributors,
              (SELECT COUNT(*) FROM follower WHERE follower.who_is_being_followed = repo.creator) AS total_followers,
              (SELECT COUNT(*) FROM repo r2 WHERE r2.creator = repo.creator) AS total_repos,
              (SELECt COUNT(*) FROM version v3 WHERE v3.repo_id = repo.id) AS total_versions,
              (SELECT COUNT(*) FROM stars WHERE user_id = '$logged_in_user_id' AND stars.repo_id = repo.id) AS is_starred,
              v.version_number,
              v.description AS version_note,
              v.file_zip AS file_name
          FROM repo
            JOIN user
            ON repo.creator = user.id
              
            LEFT JOIN version v
            ON v.id = (
              SELECT id
              FROM version v2
              WHERE v2.repo_id = repo.id
              ORDER BY id DESC
              LIMIT 1
            )
          WHERE repo.id = '$repo_id';";

if($result = mysqli_query($conn, $query)){
  if(mysqli_num_rows($result) < 1){
    header("Location: index.php");
    exit();
  }
  $data = mysqli_fetch_assoc($result);
  if($data["visibility"] != "public"){
    if(!isset($_SESSION["id"])){
      header("Location: index.php");
      exit();
    }else{
      if($data["user_id"] != $_SESSION["id"]){
        header("Location: index.php");
        exit();
      }
    }
  }
}else{
  header("Location: index.php");
  exit();
}

// get tag names
$query = "SELECT tag_name FROM tag WHERE repo_id = '$repo_id';";
$tag_result = mysqli_query($conn, $query);
$total_tags = mysqli_num_rows($tag_result);

// get contributors
$query = "SELECT user.user_name, user.name FROM user WHERE user.id IN (SELECT contributor.user_id FROM contributor WHERE repo_id = '$repo_id');";
$contributor_result = mysqli_query($conn, $query);

// get the contents of zip file (folders and files)

$zip = new ZipArchive();
$folders = [];
$files = [];
$zipFileName = "repo_files/" . $data["file_name"];
$zipSizeMB = round(filesize($zipFileName) / (1024 * 1024), 2);
if ($zip->open($zipFileName) === TRUE) {
  for ($i = 0; $i < $zip->numFiles; $i++) {
    $name = $zip->getNameIndex($i);
    $stat = $zip->statIndex($i);
    $sizeMB = round($stat['size'] / (1024 * 1024), 2);
    // Remove trailing slash for easier checking
    $trimmed = rtrim($name, '/');
    // Keep only root-level entries
    if (substr_count($trimmed, '/') > 0) {
      continue;
    }
    if (str_ends_with($name, '/')) {
      $folders[] = [rtrim($name, '/'), $sizeMB];
    } else {
      $files[] = [$name, $sizeMB];
    }
  }
  $zip->close();
}

// Sort by name ascending
usort($folders, function ($a, $b) {
    return strcmp($a[0], $b[0]);
});

usort($files, function ($a, $b) {
    return strcmp($a[0], $b[0]);
});


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $data["title"];?></title>
  <link rel="stylesheet" href="style.css" />
  <style>
    .starred {
      color: var(--yellow);
      background: rgba(251, 191, 36, 0.08);
      border-color: rgba(251, 191, 36, 0.3);
    }

    .starred:hover {
      background: rgba(251, 191, 36, 0.15);
      border-color: var(--yellow);
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
    <div class="repo-view-layout">
      
      <!-- Main Content -->
      <main>
        <div class="repo-header-main">
          <div>
            <div class="repo-path">
              <a href="user_profile.php?username=<?php echo $data["user_name"];?>" class="owner"><?php echo $data["user_name"];?></a>
              <span class="sep">/</span>
              <span class="name"><?php echo $data["title"];?></span>
              <span class="badge badge-gray" style="margin-left: 10px;"><?php echo $data["visibility"];?></span>
            </div>
            <div class="repo-path">
              <span class="repo-meta" style="font-size: 13px;">📅 <?php echo $data["created_at"];?></span>
            </div>
            <p class="text-muted mt-8"><?php echo $data["description"];?></p>
            <div class="flex gap-8 mt-16">
              <?php while($tags = mysqli_fetch_assoc($tag_result)){?>
              <a href="view_tag.php?tag=<?php echo $tags["tag_name"];?>"><span class="tag"><?php echo $tags["tag_name"];?></span></a>
              <?php }?>
            </div>
          </div>

          <div class="gap-12">
            <a class="btn btn-primary" href="repo_files/<?php echo $data["file_name"];?>">⬇️ Download ZIP</a>
          </div>
        </div>

        <!-- Stats & Actions Bar -->
        <div class="repo-stats-grid">
          <div class="repo-stat-box">
            <div class="val"><?php echo $data["total_stars"];?></div>
            <div class="lbl">Stars</div>
          </div>
          <div class="repo-stat-box">
            <div class="val"><?php echo $data["total_versions"];?></div>
            <div class="lbl">Versions</div>
          </div>
          <div class="repo-stat-box">
            <div class="val"><?php echo $total_tags;?></div>
            <div class="lbl">Tags</div>
          </div>
          <div class="repo-stat-box">
            <div class="val"><?php echo $data["total_contributors"];?></div>
            <div class="lbl">Contributors</div>
          </div>
        </div>

        <div class="flex gap-12 mb-24">
          <?php if($data["is_starred"] == 1){
            echo "<button class='btn btn-ghost btn-sm starred' id='star_btn'>★ Starred</button>";
          }else{
            echo "<button class='btn btn-ghost btn-sm' id='star_btn'>☆ Star</button>";
          } ?></button>
          <button class="btn btn-ghost btn-sm" id="share">🔗 Share</button>
          <?php if($data["demo"] != ""){
            $demo = $data["demo"];
            echo '<a href="$demo" target="_blank"><button class="btn btn-outline btn-sm">Live Demo ↗</button></a>';
          }else{
            echo '<button class="btn btn-outline btn-sm" disabled>Live Demo ↗</button>';
          }
            ?>
        </div>

        <!-- File Explorer -->
        <div class="file-explorer anim-fadeup" style="margin-top: 20px;">
          <div class="widget-header" style="background: var(--bg-3);">
            <div class="flex items-center gap-8">
              📦 <span>Latest Files (v<?php echo $data["version_number"];?>)</span> <span class="text-muted" style="font-weight: 400; font-size: 12px; margin-left: 4px;">— <?php echo $zipSizeMB; ?> MB total</span>
            </div>
            <a href="all_versions.php?repo_id=<?php echo $repo_id;?>">See all versions</a>
          </div>
          <?php foreach ($folders as $folder) {?>
          <div class="file-row">
            <div class="icon">📁</div>
            <div class="name"><?php echo $folder[0]; ?></div>
            <div class="meta"><?php echo $folder[1]; ?> MB</div>
          </div>
          <?php }?>
          <?php foreach ($files as $file) {?>
          <div class="file-row">
            <div class="icon">📄</div>
            <div class="name"><?php echo $file[0]; ?></div>
            <div class="meta"><?php echo $file[1]; ?> MB</div>
          </div>
          <?php } ?>
        </div>

        <!-- Version Description Section -->
        <div class="card anim-fadeup" style="animation-delay: 0.1s; margin-bottom: 24px;">
          <h3 class="mb-16">Version <?php echo $data["version_number"];?> Notes</h3>
          <div class="divider mb-16"></div>
          <p class="text-dim">
            <?php echo $data["version_note"];?>
          </p>
        </div>

      </main>

      <!-- Sidebar -->
      <aside class="sidebar-right">
        <div class="sidebar-widget">
          <div class="widget-header">Creator</div>
          <a href="user_profile.php?username=<?php echo $data["user_name"];?>" class="suggest-user" style="border: none;">
            <div class="avatar"><?php echo get_avatar($data["name"]);?></div>
            <div class="info">
              <div class="name"><?php echo $data["name"];?></div>
              <div class="handle">@<?php echo $data["user_name"];?></div>
            </div>
          </a>
          <div style="padding: 0 18px 18px; font-size: 13px; color: var(--text-muted);">
            <?php echo $data["bio"];?>
            <div class="mt-8">👥 <?php echo $data["total_followers"];?> followers • 📦 <?php echo $data["total_repos"];?> repos</div>
          </div>
        </div>

        <div class="sidebar-widget">
          <div class="widget-header">Contributors (<?php echo $data["total_contributors"];?>)</div>
          <?php while($contributors = mysqli_fetch_assoc($contributor_result)){ ?>
          <a href="user_profile.php?username=<?php echo $contributors["user_name"];?>"><div class="suggest-user" style="border: none;"><div class="avatar"><?php echo get_avatar($contributors["name"]); ?></div><div class="name"><?php echo $contributors["user_name"];?></div></div></a>
          <?php }?>
        </div>
      </aside>
    </div>

    <!-- Modal for Preview -->
    <div class="modal-overlay" id="imgModal">
        <div class="modal" style="max-width: 800px;">
            <button class="modal-close" onclick="closeImgModal()">✕</button>
            <div style="width:100%; height:400px; background: var(--bg-3); border-radius: var(--radius);"></div>
            <p class="mt-16 text-center">Dashboard Preview - Dark Mode</p>
        </div>
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
      if (menu && !menu.contains(e.target)) {
        document.getElementById('userDropdown').classList.remove('open');
      }
    });

    function openImgModal() { document.getElementById('imgModal').classList.add('open'); }
    function closeImgModal() { document.getElementById('imgModal').classList.remove('open'); }

    // Share functionality: Copy current URL to clipboard
    const shareBtn = document.getElementById('share');
    if (shareBtn) {
      shareBtn.addEventListener('click', function() {
        navigator.clipboard.writeText(window.location.href).then(() => {
          alert('Link copied to clipboard!');
        });
      });
    }

    // add or remove from starred repos

    const const_repo_id = <?php echo $repo_id; ?>;
    let star_btn = document.getElementById("star_btn");
    star_btn.addEventListener("click", change_star);
    
    async function change_star() {
        let response = await fetch("php/toggle_star.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            repo_id: const_repo_id
          })
        });
        let data = await response.json();
        if(data.status == true){
          if(data.is_starred == true){
            star_btn.classList.add("starred");
            star_btn.innerHTML = "★ Starred";
          }else{
            star_btn.classList.remove("starred");
            star_btn.innerHTML = "☆ Star";
          }
        }else{
          if(data.is_logged_in == false){
            window.location.href = "login.php";
          }
        }
    }
  </script>
</body>

</html>