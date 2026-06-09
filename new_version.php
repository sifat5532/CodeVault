<?php
session_start();
if (!isset($_SESSION['id'])) {
  header("Location: index.php");
  exit();
}

if (!isset($_GET['repo_id'])) {
  header("Location: feed.php");
  exit();
}
require "php/config.php";

$repo_id = $_GET['repo_id'];
$query = "SELECT
              version.version_number,
              repo.title,
              repo.creator
          FROM version
              LEFT JOIN repo
              ON version.repo_id = repo.id
          WHERE version.repo_id = '$repo_id' ORDER BY version.id DESC LIMIT 1;";
$data = mysqli_query($conn, $query);
if (mysqli_num_rows($data) == 0) {
  header("Location: feed.php");
  exit();
}
$notif = null;

$data = mysqli_fetch_assoc($data);
$title = $data['title'];
$creator = $data['creator'];
$latest_version = $data['version_number'];
if ($creator != $_SESSION['id']) {
  header("Location: feed.php");
  exit();
}

if (isset($_POST['publish_version'])) {
  $new_version_tag = $_POST['new_version_tag'];
  $version_description = $_POST['version_description'];

  $file = $_FILES["zip_file"];
  $file_name = $file["name"];
  $file_tmp = $file["tmp_name"];
  $file_err = $file["error"];
  $file_size = $file["size"];

  if ($file_err === 0) {

    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    if ($file_ext == "zip") {
      $new_file_name = $creator . "_" . time() . "." . $file_ext;
      $upload_dir = "repo_files/";
      if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
      }
      $destinition = $upload_dir . $new_file_name;
      if (move_uploaded_file($file_tmp, $destinition)) {
        $query2 = "INSERT INTO version(repo_id,version_number,file_zip,description) VALUES('$repo_id','$new_version_tag','$new_file_name','$version_description')";
        if (mysqli_query($conn, $query2)) {
          // remove existing tags
          remove_tags($conn, $repo_id);
          // adding the tag names to the database
          insert_tag_names($conn, $repo_id, $destinition);

          // adding the notifciations to database
          $notif = insert_notifications($conn, "new_version", $repo_id, $creator);
        } else
          $notif = ["type" => "error", "msg" => "Error! Please Try Again ."];
      } else
        $notif = ["type" => "error", "msg" => "Error! Please Try Again ."];
    } else
      $notif = ["type" => "error", "msg" => "Error! Please give zip file ."];
  } else
    $notif = ["type" => "error", "msg" => "Error! Please Try Again"];
}

// function to remove existing tags of the repository
function remove_tags($conn, $repo_id)
{
  $query = "DELETE FROM `tag` WHERE repo_id = '$repo_id';";
  mysqli_query($conn, $query);
}

// function to insert the tag names to the database
function insert_tag_names($conn, $repo_id, $zipFileName)
{
  $zip = new ZipArchive();
  $extensions = [];

  if ($zip->open($zipFileName) === TRUE) {
    for ($i = 0; $i < $zip->numFiles; $i++) {
      $name = $zip->getNameIndex($i);
      // Skip folders
      if (str_ends_with($name, '/')) {
        continue;
      }
      $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
      if ($ext !== '') {
        $extensions[$ext] = true;
      }
    }
    $zip->close();
  }
  $extensions = array_keys($extensions);
  if (count($extensions) <= 0) {
    return;
  }

  $query = "INSERT INTO `tag` (`tag_name`, `repo_id`) VALUES ";
  for ($i = 0; $i < count($extensions); $i++) {
    $tag = $extensions[$i];
    if ($i == count($extensions) - 1) {
      $query .= "('$tag', '$repo_id')";
    } else {
      $query .= "('$tag', '$repo_id'), ";
    }
  }

  $query .= ";";
  mysqli_query($conn, $query);
}

// insert notifications for those who needs to be notified
function insert_notifications($conn, $type, $repo_id, $sender_id)
{
  $notification_condition = '_$_$1%';
  $query = "INSERT INTO notification (who_sent, who_got, repo_id, is_read, type)
            SELECT 
                $sender_id AS who_sent, 
                target.id AS who_got,
                $repo_id AS repo_id, 
                0 AS is_read, 
                '$type' AS type
            FROM (
                SELECT
                    user.id
                FROM user
                WHERE user.id IN (
                    SELECT contributor.user_id AS user_id FROM contributor WHERE contributor.repo_id = $repo_id
                    UNION
                    SELECT follower.who_is_following FROM follower WHERE follower.who_is_being_followed = $sender_id
                    UNION
                    SELECT stars.user_id FROM stars WHERE stars.repo_id = $repo_id AND stars.user_id != $sender_id
                ) AND user.notification_settings LIKE '$notification_condition'
            ) AS target;";
  if (mysqli_query($conn, $query)) {
    // notifications inserted successfully
    $notif = ["type" => "success", "msg" => "Version published successfully and notifications sent!"];
  } else {
    // error inserting notifications
    $notif = ["type" => "success", "msg" => "Version published successfully but failed to send notifications."];
  }
  return $notif;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
  <title>Add New Version — <?php echo $title; ?></title>
  <link rel="stylesheet" href="style.css" />
</head>
<script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.history.href);
  }
</script>

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
          <a href="#">⚙️ Settings</a>
          <div class="dd-divider"></div>
          <a href="index.php" class="danger">🚪 Sign out</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- ===== PAGE ===== -->
  <div class="page-wrap">
    <main class="create-repo-container">
      <header class="create-repo-header anim-fadeup">
        <h1 class="section-title">Upload a new version</h1>
        <p class="section-sub">Updating <a href="view_repo.php?repo_id=<?php echo $repo_id;?>" class="text-accent"><?php echo $title; ?></a>. All previous versions
          will remain available in the archive.</p>
      </header>

      <form method="POST" enctype="multipart/form-data" class="settings-card anim-fadeup"
        style="animation-delay: 0.1s;">
        <!-- Version Info -->
        <div class="flex gap-12 mb-24">
          <div class="form-group" style="flex: 1;">
            <label for="version-number">New Version Tag</label>
            <input name="new_version_tag" type="text" id="version-number" placeholder="e.g. 5.0.1" required />
            <p class="text-muted" style="font-size: 12px; margin-top: 4px;">Latest is currently
              v<?php echo $latest_version; ?></p>
          </div>
        </div>

        <!-- Version Description -->
        <div class="form-group">
          <label for="version-desc">What's new in this version?</label>
          <textarea name="version_description" id="version-desc" rows="5"
            placeholder="Describe fixes, new features, or breaking changes..."></textarea>
        </div>

        <div class="divider mb-24"></div>

        <!-- File Upload -->
        <div class="form-group">
          <label for="zip-file">Project Source (ZIP) <span class="text-red">*</span></label>
          <input type="file" name="zip_file" id="zip-file" class="custom-file-input" accept=".zip" required />
        </div>

        <div class="divider mb-24"></div>

        <div class="flex gap-12" style="justify-content: flex-end;">
          <button type="button" class="btn btn-ghost" onclick="window.history.back()">Cancel</button>
          <input type="submit" name="publish_version" class="btn btn-primary" value="Publish New Version">
        </div>
      </form>
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
      if (!menu.contains(e.target)) {
        document.getElementById('userDropdown').classList.remove('open');
      }
    });

    // Version number validation
    document.getElementById('version-number').addEventListener('input', function (e) {
      this.value = this.value.replace(/[^0-9.]/g, '');
    });
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