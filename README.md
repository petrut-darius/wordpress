# WordPress Development & Custom Theme / Plugins

A WordPress development environment featuring a custom university theme and custom Gutenberg plugins by [Petrut Darius](https://github.com/petrut-darius).

---

## Overview

This repository contains custom WordPress themes and plugins built using modern WordPress development standards, PHP, JavaScript (React / `@wordpress/scripts`), and Tailwind CSS.

### Theme: Fictional University
Located at [`wp-content/themes/fictional-university-theme/`](wp-content/themes/fictional-university-theme/)

* **Custom Post Types & Taxonomies:** Campuses, Events, Programs, and Professors.
* **REST API & Live Search:** Asynchronous instant search powered by the WordPress REST API and Axios.
* **User Notes & Like System:** Logged-in user private notes (CRUD) and dynamic "Like" counter for professors.
* **Modern UI:** Styled with Tailwind CSS and responsive custom navigation walkers.
* **Build System:** Bundled via `@wordpress/scripts`.

### Custom Plugins
Located at [`wp-content/plugins/`](wp-content/plugins/)

* **Are You Paying Attention Quiz (`thepdi-are-you-paying-attention`):** A custom Gutenberg block allowing editors to insert interactive multiple-choice quiz questions into pages/posts.
* **Word Filter (`thepdi-word-filter`):** Moderation plugin that automatically replaces specified blacklisted words in post content with custom characters/symbols.
* **Post Statistics (`thepdi-plugin`):** Adds customizable reading time, word count, and character count statistics to posts with admin settings and localization support.

---

## Tech Stack

* **Core:** WordPress, PHP 8.x, MySQL
* **Frontend / Build:** JavaScript (ES6+, React, JSX), `@wordpress/scripts`, Tailwind CSS, Glide.js, Axios
* **Plugins / Extensions:** Advanced Custom Fields (ACF), Windpress, Loco Translate

---

## Quick Start

### 1. Requirements
* PHP 8.0+
* MySQL / MariaDB
* Node.js (v18+) & npm
* Local web server (Apache / Nginx / LocalWP / Docker)

### 2. Theme Asset Build
To compile CSS and JavaScript for the theme:

```bash
cd wp-content/themes/fictional-university-theme
npm install
npm run start     # Watch mode for development
npm run build     # Production build
```

### 3. Block Plugin Build
To build the Gutenberg quiz block:

```bash
cd wp-content/plugins/thepdi-are-you-paying-attention
npm install
npm run start     # Watch mode for development
npm run build     # Production build
```
