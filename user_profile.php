<?php
session_start();
$user_id = $_SESSION["id"];
$profile_name = "fhm";
$user_name = $_SESSION["username"];

require "php/config.php";
require "php/utility.php";
if ($profile_name === $user_name) {
    header("Location: profile.php");
    exit();
} else {


    $query = "SELECT  user.* ,
            (SELECT COUNT(*)  FROM follower WHERE follower.who_is_being_followed=user.id)AS followers,
           
          
          (SELECT COUNT(*)  FROM follower WHERE follower.who_is_following=user.id)AS following,
          
          (SELECT COUNT(*)  FROM repo WHERE repo.creator=user.id)AS created_repo,
          
          (SELECT COUNT(*)  FROM contributor WHERE contributor.user_id=user.id)AS contributed_repo,
          
          (SELECT COUNT(*) FROM stars WHERE stars.repo_id  IN (
          SELECT repo.id FROM repo WHERE repo.creator=user.id))AS starred_repo 
           FROM user WHERE user.user_name='$profile_name' 
           LIMIT 1  ";
    $result = mysqli_query($conn, $query);
    if (!$result || mysqli_num_rows($result) == 0) {
        header("Location: feed.php");
        exit();
    }

    $data = mysqli_fetch_assoc($result);
    $profile_id = $data["id"];
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $data["user_name"]; ?>— CodeVault</title>
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

            <!-- ===== PROFILE SIDEBAR ===== -->
            <aside class="sidebar-left">
                <div class="sidebar-profile">
                    <div class="avatar xl"><?php echo get_avatar($data["name"]); ?></div>
                    <div class="profile-name" style="font-size: 20px; margin-top: 12px;"><?php echo $data["name"]; ?> </div>
                    <div class="profile-handle">@<?php echo $data["user_name"];      ?></div>
                    <button class="follow-btn" style="margin-top: 16px;" onclick="toggleFollow(this)">Follow</button>
                    <p class="text-dim" style="font-size: 13.5px; margin: 12px 0;"><?php
                                                                                    if (isset($data["bio"])) echo $data["bio"]; ?>
                    </p>

                    <div class="profile-info-list"
                        style="text-align: left; margin-top: 16px; border-top: 1px solid var(--border); padding-top: 16px;">
                        <div class="repo-meta" style="margin-bottom: 8px;">📍<?php if (isset($data["location"])) echo $data["location"]; ?></div>
                        <div class="repo-meta" style="margin-bottom: 8px;">📅 Joined <?php echo date("F j,y", strtotime($data["created_at"]));   ?> </div>
                        <div class="repo-meta" style="margin-bottom: 8px;"><?php if (isset($data["web"]) && $data["web"] != "") { ?>🔗 <a href=<?php echo $data["web"]; ?> target="_blank" class="text-accent"><?php echo $data["web"]; ?></a><?php } ?></div>
                    </div>
                </div>

                <!-- Profile Stats -->
                <div class="sidebar-widget">
                    <div class="widget-header">Statistics</div>
                    <div class="profile-stats" style="flex-wrap: wrap; padding: 16px; border: none;">
                        <a href="followers.php" class="profile-stat" style="width: 33%; margin-bottom: 15px;">
                            <div class="n"><?php echo $data["followers"]; ?></div>
                            <div class="l">Followers</div>
                        </a>
                        <a href="following.php" class="profile-stat" style="width: 33%; margin-bottom: 15px;">
                            <div class="n"><?php echo $data["following"]; ?></div>
                            <div class="l">Following</div>
                        </a>
                        <div class="profile-stat" style="width: 33%; margin-bottom: 15px;">
                            <div class="n"><?php echo $data["created_repo"] + $data["contributed_repo"]; ?></div>
                            <div class="l">Projects</div>
                        </div>
                        <div class="profile-stat" style="width: 33%;">
                            <div class="n"><?php echo $data["starred_repo"]; ?></div>
                            <div class="l">Stars</div>
                        </div>

                    </div>
                </div>
            </aside>

            <!-- ===== MAIN CONTENT ===== -->
            <main class="feed-main">
                <div class="feed-header">
                    <div class="feed-filters">
                        <button class="filter-btn active" id="btn-created" onclick="toggleProjects('created')">Created
                            Repositories</button>
                        <button class="filter-btn" id="btn-contributing"
                            onclick="toggleProjects('contributing')">Contributing Repositories</button>
                    </div>
                </div>

                <!-- Created Projects Grid -->
                <div id="grid-created" class="features-grid anim-fadeup"
                    style="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));">

                    <?php
                    $query = "SELECT  repo.*,version.version_number ,version.created_at  AS version_created_at,
                               GROUP_CONCAT(tag.tag_name  SEPARATOR ',') AS tag_name,
                               (SELECT COUNT(*) FROM stars WHERE stars.repo_id=repo.id)AS stars
                FROM repo 
                JOIN version ON version.id=(
                SELECT MAX(version.id) FROM version WHERE version.repo_id=repo.id)
                LEFT JOIN tag ON tag.repo_id=repo.id
                
                WHERE repo.creator='$profile_id'
                AND repo.visibility='public'
                GROUP BY repo.id
                ORDER BY version.created_at DESC";

                    $result = mysqli_query($conn, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($data = mysqli_fetch_assoc($result)) {


                    ?>
                            <!-- Card 2 -->
                            <div class="feed-repo-card" style="margin-bottom: 20px;">
                                <div class="frc-top">
                                    <p class="repo-name"><?php echo $data["title"]; ?></p>
                                    <div>
                                        <button class="star-btn starred">★ <span><?php echo $data["stars"]; ?></span></button>
                                        <div class="version-chip">v<?php echo $data["version_number"]; ?> </div>
                                    </div>
                                </div>
                                <p class="frc-desc"><?php if (isset($data["description"])) echo $data["description"];     ?></p>
                                <div class="frc-footer">
                                    <?php $tags = explode(",", $data['tag_name']);

                                    foreach ($tags as $tag) { ?> <span class="tag"> <?php if (isset($tag)) echo $tag; ?> </span><?php } ?>
                                    <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Updated <?php echo timeAgo($data["version_created_at"]); ?>
                                    </div>
                                </div>
                                <div class="divider" style="margin: 15px 0;"></div>
                                <div class="flex gap-8">
                                    <button class="btn btn-ghost btn-sm" onclick="location.href='view_repo.php?repo_id=<?php echo $data['id']; ?>'" style="flex: 1; justify-content: center;">View Repositoy</button>
                                </div>
                            </div>





                        <?php }
                    } else { ?>
                        <div class="feed-repo-card" style="margin-bottom: 20px;">
                            <div class="frc-top">
                                <p class="frc-desc">No repositories found.</p>

                            </div>

                        </div>
                    <?php }
                    ?>
                </div>

                <!-- Contributing Projects Grid (Hidden by default) -->
                <div id="grid-contributing" class="features-grid anim-fadeup"
                    style="display: none; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));">
                    <!-- Card 2 -->
                    <?php
                    $query = "SELECT   repo.*,version.version_number ,version.created_at  AS version_created_at,
               GROUP_CONCAT(tag.tag_name  SEPARATOR ',') AS tag_name,
                (SELECT COUNT(*)  FROM stars WHERE stars.repo_id=repo.id)AS stars
                FROM contributor
                JOIN repo ON repo.id=contributor.repo_id
                JOIN version ON version.id=(
                SELECT MAX(version.id) FROM version WHERE version.repo_id=repo.id)
                LEFT JOIN tag ON tag.repo_id=repo.id
                WHERE contributor.user_id='$profile_id'
                AND repo.visibility='public'
                GROUP BY repo.id
                ORDER BY version.created_at DESC";

                    $result = mysqli_query($conn, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($data = mysqli_fetch_assoc($result)) {



                    ?>
                            <div class="feed-repo-card" style="margin-bottom: 20px;">
                                <div class="frc-top">
                                    <a href="view_repo.php" class="repo-name"><?php echo $data["title"]; ?></a>
                                    <div>
                                        <button class="star-btn starred">★ <span><?php echo $data["stars"]; ?></span></button>
                                        <div class="version-chip">v<?php echo $data["version_number"]; ?></div>
                                    </div>
                                </div>
                                <p class="frc-desc"><?php if (isset($data["description"])) echo $data["description"];    ?></p>
                                <div class="frc-footer">
                                    <?php $tags = explode(",", $data['tag_name']);

                                    foreach ($tags as $tag) { ?> <span class="tag"> <?php if (isset($tag)) echo $tag; ?> </span><?php } ?>
                                    <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Updated Yesterday</div>
                                </div>
                                <div class="divider" style="margin: 15px 0;"></div>
                                <div class="flex gap-8">
                                    <button class="btn btn-ghost btn-sm" onclick="location.href='view_repo.php?repo_id=<?php echo $data['id']; ?>'" style="flex: 1; justify-content: center;">View Repositoy</button>
                                </div>
                            </div>

                        <?php }
                    } else { ?>
                        <div class="feed-repo-card" style="margin-bottom: 20px;">
                            <div class="frc-top">
                                <p class="frc-desc">No repositories found.</p>

                            </div>

                        </div>
                    <?php }
                    ?>
                </div>
        </div>
        </main>
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

    <script>
        // Dropdown toggle
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('open');
        }
        document.addEventListener('click', function(e) {
            const menu = document.querySelector('.user-menu');
            if (!menu.contains(e.target)) {
                document.getElementById('userDropdown').classList.remove('open');
            }
        });

        // Star toggle
        function toggleStar(btn) {
            const starred = btn.classList.contains('starred');
            const countEl = btn.querySelector('span');
            let count = parseInt(countEl.textContent);
            if (starred) {
                btn.classList.remove('starred');
                btn.innerHTML = '☆ <span>' + (count - 1) + '</span>';
            } else {
                btn.classList.add('starred');
                btn.innerHTML = '★ <span>' + (count + 1) + '</span>';
            }
        }

        // Follow toggle
        function toggleFollow(btn) {
            if (btn.classList.contains('following')) {
                btn.classList.remove('following');
                btn.textContent = 'Follow';
            } else {
                btn.classList.add('following');
                btn.textContent = 'Following';
            }
        }

        // Project toggle logic
        function toggleProjects(type) {
            document.getElementById('btn-created').classList.toggle('active', type === 'created');
            document.getElementById('btn-contributing').classList.toggle('active', type === 'contributing');
            document.getElementById('grid-created').style.display = type === 'created' ? 'grid' : 'none';
            document.getElementById('grid-contributing').style.display = type === 'contributing' ? 'grid' : 'none';
        }
    </script>
</body>

</html>