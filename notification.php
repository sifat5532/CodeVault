<?php
session_start();
if (!isset($_SESSION['id'])) {
  header("Location: index.php");
  exit();
}
require "php/config.php";
require "php/get_notification_element.php";
require "php/utility.php";
require "php/user_info.php";
$id = $_SESSION['id'];
$logged_in_user = new User($id, $conn);
$query = "SELECT 
              notification.*,
              user.user_name AS username,
              user.name,
              user.id AS user_id,
              repo.title AS repo_title,
              v.version_number AS repo_version
          FROM notification
              LEFT JOIN user
              ON notification.who_sent = user.id
              
              LEFT JOIN repo
              ON notification.repo_id = repo.id
              
              LEFT JOIN version v
              ON v.id = (
                  SELECT sub_v.id 
                  FROM version sub_v 
                  WHERE sub_v.repo_id = notification.repo_id 
                  ORDER BY sub_v.id DESC 
                  LIMIT 1
              )
          WHERE notification.who_got = '$id' ORDER BY notification.id DESC;";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Notifications — CodeVault</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
</head>
<script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.history.href);
  }
</script>
<body>

  <!-- ===== NAVBAR (Shared from feed.php) ===== -->
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

  <!-- ===== NOTIFICATION CONTENT ===== -->
  <div class="page-wrap">
    <main class="notif-container">
      <header class="notif-header anim-fadeup">
        <h1>Notifications</h1>
        <div class="notif-controls">
          <button class="btn btn-ghost btn-sm" id="mark_all_read">Mark all as read</button>
        </div>
      </header>

      <div class="notif-list">

        <!-- Notification Item 1 -->
        <?php while ($data = mysqli_fetch_assoc($result)) {
          echo get_notification_element($data["id"], $data['username'], $data['user_id'], $data['type'], $data['repo_id'], $data['repo_title'], $data['repo_version'], get_avatar($data['name']), timeAgo($data['created_at']), $data['is_read']);
        } ?>


        <!-- Notification Item 2
      <div class="notif-item unread anim-fadeup" style="animation-delay: 0.1s">
        <div class="avatar">NJ</div>
        <div class="notif-content">
          <p class="notif-text"><strong>neeraj_dev</strong> starred your repository <span class="repo-link">vault-cli-tools</span></p>
          <span class="notif-time">45m ago</span>
        </div>
        <div class="notif-action-icon">⭐</div>
      </div> -->

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
    function toggleDropdown() {
      document.getElementById('userDropdown').classList.toggle('open');
    }
    document.addEventListener('click', function (e) {
      const menu = document.querySelector('.user-menu');
      if (menu && !menu.contains(e.target)) {
        document.getElementById('userDropdown').classList.remove('open');
      }
    });

    // mark all as read functionality
    const all_read_btn = document.getElementById("mark_all_read");
    const notyf = new Notyf();
    const notif_elements = document.querySelectorAll('.notif-item');

    all_read_btn.addEventListener("click", markAllAsRead);

    async function markAllAsRead() {
      let response = await fetch("php/mark_all_read.php");
      let result = await response.json();
      if (result.status == true) {
        notif_elements.forEach(element => {
          element.classList.remove('unread');
        });
        notyf.success('All notifications marked as read');
        document.getElementsByClassName("notif-badge")[0].style.display = "none";
      }else{
        notyf.error("Error! Please try again later.");
      }
    }

    // mark single notification as read
    async function mark_read(param){
      let card_id = "clicked_card_" + param;
      let notif_card = document.getElementById(card_id);

      let url = "php/mark_one_read.php?notif_id=" + encodeURIComponent(param);
      let response = await fetch(url);
      let data = await response.json();
      if(data.status == true){
        notif_card.classList.remove('unread');
        console.log("done");
      }
    }
  </script>
</body>

</html>