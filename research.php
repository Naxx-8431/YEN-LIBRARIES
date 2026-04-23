<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Research Support | Yenepoya Libraries</title>
  <meta name="description"
    content="Explore research support services at Yenepoya Libraries. Plagiarism checking, reference management, indexing guidelines and author profiles.">
  <link rel="icon" href="assets/images/favicon.jpg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/components.css">
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
      <a href="research.php" class="nav__link active">Research</a>
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
    <a href="research.php" class="nav__link active">Research</a>
    <a href="events.php" class="nav__link">Events</a>
    <a href="contact.php" class="nav__link">Contact</a>
  </nav>

  <!-- ═══════════════ PAGE HERO ═════════════════ -->
  <div class="page-hero" style="background-image: linear-gradient(rgba(16, 28, 56, 0.75), rgba(16, 28, 56, 0.75)), url('images/hero-bg1.png'); background-size: cover; background-position: center;"images/banners/Online Databases.webp'); background-size: cover; background-position: center;">
    <div class="page-hero__inner">
      <div class="page-hero__breadcrumb">
        <a href="index.php">Home</a>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="m9 18 6-6-6-6" />
        </svg>
        <span>Research Support</span>
      </div>
      <h1 class="page-hero__title">Research Support Services</h1>
      <p class="page-hero__subtitle">Empowering research excellence through dedicated tools, citation management guidance, and plagiarism integrity checks.</p>
    </div>
  </div>

  <!-- ═══════════════ INNER LAYOUT ═══════════════ -->
  <div class="inner-layout">

    <!-- SIDEBAR -->
    <aside class="page-sidebar" aria-label="Research navigation">
      <div class="page-sidebar__title">Research Support</div>
      <nav class="page-sidebar__nav">
        <a href="#irins" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
            <circle cx="12" cy="7" r="4" />
          </svg>
          IRINS@Yenepoya
        </a>
        <a href="#plagiarism" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
            <polyline points="22 4 12 14.01 9 11.01" />
          </svg>
          Plagiarism Detection Tool
        </a>
        <a href="#reference-management" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
          </svg>
          Reference Management Software
        </a>
        <a href="#article-request" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
            <polyline points="14 2 14 8 20 8" />
            <line x1="16" y1="13" x2="8" y2="13" />
            <line x1="16" y1="17" x2="8" y2="17" />
          </svg>
          Full-text Article Request
        </a>
        <a href="#ugc-care" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />
            <line x1="8" y1="21" x2="16" y2="21" />
          </svg>
          UGC-CARE Indexed Journals
        </a>
        <a href="#journal-selection" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
          </svg>
          Journals Selection Service For Publication
        </a>
        <a href="#bibliometrics" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
          </svg>
          Bibliometrics
        </a>
        <a href="#handbook" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
            <polyline points="14 2 14 8 20 8" />
          </svg>
          Research Support Handbook
        </a>
      </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="page-content" id="main">

      <!-- 1. IRINS@Yenepoya -->
      <section class="page-section" id="irins">
        <div class="page-section__header">
          <div class="page-section__label">Researcher Profiles</div>
          <h2 class="page-section__title">IRINS@Yenepoya</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>The **Indian Research Information Network System (IRINS)** is a web-based research information management service developed by INFLIBNET. It serves as a unified digital profile system designed to showcase the research contributions, publications, and citations metrics of Yenepoya University faculty members to the global academic community.</p>

        <div class="info-grid">
          <div class="info-box">
            <div class="info-box__label">Profiles Supported</div>
            <div class="info-box__value">Faculty & Researchers</div>
          </div>
          <div class="info-box">
            <div class="info-box__label">Platform</div>
            <div class="info-box__value">Vidwan ID Integration</div>
          </div>
          <div class="info-box">
            <div class="info-box__label">Benefits</div>
            <div class="info-box__value">Citation Tracking & Metrics</div>
          </div>
        </div>

        <p style="margin-top:24px;">
          <a href="https://yenepoya.irins.org/" target="_blank" class="btn btn--primary">
            Access IRINS Portal
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
          </a>
        </p>
      </section>

      <!-- 2. Plagiarism Detection Tool -->
      <section class="page-section" id="plagiarism" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Academic Integrity</div>
          <h2 class="page-section__title">Plagiarism Detection Tool</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>The Central Library provides access to **Turnitin by iThenticate**, a leading plagiarism detection software used by academic institutions, publishers, and researchers worldwide. iThenticate helps to ensure that research manuscripts, theses, and academic papers maintain the highest standards of originality.</p>

        <div class="service-grid">
          <div class="service-card">
            <div class="service-card__icon">A</div>
            <h3 class="service-card__title">About iThenticate</h3>
            <p class="service-card__desc">A web-based tool designed specifically for academia and publishing. It compares submitted documents to a vast database of web pages, journals, and books to identify potential instances of plagiarism and AI-generated content triggers.</p>
          </div>
          <div class="service-card">
            <div class="service-card__icon">W</div>
            <h3 class="service-card__title">Who Can Use It?</h3>
            <p class="service-card__desc">Students, researchers, and faculty members are welcome to utilize this service to ensure their work is free from plagiarism and AI-generated content prior to submission.</p>
          </div>
        </div>

        <div class="callout" style="margin-top:28px;">
          <strong>How to Access:</strong> To check your manuscript, simply send your document to <a href="mailto:plagiarismchecker@yenepoya.edu.in" class="link-primary fw-bold">plagiarismchecker@yenepoya.edu.in</a>. Our team will review the file and provide a detailed similarity report based on iThenticate’s findings.
        </div>

        <h3 style="margin-top:28px;margin-bottom:14px;font-size:16px;font-weight:700;color:var(--clr-primary);">Service Guidelines</h3>
        <ul class="content-list">
          <li><strong>Faculty Manuscripts:</strong> Free for research and publication manuscripts affiliated with Yenepoya University (Unlimited detections).</li>
          <li><strong>PG/PhD Thesis:</strong> Mandatory to check using iThenticate. Plagiarism certificate issued by the Central Library upon evaluation threshold compliance.</li>
        </ul>
      </section>

      <!-- 3. Reference Management Software -->
      <section class="page-section" id="reference-management" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Research Tools</div>
          <h2 class="page-section__title">Reference Management Software</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>Simplify your research with Reference Management Tools. Efficient and accurate reference management is crucial for academic and professional research. Our Central Library provides guidance and support for various reference management software that help you streamline the process of organizing, citing, and sharing references.</p>

        <h3 style="margin-top:28px;margin-bottom:14px;font-size:16px;font-weight:700;color:var(--clr-primary);">Popular Tools We Support</h3>
        <ul class="content-list">
          <li><strong>Mendeley:</strong> A versatile tool for organizing research, managing PDFs, and generating citations easily. Also offers collaborative features for group projects.</li>
          <li><strong>Zotero:</strong> An open-source reference manager that integrates seamlessly with your browser, enabling you to collect and organize sources directly from the web.</li>
        </ul>

         <div class="callout" style="border-left-color: #f39c12;">
          <strong>Need Help?</strong> For personalized support or to learn more about these tools, email us at <a href="mailto:researchsupport@yenepoya.edu.in" class="link-primary fw-bold">researchsupport@yenepoya.edu.in</a> or visit the Central Library for hands-on assistance.
        </div>
      </section>

      <!-- 4. Full-text Article Request -->
      <section class="page-section" id="article-request" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Full-text requests</div>
          <h2 class="page-section__title">Full-Text Article Request Service</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>The Central Library provides full-text article request services specifically tailored to support research scholars and faculty members. The articles not available in the library collections can be provided through the document delivery service of **DELNET** institutional network aggregates securely.</p>
        
        <p style="margin-top:24px;">
          <a href="mailto:articlerequest@yenepoya.edu.in?subject=Full-Text Article Request" class="btn btn--primary">
             Email Request to: articlerequest@yenepoya.edu.in
          </a>
        </p>
      </section>

      <!-- 5. UGC-CARE Indexed Journals -->
      <section class="page-section" id="ugc-care" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Metrics & Visibility</div>
          <h2 class="page-section__title">UGC-CARE Indexed Journals</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>The UGC provides a vetted list of journals that maintain quality and integrity. The library grants access and navigation tips to accessing CARE approved journals to prevent submission failures into predatory publishers circles setups.</p>

        <div class="info-grid">
          <div class="info-box">
            <div class="info-box__label">Group I</div>
            <div class="info-box__value">Journals found qualified through UGC-CARE protocols</div>
          </div>
          <div class="info-box">
            <div class="info-box__label">Group II</div>
            <div class="info-box__value">Journals indexed in globally recognized databases (Scopus, WoS)</div>
          </div>
        </div>
      </section>

      <!-- 6. Journals Selection Service For Publication -->
      <section class="page-section" id="journal-selection" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Author Consultation</div>
          <h2 class="page-section__title">Journals Selection Service For Publication</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>Selecting the right journal is crucial for maximum impact and indexing certainty. The library consultations team guides scholars through matching their paper abstracts with highly rated, SCOPUS/WoS matched publishers securing maximum exposure setups securely.</p>
      </section>

      <!-- 7. Bibliometrics -->
      <section class="page-section" id="bibliometrics" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Citation Analytics</div>
          <h2 class="page-section__title">Bibliometrics & Analytics</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>The Central Library collects aggregates and provides dashboard reporting monitoring outputs setup effectively framing research citation tracking rule aggregates securely.</p>
        
        <div class="info-grid">
          <div class="info-box">
            <div class="info-box__label">Tools supported</div>
            <div class="info-box__value">Web of Science, Scopus</div>
          </div>
          <div class="info-box">
            <div class="info-box__label">Impact Aggregates</div>
            <div class="info-box__value">h-Index, i10-Index, Impact Factor</div>
          </div>
        </div>
      </section>

      <!-- 8. Research Support Handbook -->
      <section class="page-section" id="handbook" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Guidelines Manual</div>
          <h2 class="page-section__title">Research Support Handbook</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>The complete, printable reference manual outlining all support desk guidelines, Turnitin submission guidelines, metrics analysis aggregates guidelines for scholarly success templates setup seamlessly framed.</p>
        
        <p style="margin-top:24px;">
          <a href="#" class="btn btn--outline">
             Download Support Handbook (PDF)
          </a>
        </p>
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
          <p>Central hub of information for Yenepoya (Deemed to be University). Providing library and information services to 8,000+ users since 1992.</p>
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
        <span>© 2026 <strong>Yenepoya (Deemed to be University)</strong>. All Rights Reserved.</span>
      </div>
    </div>
  </footer>

  <script src="assets/js/main.js"></script>
  <script src="assets/js/enhancements.js"></script>

  <!-- ═══════════════ SIDEBAR ENQUIRY ═══════════ -->
  <?php include 'components/enquiry.php'; ?>

  <!-- ═══════════════ NOTIFICATION SIDEBAR ═════════ -->
  <?php include 'components/notifications.php'; ?>

</body>
</html>








