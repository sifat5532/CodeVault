<?php
session_start();
if (!isset($_SESSION["id"])) {
  header("Location: login.php");
  exit();
}

if (!isset($_GET["repo_id"])) {
  header("Location: feed.php");
  exit();
}
require "php/config.php";
require "php/utility.php";
require 'php/send_notification.php';
require "php/user_info.php";
$logged_in_user = new User($_SESSION["id"], $conn);

$repo_id = $_GET["repo_id"];

// update repo data
$notif = null;
if (isset($_POST["submit_btn"])) {
  $title = $_POST["title"];
  $des = $_POST["des"];
  $vis = $_POST["vis"];
  $demo = $_POST["demo"];
  $query = "UPDATE `repo` SET `title`='$title',`description`='$des',`demo`='$demo',`visibility`='$vis' WHERE id = '$repo_id';";
  if (mysqli_query($conn, $query)) {
    $notif = ["type" => "success", "msg" => "Repo updated successfully!"];
  } else {
    $notif = ["type" => "error", "msg" => "Error, could not update!"];
  }
}


// delete version
if (isset($_POST["version_dlt_btn"])) {
  $vId = $_POST["vId"];
  // get the file name
  $query = "SELECT version.file_zip AS fileName FROM version WHERE version.id = '$vId' AND version.repo_id = '$repo_id';";
  $fileName = mysqli_fetch_assoc(mysqli_query($conn, $query))["fileName"];
  $fileName = "repo_files/" . $fileName;

  $query = "DELETE FROM `version` WHERE version.id = '$vId' AND version.repo_id = '$repo_id';";
  if (mysqli_query($conn, $query)) {
    if (file_exists($fileName)) {
      unlink($fileName);
    }
    $notif = ["type" => "success", "msg" => "Version deleted successfully!"];
  } else {
    $notif = ["type" => "error", "msg" => "Error, could not delete!"];
  }
}

// delete repo
if (isset($_POST["delete_repo_btn"])) {
  $query = "SELECT * FROM `version` WHERE repo_id = '$repo_id' ORDER by id DESC;";
  $version_result = mysqli_query($conn, $query);
  while ($data = mysqli_fetch_assoc($version_result)) {
    $fileName = "repo_files/" . $data["file_zip"];
    if (file_exists($fileName)) {
      unlink($fileName);
    }
  }
  $query = "DELETE FROM `repo` WHERE id = '$repo_id';";
  if (!mysqli_query($conn, $query)) {
    $notif = ["type" => "error", "msg" => "Error, could not delete!"];
  }
}

// remove contributor

if(isset($_POST["rmv_contributor"])){
  $rmv_contri_id = $_POST["rmv_contri_id"];
  $query = "DELETE FROM `contributor` WHERE user_id = '$rmv_contri_id' AND repo_id = '$repo_id';";
  if(mysqli_query($conn, $query)){
    $notif = ["type" => "success", "msg" => "Contributor removed successfully!"];
    // send notification to the user
    send_notification($conn, $repo_id, "removed_as_contributor", $_SESSION["id"], $rmv_contri_id);
  }else{
    $notif = ["type" => "error", "msg" => "Error, could not remove!"];
  }
}


// Add contributor
if(isset($_POST["add_contri"])){
  $add_contri_id = $_POST["add_contri_id"];
  if($add_contri_id == $_SESSION["id"]){
    $notif = ["type" => "error", "msg" => "Author is a contributor by default"];
  }else{
    $query = "SELECT * FROM `contributor` WHERE repo_id = '$repo_id' AND user_id = '$add_contri_id';";
    if(mysqli_num_rows(mysqli_query($conn, $query)) > 0){
      $notif = ["type" => "error", "msg" => "Already added as a Contributor"];
    }else{
      $query = "INSERT INTO `contributor`(`user_id`, `repo_id`) VALUES ('$add_contri_id','$repo_id');";
      if(mysqli_query($conn, $query)){
        $notif = ["type" => "success", "msg" => "Contributor added successfully!"];
        // send notification to the user
        send_notification($conn, $repo_id, "added_as_contributor", $_SESSION["id"], $add_contri_id);
      }else{
        $notif = ["type" => "error", "msg" => "Could not add. Please try again"];
      }
    }
  }
}
// show repo data
$query = "SELECT
              repo.title,
              repo.demo,
              repo.description,
              repo.visibility,
              user.id AS user_id,
              user.user_name AS username,
              user.name
          FROM repo
            JOIN user
              ON repo.creator = user.id
          WHERE repo.id = '$repo_id';";

if ($result = mysqli_query($conn, $query)) {
  $data = mysqli_fetch_assoc($result);
  if ($data["user_id"] != $_SESSION["id"]) {
    header("Location: feed.php");
    exit();
  }
} else {
  header("Location: feed.php");
  exit();
}

$public_selected = $data["visibility"] == "public" ? "selected" : "";
$private_selected = $data["visibility"] == "private" ? "selected" : "";

// show versions
$query = "SELECT * FROM `version` WHERE repo_id = '$repo_id' ORDER by id DESC;";
$version_result = mysqli_query($conn, $query);
$isMultipleVersions = mysqli_num_rows($version_result) > 1 ? true : false;

// get contributors
$query = "SELECT
              contributor.user_id AS id,
              user.name,
              user.user_name AS username
          FROM contributor
            JOIN user
              ON contributor.user_id = user.id
          WHERE contributor.repo_id = '$repo_id';";
$contributor_result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Repo Settings — CodeVault</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
  <style>
    /* Inline styles ensuring the new iframe-like user list container looks clean and functions perfectly */
    .user-picker-container {
      border: 1px solid var(--border, #e1e4e8);
      border-radius: 6px;
      max-height: 240px;
      overflow-y: auto;
      background: var(--bg-2, #ffffff);
      margin-bottom: 16px;
    }

    .user-picker-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 12px;
      border-bottom: 1px solid var(--border, #e1e4e8);
    }

    .user-picker-item:last-child {
      border-bottom: none;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .user-details {
      display: flex;
      flex-direction: column;
    }

    .user-full-name {
      font-weight: 600;
      font-size: 14px;
      color: var(--text-main, #ffffff);
      line-height: 1.2;
    }

    .user-username {
      font-size: 12px;
      color: var(--text-muted, #586069);
    }
  </style>
</head>
<script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.history.href);
  }
</script>

<body>

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
        <?php if ($logged_in_user->getTotalUnread() > 0): ?>
          <div class="notif-badge"><?php echo $logged_in_user->getTotalUnread(); ?></div>
        <?php endif; ?>
      </div>
    </a>

    <div class="user-menu">
      <div class="avatar" onclick="toggleDropdown()">
        <?php echo get_avatar($logged_in_user->getName()); ?>
      </div>
      <div class="user-dropdown" id="userDropdown">
        <a href="profile.php">👤 My Profile</a>
        <a href="settings.php">⚙️ Settings</a>
        <div class="dd-divider"></div>
        <a href="php/logout.php" class="danger">🚪 Sign out</a>
      </div>
    </div>
  </div>
  </nav>

  <div class="page-wrap">
    <div class="settings-layout">
      <aside class="sidebar-left">
        <nav class="sidebar-nav">
          <a href="#general" class="active"><span class="nav-icon">📦</span> General</a>
          <a href="#contributors"><span class="nav-icon">👥</span> Contributors</a>
          <a href="#versions"><span class="nav-icon">📜</span> Versions</a>
          <a href="profile.php"><span class="nav-icon">⬅️</span> Back to Profile</a>
        </nav>
      </aside>

      <main class="settings-main">
        <section id="general" class="settings-section anim-fadeup">
          <h2 class="section-title">Repository Settings</h2>
          <p class="section-sub">Manage visibility and core details for <strong
              class="text-accent"><?php echo $data["title"]; ?></strong>.</p>

          <form method="POST" class="settings-card">
            <div class="form-group">
              <label>Repository Name</label>
              <input name="title" type="text" value="<?php echo $data["title"]; ?>" />
            </div>
            <div class="form-group">
              <label>Project Description</label>
              <textarea name="des" rows="3"><?php echo $data["description"]; ?></textarea>
            </div>
            <div class="form-group">
              <label>Demo</label>
              <input name="demo" type="url" value="<?php echo $data["demo"]; ?>" />
            </div>
            <div class="form-group">
              <label>Visibility</label>
              <select name="vis">
                <option value="public" <?php echo $public_selected; ?>>Public</option>
                <option value="private" <?php echo $private_selected; ?>>Private</option>
              </select>
              <p class="text-muted mt-4">Public repositories are visible to everyone.</p>
            </div>
            <input type="submit" name="submit_btn" value="Save Changes" class="btn btn-primary">
          </form>
        </section>

        <section id="contributors" class="settings-section anim-fadeup" style="animation-delay: 0.1s;">
          <h2 class="section-title">Manage Contributors</h2>
          <p class="section-sub">Add or remove users who can contribute to this project.</p>

          <div class="settings-card">
            <div class="form-group">
              <div class="search-input-group">
                <button class="btn btn-primary" onclick="openAddContributorModal()">+ Add Contributor</button>
              </div>
            </div>

            <div class="divider"></div>

            <div class="contributor-list mt-16">

              <div class="contributor-item">
                <div class="flex items-center gap-12">
                  <div class="avatar"><?php echo get_avatar($data["name"]);?></div>
                  <div>
                    <div class="name"><?php echo $data["username"] ;?> <strong>(Owner)</strong></div>
                  </div>
                </div>
              </div>
              <?php while($data = mysqli_fetch_assoc($contributor_result)){ ?>
              <div class="contributor-item">
                <div class="flex items-center gap-12">
                  <div class="avatar"><?php echo get_avatar($data["name"])?></div>
                  <div>
                    <a href="user_profile.php?username=<?php echo $data["username"]; ?>"><div class="name"><?php echo $data["username"]; ?></div></a>
                  </div>
                </div>
                <form method="POST">
                  <input type="hidden" name="rmv_contri_id" value="<?php echo $data["id"];?>">
                  <input type="submit" name="rmv_contributor" value="Remove" class="btn btn-ghost btn-sm text-red">
                </form>
              </div>
              <?php } ?>
            </div>
          </div>
        </section>

        <section id="versions" class="settings-section anim-fadeup" style="animation-delay: 0.15s;">
          <h2 class="section-title">Manage Versions</h2>
          <p class="section-sub">Review and delete specific versions of your project archive.</p>

          <div class="settings-card">
            <div class="contributor-list">
              <?php
              $is_first = true;
              while ($data = mysqli_fetch_assoc($version_result)) { ?>
                <div class="contributor-item">
                  <?php if ($is_first) { ?>
                    <div class="flex items-center gap-12">
                      <div class="version-chip">v<?php echo $data["version_number"]; ?></div>
                      <div>
                        <div class="name">Latest Version</div>
                        <div class="repo-meta">Uploaded <?php echo timeAgo($data["created_at"]); ?></div>
                      </div>
                    </div>
                    <?php $is_first = false;
                  } else { ?>

                    <div class="flex items-center gap-12">
                      <div class="version-chip"
                        style="background: var(--bg-3); border-color: var(--border); color: var(--text-dim);">
                        v<?php echo $data["version_number"]; ?></div>
                      <div>
                        <div class="name">Previous Version</div>
                        <div class="repo-meta">Uploaded <?php echo timeAgo($data["created_at"]); ?></div>
                      </div>
                    </div>

                  <?php } ?>

                  <?php if ($isMultipleVersions) { ?>
                    <form method="POST">
                      <input type="hidden" name="vId" value="<?php echo $data["id"]; ?>">
                      <input type="submit" name="version_dlt_btn" class="btn btn-outline-red btn-sm" value="Delete">
                    </form>
                  <?php } ?>

                </div>
              <?php } ?>

            </div>
          </div>
        </section>

        <section id="danger-zone" class="settings-section anim-fadeup" style="animation-delay: 0.2s;">
          <h2 class="section-title text-red">Danger Zone</h2>
          <div class="settings-card danger-card">
            <div class="setting-item">
              <div>
                <h3>Delete Repository</h3>
                <p class="text-muted">Once deleted, there is no going back. Please be certain.</p>
              </div>
              <form method="POST">
                <input type="submit" name="delete_repo_btn" class="btn btn-red" value="Delete Repo">
              </form>
            </div>
          </div>
        </section>
      </main>
    </div>

    <footer>
      <div class="footer-logo">⬡ CodeVault</div>
      <div class="footer-links"><a href="#">About</a><a href="#">Privacy</a><a href="#">Terms</a><a href="#">Contact</a>
      </div>
      <div class="footer-copy">© 2025 CodeVault</div>
    </footer>
  </div>


  <!-- ADD CONTRIBUTOR MODAL -->
  <div class="modal-overlay" id="addContributorModal">
    <div class="modal" style="max-width: 440px;">
      <button class="modal-close" onclick="closeAddContributorModal()">✕</button>
      <h2 class="section-title" style="font-size: 20px;">Add Contributor</h2>
      <p class="modal-sub">Search and add registered developers who contributed on this repository.</p>

      <div class="form-group">
        <label for="contributor-username">Search Users</label>
        <input type="text" id="contributor-username" placeholder="Type username or name..." />
      </div>

      <div class="user-picker-container" id="searched_user_list">



      </div>

      <div class="flex gap-12" style="justify-content: flex-end;">
        <button class="btn btn-ghost" onclick="closeAddContributorModal()">Cancel</button>
      </div>
    </div>
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

    // Add Contributor Modal functions
    function openAddContributorModal() {
      document.getElementById('addContributorModal').classList.add('open');
    }

    function closeAddContributorModal() {
      document.getElementById('addContributorModal').classList.remove('open');
    }

    // Fixed Overlay closing logic
    const modalOverlay = document.getElementById('addContributorModal');
    modalOverlay.addEventListener('click', function (e) {
      if (e.target === modalOverlay) {
        closeAddContributorModal();
      }
    });

    // search users for contribution
    const input_field = document.getElementById("contributor-username");
    const user_list = document.getElementById("searched_user_list");
    input_field.addEventListener("input", get_users);

    async function get_users() {
      if (input_field.value != "") {
        let html = "";

        let url = "php/get_users.php?searching_for=" + encodeURIComponent(input_field.value);
        let response = await fetch(url);
        let data = await response.json();
        data.forEach(e => {
          html += `
              <div class="user-picker-item">
                <div class="user-info">
                  <div class="avatar">${e.avatar}</div>
                  <div class="user-details">
                    <span class="user-full-name">${e.name}</span>
                    <span class="user-username">@${e.user_name}</span>
                  </div>
                </div>
                <form method="POST" action="">
                <input type="hidden" name="add_contri_id" value="${e.id}">
                <input type="submit" name="add_contri" value="Add" class="btn btn-primary btn-sm">
                </form>
              </div>`;
        });
        user_list.innerHTML = html;
      }else{
        user_list.innerHTML = "";
      }
    }
  </script>

  <?php if ($notif): ?>
    <script>
      window.addEventListener('load', function () {
        let notyf = new Notyf();
        notyf.<?php echo $notif["type"]; ?>('<?php echo $notif["msg"]; ?>');
      });
    </script>
  <?php endif; ?>
</body>

</html>