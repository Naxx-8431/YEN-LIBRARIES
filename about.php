<?php
require_once 'db.php';
require_once 'includes/library_helpers.php';

// Fetch all active libraries (single query)
$about_libraries = getActiveLibraries($conn);

// Pre-fetch ALL gallery images in one query, grouped by library_id
$all_gallery = getAllGalleryImages($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us | Yenepoya Libraries</title>
  <meta name="description"
    content="Learn about Yenepoya Libraries — 6 constituent libraries, vision, library rules, committee, team, hours and collections.">
  <link rel="icon" href="assets/images/favicon.jpg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>

  <!-- TOP BAR -->
  <div class="topbar">
    <div class="topbar__left">
      <div class="topbar__contact">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="2" y="4" width="20" height="16" rx="2" />
          <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
        </svg>
        <a href="mailto:library@yenepoya.edu.in">library@yenepoya.edu.in</a>
      </div>
      <div class="topbar__divider"></div>
      <div class="topbar__contact">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path
            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.15 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.06 1.2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16z" />
        </svg>
        <a href="tel:08242206067">0824-2206067</a>
      </div>
    </div>
    <div class="topbar__right">
      <a href="https://opac.yenepoya.edu.in/cgi-bin/koha/opac-user.html" target="_blank">My Account</a>
      <div class="topbar__divider"></div>
      <a href="services.php#membership">Get Library Card</a>
    </div>
  </div>

  <!-- HEADER -->
  <header class="header">
    <a href="index.php" class="header__logo" aria-label="Yenepoya Libraries Home">
      <img src="https://library.yenepoya.edu.in/images/Central-Library-logo.png" alt="Yenepoya Central Library">
      <img src="https://library.yenepoya.edu.in/images/naac.png" alt="NAAC" class="header__logo-naac">
    </a>
    <nav class="header__nav" aria-label="Primary Navigation">
      <a href="index.php" class="nav__link">Home</a>
      <a href="about.php" class="nav__link active">About</a>
      <a href="services.php" class="nav__link">Services</a>
      <a href="e-resources.php" class="nav__link">E-Resources</a>
      <a href="repository.php" class="nav__link">Repository</a>
      <a href="research.php" class="nav__link">Research</a>
      <a href="events.php" class="nav__link">Events</a>
      <a href="contact.php" class="nav__link">Contact</a>
    </nav>
          <div class="header__search">
        <div class="header__search-container" id="headerSearchContainer" onclick="window.location.href='index.html#opac'" style="cursor: pointer;">
          <button class="header__search-btn" id="headerSearchBtn" aria-label="Search" onclick="window.location.href='index.html#opac'" style="cursor: pointer; z-index: 10;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
              <circle cx="11" cy="11" r="8" />
              <path d="m21 21-4.35-4.35" />
            </svg>
          </button>
          <input type="text" class="header__search-input" id="headerSearchInput" placeholder="Search for books..." readonly onclick="window.location.href='index.html#opac'" style="cursor: pointer; z-index: 10;">
        </div>
      </div>
    <button class="header__burger" id="burger"
      aria-label="Toggle navigation"><span></span><span></span><span></span></button>
  </header>

  <nav class="mobile-nav" id="mobileNav">
    <a href="index.php" class="nav__link">Home</a>
    <a href="about.php" class="nav__link active">About</a>
    <a href="services.php" class="nav__link">Services</a>
    <a href="e-resources.php" class="nav__link">E-Resources</a>
    <a href="repository.php" class="nav__link">Repository</a>
    <a href="research.php" class="nav__link">Research</a>
    <a href="events.php" class="nav__link">Events</a>
    <a href="contact.php" class="nav__link">Contact</a>
  </nav>

  <!-- PAGE HERO -->
  <div class="page-hero" style="background-image: linear-gradient(rgba(16, 28, 56, 0.75), rgba(16, 28, 56, 0.75)), url('images/hero-bg1.png'); background-size: cover; background-position: center;"images/banners/YENEPOYA LIBRARIES-1.webp'); background-size: cover; background-position: center;">
    <div class="page-hero__inner">
      <div class="page-hero__breadcrumb">
        <a href="index.php">Home</a>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="m9 18 6-6-6-6" />
        </svg>
        <span>About Us</span>
      </div>
      <h1 class="page-hero__title">About Yenepoya Libraries</h1>
      <p class="page-hero__subtitle">Six constituent libraries serving Yenepoya (Deemed to be University) since 1992 —
        discover our team, collections, rules and more.</p>
    </div>
  </div>

  <!-- INNER LAYOUT -->
  <div class="inner-layout">

    <!-- SIDEBAR -->
    <aside class="page-sidebar" aria-label="About section navigation">
      <div class="page-sidebar__title">Libraries</div>
      <nav class="page-sidebar__nav">
        <?php foreach ($about_libraries as $lib): ?>
        <a href="#<?php echo htmlspecialchars($lib['slug']); ?>" class="page-sidebar__link">
          <?php echo getLibraryIconSvg($lib['icon_name']); ?>
          <?php echo htmlspecialchars($lib['library_name']); ?>
        </a>
        <?php endforeach; ?>

        <div class="page-sidebar__divider"></div>
        <div class="page-sidebar__title">Information</div>
        <a href="#vision-mission" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8v4l3 3" />
          </svg>
          Vision &amp; Mission
        </a>
        <a href="#library-rules" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
            <polyline points="14 2 14 8 20 8" />
          </svg>
          Library Rules
        </a>
        <a href="#library-committee" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
            <circle cx="9" cy="7" r="4" />
            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
          </svg>
          Library Committee
        </a>
        <a href="#library-hours" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10" />
            <polyline points="12 6 12 12 16 14" />
          </svg>
          Library Hours
        </a>
        <a href="#library-team" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
            <circle cx="12" cy="7" r="4" />
          </svg>
          Library Team
        </a>
        <a href="#library-collection" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
          </svg>
          Library Collections
        </a>

        <div class="page-sidebar__divider"></div>
        <div class="page-sidebar__title">Facilities</div>
        <a href="#floor-plan" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="18" height="18" rx="2" />
            <path d="M3 9h18M3 15h18M9 3v18" />
          </svg>
          Floor Plans
        </a>
        <a href="#library-policy" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
          </svg>
          Library Policy
        </a>
      </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="page-content" id="main">

      <!-- ══ DYNAMIC LIBRARY SECTIONS ══ -->
      <?php foreach ($about_libraries as $lib): ?>
      <section class="page-section" id="<?php echo htmlspecialchars($lib['slug']); ?>">
        <div class="page-section__header">
          <div class="page-section__label"><?php echo htmlspecialchars($lib['section_label']); ?></div>
          <h2 class="page-section__title"><?php echo htmlspecialchars($lib['library_name']); ?></h2>
          <div class="page-section__divider"></div>
        </div>

        <?php
        // Full description may contain HTML (e.g. <strong> tags), so we don't escape it
        // It's admin-entered content stored in the database
        echo '<p>' . str_replace("\n\n", '</p><p>', $lib['full_description']) . '</p>';
        ?>

        <?php
        // Info boxes (only renders fields that have data)
        echo renderInfoBoxes($lib);
        ?>

        <?php
        // Working hours table (from structured JSON)
        echo renderWorkingHoursTable($lib['working_hours']);
        ?>

        <?php
        // Photo gallery (using pre-fetched data — no query in loop)
        $lib_gallery = isset($all_gallery[$lib['id']]) ? $all_gallery[$lib['id']] : [];
        if (!empty($lib_gallery)):
        ?>
        <div class="photo-gallery">
          <div class="photo-gallery__label">Library Facilities — Scroll to View More</div>
          <div class="photo-gallery__track">
            <?php foreach ($lib_gallery as $img): ?>
            <div class="photo-gallery__item">
              <img src="<?php echo htmlspecialchars($img['image_path']); ?>" alt="<?php echo htmlspecialchars($img['caption']); ?>">
              <div class="photo-gallery__caption"><?php echo htmlspecialchars($img['caption']); ?></div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($lib['contact_info'])): ?>
        <div class="callout" style="margin-top:20px;">
          <?php echo $lib['contact_info']; ?>
        </div>
        <?php endif; ?>
      </section>
      <?php endforeach; ?>

      <!-- ══ VISION & MISSION ══ -->
      <section class="page-section" id="vision-mission">
        <div class="page-section__header">
          <div class="page-section__label">Our Purpose</div>
          <h2 class="page-section__title">Vision &amp; Mission</h2>
          <div class="page-section__divider"></div>
        </div>
        <div class="purpose-grid">
          <!-- Vision -->
          <div class="purpose-card purpose-card--vision">
            <span class="purpose-tag">Vision</span>
            <p class="purpose-main">To be a premier academic library that empowers the university community through innovative information services, seamless access to resources, and a culture of lifelong learning and research excellence.</p>
            <ul class="purpose-list">
              <li>
                <svg class="purpose-bullet" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
                <span>Establish global reach through connected digital knowledge systems.</span>
              </li>
              <li>
                <svg class="purpose-bullet" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path d="M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5" />
                </svg>
                <span>Shape innovative, collaborative learning spaces for students and faculty.</span>
              </li>
              <li>
                <svg class="purpose-bullet" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="12" r="3" />
                  <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2v.09a1.65 1.65 0 0 0 1.51-1h-.09a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33 1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51h-.09a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82 1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2v-.09a1.65 1.65 0 0 0-1.51 1H19.4z" />
                </svg>
                <span>Drive advanced scholarship support via emerging analytics tools.</span>
              </li>
            </ul>
          </div>

          <!-- Mission -->
          <div class="purpose-card purpose-card--mission">
            <span class="purpose-tag">Mission</span>
            <ul class="purpose-list">
              <li>
                <svg class="purpose-bullet" fill="none" viewBox="0 0 24 24" stroke="var(--clr-primary)" stroke-width="2">
                  <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
                <span>Provide equitable access to quality information resources in print and digital formats.</span>
              </li>
              <li>
                <svg class="purpose-bullet" fill="none" viewBox="0 0 24 24" stroke="var(--clr-primary)" stroke-width="2">
                  <path d="M12 14l9-5-9-5-9 5 9 5z" />
                  <path d="M12 14v7" />
                  <path d="M4.3 18.2l7.7 3.8 7.7-3.8" />
                </svg>
                <span>Support academic excellence, research, and professional development.</span>
              </li>
              <li>
                <svg class="purpose-bullet" fill="none" viewBox="0 0 24 24" stroke="var(--clr-primary)" stroke-width="2">
                  <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                </svg>
                <span>Deliver expert library services with a user-centric approach.</span>
              </li>
              <li>
                <svg class="purpose-bullet" fill="none" viewBox="0 0 24 24" stroke="var(--clr-primary)" stroke-width="2">
                  <path d="M2 3h6a4 4 0 0 1 4 4v14a4 4 0 0 0-4-4H2z" />
                  <path d="M22 3h-6a4 4 0 0 0-4 4v14a4 4 0 0 1 4-4h6z" />
                </svg>
                <span>Foster information literacy and digital learning skills.</span>
              </li>
              <li>
                <svg class="purpose-bullet" fill="none" viewBox="0 0 24 24" stroke="var(--clr-primary)" stroke-width="2">
                  <path d="M15 6v12a3 3 0 1 0 3-3H6a3 3 0 1 0 3 3V6a3 3 0 1 0-3 3h12a3 3 0 1 0-3-3z" />
                </svg>
                <span>Collaborate with national and international library networks.</span>
              </li>
              <li>
                <svg class="purpose-bullet" fill="none" viewBox="0 0 24 24" stroke="var(--clr-primary)" stroke-width="2">
                  <rect x="4" y="4" width="16" height="16" rx="2" ry="2" />
                  <rect x="9" y="9" width="6" height="6" />
                  <polyline points="9 1 9 4" />
                  <polyline points="15 1 15 4" />
                  <polyline points="9 20 9 23" />
                  <polyline points="15 20 15 23" />
                  <polyline points="20 9 23 9" />
                  <polyline points="20 15 23 15" />
                  <polyline points="1 9 4 9" />
                  <polyline points="1 15 4 15" />
                </svg>
                <span>Continuously adopt emerging technologies to enhance library services.</span>
              </li>
            </ul>
          </div>
        </div>
      </section>

      <!-- ══ LIBRARY RULES ══ -->
      <section class="page-section" id="library-rules">
        <div class="page-section__header">
          <div class="page-section__label">Regulations</div>
          <h2 class="page-section__title">Library Rules &amp; Regulations</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>All library users are expected to observe the following rules to maintain a conducive learning environment.
          Violation may result in cancellation of library membership.</p>
        <ul class="content-list">
          <li>Maintain silence inside the library at all times. Mobile phones must be switched to silent mode.</li>
          <li>Library cards are non-transferable. Lending of library cards to others is strictly prohibited.</li>
          <li>Personal bags must be deposited at the bag counter before entering the library.</li>
          <li>Books must be returned on or before the due date. Overdue charges apply as per library policy.</li>
          <li>Library materials must not be mutilated, marked, or damaged in any way.</li>
          <li>Food and beverages are not permitted inside the library premises.</li>
          <li>Users must maintain cleanliness — books should be returned to their proper shelves.</li>
          <li>Prior permission is required from the Librarian for any photography inside the library.</li>
          <li>Users must present their library card / institutional ID card for entry and book borrowing.</li>
          <li>Theses, dissertations, reference books, and current journals are strictly for reference only and cannot be
            borrowed.</li>
          <li>Report loss of library card immediately to the library. A duplicate card will be issued on payment of a
            fine.</li>
          <li>The Library Committee and Librarian reserves the right to amend rules as required.</li>
        </ul>
      </section>

      <!-- ══ LIBRARY COMMITTEE ══ -->
      <section class="page-section" id="library-committee">
        <div class="page-section__header">
          <div class="page-section__label">Governance</div>
          <h2 class="page-section__title">Library Committee</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>The Library Committee is responsible for the overall management, policy formulation, resource allocation and
          evaluation of library services. The committee meets periodically to review library activities.</p>

        <div class="team-grid">
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/Vijayakumar1.jpg" alt="Dr. Vijayakumar" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. Vijayakumar</h3>
              <div class="team-card__role">Honorable Vice-Chancellor</div>
              <div class="team-card__subrole">Chairman</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/drSripathi.jpg" alt="Dr. B. H. Sripathi Rao" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. B. H. Sripathi Rao</h3>
              <div class="team-card__role">Pro Vice Chancellor</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/Gangadhara_Somayaji1.jpg" alt="Dr. K. S. Gangadhara Somayaji" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. K. S. Gangadhara Somayaji</h3>
              <div class="team-card__role">Registrar</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/AbdulRahiman.webp" alt="Prof. M. Abdul Rahiman" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Prof. M. Abdul Rahiman</h3>
              <div class="team-card__role">Special Invitee</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/drMoideen.jpg" alt="Dr. A V Moideen Kutty" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. A V Moideen Kutty</h3>
              <div class="team-card__role">Special Invitee</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/mohsin.jpg" alt="Mr. Abdul Mohsin B" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mr. Abdul Mohsin B</h3>
              <div class="team-card__role">Finance Officer</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/drAswini.jpg" alt="Dr. Aswini Dutt R" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. Aswini Dutt R</h3>
              <div class="team-card__role">Dean of Academics</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/Mosabba1.jpg" alt="Dr. M. S. Moosabba" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. M. S. Moosabba</h3>
              <div class="team-card__role">Dean, YMC</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/drLaxmikanth.jpg" alt="Dr. Laxmikanth Chatra" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. Laxmikanth Chatra</h3>
              <div class="team-card__role">Principal, YDC</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/Dr.-leena.jpg" alt="Dr. Leena K.C." onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. Leena K.C.</h3>
              <div class="team-card__role">Dean, YNC</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/drLourdhuraj.jpg" alt="Dr. Lourdhuraj I" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. Lourdhuraj I</h3>
              <div class="team-card__role">Principal, YPC</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/MOHAMMED GULZAR AHMED1.jpg" alt="Dr. Mohammed Gulzar Ahmed" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. Mohammed Gulzar Ahmed</h3>
              <div class="team-card__role">Dean, YPCRC</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/drArun.jpg" alt="Dr. Arun Bhagwath" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. Arun Bhagwath</h3>
              <div class="team-card__role">Principal, YIASCM</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/drShivaprasad.jpg" alt="Dr. Shivaprasad" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. Shivaprasad</h3>
              <div class="team-card__role">Dean, YHMCH</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/GURURAJ1.jpg" alt="Dr. Gururaja H." onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. Gururaja H.</h3>
              <div class="team-card__role">Dean, YAMCH</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/Dr.-Puneeth.jpg" alt="Dr. Puneeth Raghavendra" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. Puneeth Raghavendra</h3>
              <div class="team-card__role">Principal, YN&YSC&H</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/sunitha_saldhana.webp" alt="Dr. Sunitha Saldanha" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. Sunitha Saldanha</h3>
              <div class="team-card__role">Dean, YSAHS</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/janet prima mirnda.webp" alt="Mrs. Janet Prima Mirnda" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Janet Prima Mirnda</h3>
              <div class="team-card__role">Vice Principal, YNC</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/harishchandra.webp" alt="Dr. Harishchandra B" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. Harishchandra B</h3>
              <div class="team-card__role">Prof & HOD, General Surgery, YMC&H</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/rajesh s.webp" alt="Dr. Rajesh S" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. Rajesh S</h3>
              <div class="team-card__role">Prof & HOD, Periodontics, YDC</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/committee/Dr.Ali1.jpg" alt="Dr. K. S. Ali" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Dr. K. S. Ali</h3>
              <div class="team-card__role">Chief Librarian</div>
              <div class="team-card__subrole">Member Secretary</div>
            </div>
          </div>
        </div>
      </section>

      <!-- ══ LIBRARY HOURS ══ -->
      <section class="page-section" id="library-hours">
        <div class="page-section__header">
          <div class="page-section__label">Timings</div>
          <h2 class="page-section__title">Library Hours</h2>
          <div class="page-section__divider"></div>
        </div>
        <table class="hours-table">
          <thead>
            <tr>
              <th>Library</th>
              <th>Weekdays</th>
              <th>Sundays / Holidays</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>Central Library</strong></td>
              <td>09.00 am – 12.00 Midnight</td>
              <td>09.00 am – 12.00 Midnight</td>
            </tr>
            <tr>
              <td><strong>Reading Room (24×7)</strong></td>
              <td colspan="2" style="text-align:center;">Open 24 hours, 7 days a week</td>
            </tr>
            <tr>
              <td><strong>Ayurveda Library</strong></td>
              <td>09.00 am – 05.00 pm</td>
              <td>Closed</td>
            </tr>
            <tr>
              <td><strong>Homoeopathy Library</strong></td>
              <td>09.00 am – 05.00 pm</td>
              <td>Closed</td>
            </tr>
            <tr>
              <td><strong>Allied Health Library</strong></td>
              <td>09.00 am – 05.00 pm</td>
              <td>Closed</td>
            </tr>
            <tr>
              <td><strong>YIASCM Library</strong></td>
              <td>09.00 am – 05.00 pm</td>
              <td>Closed</td>
            </tr>
            <tr>
              <td><strong>Pharmacy Library</strong></td>
              <td>09.00 am – 05.00 pm</td>
              <td>Closed</td>
            </tr>
          </tbody>
        </table>
        <div class="callout">During examination periods, extended hours may apply. Revised timings will be displayed on
          the library notice board.</div>
      </section>

      <!-- ══ LIBRARY TEAM ══ -->
      <section class="page-section" id="library-team">
        <div class="page-section__header">
          <div class="page-section__label">Our Staff</div>
          <h2 class="page-section__title">Library Team</h2>
          <div class="page-section__divider"></div>
        </div>

        <h3 style="font-size:18px; font-weight:700; color:var(--clr-primary); margin-bottom:16px;">Central Library Team</h3>
        <div class="team-grid">
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Kalidh.jpg" alt="Mr. Khalid B. P." onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mr. Khalid B. P.</h3>
              <div class="team-card__role">Chief Librarian</div>
            </div>
          </div>
        </div>

        <h3 style="font-size:18px; font-weight:700; color:var(--clr-primary); margin-bottom:16px; margin-top:32px;">Professional Staff</h3>
        <div class="team-grid">
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Mr. Azeez.webp" alt="Mr. Abdul Azeez" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mr. Abdul Azeez</h3>
              <div class="team-card__role">Asst. Librarian</div>
              <div class="team-card__subrole">M.L.I.Sc., B.Com</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms. Shashikala.webp" alt="Mrs. Shashikala B" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Shashikala B</h3>
              <div class="team-card__role">Asst. Librarian</div>
              <div class="team-card__subrole">M.L.I.Sc., B.A</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms. Mamatha Suvarna.webp" alt="Mrs. Mamatha Suvarna" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Mamatha Suvarna</h3>
              <div class="team-card__role">Asst. Librarian</div>
              <div class="team-card__subrole">M.L.I.Sc., M.A</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/ThilakRaj.webp" alt="Mr. ThilakRaj" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mr. ThilakRaj</h3>
              <div class="team-card__role">Asst. Librarian Cum Lecturer</div>
              <div class="team-card__subrole">M.L.I.Sc., B.Com</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Adam.webp" alt="Mr. Adam" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mr. Adam</h3>
              <div class="team-card__role">Asst. Librarian Cum Lecturer</div>
              <div class="team-card__subrole">M.L.I.Sc., BA</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/hamad.webp" alt="Mr. Hamad Bilal" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mr. Hamad Bilal</h3>
              <div class="team-card__role">Asst. Librarian Cum Lecturer</div>
              <div class="team-card__subrole">M.L.I.Sc., B.Com</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/amreen.webp" alt="Ms. Amreen Taj" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Ms. Amreen Taj</h3>
              <div class="team-card__role">Asst. Librarian</div>
              <div class="team-card__subrole">M.L.I.Sc., (PhD)</div>
            </div>
          </div>
        </div>

        <h3 style="font-size:18px; font-weight:700; color:var(--clr-primary); margin-bottom:16px; margin-top:32px;">Semi Professional Staff</h3>
        <div class="team-grid">
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms. Divya.webp" alt="Mrs. Divya" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Divya</h3>
              <div class="team-card__subrole">B.Lib.Sc., BA</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms. Sharmila.webp" alt="Mrs. Sharmila M.G" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Sharmila M.G</h3>
              <div class="team-card__subrole">B.Lib.Sc., BA</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms. Sumalatha.webp" alt="Mrs. Sumalatha" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Sumalatha</h3>
              <div class="team-card__subrole">B.Lib.Sc., BA</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms. Babita.webp" alt="Ms. Babitha Audrean D’Souza" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Ms. Babitha Audrean D’Souza</h3>
              <div class="team-card__subrole">D.Lib.Sc.</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms. Nalinakshi.webp" alt="Mrs. Nalinakshi Lokesh" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Nalinakshi Lokesh</h3>
              <div class="team-card__subrole">B.Lib.Sc.</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms.Deekshitha.webp" alt="Ms. Deekshitha" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Ms. Deekshitha</h3>
              <div class="team-card__subrole">B.Lib.Sc.</div>
            </div>
          </div>
        </div>

        <h3 style="font-size:18px; font-weight:700; color:var(--clr-primary); margin-bottom:16px; margin-top:32px;">Support Staff</h3>
        <div class="team-grid">
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms. Cynthia.webp" alt="Mrs. Cynthia Veigas" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Cynthia Veigas</h3>
              <div class="team-card__subrole">Ist Division Asst.</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms. Savitha.webp" alt="Ms. Savitha N M" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Ms. Savitha N M</h3>
              <div class="team-card__subrole">IInd Division Asst.</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms. Nethralaxmi.webp" alt="Ms. Nethra Lakshmi" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Ms. Nethra Lakshmi</h3>
              <div class="team-card__subrole">IInd Division Asst.</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Mr. Dayanand Gatty.webp" alt="Mr. Dayananda Gatty" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mr. Dayananda Gatty</h3>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Mr. Dinesh.webp" alt="Mr. Dinesh B" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mr. Dinesh B</h3>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Mr.santhosh kumar.webp" alt="Mr. Santhosh Kumar" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mr. Santhosh Kumar</h3>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Mr. Praveen Rai.webp" alt="Mr. Praveen Rai" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mr. Praveen Rai</h3>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Sachita.webp" alt="Mrs. Sachitha" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Sachitha</h3>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/VidyaShree.webp" alt="Mrs. Vidya Shree" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Vidya Shree</h3>
            </div>
          </div>
        </div>
        
        <h3 style="font-size:18px; font-weight:700; color:var(--clr-primary); margin-bottom:16px; margin-top:32px;">Constituent Units Staff</h3>
        <div class="team-grid">
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms. Seemalatha.webp" alt="Mrs. Seemalatha" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Seemalatha</h3>
              <div class="team-card__role">Librarian, YIASCM</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Mr. Yogesh.webp" alt="Mr. Yogesh H G" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mr. Yogesh H G</h3>
              <div class="team-card__role">Librarian, YPCRC</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms.Yashaswini.webp" alt="Mrs. Yashaswini" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Yashaswini</h3>
              <div class="team-card__role">Asst. Librarian, YSAHS</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/VinuthaD.jpg" alt="Vinutha D" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Vinutha D</h3>
              <div class="team-card__role">Librarian, YAMCH</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/rajeevi.jpg" alt="Mrs. Rajeevi" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Rajeevi</h3>
              <div class="team-card__role">Asst. Librarian, YIASCM</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms.Pratiksha.webp" alt="Ms. Prathiksha" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Ms. Prathiksha</h3>
              <div class="team-card__role">Asst. Librarian, YHMCH</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms. Sarita.webp" alt="Mrs. Saritha" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Saritha</h3>
              <div class="team-card__role">Asst. Librarian, YIASCM</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Mrs. Sumana 3559.webp" alt="Mrs. Sumana" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Sumana</h3>
              <div class="team-card__role">Asst. Librarian</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms. Nishmitha.webp" alt="Mrs. Nishmitha" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Nishmitha</h3>
              <div class="team-card__role">Junior Asst. Librarian, YNC & YPC</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms. Amita Ayurveda Library.webp" alt="Mrs. Amitha" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Amitha</h3>
              <div class="team-card__role">Library Asst, YAMCH</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Ms.Shareena HEM_6130.webp" alt="Mrs. Shareena Diana D'souza" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mrs. Shareena Diana D'souza</h3>
              <div class="team-card__subrole">YHMCH</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/Meghashree.jpg" alt="Meghashree" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Meghashree</h3>
              <div class="team-card__role">Library Assistant, YAMCH</div>
            </div>
          </div>
          <div class="team-card">
            <div class="team-card__img">
              <img src="assets/images/about/teams/sherief.webp" alt="Mr. Sherief" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <div class="team-card__info">
              <h3 class="team-card__name">Mr. Sherief</h3>
              <div class="team-card__subrole">YHMCH</div>
            </div>
          </div>
        </div>
      </section>

      <!-- ══ LIBRARY COLLECTIONS ══ -->
      <section class="page-section" id="library-collection">
        <div class="page-section__header">
          <div class="page-section__label">Resources</div>
          <h2 class="page-section__title">Library Collections</h2>
          <div class="page-section__divider"></div>
        </div>
        <div class="info-grid" style="grid-template-columns:repeat(auto-fit,minmax(160px,1fr));">
          <div class="info-box">
            <div class="info-box__label">Books</div>
            <div class="info-box__value">60,647+</div>
          </div>
          <div class="info-box">
            <div class="info-box__label">Print Journals</div>
            <div class="info-box__value">189</div>
          </div>
          <div class="info-box">
            <div class="info-box__label">Back Volumes</div>
            <div class="info-box__value">9,838</div>
          </div>
          <div class="info-box">
            <div class="info-box__label">Theses &amp; Dissertations</div>
            <div class="info-box__value">2,977</div>
          </div>
          <div class="info-box">
            <div class="info-box__label">Online Databases</div>
            <div class="info-box__value">9</div>
          </div>
          <div class="info-box">
            <div class="info-box__label">E-Journals</div>
            <div class="info-box__value">13,000+</div>
          </div>
          <div class="info-box">
            <div class="info-box__label">E-Books</div>
            <div class="info-box__value">2,20,000+</div>
          </div>
        </div>
        <table class="data-table" style="margin-top:24px;">
          <thead>
            <tr>
              <th>Library</th>
              <th>Books</th>
              <th>Journals</th>
              <th>Special Collections</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>Central Library</strong></td>
              <td>60,647+</td>
              <td>189+</td>
              <td>Theses, Question Papers, Ancient Books</td>
            </tr>
            <tr>
              <td><strong>Ayurveda Library</strong></td>
              <td>8,338</td>
              <td>8</td>
              <td>Classical Ayurveda Texts</td>
            </tr>
            <tr>
              <td><strong>Homoeopathy Library</strong></td>
              <td>4,780+</td>
              <td>Selected</td>
              <td>Materia Medica, Repertory</td>
            </tr>
            <tr>
              <td><strong>Allied Health Library</strong></td>
              <td>Growing</td>
              <td>Selected</td>
              <td>Allied Health Sciences</td>
            </tr>
            <tr>
              <td><strong>YIASCM Library</strong></td>
              <td>Growing</td>
              <td>Selected</td>
              <td>Commerce &amp; Management</td>
            </tr>
            <tr>
              <td><strong>Pharmacy Library</strong></td>
              <td>Growing</td>
              <td>Selected</td>
              <td>Pharmaceutical Sciences</td>
            </tr>
          </tbody>
        </table>
      </section>

      <!-- ══ FLOOR PLANS ══ -->
      <section class="page-section" id="floor-plan">
        <div class="page-section__header">
          <div class="page-section__label">Facilities</div>
          <h2 class="page-section__title">Floor Plans — Central Library</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>The Central Library is housed in a standalone building with two functional floors.</p>
        <div style="display:flex;gap:20px;flex-wrap:wrap;margin-top:16px;">
          <div
            style="background:var(--clr-bg);border:1px solid var(--clr-border);border-radius:var(--radius-md);padding:24px;flex:1;min-width:300px;">
            <h3 style="font-size:15px;font-weight:700;color:var(--clr-primary);margin-bottom:14px;">Ground Floor</h3>
            <img src="assets/images/about/floorplan_gf.jpg" alt="Ground Floor Plan" style="width:100%; height:auto; border-radius:var(--radius-sm); margin-bottom:16px; border:1px solid var(--clr-border);">
            <ul class="content-list">
              <li>Main Entrance &amp; Reception / Property Counter</li>
              <li>Circulation / Issue-Return Desk</li>
              <li>UG Book Stack Area</li>
              <li>Periodicals / Journals &amp; Newspaper Section</li>
              <li>New Arrivals Display</li>
              <li>Faculty &amp; Staff Reading Room</li>
              <li>Librarian's Office</li>
              <li>Reprography Section</li>
            </ul>
          </div>
          <div
            style="background:var(--clr-bg);border:1px solid var(--clr-border);border-radius:var(--radius-md);padding:24px;flex:1;min-width:300px;">
            <h3 style="font-size:15px;font-weight:700;color:var(--clr-primary);margin-bottom:14px;">Basement</h3>
            <img src="assets/images/about/floorplan_basement.jpg" alt="Basement Floor Plan" style="width:100%; height:auto; border-radius:var(--radius-sm); margin-bottom:16px; border:1px solid var(--clr-border);">
            <ul class="content-list">
              <li>UG / PG Reading Area (Silent Zone)</li>
              <li>PG Book Stack Area</li>
              <li>Digital Browsing Lab / E-learning Centre</li>
              <li>Theses &amp; Reference Section</li>
              <li>Audio-Visual Room</li>
              <li>Journal Archival / Back Volumes Section</li>
              <li>Ancient Books Section</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- ══ LIBRARY POLICY ══ -->
      <section class="page-section" id="library-policy">
        <div class="page-section__header">
          <div class="page-section__label">Policy Document</div>
          <h2 class="page-section__title">Library Policy</h2>
          <div class="page-section__divider"></div>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:20px;">
          <div class="info-box">
            <div class="info-box__label">UG Students</div>
            <div class="info-box__value" style="font-size:14px;margin-top:4px;">4 Books · 15 Days</div>
          </div>
          <div class="info-box">
            <div class="info-box__label">PG Students</div>
            <div class="info-box__value" style="font-size:14px;margin-top:4px;">6 Books · 15 Days</div>
          </div>
          <div class="info-box">
            <div class="info-box__label">Faculty</div>
            <div class="info-box__value" style="font-size:14px;margin-top:4px;">10 Books · 30 Days</div>
          </div>
          <div class="info-box">
            <div class="info-box__label">Research Scholars</div>
            <div class="info-box__value" style="font-size:14px;margin-top:4px;">8 Books · 30 Days</div>
          </div>
        </div>
        <div class="callout"><strong>Overdue Fine:</strong> ₹2 per book per day for students | ₹5 per book per day for
          others, from the due date to the date of return.</div>
        <div style="margin-top:20px;">
          <a href="assets/documents/Library_Policy.pdf" target="_blank" class="btn btn--primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
              <polyline points="7 10 12 15 17 10" />
              <line x1="12" y1="15" x2="12" y2="3" />
            </svg>
            Download Library Policy (PDF)
          </a>
        </div>
      </section>

    </main>
  </div><!-- end inner-layout -->

  <!-- FOOTER -->
  <footer class="footer" role="contentinfo">
    <div class="footer__top">
      <div class="footer__grid">
        <div class="footer__brand">
          <div class="footer__brand-logo">
            <img src="https://library.yenepoya.edu.in/images/Central-Library-logo.png" alt="Yenepoya Libraries">
            <span style="font-weight:800;font-size:18px;color:#fff;letter-spacing:-.2px;">Yenepoya Libraries</span>
          </div>
          <p>Central hub of information for Yenepoya (Deemed to be University). Providing library and information
            services to 8,000+ users since 1992.</p>
        </div>
        <div>
          <div class="footer__col-title">Useful Links</div>
          <div class="footer__links">
            <a href="about.php">About Library</a>
            <a href="e-resources.php">E-Resources</a>
            <a href="services.php">Services</a>
            <a href="repository.php">Institutional Repository</a>
            <a href="research.php">Research Support</a>
            <a href="events.php">Events</a>
            <a href="contact.php">Contact Us</a>
            <a href="https://opac.yenepoya.edu.in/cgi-bin/koha/opac-user.html" target="_blank">My Account</a>
          </div>
        </div>
        <div>
          <div class="footer__col-title">Our Institutes</div>
          <div class="footer__links">
            <a href="https://ydc.yenepoya.edu.in" target="_blank">Dental College</a>
            <a href="https://www.ypcrc.yenepoya.edu.in" target="_blank">Pharmacy &amp; Research Centre</a>
            <a href="https://ymc.yenepoya.edu.in" target="_blank">Medical College</a>
            <a href="https://ync.yenepoya.edu.in" target="_blank">Nursing College</a>
            <a href="https://ypc.yenepoya.edu.in" target="_blank">Physiotherapy College</a>
            <a href="https://yiascm.in" target="_blank">YIASCM</a>
            <a href="https://www.yenepoyaayurveda.com" target="_blank">Ayurveda College</a>
            <a href="https://www.yhch.in" target="_blank">Homoeopathy College</a>
          </div>
        </div>
        <div>
          <div class="footer__col-title">Get In Touch</div>
          <div class="footer__contact-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
              <circle cx="12" cy="10" r="3" />
            </svg>
            <span>University Road, Deralakatte,<br>Mangalore – 575018, Karnataka, India</span>
          </div>
          <div class="footer__contact-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="4" width="20" height="16" rx="2" />
              <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
            </svg>
            <a href="mailto:library@yenepoya.edu.in">library@yenepoya.edu.in</a>
          </div>
          <div class="footer__contact-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path
                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.15 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.06 1.2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16z" />
            </svg>
            <a href="tel:08242206067">+91 824 2206067</a>
          </div>
        </div>
      </div>
    </div>
    <div class="footer__bottom">
      <div class="footer__bottom-inner">
        <span>© 2026 <strong>Yenepoya (Deemed to be University)</strong>. All Rights Reserved.</span>
        <span>Designed by <a href="https://ytincubator.com" target="_blank">Yenepoya Technology Incubator</a></span>
      </div>
    </div>
  </footer>

  <!-- ═══════════════ SIDEBAR ENQUIRY ═══════════ -->
  <?php include 'components/enquiry.php'; ?>

  <!-- ═══════════════ NOTIFICATION SIDEBAR ═════════ -->
  <?php include 'components/notifications.php'; ?>

  <!-- ═══════════════ AI CHATBOT ═══════════════════ -->
  <?php include 'components/chatbot.php'; ?>

  <script src="assets/js/main.js"></script>
  <script src="assets/js/enhancements.js"></script>


</body>

</html>








