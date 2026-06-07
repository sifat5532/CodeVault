<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>#react — Technology Tag — CodeVault</title>
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
                    <div class="profile-name" style="font-size: 24px; margin-top: 12px;">#react</div>
                    <div class="profile-handle">Technology Tag</div>
                    <p class="text-dim" style="font-size: 13.5px; margin: 12px 0;">A JavaScript library for building user interfaces. Maintained by Meta and a community of individual developers and companies.</p>

                    <div class="profile-info-list"
                        style="text-align: left; margin-top: 16px; border-top: 1px solid var(--border); padding-top: 16px;">
                        <div class="repo-meta" style="margin-bottom: 8px;">📁 980 Repositories</div>
                        <div class="repo-meta" style="margin-bottom: 8px;">👥 450 Developers</div>
                        <div class="repo-meta" style="margin-bottom: 8px;">📅 Popularized in 2013</div>
                    </div>
                </div>

                <!-- Tag Statistics Widget (Style from user_profile.php) -->
                <div class="sidebar-widget">
                    <div class="widget-header">Global Impact</div>
                    <div class="profile-stats" style="flex-wrap: wrap; padding: 16px; border: none;">
                        <div class="profile-stat" style="width: 33%; margin-bottom: 15px;">
                            <div class="n">980</div>
                            <div class="l">Repos</div>
                        </div>
                        <div class="profile-stat" style="width: 33%; margin-bottom: 15px;">
                            <div class="n">150k</div>
                            <div class="l">Stars</div>
                        </div>
                        <div class="profile-stat" style="width: 33%; margin-bottom: 15px;">
                            <div class="n">450</div>
                            <div class="l">Devs</div>
                        </div>
                        <div class="profile-stat" style="width: 33%;">
                            <div class="n">2.4M</div>
                            <div class="l">Downloads</div>
                        </div>
                        <div class="profile-stat" style="width: 33%;">
                            <div class="n">12M</div>
                            <div class="l">Views</div>
                        </div>
                        <div class="profile-stat" style="width: 33%;">
                            <div class="n">98%</div>
                            <div class="l">Growth</div>
                        </div>
                    </div>
                </div>

            
            </aside>

            <!-- ===== MAIN CONTENT ===== -->
            <main class="feed-main">
                <div class="feed-header">
                    <div>
                        <h2 style="font-size: 20px;">Repositories tagged with <span class="text-accent">#react</span></h2>
                        <p class="text-muted" style="font-size: 14px; margin-top: 4px;">Showing 980 total repositories using this technology</p>
                    </div>
                </div>

                <div class="feed-list">
                    <!-- Tagged Repo 1 -->
                    <div class="feed-repo-card anim-fadeup" style="animation-delay:0.05s">
                        <div class="frc-top">
                            <div class="frc-meta">
                                <div class="avatar">NJ</div>
                                <div>
                                    <a href="view_repo.php"><div class="repo-name">react-dashboard-kit</div></a>
                                    <div class="by">by <a href="user_profile.php"><strong>neeraj_dev</strong></a></div>
                                </div>
                            </div>
                            <button class="star-btn" onclick="toggleStar(this)">☆ <span>142</span></button>
                        </div>
                        <p class="frc-desc">A lightweight, zero-dependency React dashboard component library. Now with dark mode support and improved chart rendering performance in v4.</p>
                        <div class="frc-footer">
                            <div class="version-chip">✦ v4</div>
                            <span class="tag">react</span>
                            <span class="tag">typescript</span>
                            <div class="repo-meta" style="margin-left:auto; color: var(--text-muted);">Updated 2h ago</div>
                            <a href="view_repo.php" class="btn btn-ghost btn-sm" style="margin-left: 12px;">View Repository</a>
                        </div>
                    </div>
                </div>
            </main>

            <!-- ===== RIGHT SIDEBAR ===== -->
            <aside class="sidebar-right">
                <!-- Related Tags -->
                <div class="sidebar-widget">
                    <div class="widget-header">Related Tags</div>
                    <a href="#" class="trending-tag"><span class="t-name">#javascript</span><span class="t-count">1.2k repos</span></a>
                    <a href="#" class="trending-tag"><span class="t-name">#typescript</span><span class="t-count">843 repos</span></a>
                    <a href="#" class="trending-tag"><span class="t-name">#frontend</span><span class="t-count">2.1k repos</span></a>
                    <a href="#" class="trending-tag"><span class="t-name">#nextjs</span><span class="t-count">412 repos</span></a>
                </div>

                <!-- Popular Contributors Widget -->
                <div class="sidebar-widget">
                    <div class="widget-header">Top Contributors</div>
                    <div class="suggest-user">
                        <div class="avatar">MZ</div>
                        <div class="info">
                            <a href="user_profile.php"><div class="name">man_zhang</div></a>
                            <div class="handle">@man_zhang</div>
                        </div>
                        <button class="follow-btn" onclick="">Follow</button>
                    </div>
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
        document.addEventListener('click', function (e) {
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