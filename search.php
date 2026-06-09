<?php 
session_start();
$search_for=$_GET["search"];
// $search_for='ishra19';
//developers
require "php/config.php";
require "php/utility.php";
$query="SELECT user.name,user.user_name,user.bio,
        (SELECT COUNT(*) FROM repo WHERE repo.creator=user.id)AS total_repo,
        (SELECT COUNT(*) FROM follower WHERE follower.who_is_being_followed=user.id)AS total_follower
        FROM user
        WHERE user.user_name='$search_for'
        UNION
        SELECT user.name, user.user_name,user.bio,
        (SELECT COUNT(*) FROM repo WHERE repo.creator=user.id),
        (SELECT COUNT(*) FROM follower WHERE follower.who_is_being_followed=user.id)
        FROM user
        WHERE user.name LIKE '%$search_for%' OR user.user_name LIKE '%$search_for%'";
 $dev=mysqli_query($conn,$query);
 $dev_count=mysqli_num_rows($dev);
 //repo
  $query="SELECT user.id, user.name,user.user_name,repo.id,repo.title,repo.description,
            (SELECT COUNT(*) FROM stars  WHERE stars.repo_id=repo.id)AS total_stars
            FROM repo
             JOIN user ON user.id=repo.creator
             WHERE repo.title LIKE '%$search_for%' OR repo.description LIKE '%$search_for%' OR user.user_name LIKE '%$search_for%' OR user.name LIKE '%$search_for%'
             GROUP BY repo.id
            ORDER BY repo.created_at DESC";
$repo=mysqli_query($conn,$query);
$repo_count=mysqli_num_rows($repo);


//tag
$query="SELECT tag.tag_name,COUNT(DISTINCT tag.repo_id)AS total_repo
        FROM tag WHERE tag.tag_name LIKE '%$search_for%'
        GROUP BY tag.tag_name";
$tag=mysqli_query($conn,$query);
$tag_count=mysqli_num_rows($tag);
$total=$dev_count+$repo_count+$tag_count;





?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Search Results — CodeVault</title>
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
      <input type="text" placeholder="Search repos, developers…" value="react dashboard" />
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

      <!-- ===== LEFT SIDEBAR (Filters) ===== -->
      <aside class="sidebar-left">
        <div class="section-label" style="margin-left: 16px; margin-bottom: 8px;">Filter by</div>
        <nav class="sidebar-nav">
          <a href="#" class="active all_results_btn" onclick="filterResult(0)"><span class="nav-icon">📁</span>
            All Results <span class="nav-badge"><?php     echo $total;   ?></span></a>
          <a href="#" class="repo_results_btn" onclick="filterResult(1)"><span class="nav-icon">📦</span> Repositories
            <span class="nav-badge"><?php     echo $repo_count;     ?></span></a>
          <a href="#" class="dev_results_btn" onclick="filterResult(2)"><span class="nav-icon">👥</span> Developers
            <span class="nav-badge"><?php echo $dev_count;  ?></span></a>
          <a href="#" class="tags_results_btn" onclick="filterResult(3)"><span class="nav-icon">🏷️</span> Tags <span
              class="nav-badge"><?php echo $tag_count; ?></span></a>

        </nav>
      </aside>

      <!-- ===== MAIN RESULTS ===== -->
      <main class="feed-main">
        <div class="feed-header">
          <div>
            <h2 style="font-size: 18px;">Results for <span class="text-accent"> <?php echo '  "'.$search_for.'"'; ?></span></h2>
            <p class="text-muted" style="font-size: 13px; margin-top: 4px;">Found <?php echo $total ?> results across the vault</p>
          </div>
          <nav class="mobile-search-filters">
            <a href="#" class="active all_results_btn" onclick="filterResult(0)"><span class="nav-icon">📁</span> All
              Results <span class="nav-badge"><?php     echo $total;   ?></span></a>
            <a href="#" class="repo_results_btn" onclick="filterResult(1)"><span class="nav-icon">📦</span> Repositories
              <span class="nav-badge"><?php     echo $repo_count;     ?></span></a>
            <a href="#" class="dev_results_btn" onclick="filterResult(2)"><span class="nav-icon">👥</span> Developers
              <span class="nav-badge"><?php echo $dev_count;  ?></span></a>
            <a href="#" class="tags_results_btn" onclick="filterResult(3)"><span class="nav-icon">🏷️</span> Tags <span
                class="nav-badge"><?php echo $tag_count; ?></span></a>
        </div>

        <div class="feed-list">
          <?php  
          while($data=mysqli_fetch_assoc($repo)){      ?>
          <!-- Repository Result -->
          <div class="repo_result_card feed-repo-card anim-fadeup" style="animation-delay:0.05s">
            <div class="frc-top">
              <div class="frc-meta">
                <div class="avatar"><?php    echo get_avatar($data["name"]);     ?></div>
                <div>
                  <a href="view_repo.php?repo_id=<?php echo $data['id'] ?>" class="repo-name"><?php echo $data["title"];       ?></a>
                  <div class="by">by <a href="user_profile.php?username=<?php   echo $data['user_name'];      ?>"><strong><?php echo  $data["user_name"]; ?></strong></a></div>
                </div>
              </div>

            </div>
            <p class="frc-desc"><?php  if(isset($data["description"])) echo $data["description"];        ?></p>
            <div class="frc-footer">
          
            
            </div>
          </div>
          <?php   }  ?>

          <!-- Developer Result -->

          <?php     
          while($data=mysqli_fetch_assoc($dev)){      ?>
    
          <div class="dev_result_card follower-list">
            <div class="follower-card anim-fadeup" style="animation-delay:0.1s">
              <div class="avatar lg"><?php echo get_avatar($data["name"]);    ?></div>
              <div class="follower-info">
                <a href="user_profile.php?username=<?php echo $data["user_name"];?>"><div class="follower-name"><?php   echo $data["name"];      ?></div></a>
                <div class="follower-handle">@<?php echo $data["user_name"];?></div>
                <p class="text-muted" style="font-size: 13px; margin-top: 4px;">
                      <?php    if(isset($data["bio"]))   echo $data["bio"];            ?></p>
                <div class="flex items-center gap-12 mt-4">
                  <span class="repo-meta">📦 <?php echo $data["total_repo"];?> repos</span>
                  <span class="repo-meta">👥 <?php echo $data["total_follower"];?> followers</span>
                </div>
              </div>
              <div class="flex gap-8">
               
              </div>
            </div>
          </div>
          <?php  }?>

         <?php  
         while($data=mysqli_fetch_assoc($tag) )
         { ?>

          <!-- Tag Result -->
          <div class="tag_result_card follower-card anim-fadeup" style="animation-delay:0.2s">
            <div class="tag-icon-box">🏷️</div>
            <div class="follower-info">
              <a href="view_tag.php?tag=<?php echo $data["tag_name"];   ?> " class="follower-name text-accent mono">#<?php echo $data["tag_name"]  ; ?></div></a>
              <div class="flex items-center gap-12 mt-8">
                <span class="repo-meta">📦 <?php echo $data["total_repo"];   ?> repos</span>
              </div>
            <div class="flex flex-col gap-8">

            </div>
          </div>
          <?php  }?>
          
          <!-- Empty State (Hidden by default, used when no results found) -->
          <?php if ($total == 0) { ?>
          <div class="notif-empty anim-fadein" style="display: block;">
          <?php } else { ?>
          <div class="notif-empty anim-fadein" style="display: none;">
          <?php } ?>
            <div class="notif-empty-icon">🔍</div>
            <h3>No results found</h3>
            <p>We couldn't find anything matching your search. Try different keywords.</p> 
            <div class="mt-16">
              <a href="feed.php" class="text-accent">Return to feed</a>
            </div>
          </div>

        </div>
      </main>

      <!-- ===== RIGHT SIDEBAR (Stats) ===== -->
      <aside class="sidebar-right">

        <div class="sidebar-widget">
          <div class="widget-header">Suggested Keywords</div>
          <div class="trending-tag"><span class="t-name">#react-ui</span></div>
          <div class="trending-tag"><span class="t-name">#dashboard-theme</span></div>
          <div class="trending-tag"><span class="t-name">#data-visualization</span></div>
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


    // Feed filter
    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', function () {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
      });
    });

    // show hide result by categories
    const all_results_btn = document.querySelectorAll(".all_results_btn");
    const repo_results_btn = document.querySelectorAll(".repo_results_btn");
    const dev_results_btn = document.querySelectorAll(".dev_results_btn");
    const tags_results_btn = document.querySelectorAll(".tags_results_btn");

    const repo_result_card = document.querySelectorAll(".repo_result_card");
    const dev_result_card = document.querySelectorAll(".dev_result_card");
    const tag_result_card = document.querySelectorAll(".tag_result_card");

    function remove_all_active() {
      all_results_btn.forEach(btn => btn.classList.remove("active"));
      repo_results_btn.forEach(btn => btn.classList.remove("active"));
      dev_results_btn.forEach(btn => btn.classList.remove("active"));
      tags_results_btn.forEach(btn => btn.classList.remove("active"));
    }

    function showCards(cards, display_type) {
      cards.forEach(card => card.style.display = display_type);
    }

    function hideCards(cards) {
      cards.forEach(card => card.style.display = "none");
    }

    function filterResult(btn_code) {
      remove_all_active();

      switch (btn_code) {
        case 0:
          all_results_btn.forEach(btn => btn.classList.add("active"));
          showCards(repo_result_card, "block");
          showCards(dev_result_card, "flex");
          showCards(tag_result_card, "flex");
          break;

        case 1:
          repo_results_btn.forEach(btn => btn.classList.add("active"));
          hideCards(dev_result_card);
          hideCards(tag_result_card);
          showCards(repo_result_card, "block");
          break;

        case 2:
          dev_results_btn.forEach(btn => btn.classList.add("active"));
          hideCards(repo_result_card);
          hideCards(tag_result_card);
          showCards(dev_result_card, "flex");
          break;

        case 3:
          tags_results_btn.forEach(btn => btn.classList.add("active"));
          hideCards(repo_result_card);
          hideCards(dev_result_card);
          showCards(tag_result_card, "flex");
          break;
      }
    }
  </script>
</body>

</html>