<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Neeraj Dev (@neeraj_dev) — CodeVault</title>
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
                    <div class="avatar xl">NJ</div>
                    <div class="profile-name" style="font-size: 20px; margin-top: 12px;">Neeraj Dev</div>
                    <div class="profile-handle">@neeraj_dev</div>
                    <button class="follow-btn" style="margin-top: 16px;" onclick="toggleFollow(this)">Follow</button>
                    <p class="text-dim" style="font-size: 13.5px; margin: 12px 0;">Building open source UI kits since
                        2022. Passionate about clean code and design systems.</p>

                    <div class="profile-info-list"
                        style="text-align: left; margin-top: 16px; border-top: 1px solid var(--border); padding-top: 16px;">
                        <div class="repo-meta" style="margin-bottom: 8px;">📍 Berlin, Germany</div>
                        <div class="repo-meta" style="margin-bottom: 8px;">📅 Joined May 2022</div>
                        <div class="repo-meta" style="margin-bottom: 8px;">🔗 <a href="#"
                                class="text-accent">neeraj.dev</a></div>
                    </div>
                </div>

                <!-- Profile Stats -->
                <div class="sidebar-widget">
                    <div class="widget-header">Statistics</div>
                    <div class="profile-stats" style="flex-wrap: wrap; padding: 16px; border: none;">
                        <a href="followers.php" class="profile-stat" style="width: 33%; margin-bottom: 15px;">
                            <div class="n">1.2k</div>
                            <div class="l">Followers</div>
                        </a>
                        <a href="followings.php" class="profile-stat" style="width: 33%; margin-bottom: 15px;">
                            <div class="n">80</div>
                            <div class="l">Following</div>
                        </a>
                        <div class="profile-stat" style="width: 33%; margin-bottom: 15px;">
                            <div class="n">24</div>
                            <div class="l">Projects</div>
                        </div>
                        <div class="profile-stat" style="width: 33%;">
                            <div class="n">8.5k</div>
                            <div class="l">Stars</div>
                        </div>
                        <div class="profile-stat" style="width: 33%;">
                            <div class="n">15k</div>
                            <div class="l">Downloads</div>
                        </div>
                        <div class="profile-stat" style="width: 33%;">
                            <div class="n">50k</div>
                            <div class="l">Views</div>
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
                    <!-- Card 2 -->
                    <div class="feed-repo-card" style="margin-bottom: 20px;">
                        <div class="frc-top">
                            <a href="view_repo.php" class="repo-name">vault-cli-tool</a>
                            <div>
                                <button class="star-btn starred">★ <span>89</span></button>
                                <div class="version-chip">v1.2</div>
                            </div>
                        </div>
                        <p class="frc-desc">Command line interface for interacting with the CodeVault API directly from
                            your terminal.</p>
                        <div class="frc-footer">
                            <span class="tag">nodejs</span>
                            <span class="tag">cli</span>
                            <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Updated Yesterday
                            </div>
                        </div>
                        <div class="divider" style="margin: 15px 0;"></div>
                        <div class="flex gap-8">
                            <button class="btn btn-ghost btn-sm" style="flex: 1; justify-content: center;">View
                                Repositoy</button>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="feed-repo-card" style="margin-bottom: 20px;">
                    <div class="frc-top">
                        <a href="view_repo.php" class="repo-name">vault-cli-tool</a>
                        <div>
                            <button class="star-btn starred">★ <span>89</span></button>
                            <div class="version-chip">v1.2</div>
                        </div>
                    </div>
                    <p class="frc-desc">Command line interface for interacting with the CodeVault API directly from your
                        terminal.</p>
                    <div class="frc-footer">
                        <span class="tag">nodejs</span>
                        <span class="tag">cli</span>
                        <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Updated Yesterday
                        </div>
                    </div>
                    <div class="divider" style="margin: 15px 0;"></div>
                    <div class="flex gap-8">
                        <button class="btn btn-ghost btn-sm" style="flex: 1; justify-content: center;">View
                            Repositoy</button>
                    </div>
                </div>
        </div>

        <!-- Contributing Projects Grid (Hidden by default) -->
        <div id="grid-contributing" class="features-grid anim-fadeup"
            style="display: none; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));">
            <!-- Card 2 -->
            <div class="feed-repo-card" style="margin-bottom: 20px;">
                <div class="frc-top">
                    <a href="view_repo.php" class="repo-name">vault-cli-tool</a>
                    <div>
                        <button class="star-btn starred">★ <span>89</span></button>
                        <div class="version-chip">v1.2</div>
                    </div>
                </div>
                <p class="frc-desc">Command line interface for interacting with the CodeVault API directly from your
                    terminal.</p>
                <div class="frc-footer">
                    <span class="tag">nodejs</span>
                    <span class="tag">cli</span>
                    <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Updated Yesterday</div>
                </div>
                <div class="divider" style="margin: 15px 0;"></div>
                <div class="flex gap-8">
                    <button class="btn btn-ghost btn-sm" style="flex: 1; justify-content: center;">View
                        Repositoy</button>
                </div>
            </div>
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
        document.addEventListener('click', function (e) {
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