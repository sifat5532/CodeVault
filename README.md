<div align="center">

<h1>
  <br/>
  ⬡ CodeVault
  <br/>
</h1>

**Your code, vaulted and versioned.**

Upload, share, and manage your projects with ease.
Drop a README and a ZIP — CodeVault handles the rest.

<br/>

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-MariaDB-4479A1?style=flat-square&logo=mysql&logoColor=white)
![HTML CSS JS](https://img.shields.io/badge/Frontend-HTML%20%2F%20CSS%20%2F%20JS-E34F26?style=flat-square&logo=html5&logoColor=white)
![Status](https://img.shields.io/badge/Status-Public%20Beta-22c55e?style=flat-square)

<br/>

</div>

---

## ✦ What is CodeVault?

CodeVault is a full-stack developer platform — a lightweight, self-hostable alternative to GitHub — where you can upload ZIP-based code projects, version them, share them publicly or privately, and connect with other developers through follows, stars, and a personalized feed.

Built entirely with **PHP + MySQL**, no frameworks, no dependencies — just raw full-stack web development.

---

## ✦ Features

| | Feature | Description |
|---|---|---|
| 📦 | **Upload & Version** | Drop a ZIP file to create a new version — v1, v2, v3 and beyond |
| 🔒 | **Public / Private Repos** | Control visibility per repository |
| ⭐ | **Stars** | Star repos you like; view all your starred projects in one place |
| 👥 | **Follow System** | Follow developers and see their latest uploads in your feed |
| 📰 | **Activity Feed** | Personalized feed from followed users, starred repos, and contributions |
| 🔍 | **Search** | Search across users, repositories, and tags simultaneously |
| 🗂️ | **Version History** | Browse and download any previous version of any repository |
| 🏷️ | **Tags** | Tag repos for discoverability; browse all repos under a tag |
| 🤝 | **Contributors** | Add collaborators to repos; they get feed access and private repo visibility |
| 🔔 | **Notifications** | In-app notifications for follows, stars, and contributor activity |
| 🧭 | **Explore** | Discover top-starred repos, trending tags, and popular developers |
| 🙍 | **User Profiles** | Public profiles with bio, location, website, join date, and stats |
| ⚙️ | **Settings** | Update profile, notification preferences, default repo visibility, or delete account |

---

## ✦ Tech Stack

```
Frontend  →  HTML, CSS, Vanilla JavaScript
Backend   →  PHP 8.2 (no framework)
Database  →  MySQL / MariaDB 10.4
UI Toasts →  Notyf 3
Server    →  Apache (XAMPP / Laragon)
```

---

## ✦ Project Structure

```
CodeVault/
│
├── 📄 index.php                  # Landing page with live stats
├── 📄 feed.php                   # Personalized activity feed
├── 📄 explore.php                # Discover top repos, tags, developers
├── 📄 search.php                 # Search users, repos, and tags
│
├── 📄 new_repository.php         # Create a new repository
├── 📄 view_repo.php              # View a single repository
├── 📄 all_versions.php           # Full version history for a repo
├── 📄 new_version.php            # Upload a new version
├── 📄 repo_settings.php          # Edit/delete repo, manage contributors & versions
│
├── 📄 profile.php                # Your profile page
├── 📄 user_profile.php           # Public profile of any user
├── 📄 follow.php                 # Followers / Followings list
├── 📄 starred.php                # Your starred repositories
├── 📄 view_tag.php               # Browse repositories by tag
├── 📄 notification.php           # Notifications inbox
├── 📄 settings.php               # Account settings
├── 📄 login.php                  # Login
├── 📄 signup.php                 # Sign up
│
├── 🎨 style.css                  # Global stylesheet
├── ⚙️  script.js                  # Shared scripts
│
├── 📁 php/
│   ├── config.php                # Database connection
│   ├── user_info.php             # User class
│   ├── utility.php               # Helper functions
│   ├── logout.php                # Session destroy & redirect
│   ├── toggle_star.php           # Star / unstar a repo
│   ├── send_notification.php     # Create notifications
│   ├── get_notification_element.php
│   ├── update_notification.php
│   ├── mark_all_read.php
│   ├── mark_one_read.php
│   ├── get_users.php             # User search / autocomplete
│   ├── update_profile.php
│   ├── update_session.php
│   └── validate_username.php
│
└── 📁 db_schema/
    └── codevault.sql             # ✅ Full database schema (import this)
```

---

## ✦ Getting Started

### Prerequisites

- PHP 8.0+
- MySQL / MariaDB
- Apache server — [XAMPP](https://www.apachefriends.org/) or [Laragon](https://laragon.org/) recommended

---

### Installation

**1. Clone the repository**

```bash
git clone https://github.com/sifat5532/CodeVault.git
```

**2. Move it to your server's web root**

```
# XAMPP
C:/xampp/htdocs/CodeVault

# Laragon
C:/laragon/www/CodeVault
```

**3. Create and import the database**

- Open **phpMyAdmin** → create a new database named `codevault`
- Import the schema:

```
db_schema/codevault.sql
```

**4. Configure the database connection**

Open `php/config.php` and update your credentials if needed:

```php
$conn = mysqli_connect("localhost", "root", "", "codevault");
```

**5. Create the uploads folder**

```bash
mkdir repo_files
```

> Uploaded ZIP files are stored here. This folder is excluded from Git via `.gitignore`.

**6. Add the default profile picture**

Place a file named `default_dp.jpg` in the project root. This is used as the default avatar for new users.

**7. Start your server and open the app**

```
http://localhost/CodeVault/
```

---

## ✦ Database Schema

The full schema is in [`db_schema/codevault.sql`](db_schema/codevault.sql).

| Table | Description |
|---|---|
| `user` | Registered users with profile info and settings |
| `repo` | Repositories (title, description, visibility, demo link) |
| `version` | Versioned uploads per repo (ZIP file, version number, notes) |
| `contributor` | Many-to-many: users who contribute to repos |
| `stars` | Many-to-many: users who starred repos |
| `follower` | Follow relationships between users |
| `tag` | Tags attached to repos for discoverability |
| `notification` | In-app notifications (follow, star, contributor events) |

All foreign keys use `ON DELETE CASCADE` so deleting a user or repo cleans up all related data automatically.

---

## ✦ Notes

> ⚠️ **This is a learning project.** The codebase uses raw MySQLi queries without prepared statements and has no CSRF protection — it is **not intended for production use** as-is.

- `repo_files/` is gitignored — you must create it manually after cloning
- `default_dp.jpg` must be present in the root for default avatars to render
- Session-based authentication guards all protected pages with redirect fallbacks

---

## ✦ License

This project is open for learning and personal use. Feel free to fork, explore, and build on top of it.

---

<div align="center">
  <sub>Built with PHP, MySQL, and a lot of debugging · <a href="https://github.com/sifat5532/CodeVault">github.com/sifat5532/CodeVault</a></sub>
</div>
