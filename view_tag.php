<?php
session_start();
$tag_name = $_GET["tag"];
// $tag_name="css";
require "php/config.php";
require "php/utility.php";
$query = "SELECT COUNT(DISTINCT tag.repo_id) AS repo_count,
  (SELECT COUNT(DISTINCT user.id)
  FROM user WHERE user.id IN (
  SELECT repo.creator from repo 
  JOIN tag ON tag.repo_id=repo.id
  WHERE tag.tag_name='$tag_name'
  UNION
  SELECT contributor.user_id from contributor
  JOIN tag ON tag.repo_id=contributor.repo_id
  WHERE tag.tag_name='$tag_name'
    )
    )AS dev_count,
 MIN(repo.created_at) AS created_at FROM tag
 JOIN repo ON repo.id=tag.repo_id
 WHERE tag.tag_name='$tag_name' ";
$result = mysqli_query($conn, $query);

$data = mysqli_fetch_assoc($result);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $tag_name; ?> — CodeVault</title>
    <link rel="stylesheet" href="style.css" />
</head>

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
        <div class="feed-layout">

            <!-- ===== TAG PROFILE SIDEBAR ===== -->
            <aside class="sidebar-left">
                <div class="sidebar-profile">
                    <div class="tag-icon-box" style="margin: 0 auto 12px; width: 72px; height: 72px; font-size: 32px;">🏷️</div>
                    <div class="profile-name" style="font-size: 24px; margin-top: 12px;">#<?php echo $tag_name; ?></div>



                    <div class="profile-info-list"
                        style="text-align: left; margin-top: 16px; border-top: 1px solid var(--border); padding-top: 16px;">
                        <div class="repo-meta" style="margin-bottom: 8px;">📁 <?php echo $data["repo_count"]; ?> Repositories</div>
                        <div class="repo-meta" style="margin-bottom: 8px;">👥 <?php echo $data["dev_count"]; ?> Developers</div>
                        <div class="repo-meta" style="margin-bottom: 8px;"><?php if (isset($data['created_at'])) {  ?>📅 Created in <?php echo date("Y", strtotime($data['created_at']));
                                                                                                                                } ?></div>
                    </div>
                </div>


            </aside>

            <!-- ===== MAIN CONTENT ===== -->
            <main class="feed-main">
                <div class="feed-header">
                    <div>
                        <h2 style="font-size: 20px;">Repositories tagged with <span class="text-accent">#<?php echo $tag_name;   ?></span></h2>
                        <?php if ($data["repo_count"] > 0) { ?> <p class="text-muted" style="font-size: 14px; margin-top: 4px;">Showing <?php echo $data["repo_count"];  ?> total repositories using this tag</p><?php } else { ?> <p class="text-muted" style="font-size: 14px; margin-top: 4px;">No repositorie found using this tag</p><?php } ?>
                    </div>
                </div>

                <div class="feed-list">

                    <?php
                    $query = "SELECT  repo.*,user.user_name
                            FROM tag
                            JOIN repo ON repo.id=tag.repo_id
                            JOIN user ON user.id=repo.creator
                            WHERE tag.tag_name='$tag_name' AND repo.visibility='public'
                            ORDER BY repo.created_at DESC";
                    $result = mysqli_query($conn, $query);
                    while ($data = mysqli_fetch_assoc($result)) {
                       

                    ?>
                        <!-- Tagged Repo 1 -->
                        <div class="feed-repo-card anim-fadeup" style="animation-delay:0.05s">
                            <div class="frc-top">
                                <div class="frc-meta">
                                    <div class="avatar"><?php echo get_avatar($data["user_name"]); ?></div>
                                    <div>
                                        <a href="view_repo.php?repo_id=<?php echo $data["id"]; ?>">
                                            <div class="repo-name"><?php echo $data['title']; ?></div>
                                        </a>
                                        <div class="by">by <strong><?php echo $data["user_name"];    ?></strong></a></div>
                                    </div>
                                </div>

                            </div>
                            <p class="frc-desc"><?php if (isset($data["description"])) echo $data["description"];    ?></p>
                            <div class="frc-footer">

                                <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Updated <?php echo timeAgo($data["created_at"]);     ?> ago</div>

                            </div>
                        </div>
                    <?php } 
                         if ($data['repo_count'] == 0) {
                            header("Location: feed.php");
                            exit();
                        }{
                            header("Location: feed.php");
                            exit();
                        }?>
            </main>

            <!-- ===== RIGHT SIDEBAR ===== -->
            <aside class="sidebar-right">
                <!-- Related Tags -->
                <div class="sidebar-widget">
                    <div class="widget-header">Related Tags</div>
                    <?php
                    //  $query="SELECT tag.tag_name,repo.id,COUNT(tag.repo_id) AS repo_count
                    //  FROM tag
                    //  JOIN repo ON repo.id IN tag.repo_id
                    //  JOIN tag ON   tag.repo_id=repo.id
                    //  WHERE tag.tag_name='$tag_name'";
                    //  $result=
                    //<a href="#" class="trending-tag"><span class="t-name">#javascript</span><span class="t-count">1.2k repos</span></a>
                    ?>

                </div>


            </aside>
        </div>
    </div>

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

    <!-- ===== SCRIPTS (Strictly from feed.php) ===== -->
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

        // Star toggle
        function toggleStar(btn) {
            btn.classList.toggle('starred');
        }
    </script>
</body>

</html>