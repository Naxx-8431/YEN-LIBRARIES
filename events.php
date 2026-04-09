<?php
/**
 * EVENTS PAGE — Fetches published events from database
 * Hardcoded historical events are kept below.
 */
require_once 'db.php';

// Fetch published events from database (added via admin panel)
$db_events = mysqli_query($conn, "SELECT * FROM events WHERE status = 'published' ORDER BY event_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library Events | Yenepoya Libraries</title>
  <meta name="description"
    content="Stay updated with regular training programs, user awareness seminars, library orientations, and book exhibitions organized by Yenepoya Libraries.">
  <link rel="icon" href="assets/images/favicon.jpg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <style>
    /* ── Minimal Events Styles ── */

    .events-grid {
      margin-top: 1rem;
    }

    /* Clean accordion */
    .styled-accordion details {
      border-bottom: 1px solid var(--clr-border, #e2e8f0);
    }

    .styled-accordion summary {
      padding: 18px 0;
      font-weight: 600;
      font-size: 1.05rem;
      cursor: pointer;
      color: var(--clr-text-title, #1e293b);
      list-style: none;
      display: flex;
      justify-content: space-between;
      align-items: center;
      user-select: none;
    }

    .styled-accordion summary::-webkit-details-marker {
      display: none;
    }

    .styled-accordion summary::after {
      content: '+';
      font-size: 1.3rem;
      font-weight: 400;
      color: var(--clr-primary, #283B6A);
      flex-shrink: 0;
      margin-left: 16px;
    }

    .styled-accordion details[open] summary::after {
      content: '−';
    }

    .styled-accordion .details-content {
      padding: 0 0 24px 0;
    }

    .styled-accordion .details-content>p {
      font-size: 0.93rem;
      line-height: 1.65;
      color: var(--clr-text, #475569);
      margin: 0 0 16px 0;
    }

    /* Simple event entry */
    .event-entry {
      margin-bottom: 20px;
    }

    .event-entry:last-child {
      margin-bottom: 0;
    }

    .event-entry h3 {
      font-size: 0.98rem;
      font-weight: 600;
      color: var(--clr-text-title, #1e293b);
      margin: 0 0 4px 0;
    }

    .event-entry p,
    .event-entry span {
      font-size: 0.9rem;
      line-height: 1.55;
      color: var(--clr-text-muted, #64748b);
      margin: 0;
      display: block;
    }

    .event-entry strong {
      color: var(--clr-text-title, #1e293b);
    }

    /* Simple inline images */
    .event-photos {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 10px;
    }

    .event-photos img {
      width: 170px;
      height: 110px;
      object-fit: cover;
      border-radius: 6px;
    }

    /* Simple list items for flat sections */
    .event-list-item {
      padding: 16px 0;
      border-bottom: 1px solid var(--clr-border, #e2e8f0);
    }

    .event-list-item:last-child {
      border-bottom: none;
    }

    .event-list-item h3 {
      font-size: 0.98rem;
      font-weight: 600;
      color: var(--clr-text-title, #1e293b);
      margin: 0 0 4px 0;
    }

    .event-list-item p {
      font-size: 0.9rem;
      line-height: 1.5;
      color: var(--clr-text-muted, #64748b);
      margin: 2px 0 0 0;
    }
  </style>
</head>

<body>

  <!-- ═══════════════ TOP BAR ═══════════════════ -->
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

  <!-- ═══════════════ HEADER ════════════════════ -->
  <header class="header">
    <a href="index.php" class="header__logo" aria-label="Yenepoya Libraries Home">
      <img src="https://library.yenepoya.edu.in/images/Central-Library-logo.png" alt="Yenepoya Central Library">
      <img src="https://library.yenepoya.edu.in/images/naac.png" alt="NAAC" class="header__logo-naac">
    </a>

    <nav class="header__nav" aria-label="Primary Navigation">
      <a href="index.php" class="nav__link">Home</a>
      <a href="about.php" class="nav__link">About</a>
      <a href="services.php" class="nav__link">Services</a>
      <a href="e-resources.php" class="nav__link">E-Resources</a>
      <a href="repository.php" class="nav__link">Repository</a>
      <a href="research.php" class="nav__link">Research</a>
      <a href="events.php" class="nav__link active">Events</a>
      <a href="contact.php" class="nav__link">Contact</a>
    </nav>

    <div class="header__search">
      <div class="header__search-container" id="headerSearchContainer" onclick="window.location.href='index.html#opac'"
        style="cursor: pointer;">
        <button class="header__search-btn" id="headerSearchBtn" aria-label="Search"
          onclick="window.location.href='index.html#opac'" style="cursor: pointer; z-index: 10;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.35-4.35" />
          </svg>
        </button>
        <input type="text" class="header__search-input" id="headerSearchInput" placeholder="Search for books..."
          readonly onclick="window.location.href='index.html#opac'" style="cursor: pointer; z-index: 10;">
      </div>
    </div>

    <button class="header__burger" id="burger" aria-label="Toggle navigation" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </header>

  <!-- Mobile Nav -->
  <nav class="mobile-nav" id="mobileNav" aria-label="Mobile Navigation">
    <a href="index.php" class="nav__link">Home</a>
    <a href="about.php" class="nav__link">About</a>
    <a href="services.php" class="nav__link">Services</a>
    <a href="e-resources.php" class="nav__link">E-Resources</a>
    <a href="repository.php" class="nav__link">Repository</a>
    <a href="research.php" class="nav__link">Research</a>
    <a href="events.php" class="nav__link active">Events</a>
    <a href="contact.php" class="nav__link">Contact</a>
  </nav>

  <!-- ═══════════════ PAGE HERO ═════════════════ -->
  <div class="page-hero" style="background-image: linear-gradient(rgba(16, 28, 56, 0.75), rgba(16, 28, 56, 0.75)), url('images/hero-bg1.png'); background-size: cover; background-position: center;"images/banners/Library%20Events.webp'); background-size: cover; background-position: center;">
    <div class="page-hero__inner">
      <div class="page-hero__breadcrumb">
        <a href="index.php">Home</a>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="m9 18 6-6-6-6" />
        </svg>
        <span>Events</span>
      </div>
      <h1 class="page-hero__title">Library Events &amp; Education</h1>
      <p class="page-hero__subtitle">Explore our continuous endeavors to educate, empower, and engage students and
        faculty through robust academic interactions.</p>
    </div>
  </div>

  <!-- ═══════════════ INNER LAYOUT ═══════════════ -->
  <div class="inner-layout">

    <!-- SIDEBAR -->
    <aside class="page-sidebar" aria-label="Events navigation">
      <div class="page-sidebar__title">Events Index</div>
      <nav class="page-sidebar__nav">
        <a href="#library-events" class="page-sidebar__link active">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
            <line x1="16" y1="2" x2="16" y2="6" />
            <line x1="8" y1="2" x2="8" y2="6" />
            <line x1="3" y1="10" x2="21" y2="10" />
          </svg>
          Library Events
        </a>
        <a href="#user-education" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polygon points="12 2 2 7 12 12 22 7 12 2" />
            <polyline points="2 17 12 22 22 17" />
            <polyline points="2 12 12 17 22 12" />
          </svg>
          User Education Programs
        </a>
        <a href="#library-orientation" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="4" y="4" width="16" height="16" rx="2" ry="2" />
            <rect x="9" y="9" width="6" height="6" />
            <line x1="9" y1="1" x2="9" y2="4" />
            <line x1="15" y1="1" x2="15" y2="4" />
            <line x1="9" y1="20" x2="9" y2="23" />
            <line x1="15" y1="20" x2="15" y2="23" />
            <line x1="20" y1="9" x2="23" y2="9" />
            <line x1="20" y1="14" x2="23" y2="14" />
            <line x1="1" y1="9" x2="4" y2="9" />
            <line x1="1" y1="14" x2="4" y2="14" />
          </svg>
          Library Orientations
        </a>
        <a href="#books-exhibition" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
          </svg>
          Books Exhibitions
        </a>
      </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="page-content" id="main">

      <!-- 1. Library Events -->
      <section class="page-section active" id="library-events">
        <div class="page-section__header">
          <div class="page-section__label">Knowledge Gathering</div>
          <h2 class="page-section__title">Library Events</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>Annual academic training conferences directly hosted by the Central Library with expert industry trainers
          from major research indexing platforms.</p>

        <!-- Dynamic Events from Database (added via Admin Panel) -->
        <?php if (mysqli_num_rows($db_events) > 0): ?>
        <div class="events-grid" style="margin-bottom:32px;">
          <?php while ($ev = mysqli_fetch_assoc($db_events)): ?>
          <div class="event-list-item">
            <h3><?php echo htmlspecialchars($ev['title']); ?></h3>
            <p>
              <strong>Date:</strong> <?php echo $ev['event_date'] ? date('d M Y', strtotime($ev['event_date'])) : 'TBA'; ?>
              &nbsp;·&nbsp;
              <strong>Location:</strong> <?php echo htmlspecialchars($ev['location'] ?? 'TBA'); ?>
              &nbsp;·&nbsp;
              <span class="badge" style="font-size:11px; padding:2px 8px; background:<?php echo $ev['category']=='Workshop'?'#dbeafe':'#dcfce7'; ?>; color:<?php echo $ev['category']=='Workshop'?'#1e40af':'#16a34a'; ?>; border-radius:4px;"><?php echo htmlspecialchars($ev['category']); ?></span>
            </p>
            <?php if (!empty($ev['description'])): ?>
              <p><?php echo htmlspecialchars($ev['description']); ?></p>
            <?php endif; ?>
            <?php if (!empty($ev['image'])): ?>
              <div class="event-photos"><img src="<?php echo htmlspecialchars($ev['image']); ?>" alt="<?php echo htmlspecialchars($ev['title']); ?>"></div>
            <?php endif; ?>
          </div>
          <?php endwhile; ?>
        </div>
        <h3 style="font-size:1.15rem; font-weight:700; color:var(--clr-text-title); margin-bottom:16px; padding-top:8px; border-top:1px solid var(--clr-border);">Past Events Archive</h3>
        <?php endif; ?>

        <div class="styled-accordion mt-4">

          <!-- Accordion 1 -->
          <details open>
            <summary>User Awareness Programs — February 18–20, 2025</summary>
            <div class="details-content">
              <p>The Central Library organized a series of User Awareness Programs designed for faculty members,
                researchers, and students to enhance awareness of effective utilization of subscribed e-resources.</p>

              <div class="event-entry">
                <h3>Library e-Resources and Research Tools Collaboration Seminars</h3>
                <span><strong>Resource Person:</strong> Dr. K.S. Ali, Chief Librarian</span>
                <span><strong>Highlights:</strong> Hands-on training on journal selection (without APC), identifying
                  indexed publishers, and effective utilization of research methodology tools.</span>
                <div class="event-photos">
                  <img src="images/library_events/events1.jpg" alt="Event photo YMC">
                  <img src="images/library_events/events2.jpg" alt="Event photo Ayurveda College">
                </div>
              </div>
            </div>
          </details>

          <!-- Accordion 2 -->
          <details>
            <summary>Sensitization &amp; User Awareness Programs — December 11–19, 2024</summary>
            <div class="details-content">
              <p>Series of online interactive seminars enhancing robust e-resources usage tracking.</p>

              <div class="event-entry">
                <h3>Program 1: ClinicalKey Flex (Elsevier)</h3>
                <span><strong>Date:</strong> December 11, 2024</span>
                <span><strong>Trainer:</strong> Mr. Abhishek Gupta, Elsevier Health Solutions</span>
                <div class="event-photos">
                  <img src="images/library_events/clinicalkeyflex1.jpg" alt="ClinicalKey flex 1">
                  <img src="images/library_events/clinicalkeyflex2.jpg" alt="ClinicalKey flex 2">
                </div>
              </div>

              <div class="event-entry">
                <h3>Program 2: Grammarly Premium</h3>
                <span><strong>Date:</strong> December 12, 2024</span>
                <span><strong>Trainer:</strong> Mr. Binoy Halam, Grammarly</span>
                <div class="event-photos">
                  <img src="images/library_events/grammarly1.png" alt="Grammarly Seminar">
                  <img src="images/library_events/grammarly2.png" alt="Grammarly Session">
                </div>
              </div>

              <div class="event-entry">
                <h3>Program 3 &amp; 4: Edzter &amp; Knimbus Off-Campus</h3>
                <span><strong>Date:</strong> December 18–19, 2024</span>
                <span><strong>Highlights:</strong> Platform demonstrations for remote repository tools and magazine
                  aggregates handling over 100 participants.</span>
              </div>
            </div>
          </details>

          <!-- Accordion 3 -->
          <details>
            <summary>User Training Program on Subscribed E-Resources — May 22 – June 27, 2024</summary>
            <div class="details-content">
              <div class="event-entry">
                <h3>ProQuest Central &amp; Web of Science Training Weeks</h3>
                <span><strong>Resource Person:</strong> Dr. Subhasree Nag &amp; Mr. Srijith Sasidharan
                  (Clarivate)</span>
                <span><strong>Programs:</strong> Web of Science Literature Review, EndNote Mastery, Journal Citation
                  Report (JCR), ProQuest E-Books Central Database Navigation.</span>
                <div class="event-photos">
                  <img src="images/library_events/webscience.jpg" alt="Web of Science Session">
                  <img src="images/library_events/endnote.png" alt="EndNote Training">
                  <img src="images/library_events/proquest.jpg" alt="ProQuest Module">
                </div>
              </div>
            </div>
          </details>

        </div>
      </section>

      <!-- 2. User Education Programs -->
      <section class="page-section" id="user-education" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Skill Building</div>
          <h2 class="page-section__title">User Education Programs</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>Our User Education Initiatives ensure every researcher and faculty member stays highly proficient in
          navigating complex publication standards and platform paradigms.</p>

        <div class="events-grid">

          <div class="event-list-item">
            <h3>Predatory Vs Indexed Journals Seminar</h3>
            <p><strong>Date:</strong> 25-09-2021 | Google Meet &nbsp;·&nbsp; <strong>Resource:</strong> Dr. B. T.
              Sampath Kumar</p>
            <p>Webinar explicitly highlighting nuances differentiating predatory setups from correctly indexed standard
              mechanisms. Topics traversed NIRF ranking metrics, SJR arrays, Scimago structures and WoS profiles.</p>
          </div>

          <div class="event-list-item">
            <h3>Submitting Publications for BMJ</h3>
            <p><strong>Date:</strong> 15-11-2021 | YDC Auditorium &nbsp;·&nbsp; <strong>Resource:</strong> Mr. R. Anand
              and Ms. Pooja Nair (BMJ)</p>
            <p>Personalized mini workshops empowering authors with insights strictly mapping the standards for authoring
              BMJ accepted articles and case report evaluations.</p>
            <div class="event-photos">
              <img src="images/user/user1.webp" alt="BMJ Seminar 1">
              <img src="images/user/user2.webp" alt="BMJ Seminar 2">
            </div>
          </div>

          <div class="event-list-item">
            <h3>URKUND (Ouriginal) Plagiarism Detection Software Launch</h3>
            <p><strong>Date:</strong> 12-11-2021 | Virtual &nbsp;·&nbsp; <strong>Resource:</strong> Shri Manoj Kumar K
              (Scientist-E INFLIBNET)</p>
            <p>Detailed initiation providing administrator thresholds configurations, enabling University scholars
              access utilizing ethical research analysis parameters comprehensively.</p>
          </div>

          <div class="event-list-item">
            <h3>Author Workshops &amp; Basics of Publication Metrics</h3>
            <p><strong>Date:</strong> Oct 2020 | Microsoft Teams &nbsp;·&nbsp; <strong>Resource:</strong> Dr. K.S. Ali
              &amp; Clarivate Analytics Team</p>
            <p>Multi-tiered sessions detailing accurate measurements of citations, institutional indexing via IRINS
              matching criteria III protocols mappings completely integrated. Focuses heavily addressed h-index
              calculations procedures precisely.</p>
          </div>

        </div>
      </section>

      <!-- 3. Library Orientations -->
      <section class="page-section" id="library-orientation" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Student Success</div>
          <h2 class="page-section__title">Library Orientations</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>Induction assemblies equipping incoming batches and postgraduate divisions covering Central Library
          resources.</p>

        <div class="events-grid mt-4">

          <div class="event-list-item">
            <h3>2021 &amp; 2019 Academic Cohorts</h3>
            <div class="event-photos">
              <img src="images/orientation/5.webp" alt="UG orientation 21">
              <img src="images/orientation/bsc01.webp" alt="Nursing Cohort Bsc">
              <img src="images/orientation/3B%20UG%20Orientation%20Prog.webp" alt="UG Progress Cohort">
              <img src="images/orientation/DSC_5943.webp" alt="DSC Cohort 19">
            </div>
          </div>

          <div class="event-list-item">
            <h3>2018 Nursing &amp; Radiology Wings</h3>
            <div class="event-photos">
              <img src="images/orientation/19-09-2018%20Radiology%20dept-%20Library%20Orientation.webp"
                alt="Radiology dept">
              <img src="images/orientation/20-07-2018%20nursng%20faculty%20oriention.webp" alt="Nursing dept">
            </div>
          </div>

          <div class="event-list-item">
            <h3>2017 &amp; 2016 Medical Arrays</h3>
            <div class="event-photos">
              <img src="images/orientation/DSC_0862.webp" alt="B.Pharm Induction">
              <img src="images/orientation/Lib%20Orientation-Medical%20PGs.webp" alt="PG Medical Induction">
              <img src="images/orientation/1.webp" alt="Orientation Base Set 1">
              <img src="images/orientation/2.webp" alt="Orientation Base Set 2">
            </div>
          </div>

        </div>
      </section>

      <!-- 4. Books Exhibitions -->
      <section class="page-section" id="books-exhibition" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Collection Building</div>
          <h2 class="page-section__title">Books Exhibitions</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>Curated literature showcases linking leading vendor publishers with University faculties, fostering specific
          requisition pathways driving collection enrichments.</p>

        <div class="styled-accordion mt-4">

          <details open>
            <summary>Books Exhibition 2024–25</summary>
            <div class="details-content">
              <p>The Central Library organized a five-day Books Exhibition featuring Medical, Dental, Nursing,
                Physiotherapy, General Interest literature streams across multiple campuses including Deralakatte,
                Mudipu and Kulur.</p>
              <div class="event-photos">
                <img src="images/Books%20Exhibhition/books24-25-1.jpg" alt="Exhibition 2024 Snap 1">
                <img src="images/Books%20Exhibhition/books24-25-2.jpg" alt="Exhibition 2024 Snap 2">
                <img src="images/Books%20Exhibhition/books24-25-3.jpg" alt="Exhibition 2024 Snap 3">
              </div>
            </div>
          </details>

          <details>
            <summary>Books Exhibition 2017</summary>
            <div class="details-content">
              <div class="event-photos">
                <img src="images/Books%20Exhibhition/Book%20Exhibition-2017.jpg" alt="Exhibition 2017"
                  style="width:100%;height:auto;">
              </div>
            </div>
          </details>

          <details>
            <summary>Books Exhibition 2015 &amp; 2014</summary>
            <div class="details-content">
              <div class="event-photos">
                <img src="images/Books%20Exhibhition/Book%20exhibition-23%20sept%202015-1.jpg" alt="Exhibition 2015">
                <img src="images/Books%20Exhibhition/DSC_0001.jpg" alt="Exhibition 2014">
              </div>
            </div>
          </details>

        </div>
      </section>

    </main>
  </div>

  <!-- ═══════════════ FOOTER ════════════════════ -->
  <footer class="footer" role="contentinfo">
    <div class="footer__top">
      <div class="footer__grid">
        <!-- Brand -->
        <div class="footer__brand">
          <div class="footer__brand-logo">
            <img src="https://library.yenepoya.edu.in/images/Central-Library-logo.png" alt="Yenepoya Libraries">
            <span style="font-weight:800;font-size:18px;color:#fff;letter-spacing:-.2px;">Yenepoya Libraries</span>
          </div>
          <p>Central hub of information for Yenepoya (Deemed to be University). Providing library and information
            services to 8,000+ users since 1992.</p>
        </div>
        <!-- Links -->
        <div>
          <div class="footer__col-title">Useful Links</div>
          <div class="footer__links">
            <a href="about.php">About Library</a>
            <a href="e-resources.php">E-Resources</a>
            <a href="services.php">Services</a>
            <a href="repository.php">Institutional Repository</a>
            <a href="research.php">Research Support</a>
          </div>
        </div>
      </div>
    </div>
    <div class="footer__bottom">
      <div class="footer__bottom-inner">
        <span>&copy; 2026 <strong>Yenepoya (Deemed to be University)</strong>. All Rights Reserved.</span>
      </div>
    </div>
  </footer>

  <script src="assets/js/main.js"></script>

</body>

</html>