<?php require_once 'db.php'; ?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Resources | Yenepoya Libraries</title>
  <meta name="description"
    content="Access our extensive collection of digital databases, journals, e-books, and open-access materials at Yenepoya Libraries.">
  <link rel="icon" href="assets/images/favicon.jpg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <style>
    /* E-RESOURCES specific tweaks */
    .resource-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 20px;
      margin-top: 20px;
    }

    .resource-card {
      background: #ffffff;
      border: 1px solid var(--clr-border);
      border-radius: var(--radius-md);
      padding: 20px;
      display: flex;
      gap: 20px;
      transition: all 0.3s ease;
      align-items: center;
    }

    .resource-card:hover {
      border-color: var(--clr-accent);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
      transform: translateY(-2px);
    }

    .resource-card__img {
      width: 120px;
      height: 80px;
      object-fit: contain;
      flex-shrink: 0;
    }

    .resource-card__content {
      flex: 1;
    }

    .resource-card__title {
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--clr-primary);
      margin-bottom: 5px;
      text-decoration: none;
    }

    .resource-card__subtitle {
      font-size: 0.9rem;
      color: var(--clr-text-muted);
      margin-bottom: 8px;
      font-weight: 600;
    }

    .resource-card__text {
      font-size: 0.85rem;
      color: var(--clr-text);
      line-height: 1.5;
    }

    .open-access-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
      gap: 15px;
      margin-top: 20px;
    }

    .oa-card {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      padding: 20px 15px;
      border: 1px solid var(--clr-border);
      border-radius: var(--radius-md);
      background: #fff;
      transition: all 0.3s ease;
      text-decoration: none;
    }

    .oa-card:hover {
      border-color: var(--clr-accent);
      transform: translateY(-4px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    }

    .oa-card img {
      height: 50px;
      width: auto;
      object-fit: contain;
      margin-bottom: 12px;
    }

    .oa-card span {
      font-size: 0.85rem;
      font-weight: 700;
      color: var(--clr-primary);
    }
  </style>
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
      <a href="about.php" class="nav__link">About</a>
      <a href="services.php" class="nav__link">Services</a>
      <a href="e-resources.php" class="nav__link active">E-Resources</a>
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
    <a href="about.php" class="nav__link">About</a>
    <a href="services.php" class="nav__link">Services</a>
    <a href="e-resources.php" class="nav__link active">E-Resources</a>
    <a href="repository.php" class="nav__link">Repository</a>
    <a href="research.php" class="nav__link">Research</a>
    <a href="events.php" class="nav__link">Events</a>
    <a href="contact.php" class="nav__link">Contact</a>
  </nav>

  <!-- PAGE HERO -->
  <div class="page-hero" style="background-image: linear-gradient(rgba(16, 28, 56, 0.75), rgba(16, 28, 56, 0.75)), url('images/hero-bg2.png'); background-size: cover; background-position: center;"images/banners/Online Databases.webp'); background-size: cover; background-position: center;">
    <div class="page-hero__inner">
      <div class="page-hero__breadcrumb">
        <a href="index.php">Home</a>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="m9 18 6-6-6-6" />
        </svg>
        <span>E-Resources</span>
      </div>
      <h1 class="page-hero__title">Electronic Resources</h1>
      <p class="page-hero__subtitle">Access a vast digital universe of knowledge, from premium academic databases and
        peer-reviewed journals to comprehensive e-book collections.</p>
    </div>
  </div>

  <div class="inner-layout">

    <!-- SIDEBAR -->
    <aside class="page-sidebar" aria-label="E-Resources navigation">
      <div class="page-sidebar__title">E-Resources</div>
      <nav class="page-sidebar__nav">
        <a href="#online-databases" class="page-sidebar__link active">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <ellipse cx="12" cy="5" rx="9" ry="3" />
            <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3" />
            <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5" />
          </svg>
          Online Databases
        </a>
        <a href="#e-journals" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
          </svg>
          E-Journals
        </a>
        <a href="#e-books" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
          </svg>
          E-Books Collections
        </a>
        <a href="#coursewise-ebooks" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="m16 6 4 14" />
            <path d="M12 6v14" />
            <path d="M8 8v12" />
            <path d="M4 4v16" />
          </svg>
          Course Wise E-Books
        </a>
        <a href="#newspapers-magazines" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path
              d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2" />
            <path d="M18 14h-8" />
            <path d="M15 18h-5" />
            <path d="M10 6h8v4h-8V6Z" />
          </svg>
          E-Newspapers & Magazines
        </a>
        <a href="#other-resources" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 2H2v10h10V2z" />
            <path d="M22 2h-10v10h10V2z" />
            <path d="M12 12H2v10h10V12z" />
            <path d="M22 12h-10v10h10V12z" />
          </svg>
          Other Electronic Resources
        </a>
        <a href="#open-access" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
            <path d="M7 11V7a5 5 0 0 1 9.9-1" />
          </svg>
          Open Access Resources
        </a>
      </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="page-content" id="main">

              <!-- Default View -->
        <section class="page-section" id="default-view">
          <div class="page-section__header">
            <div class="page-section__label">Knowledge Portal</div>
            <h2 class="page-section__title">Yenepoya Library E-Resources</h2>
            <div class="page-section__divider"></div>
          </div>
          <div class="content-block">

            <div style="background: linear-gradient(135deg, var(--clr-primary), var(--clr-primary-dk)); border-radius: 12px; padding: 24px; color: #fff; margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
              <div style="flex: 1; min-width: 250px;">
                <h3 style="color: #fff; margin-bottom: 8px; font-weight: 700;">Remote (Off-Campus) Access</h3>
                <p style="margin: 0; font-size: 15px; opacity: 0.9;">Access all our E-Journals, E-Books, and Databases 24x7 from anywhere through our secure remote access portals.</p>
              </div>
              <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="https://app.myloft.xyz/user/login?institute=ckp6jp0d6km6t0a2446c6v30c" target="_blank" style="background: #fff; color: var(--clr-primary); padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: transform 0.2s;">Login via MyLOFT</a>
                <a href="https://forms.gle/4ezioAY7YQZicoKs8" target="_blank" style="background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.3); padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: background 0.2s;">Knimbus Registration</a>
              </div>
            </div>

            <p class="lead">Welcome to the Yenepoya Libraries E-Resources portal. We provide comprehensive access to a vast collection of academic and research materials through various digital platforms including ClinicalKey, ProQuest, and multiple national consortiums.</p>
            <p>Please select a category from the sidebar menu to explore available databases, journals, e-books, and open-access materials tailored to support your learning and research needs.</p>

            <div class="row g-4 mt-4">
              <div class="col-md-4">
                <div class="stat-card stat-card--primary text-center p-4 rounded bg-light border">
                  <i class="bi bi-database display-4 text-primary mb-3 block"></i>
                  <h3 class="h2 font-weight-bold mb-1">15+</h3>
                  <p class="text-muted mb-0">Premium Databases</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="stat-card stat-card--secondary text-center p-4 rounded bg-light border">
                  <i class="bi bi-journal-check display-4 text-secondary mb-3 block"></i>
                  <h3 class="h2 font-weight-bold mb-1">5000+</h3>
                  <p class="text-muted mb-0">E-Journals</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="stat-card stat-card--accent text-center p-4 rounded bg-light border">
                  <i class="bi bi-book-half display-4 text-warning mb-3 block"></i>
                  <h3 class="h2 font-weight-bold mb-1">1000s</h3>
                  <p class="text-muted mb-0">E-Books Available</p>
                </div>
              </div>
            </div>
            
            <div style="margin-top: 32px; border: 1px solid var(--clr-border); padding: 20px; border-radius: 12px; background: #fafafa;">
              <h4 style="font-size: 16px; margin-bottom: 12px; color: var(--clr-primary-dk); font-weight: 700;">Library Consortia & Memberships</h4>
              <p style="font-size: 14px; margin-bottom: 0; color: var(--clr-text-main);">Yenepoya (Deemed to be University) proudly holds active memberships with the <strong>National Cancer Grid (NCG)</strong>, <strong>National Digital Library (NDL)</strong>, <strong>HELINET</strong> (Rajiv Gandhi University of Health Sciences), and <strong>DELNET</strong> to enable extensive resource sharing.</p>
            </div>
          </div>
        </section>

                <!-- 1. Online Databases -->
      <section class="page-section" id="online-databases" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Research Tools</div>
          <h2 class="page-section__title">Subscribed Online Databases</h2>
          <div class="page-section__divider"></div>
        </div>

        <div class="resource-grid" id="database-grid">
          <?php
          $q_db = mysqli_query($conn, "SELECT * FROM e_resources WHERE category='database' AND visible=1 ORDER BY sort_order ASC, created_at DESC");
          if(mysqli_num_rows($q_db) > 0):
             while($row = mysqli_fetch_assoc($q_db)):
               $fc = strtoupper(substr($row['title'],0,1));
          ?>
          <div class="resource-card">
            <div class="resource-card__img" style="background:#f1f5f9;border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:32px;font-weight:800;color:var(--clr-primary);width:120px;height:80px;"><?php echo $fc; ?></div>
            <div class="resource-card__content">
              <a href="<?php echo htmlspecialchars($row['access_url']); ?>" class="resource-card__title" target="_blank"><?php echo htmlspecialchars($row['title']); ?></a>
              <?php if($row['provider']): ?><div class="resource-card__subtitle"><?php echo htmlspecialchars($row['provider']); ?></div><?php endif; ?>
              <p class="resource-card__text"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
            </div>
          </div>
          <?php endwhile; else: ?>
             <p style="padding:20px; color:#666;">No databases found.</p>
          <?php endif; ?>
        </div>
      </section>

      <!-- 2. E-Journals -->
      <section class="page-section" id="e-journals" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Publications</div>
          <h2 class="page-section__title">E-Journals</h2>
          <div class="page-section__divider"></div>
        </div>
        <div class="resource-grid">
          <?php
          $q_ej = mysqli_query($conn, "SELECT * FROM e_resources WHERE category='ejournal' AND visible=1 ORDER BY sort_order ASC, created_at DESC");
          if(mysqli_num_rows($q_ej) > 0):
             while($row = mysqli_fetch_assoc($q_ej)):
               $fc = strtoupper(substr($row['title'],0,1));
          ?>
          <div class="resource-card">
            <div class="resource-card__img" style="background:#fef3c7;border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:32px;font-weight:800;color:#d97706;width:120px;height:80px;"><?php echo $fc; ?></div>
            <div class="resource-card__content">
              <a href="<?php echo htmlspecialchars($row['access_url']); ?>" class="resource-card__title" target="_blank"><?php echo htmlspecialchars($row['title']); ?></a>
              <p class="resource-card__text"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
            </div>
          </div>
          <?php endwhile; else: ?>
             <p style="padding:20px; color:#666;">No e-journals found.</p>
          <?php endif; ?>
        </div>
      </section>

      <!-- 3. E-Books -->
      <section class="page-section" id="e-books" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Digital Libary</div>
          <h2 class="page-section__title">E-Books Collections</h2>
          <div class="page-section__divider"></div>
        </div>
        <div class="resource-grid">
          <?php
          $q_eb = mysqli_query($conn, "SELECT * FROM e_resources WHERE category='ebook' AND visible=1 ORDER BY sort_order ASC, created_at DESC");
          if(mysqli_num_rows($q_eb) > 0):
             while($row = mysqli_fetch_assoc($q_eb)):
               $fc = strtoupper(substr($row['title'],0,1));
          ?>
          <div class="resource-card">
            <div class="resource-card__img" style="background:#e0e7ff;border-radius:4px;display:flex;align-items:center;justify-content:center;font-size:32px;font-weight:800;color:#4f46e5;width:120px;height:80px;"><?php echo $fc; ?></div>
            <div class="resource-card__content">
              <a href="<?php echo htmlspecialchars($row['access_url']); ?>" class="resource-card__title" target="_blank"><?php echo htmlspecialchars($row['title']); ?></a>
              <?php if($row['provider']): ?><div class="resource-card__subtitle"><?php echo htmlspecialchars($row['provider']); ?></div><?php endif; ?>
              <p class="resource-card__text"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
            </div>
          </div>
          <?php endwhile; else: ?>
             <p style="padding:20px; color:#666;">No e-books found.</p>
          <?php endif; ?>
        </div>
      </section>

            <!-- 4. Coursewise E-Books -->
      <section class="page-section" id="coursewise-ebooks" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Curriculum Books</div>
          <h2 class="page-section__title">Course Wise E-Books</h2>
          <div class="page-section__divider"></div>
        </div>
        <p class="mb-4">Select your college to view prescribed digital textbooks for your courses.</p>
        
        <!-- Internal Filters -->
        <div class="course-filters" style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 24px;">
          <button class="btn btn--primary filter-btn active" onclick="filterCourse('ymc', this)" style="padding: 8px 16px; font-size: 13px; border-radius: 20px;">Medical College</button>
          <button class="btn btn--outline filter-btn" onclick="filterCourse('ydc', this)" style="padding: 8px 16px; font-size: 13px; border-radius: 20px;">Dental College</button>
          <button class="btn btn--outline filter-btn" onclick="filterCourse('ync', this)" style="padding: 8px 16px; font-size: 13px; border-radius: 20px;">Nursing College</button>
          <button class="btn btn--outline filter-btn" onclick="filterCourse('ypc', this)" style="padding: 8px 16px; font-size: 13px; border-radius: 20px;">Physiotherapy College</button>
        </div>

        <!-- Medical College Books -->
        <div class="open-access-grid course-grid active" id="grid-ymc">
          <a href="https://opac.yenepoya.edu.in/cgi-bin/koha/opac-search.pl?q=anatomy" target="_blank" class="oa-card">
            <img src="images/e-books/ymc-e-book1.jpg" alt="Medical Book 1">
            <span>Anatomy</span>
          </a>
          <a href="https://opac.yenepoya.edu.in/cgi-bin/koha/opac-search.pl?q=biochemistry" target="_blank" class="oa-card">
            <img src="images/e-books/ymc-e-book2.jpg" alt="Medical Book 2">
            <span>Biochemistry</span>
          </a>
          <a href="https://opac.yenepoya.edu.in/cgi-bin/koha/opac-search.pl?q=pathology" target="_blank" class="oa-card">
            <img src="images/e-books/ymc-e-book3.jpg" alt="Medical Book 3">
            <span>Pathology</span>
          </a>
          <a href="https://opac.yenepoya.edu.in/cgi-bin/koha/opac-search.pl?q=pharmacology" target="_blank" class="oa-card">
            <img src="images/e-books/ymc-e-book4.jpg" alt="Medical Book 4">
            <span>Pharmacology</span>
          </a>
          <a href="https://opac.yenepoya.edu.in/cgi-bin/koha/opac-search.pl?q=microbiology" target="_blank" class="oa-card">
            <img src="images/e-books/ymc-e-book5.jpg" alt="Medical Book 5">
            <span>Microbiology</span>
          </a>
        </div>

        <!-- Dental College Books -->
        <div class="open-access-grid course-grid" id="grid-ydc" style="display: none;">
          <a href="https://opac.yenepoya.edu.in/cgi-bin/koha/opac-search.pl?q=oral+medicine" target="_blank" class="oa-card">
            <img src="images/e-books/ydc-e-book1.jpg" alt="Dental Book 1">
            <span>Oral Medicine</span>
          </a>
          <a href="https://opac.yenepoya.edu.in/cgi-bin/koha/opac-search.pl?q=dental+surgery" target="_blank" class="oa-card">
            <img src="images/e-books/ydc-e-book2.jpg" alt="Dental Book 2">
            <span>Dental Surgery</span>
          </a>
          <a href="https://opac.yenepoya.edu.in/cgi-bin/koha/opac-search.pl?q=orthodontics" target="_blank" class="oa-card">
            <img src="images/e-books/ydc-e-book3.jpg" alt="Dental Book 3">
            <span>Orthodontics</span>
          </a>
          <a href="https://opac.yenepoya.edu.in/cgi-bin/koha/opac-search.pl?q=periodontics" target="_blank" class="oa-card">
            <img src="images/e-books/ydc-e-book4.jpg" alt="Dental Book 4">
            <span>Periodontics</span>
          </a>
        </div>

        <!-- Nursing College Books -->
        <div class="open-access-grid course-grid" id="grid-ync" style="display: none;">
          <div style="grid-column: 1 / -1; padding: 30px; text-align: center; background: var(--clr-bg); border-radius: 8px; border: 1 dashed var(--clr-border);">
            <p style="margin:0; color: var(--clr-text-muted);">Nursing e-books catalogue integration pending.</p>
          </div>
        </div>

        <!-- Physiotherapy College Books -->
        <div class="open-access-grid course-grid" id="grid-ypc" style="display: none;">
          <div style="grid-column: 1 / -1; padding: 30px; text-align: center; background: var(--clr-bg); border-radius: 8px; border: 1 dashed var(--clr-border);">
            <p style="margin:0; color: var(--clr-text-muted);">Physiotherapy e-books catalogue integration pending.</p>
          </div>
        </div>

        
  <!-- ═══════════════ NOTIFICATION SIDEBAR ═════════ -->
  <?php include 'components/notifications.php'; ?>

  <script>
          function filterCourse(collegeId, btn) {
            // Hide all grids
            document.querySelectorAll('.course-grid').forEach(grid => {
              grid.style.display = 'none';
            });
            // Reset button styles
            document.querySelectorAll('.filter-btn').forEach(b => {
              b.classList.remove('btn--primary');
              b.classList.add('btn--outline');
            });
            // Show selected grid
            document.getElementById('grid-' + collegeId).style.display = 'grid';
            // Set active button
            btn.classList.remove('btn--outline');
            btn.classList.add('btn--primary');
          }
        </script>
      </section>

      <!-- 5. E-Newspapers & Magazines -->
      <section class="page-section" id="newspapers-magazines" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Periodicals</div>
          <h2 class="page-section__title">E-Newspapers & Magazines</h2>
          <div class="page-section__divider"></div>
        </div>
        <div class="resource-grid">
           <div class="resource-card">
            <img src="images/edzter/userManual.png" style="height:80px; object-fit:contain;" class="resource-card__img" alt="Edzter">
            <div class="resource-card__content">
              <a href="https://www.edzter.com/" class="resource-card__title" target="_blank">EDZTER</a>
              <div class="resource-card__subtitle">Digital Newsstand</div>
              <p class="resource-card__text">Access over 5,000+ top magazines, newspapers and journals globally.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- 6. Other Electronic Resources -->
      <section class="page-section" id="other-resources" style="display:none;">
        <div class="page-section__header">
           <h2 class="page-section__title">Other Electronic Resources</h2>
           <div class="page-section__divider"></div>
        </div>
        <div class="open-access-grid">
          <a href="https://ndl.iitkgp.ac.in/" target="_blank" class="oa-card">
            <img src="images/opendb/National-Digital-Library-of-India.jpg" alt="NDLI">
            <span>NDLI</span>
          </a>
          <a href="https://delnet.in/" target="_blank" class="oa-card">
            <img src="images/open-access/Delnet-logo.jpg" alt="DELNET">
            <span>DELNET</span>
          </a>
          <a href="https://jgateplus.com/" target="_blank" class="oa-card">
            <img src="images/opendb/Akshara-J gateplus.webp" alt="J-Gate">
            <span>J-Gate Plus</span>
          </a>
        </div>
      </section>

      <!-- 7. Open Access Resources -->
      <section class="page-section" id="open-access" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Free Access</div>
          <h2 class="page-section__title">Open Access Resources</h2>
          <div class="page-section__divider"></div>
        </div>
        <div class="open-access-grid">
          <?php
          $q_oa = mysqli_query($conn, "SELECT * FROM e_resources WHERE category='openaccess' AND visible=1 ORDER BY sort_order ASC, created_at DESC");
          if(mysqli_num_rows($q_oa) > 0):
             while($row = mysqli_fetch_assoc($q_oa)):
          ?>
          <a href="<?php echo htmlspecialchars($row['access_url']); ?>" target="_blank" class="oa-card">
            <div style="width:50px;height:50px;border-radius:50%;background:#dcfce7;color:#16a34a;display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:700;margin-bottom:12px;"><?php echo strtoupper(substr($row['title'],0,1)); ?></div>
            <span><?php echo htmlspecialchars($row['title']); ?></span>
          </a>
          <?php endwhile; else: ?>
             <p style="padding:20px; color:#666; grid-column:1/-1;">No open access resources found.</p>
          <?php endif; ?>
        </div>
        <p class="mt-4 text-muted" style="font-size:0.9rem;">Many of these resources are sponsored by the Ministry of Education (MoE) and other government bodies.</p>
      </section>
    </main> <!-- end page-content -->
  </div> <!-- end inner-layout -->

  <footer class="footer">
    <div class="footer__top">
      <div class="footer__grid">
        <div class="footer__brand">
          <div class="footer__brand-logo">
            <img src="https://library.yenepoya.edu.in/images/Central-Library-logo.png" alt="Yenepoya Libraries">
            <span style="font-weight:800;font-size:18px;color:#fff;letter-spacing:-.2px;">Yenepoya Libraries</span>
          </div>
          <p class="footer__desc">Dedicated to excellence in information retrieval and academic support, providing the
            foundation for research and clinical practice at Yenepoya University.</p>
          <div class="footer__social">
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
        <div>
          <div class="footer__col-title">Quick Links</div>
          <div class="footer__links">
            <a href="index.php">Home</a>
            <a href="about.php">About Library</a>
            <a href="services.php">Library Services</a>
            <a href="e-resources.php">E-Resources</a>
            <a href="repository.php">Repository</a>
          </div>
        </div>
        <div>
          <div class="footer__col-title">Constituent Units</div>
          <div class="footer__links">
            <a href="https://www.ymc.yenepoya.edu.in" target="_blank">Medical College</a>
            <a href="https://www.ydc.yenepoya.edu.in" target="_blank">Dental College</a>
            <a href="https://www.ync.yenepoya.edu.in" target="_blank">Nursing College</a>
            <a href="https://www.ypt.yenepoya.edu.in" target="_blank">Physiotherapy College</a>
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

  <!-- ENQUIRY SIDEBAR -->
  <?php include 'components/enquiry.php'; ?>

  <script src="assets/js/main.js"></script>
</body>

</html>













