<?php
require "php/config.php";
session_start();
if(isset($_SESSION["id"])){
  header("Location: feed.php");
  exit();
}
function getNumFromDB($con, $query){
  if($result = mysqli_query($con, $query)){
    return mysqli_fetch_assoc($result)["total"];
  }
  return 0;
}

$total_repo = getNumFromDB($conn, "SELECT COUNT(id) AS total FROM repo");
$total_dev = getNumFromDB($conn, "SELECT COUNT(id) AS total FROM user");
$total_version = getNumFromDB($conn, "SELECT COUNT(id) AS total FROM version");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CodeVault — Store. Share. Version.</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar">
    <a href="index.php" class="nav-logo">
      <div class="logo-icon">⬡</div>
      Code<span class="dim">Vault</span>
    </a>

    <div class="nav-links">
      <a href="#features">Features</a>
    </div>

    <div class="nav-right">
      <a href="login.php" class="btn btn-ghost btn-sm">Login</a>
      <a href="signup.php" class="btn btn-primary btn-sm">Get started</a>
    </div>
  </nav>

  <!-- ===== HERO ===== -->
  <main class="page-wrap">
    <section class="hero">
      <div class="hero-eyebrow">
        <span class="dot"></span>
        Now in public beta
      </div>

      <h1>Your code,<br /><span class="accent">vaulted</span> and versioned.</h1>

      <p class="hero-sub">
        Upload, share, and manage your projects with ease. Drop a README and a ZIP — CodeVault handles the rest.
      </p>

      <div class="hero-actions">
        <a href="signup.php" class="btn btn-primary">Create free account</a>
        <a href="#features" class="btn btn-ghost">See how it works</a>
      </div>

      <div class="hero-code-strip">
        <div class="line"><span class="ln">1</span><span class="kw">vault</span> <span class="fn">create</span> <span
            class="str">"my-project"</span></div>
        <div class="line"><span class="ln">2</span><span class="kw">vault</span> <span class="fn">upload</span> <span
            class="str">README.md</span> <span class="str">project.zip</span></div>
        <div class="line"><span class="ln">3</span><span class="fn"># → version v1 created ✓</span></div>
      </div>
    </section>

    <!-- ===== STATS ===== -->
    <div class="stats-bar" id="stats">
      <div class="stats-inner">
        <div class="stat-item">
          <div class="num"><?php echo $total_repo;?><span>+</span></div>
          <div class="label">Repositories</div>
        </div>
        <div class="stat-item">
          <div class="num"><?php echo $total_dev; ?><span>+</span></div>
          <div class="label">Developers</div>
        </div>
        <div class="stat-item">
          <div class="num"><?php echo $total_version ?><span>+</span></div>
          <div class="label">Versions uploaded</div>
        </div>
        <div class="stat-item">
          <div class="num">99<span>%</span></div>
          <div class="label">Uptime</div>
        </div>
      </div>
    </div>

    <!-- ===== FEATURES ===== -->
    <section class="section" id="features">
      <div class="section-label">Features</div>
      <h2 class="section-title">Everything you need, nothing you don't.</h2>
      <p class="section-sub">CodeVault is built for simplicity. No complex workflows — just clean code storage with the
        social layer developers love.</p>

      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">📦</div>
          <h3>Upload & Version</h3>
          <p>Drop a README and a ZIP file. Each upload creates a new version automatically — v1, v2, v3 and beyond.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">🔒</div>
          <h3>Public or Private</h3>
          <p>Control visibility at the repo level. Keep work-in-progress private, go public when you're ready to share.
          </p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">⭐</div>
          <h3>Stars & Discovery</h3>
          <p>Star repos you love, follow developers you admire. Your feed stays relevant with what matters to you.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">🔍</div>
          <h3>Powerful Search</h3>
          <p>Find any repo or developer instantly. Filter by language tag, visibility, or sort by stars and activity.
          </p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">👥</div>
          <h3>Follow Developers</h3>
          <p>Build your network. Follow people and get their latest uploads surfaced right in your feed.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">🗂️</div>
          <h3>Version History</h3>
          <p>Every upload is preserved. Browse and download any previous version of a repository at any time.</p>
        </div>
      </div>
    </section>

    <!-- ===== HOW IT WORKS ===== -->
    <section class="section" style="padding-top: 0;" id="How_it_works">
      <div class="section-label">How it works</div>
      <h2 class="section-title">Simple by design.</h2>
      <p class="section-sub">Get a project online in under a minute.</p>

      <div class="steps">
        <div class="step">
          <div class="step-left">
            <div class="step-num">01</div>
            <div class="step-line"></div>
          </div>
          <div class="step-body">
            <h3>Create a repository</h3>
            <p>Give it a name, write a short description, and choose public or private. Your vault is ready.</p>
          </div>
        </div>
        <div class="step">
          <div class="step-left">
            <div class="step-num">02</div>
            <div class="step-line"></div>
          </div>
          <div class="step-body">
            <h3>Upload your files</h3>
            <p>Upload a README.md and your code as a ZIP archive. CodeVault tags it as version 1 automatically.</p>
          </div>
        </div>
        <div class="step">
          <div class="step-left">
            <div class="step-num">03</div>
            <div class="step-line"></div>
          </div>
          <div class="step-body">
            <h3>Share or keep private</h3>
            <p>Share the link with anyone or keep it locked to just you. Public repos show up in search and feeds.</p>
          </div>
        </div>
        <div class="step">
          <div class="step-left">
            <div class="step-num">04</div>
            <div class="step-line"></div>
          </div>
          <div class="step-body">
            <h3>Keep uploading new versions</h3>
            <p>When your code evolves, just upload again. Each upload becomes a new version — all old ones stay safe.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="cta-section">
      <h2>Ready to vault your code?</h2>
      <p>Free forever for public repos. Private repos included in every account.</p>
      <a href="signup.php" class="btn btn-primary">Create your account →</a>
    </section>

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
  </main>

</body>

</html>