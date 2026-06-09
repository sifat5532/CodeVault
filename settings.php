<?php 
session_start();
if(!isset($_SESSION["id"])){
  header("Location: login.php");
  exit();
}

require "php/config.php";
require "php/utility.php";
require "php/user_info.php";
$logged_in_user = new User($_SESSION["id"], $conn);

$user_id = $_SESSION["id"];
$query = "SELECT * FROM user WHERE id = '$user_id' LIMIT 1;";
if($result = mysqli_query($conn, $query)){
  $data = mysqli_fetch_assoc($result);
}else{
  header("Location: feed.php");
  exit();
}
$notif_settings = explode('$', $data["notification_settings"]);
$public_selected = $data["default_repo_visibility"] == "public" ? "selected" : "";
$private_selected = $data["default_repo_visibility"] == "private" ? "selected" : "";

if(isset($_POST["dlt_btn"])){
  $query = "DELETE FROM `user` WHERE id='$user_id';";
  if(mysqli_query($conn, $query)){
    header("Location: php/logout.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Settings — CodeVault</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
  <script src="script.js"></script>

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
          <a href="#">⚙️ Settings</a>
          <div class="dd-divider"></div>
          <a href="php/logout.php" class="danger">🚪 Sign out</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- ===== PAGE ===== -->
  <div class="page-wrap">
    <div class="settings-layout">

      <!-- ===== LEFT SIDEBAR (Settings Navigation) ===== -->
      <aside class="sidebar-left">
        <nav class="sidebar-nav">
          <a href="#profile-settings" class="active"><span class="nav-icon">👤</span> Profile</a>
          <a href="#notification-preferences"><span class="nav-icon">🔔</span> Notifications</a>
          <a href="#repository-defaults"><span class="nav-icon">📦</span> Repositories</a>
          <a href="#danger-zone"><span class="nav-icon">⚠️</span> Danger Zone</a>
        </nav>
      </aside>

      <!-- ===== MAIN SETTINGS CONTENT ===== -->
      <main class="settings-main">

        <!-- Profile Settings -->
        <section id="profile-settings" class="settings-section anim-fadeup" style="animation-delay:0.05s">
          <h2 class="section-title">Profile Settings</h2>
          <p class="section-sub">Update your public profile information.</p>

          <div class="settings-card">
            <div class="form-group profile-avatar-upload">
              <label for="profile-picture">Profile Avatar</label>
              <div class="avatar xl" style="margin-bottom: 10px;"><?php if(isset($data)){echo get_avatar($data["name"]);} ?></div>
            </div>
            <div class="form-group">
              <label for="full-name">Full Name</label>
              <input type="text" id="name" placeholder="Rafid Khan" value="<?php if(isset($data)){echo $data["name"];} ?>" required/>
            </div>
            <div class="form-group">
              <label for="username" id="usernameLabel">Username</label>
              <input type="text" id="username" placeholder="john_doe" value="<?php if(isset($data)){echo $data["user_name"];} ?>" required/>
            </div>
            <div class="form-group">
              <label for="bio">Bio</label>
              <textarea id="bio" rows="4"
                placeholder="A passionate developer building awesome things." required><?php if(isset($data)){echo $data["bio"];} ?></textarea>
            </div>
            <div class="form-group">
              <label for="location">Location</label>
              <input type="text" id="location" placeholder="e.g. Dhaka, Bangladesh" value="<?php if(isset($data)){echo $data["location"];} ?>" required/>
            </div>
            <div class="form-group">
              <label for="web">Website</label>
              <input type="text" id="web" placeholder="e.g. rafidkhan.dev" value="<?php if(isset($data)){echo $data["web"];} ?>" />
            </div>
            <button id="save_btn" class="btn btn-primary" style="text-align: center;">Save Profile</button>
          </div>
        </section>

        <!-- Notification Preferences -->
        <section id="notification-preferences" class="settings-section anim-fadeup" style="animation-delay:0.15s">
          <h2 class="section-title">Notification Preferences</h2>
          <p class="section-sub">Choose what you want to be notified about.</p>

          <div class="settings-card">
            <div class="setting-item">
              <label for="notif-stars">Repository stars notifications</label>
              <label class="switch">
                <input type="checkbox" id="notif-0" onclick="update_notif_settings()" <?php if(isset($notif_settings)){echo $notif_settings[0] == "1" ? "checked" : "";} ?>>
                <span class="slider round"></span>
              </label>
            </div>
            <div class="setting-item">
              <label for="notif-followers">New follower notifications</label>
              <label class="switch">
                <input type="checkbox" id="notif-1"  onclick="update_notif_settings()" <?php if(isset($notif_settings)){echo $notif_settings[1] == "1" ? "checked" : "";} ?>>
                <span class="slider round"></span>
              </label>
            </div>
            <div class="setting-item">
              <label for="notif-versions">Version update notifications</label>
              <label class="switch">
                <input type="checkbox" id="notif-2"  onclick="update_notif_settings()" <?php if(isset($notif_settings)){echo $notif_settings[2] == "1" ? "checked" : "";} ?>>
                <span class="slider round"></span>
              </label>
            </div>
            <div class="setting-item">
              <label for="notif-system">System alert notifications</label>
              <label class="switch">
                <input type="checkbox" id="notif-3"  onclick="update_notif_settings()" <?php if(isset($notif_settings)){echo $notif_settings[3] == "1" ? "checked" : "";} ?>>
                <span class="slider round"></span>
              </label>
            </div>
          </div>
        </section>

        <!-- Repository Defaults -->
        <section id="repository-defaults" class="settings-section anim-fadeup" style="animation-delay:0.25s">
          <h2 class="section-title">Repository Defaults</h2>
          <p class="section-sub">Set default options for new repositories.</p>

          <div class="settings-card">
            <div class="form-group">
              <label for="default-visibility">Default repository visibility</label>
              <select id="default-visibility">
                <option value="public" <?php echo $public_selected; ?>>Public</option>
                <option value="private" <?php echo $private_selected; ?>>Private</option>
              </select>
            </div>
          </div>
        </section>

        <!-- Danger Zone -->
        <section id="danger-zone" class="settings-section anim-fadeup" style="animation-delay:0.3s">
          <h2 class="section-title text-red">Danger Zone</h2>
          <p class="section-sub">Irreversible actions for your account.</p>

          <div class="settings-card danger-card">
            <p class="text-red" style="margin-bottom: 15px;">
              <span class="nav-icon">⚠️</span> Be careful! These actions cannot be undone.
            </p>

            <div class="setting-item"
              style="border-top: 1px solid var(--border-soft); padding-top: 10px; margin-top: 0px;">
              <div>
                <h3>Delete Account</h3>
                <p class="text-muted">Permanently delete your account and all associated data.</p>
              </div>
              <form method="POST"><input type="submit" name="dlt_btn" class="btn btn-red" value="Delete Account"></form>
            </div>
          </div>
        </section>

      </main>
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

  <!-- ===== SCRIPTS ===== -->
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

    // // Star toggle (commented out as it's not relevant for settings page)
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

    // Follow toggle (commented out as it's not relevant for settings page)
    // function toggleFollow(btn) {
    //   if (btn.classList.contains('following')) {
    //     btn.classList.remove('following');
    //     btn.textContent = 'Follow';
    //   } else {
    //     btn.classList.add('following');
    //     btn.textContent = 'Following';
    //   }
    // }

    // Settings sidebar navigation active state
    document.querySelectorAll('.sidebar-nav a').forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelectorAll('.sidebar-nav a').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const targetId = this.getAttribute('href').substring(1);
        const targetSection = document.getElementById(targetId);
        if (targetSection) {
          targetSection.scrollIntoView({ behavior: 'smooth' });
        }
      });
    });

    // Optional: Highlight sidebar nav item on scroll
    const sections = document.querySelectorAll('.settings-section');
    const navLinks = document.querySelectorAll('.sidebar-nav a');

    window.addEventListener('scroll', () => {
      let current = '';
      sections.forEach(section => {
        const sectionTop = section.offsetTop - document.querySelector('.navbar').offsetHeight - 20; // Adjust for navbar height and some offset
        const sectionHeight = section.clientHeight;
        if (pageYOffset >= sectionTop && pageYOffset < sectionTop + sectionHeight) {
          current = section.getAttribute('id');
        }
      });

      navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href').includes(current)) {
          link.classList.add('active');
        }
      });
    });


    

    // validate username
    const uname_input = document.getElementById("username");
    const uname_label = document.getElementById("usernameLabel");
    const save_btn = document.getElementById("save_btn");
    uname_input.addEventListener("input", (e) => {
      validate_username(uname_input, uname_label, save_btn);
    });


    // update profile info
    const notyf = new Notyf();

    const name_input = document.getElementById("name");
    const bio_input = document.getElementById("bio");
    const location_input = document.getElementById("location");
    const web_input = document.getElementById("web");
    save_btn.addEventListener("click", update_profile);
    
    async function update_profile() {
        let response = await fetch("php/update_profile.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            name: name_input.value,
            username: uname_input.value,
            bio: bio_input.value,
            location: location_input.value,
            web: web_input.value
          })
        });
        let data = await response.json();
        if(data.status == true){
          updateSession(uname_input.value);         
        }else{
          notyf.error('Something went wrong!');
        }
    }


    // update notification & visibility settings
    
    let notif_id_nums = 4;
    let arr = [];
    for (let i = 0; i < notif_id_nums; i++) {
      arr.push(`notif-${i}`);
    }

    let visibility_option = document.getElementById("default-visibility");
    visibility_option.addEventListener("change", update_notif_settings);

    async function update_notif_settings() {
      // preparing array
      let str = [];
      for(let i = 0; i < notif_id_nums; i++){
        if(document.getElementById(arr[i]).checked){
          str.push(`1`);
        }else{
          str.push(`0`);
        }

        if(i != notif_id_nums - 1)
          str.push(`$`);
      }
      // preparing string
      let settings = str.join("");

      // async call
      let response = await fetch("php/update_notification.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            string: settings,
            vis: visibility_option.value
          })
        });
        let data = await response.json();
        if(data.status != true){
          notyf.error('Something went wrong!');
        }
    }


  async function updateSession(username) {
    try {
      const response = await fetch("php/update_session.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ username })
      });

      const data = await response.json();
      if(data.status == true){
        notyf.success('Operation completed successfully!');
      }else{
        notyf.success('Operation completed successfully! But please login again!');
      }
    } catch (error) {
      console.error("Error updating session:", error);
    }
  }
  </script>
</body>

</html>