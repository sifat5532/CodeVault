<?php
session_start();
if (!isset($_SESSION["id"])) {
  header("Location: login.php");
  exit();
}
require "php/config.php";
$creator = $_SESSION["id"];

// check the default_repo_visibility from user table
$default_repo_visibility = (mysqli_fetch_assoc(mysqli_query($conn, "SELECT default_repo_visibility AS def FROM user WHERE id = '$creator'"))["def"] == "public") ? "checked" : " ";

if (isset($_POST["create_btn"])) {
  $title = $_POST["title"];
  $file = $_FILES["file"];
  $file_name = $file["name"];
  $file_tmp = $file["tmp_name"];
  $file_err = $file["error"];
  $file_size = $file["size"];
  if (isset($_POST["description"]))
    $description = $_POST["description"];
  else
    $description = " ";

  if (isset($_POST["demo"]))
    $demo = $_POST["demo"];
  else
    $demo = "";
  $visibility = $_POST["visibility"];

  if ($visibility == "on") {
    $visibility = "public";
  } else {
    $visibility = "private";
  }

  $initial_version = $_POST["initial_version"];
  if (isset($_POST["version_description"]))
    $version_description = $_POST["version_description"];
  else
    $version_description = "";
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
        $query1 = "INSERT INTO repo(title,file,creator,description,demo,visibility) VALUES('$title','$new_file_name','$creator','$description','$demo','$visibility')";

        if (mysqli_query($conn, $query1)) {
          $repo_id = mysqli_insert_id($conn);
          $query2 = "INSERT INTO version(repo_id,version_number,file_zip,description) VALUES('$repo_id','$initial_version','$new_file_name','$version_description')";

          if (mysqli_query($conn, $query2)) {
            $msg = "<div style='color: #28a745'>Repository Created Successfully!</div>";
          } else
            $msg = "<div style='color: #dc3545'>Error! Please Try Again .</div>";
        } else
          $msg = "<div style='color: #dc3545'>Error! Please Try Again .</div>";
      } else
        $msg = "<div style='color: #dc3545'>Error! Please Try Again .</div>";
    } else
      $msg = "<div style='color: #dc3545'>Error! Please give zip file .</div>";
  } else
    $msg = "<div style='color: #dc3545'>Error! Please Try Again</div>";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Create New Repository — CodeVault</title>
  <link rel="stylesheet" href="style.css" />
</head>
<script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.history.href);
  }
</script>

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
    <main class="create-repo-container">
      <header class="create-repo-header anim-fadeup">
        <h1 class="section-title">Create a new vault</h1>
        <p class="section-sub">A repository contains all your project files, including the version history.</p>
      </header>
      <?php if (isset($msg)) {
        echo $msg;
      } ?>
      <form method="POST" enctype="multipart/form-data" class="settings-card anim-fadeup"
        style="animation-delay: 0.1s;">
        <!-- Title -->
        <div class="form-group">
          <label for="repo-title">Repository Title</label>
          <input type="text" name="title" id="repo-title" placeholder="e.g. my-awesome-project" required />
          <p class="text-muted" style="font-size: 12px; ">Great repository names are short and memorable.</p>
        </div>

        <!-- Description -->
        <div class="form-group">
          <label for="repo-desc">Description (optional)</label>
          <textarea id="repo-desc" rows="3" name="description" placeholder="What is your project about?"></textarea>
        </div>

        <div class="divider mb-24"></div>

        <!-- Versioning -->
        <div class="flex gap-12 mb-24">
          <div class="form-group" style="flex: 1;">
            <label for="version-number">Initial Version</label>
            <input type="text" id="version-number" name="initial_version" placeholder="1.0.0" required />
          </div>
          <div class="form-group" style="flex: 2;">
            <label for="live-demo">Live Demo URL (optional)</label>
            <input type="url" id="live-demo" name="demo" placeholder="https://example.com" />
          </div>
        </div>

        <div class="form-group">
          <label for="version-desc">Version Notes</label>
          <textarea id="version-desc" rows="3" name="version_description"
            placeholder="Initial release features..."></textarea>
        </div>

        <div class="divider mb-24"></div>

        <!-- File Uploads -->
        <div class="form-group">
          <label for="zip-file">Project Source (ZIP) <span class="text-red">*</span></label>
          <input type="file" id="zip-file" name="file" class="custom-file-input" accept=".zip" required />
        </div>



        <!-- Visibility -->
        <div class="setting-item mb-24">
          <div>
            <label style="font-weight: 600;">Public Repository</label>
            <p class="text-muted">Anyone on the internet can see this repository.</p>
          </div>
          <label class="switch">
            <input type="checkbox" name="visibility" <?php echo $default_repo_visibility; ?>>
            <span class="slider round"></span>
          </label>
        </div>

        <div class="flex gap-12" style="justify-content: flex-end;">
          <button type="button" name="cancel_btn " class="btn btn-ghost" onclick="window.history.back()">Cancel</button>
          <button type="submit" name="create_btn" class="btn btn-primary">Create Repository</button>
        </div>
      </form>
    </main>

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

    // Feed filter
    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', function () {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
      });
    });

    // Custom implementation: Version Number Restriction
    const versionInput = document.getElementById('version-number');
    if (versionInput) {
      versionInput.addEventListener('input', function (e) {
        // Restriction: only digits and dots
        this.value = this.value.replace(/[^0-9.]/g, '');
      });
    }

    // Custom implementation: Image Count Restriction (Max 5)
    const previewsInput = document.getElementById('previews');
    if (previewsInput) {
      previewsInput.addEventListener('change', function () {
        if (this.files.length > 5) {
          alert("You can only upload a maximum of 5 images.");
          this.value = ""; // Reset the input
        }
      });
    }
  </script>
</body>

</html>