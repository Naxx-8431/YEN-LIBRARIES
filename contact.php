<?php
/**
 * ═══════════════════════════════════════════════════════════
 * CONTACT PAGE — Form Handling
 * ═══════════════════════════════════════════════════════════
 * 
 * This page handles 3 form submissions:
 * 1. Ask a Librarian (contact message)
 * 2. Recommend a Book
 * 3. Recommend a Journal
 * 
 * Each form submits to THIS SAME PAGE using method="POST".
 * The PHP code at the top processes the form BEFORE any HTML is output.
 */

// Include database connection
require_once 'db.php';

$success_msg = "";
$error_msg = "";
$active_section = "ask-librarian"; // Which section to show after submit

// ─── FORM 1: Ask a Librarian (Contact Message) ─────────────
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_contact'])) {
    $name    = clean($conn, $_POST['name']);
    $email   = clean($conn, $_POST['email']);
    $subject = clean($conn, $_POST['subject']);
    $message = clean($conn, $_POST['message']);
    
    // Validate
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error_msg = "All fields are required.";
    } else {
        // INSERT into contacts table
        $query = "INSERT INTO contacts (name, email, subject, message) 
                  VALUES ('$name', '$email', '$subject', '$message')";
        if (mysqli_query($conn, $query)) {
            $success_msg = "Your message has been sent successfully! We will respond shortly.";
        } else {
            $error_msg = "Error sending message. Please try again.";
        }
    }
    $active_section = "ask-librarian";
}

// ─── FORM 2: Recommend a Book ───────────────────────────────
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_book'])) {
    $title         = clean($conn, $_POST['title']);
    $author        = clean($conn, $_POST['author']);
    $publisher     = clean($conn, $_POST['publisher']);
    $edition       = clean($conn, $_POST['edition']);
    $yop           = clean($conn, $_POST['yop']);
    $noc           = (int)($_POST['noc'] ?? 1);
    $message       = clean($conn, $_POST['message']);
    $recommendedby = clean($conn, $_POST['recommendedby']);
    $name          = clean($conn, $_POST['name']);
    $campus_id     = clean($conn, $_POST['campus_id']);
    $course        = clean($conn, $_POST['course']);
    $college       = clean($conn, $_POST['college']);
    
    if (empty($title) || empty($author) || empty($name)) {
        $error_msg = "Book title, author, and your name are required.";
    } else {
        $query = "INSERT INTO book_recommendations (title, author, publisher, edition, year_of_pub, num_copies, reason, recommended_by, requester_name, campus_id, course, college) 
                  VALUES ('$title', '$author', '$publisher', '$edition', '$yop', $noc, '$message', '$recommendedby', '$name', '$campus_id', '$course', '$college')";
        if (mysqli_query($conn, $query)) {
            $success_msg = "Your book recommendation has been submitted! The acquisition team will review it.";
        } else {
            $error_msg = "Error submitting recommendation.";
        }
    }
    $active_section = "recommend-book";
}

// ─── FORM 3: Recommend a Journal ────────────────────────────
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_journal'])) {
    $title         = clean($conn, $_POST['title']);
    $typeofjournal = clean($conn, $_POST['typeofjournal']);
    $publisher     = clean($conn, $_POST['publisher']);
    $issn          = clean($conn, $_POST['issn']);
    $description   = clean($conn, $_POST['description']);
    
    if (empty($title) || empty($publisher)) {
        $error_msg = "Journal title and publisher are required.";
    } else {
        $query = "INSERT INTO journal_recommendations (title, type_of_journal, publisher, issn, description) 
                  VALUES ('$title', '$typeofjournal', '$publisher', '$issn', '$description')";
        if (mysqli_query($conn, $query)) {
            $success_msg = "Your journal recommendation has been submitted for review!";
        } else {
            $error_msg = "Error submitting recommendation.";
        }
    }
    $active_section = "recommend-journal";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact & Requests | Yenepoya Libraries</title>
  <meta name="description"
    content="Contact Yenepoya Libraries immediately. Ask a Librarian, recommend books and journals, or provide critical institutional feedback gracefully securely.">
  <link rel="icon" href="assets/images/favicon.jpg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <style>
    /* Premium Form Styling */
    .contact-form {
      background: var(--clr-surface);
      padding: 32px;
      border-radius: 12px;
      border: 1px solid var(--clr-border);
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
      margin-top: 24px;
    }

    .form-group {
      margin-bottom: 24px;
    }

    .form-control {
      width: 100%;
      padding: 16px 20px;
      font-family: 'Inter', sans-serif;
      font-size: 1rem;
      border: 1px solid var(--clr-border);
      border-radius: 8px;
      background-color: var(--clr-surface-alt);
      color: var(--clr-text);
      transition: all 0.2s ease;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--clr-primary);
      background-color: var(--clr-surface);
      box-shadow: 0 0 0 4px rgba(40, 59, 106, 0.1);
    }

    .form-control::placeholder {
      color: #9aa0ac;
    }

    .btn-submit {
      background: var(--clr-accent);
      color: #ffffff;
      font-weight: 700;
      font-size: 1.05rem;
      padding: 16px 36px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 12px;
      transition: all 0.2s ease;
    }

    .btn-submit:hover {
      background: #48c4b9;
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(89, 204, 193, 0.3);
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 24px;
    }

    textarea.form-control {
      resize: vertical;
      min-height: 140px;
    }

    @media (max-width: 768px) {
      .form-grid {
        grid-template-columns: 1fr;
        gap: 16px;
      }
      .contact-form {
        padding: 24px 16px;
      }
    }

    /* Contact Info Cards */
    .contact-info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
      margin-bottom: 32px;
    }

    .contact-info-card {
      display: flex;
      align-items: flex-start;
      gap: 16px;
      padding: 24px;
      background: var(--clr-surface-alt);
      border-radius: 12px;
      border: 1px solid var(--clr-border);
      transition: transform 0.2s ease;
    }

    .contact-info-card:hover {
      transform: translateY(-2px);
    }

    .contact-info-card svg {
      width: 28px;
      height: 28px;
      color: var(--clr-primary);
      flex-shrink: 0;
      background: rgba(40, 59, 106, 0.1);
      padding: 12px;
      border-radius: 12px;
      width: 52px;
      height: 52px;
    }

    .contact-info-content h4 {
      margin: 0 0 6px 0;
      font-size: 1.1rem;
      color: var(--clr-text-title);
    }

    .contact-info-content p, .contact-info-content a {
      margin: 0;
      color: var(--clr-text-secondary);
      line-height: 1.5;
      text-decoration: none;
      font-size: 0.95rem;
    }

    .contact-info-content a:hover {
      color: var(--clr-primary);
      text-decoration: underline;
    }
    
    /* Feedback specific styling */
    .feedback-banner {
      background: linear-gradient(135deg, var(--clr-primary), #1a2544);
      border-radius: 12px;
      padding: 48px 32px;
      text-align: center;
      color: white;
      margin-top: 24px;
    }
    
    .feedback-banner h3 {
      font-size: 2rem;
      font-weight: 800;
      margin-bottom: 16px;
      color: white;
    }
    
    .feedback-banner p {
      font-size: 1.1rem;
      opacity: 0.9;
      max-width: 600px;
      margin: 0 auto 32px auto;
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
      <a href="events.php" class="nav__link">Events</a>
      <a href="contact.php" class="nav__link active">Contact</a>
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
    <a href="research.php" class="nav__link">Research</a>
    <a href="events.php" class="nav__link">Events</a>
    <a href="contact.php" class="nav__link active">Contact</a>
  </nav>

  <!-- ═══════════════ PAGE HERO ═════════════════ -->
  <div class="page-hero" style="background-image: linear-gradient(rgba(16, 28, 56, 0.75), rgba(16, 28, 56, 0.75)), url('images/hero-bg3.png'); background-size: cover; background-position: center;"images/banners/Contact%20Us.webp'); background-size: cover; background-position: center;">
    <div class="page-hero__inner">
      <div class="page-hero__breadcrumb">
        <a href="index.php">Home</a>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="m9 18 6-6-6-6" />
        </svg>
        <span>Contact & Support</span>
      </div>
      <h1 class="page-hero__title">Contact & Feedback</h1>
      <p class="page-hero__subtitle">Your queries, recommendations, and feedback are integral to our collection growth.</p>
    </div>
  </div>

  <!-- ═══════════════ INNER LAYOUT ═══════════════ -->
  <div class="inner-layout">

    <!-- SIDEBAR -->
    <aside class="page-sidebar" aria-label="Contact navigation">
      <div class="page-sidebar__title">Get In Touch</div>
      <nav class="page-sidebar__nav">
        <a href="#ask-librarian" class="page-sidebar__link active">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
          </svg>
          Ask a Librarian
        </a>
        <a href="#recommend-book" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
          </svg>
          Recommend a Book
        </a>
        <a href="#recommend-journal" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
             <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
             <polyline points="14 2 14 8 20 8" />
             <line x1="16" y1="13" x2="8" y2="13" />
             <line x1="16" y1="17" x2="8" y2="17" />
             <polyline points="10 9 9 9 8 9" />
          </svg>
          Recommend a Journal
        </a>
        <a href="#give-feedback" class="page-sidebar__link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
             <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
          </svg>
          Give us Feedback
        </a>
      </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="page-content" id="main">

      <!-- 1. Ask a Librarian -->
      <section class="page-section active" id="ask-librarian">
        <div class="page-section__header">
          <div class="page-section__label">Help Desk</div>
          <h2 class="page-section__title">Contact Information</h2>
          <div class="page-section__divider"></div>
        </div>
        
        <div class="contact-info-grid">
          <!-- Location -->
          <div class="contact-info-card">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
              <circle cx="12" cy="10" r="3" />
            </svg>
            <div class="contact-info-content">
              <h4>Location</h4>
              <p>University Road Deralakatte Mangalore 575018</p>
            </div>
          </div>
          
          <!-- Email -->
          <div class="contact-info-card">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="4" width="20" height="16" rx="2" />
              <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
            </svg>
            <div class="contact-info-content">
              <h4>Email Administration</h4>
              <a href="mailto:reachus@yenepoya.edu.in">reachus@yenepoya.edu.in</a><br>
              <a href="mailto:library@yenepoya.edu.in">library@yenepoya.edu.in</a>
            </div>
          </div>

          <!-- Phone -->
          <div class="contact-info-card">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.15 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.06 1.2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16z" />
            </svg>
            <div class="contact-info-content">
              <h4>Direct Call</h4>
              <p>Enquiry: 09686985055<br>Support: 0824-2206067</p>
            </div>
          </div>
        </div>

        <h3 style="margin-top:28px;margin-bottom:14px;font-size:1.3rem;font-weight:700;color:var(--clr-primary);">Direct Inquiry Message</h3>
        <p>Send a direct message immediately to the Central Library administrative hub for instant routing.</p>

        <?php if ($active_section == 'ask-librarian' && !empty($success_msg)): ?>
          <div style="background:#dcfce7;color:#16a34a;padding:14px 20px;border-radius:8px;margin:16px 0;font-weight:500;"><?php echo $success_msg; ?></div>
        <?php elseif ($active_section == 'ask-librarian' && !empty($error_msg)): ?>
          <div style="background:#fee2e2;color:#dc2626;padding:14px 20px;border-radius:8px;margin:16px 0;font-weight:500;"><?php echo $error_msg; ?></div>
        <?php endif; ?>

        <form action="contact.php" method="post" class="contact-form">
          <div class="form-grid">
            <div class="form-group">
              <input type="text" name="name" class="form-control" placeholder="Your Name" required>
            </div>
            <div class="form-group">
              <input type="email" name="email" class="form-control" placeholder="Your Email" required>
            </div>
          </div>
          <div class="form-group">
            <input type="text" name="subject" class="form-control" placeholder="Message Subject" required>
          </div>
          <div class="form-group">
            <textarea name="message" class="form-control" placeholder="Detailed Message..." required></textarea>
          </div>
          <button type="submit" name="submit_contact" class="btn-submit">
            Send Message
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
            </svg>
          </button>
        </form>
      </section>

      <!-- 2. Recommend a Book -->
      <section class="page-section" id="recommend-book" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Acquisitions Menu</div>
          <h2 class="page-section__title">Recommend a Book</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>Submit textbook and literary requests directly into the procurement framework. Make sure to complete all required tracking nodes so faculties are correctly notified once materials arrive.</p>

        <?php if ($active_section == 'recommend-book' && !empty($success_msg)): ?>
          <div style="background:#dcfce7;color:#16a34a;padding:14px 20px;border-radius:8px;margin:16px 0;font-weight:500;"><?php echo $success_msg; ?></div>
        <?php elseif ($active_section == 'recommend-book' && !empty($error_msg)): ?>
          <div style="background:#fee2e2;color:#dc2626;padding:14px 20px;border-radius:8px;margin:16px 0;font-weight:500;"><?php echo $error_msg; ?></div>
        <?php endif; ?>

        <form action="contact.php" method="post" class="contact-form">
          <div class="form-grid">
            <div class="form-group">
              <input type="text" name="title" class="form-control" placeholder="Book Title" required>
            </div>
            <div class="form-group">
              <input type="text" name="author" class="form-control" placeholder="Author" required>
            </div>
            <div class="form-group">
              <input type="text" name="publisher" class="form-control" placeholder="Publisher" required>
            </div>
            <div class="form-group">
              <input type="text" name="edition" class="form-control" placeholder="Edition/Volume" required>
            </div>
            <div class="form-group">
              <input type="text" name="yop" class="form-control" placeholder="Year Of Publication" required>
            </div>
            <div class="form-group">
              <input type="text" name="noc" class="form-control" placeholder="Number Of Copies" required>
            </div>
          </div>
          
          <div class="form-group" style="margin-top: 16px;">
            <textarea name="message" class="form-control" placeholder="I think you would like this book because..." required></textarea>
          </div>

          <h3 style="margin-top:28px;margin-bottom:14px;font-size:1.1rem;font-weight:700;color:var(--clr-text-title);">Requester Information</h3>
          <div class="form-group">
            <input type="text" name="recommendedby" class="form-control" placeholder="Recommended by (Head of Dept / Name)" required>
          </div>
          <div class="form-grid">
            <div class="form-group">
              <input type="text" name="name" class="form-control" placeholder="Your Name" required>
            </div>
            <div class="form-group">
              <input type="text" name="campus_id" class="form-control" placeholder="Campus ID / Employee Code" required>
            </div>
            <div class="form-group">
              <input type="text" name="course" class="form-control" placeholder="Course / Designation" required>
            </div>
            <div class="form-group">
              <input type="text" name="college" class="form-control" placeholder="Department & College" required>
            </div>
          </div>
          
          <button type="submit" name="submit_book" class="btn-submit" style="margin-top:10px;">
            Submit Book Request
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
            </svg>
          </button>
        </form>
      </section>

      <!-- 3. Recommend a Journal -->
      <section class="page-section" id="recommend-journal" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Serials Request</div>
          <h2 class="page-section__title">Recommend a Journal</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>Propose the integration of pivotal academic journals and databases utilizing our subscription evaluation pipeline.</p>

        <?php if ($active_section == 'recommend-journal' && !empty($success_msg)): ?>
          <div style="background:#dcfce7;color:#16a34a;padding:14px 20px;border-radius:8px;margin:16px 0;font-weight:500;"><?php echo $success_msg; ?></div>
        <?php elseif ($active_section == 'recommend-journal' && !empty($error_msg)): ?>
          <div style="background:#fee2e2;color:#dc2626;padding:14px 20px;border-radius:8px;margin:16px 0;font-weight:500;"><?php echo $error_msg; ?></div>
        <?php endif; ?>

        <form action="contact.php" method="post" class="contact-form">
          <div class="form-grid">
            <div class="form-group">
              <input type="text" name="title" class="form-control" placeholder="Journal Title" required>
            </div>
            <div class="form-group">
              <input type="text" name="typeofjournal" class="form-control" placeholder="Type of Journal (Print / e-Journal)" required>
            </div>
            <div class="form-group">
              <input type="text" name="publisher" class="form-control" placeholder="Publisher" required>
            </div>
            <div class="form-group">
              <input type="text" name="issn" class="form-control" placeholder="ISSN Number" required>
            </div>
          </div>
          
          <div class="form-group" style="margin-top: 16px;">
            <textarea name="description" class="form-control" placeholder="Description of the journal and the reason you want us to subscribe globally..." required></textarea>
          </div>
          
          <button type="submit" name="submit_journal" class="btn-submit">
            Submit Journal Request
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
          </button>
        </form>
      </section>

      <!-- 4. Give Feedback -->
      <section class="page-section" id="give-feedback" style="display:none;">
        <div class="page-section__header">
          <div class="page-section__label">Continuous Optimization</div>
          <h2 class="page-section__title">Give us Feedback</h2>
          <div class="page-section__divider"></div>
        </div>
        <p>Your honest experience directly defines our technological expansions. Help us iterate and enhance Central Library logistics by leaving comprehensive experiential metrics securely.</p>

        <div class="feedback-banner">
          <h3>We value your voice!</h3>
          <p>Click below to seamlessly navigate to the universal library operations assessment framework structured securely on Google Forms.</p>
          <a href="https://tinyurl.com/LIBRARYFEDBCK" target="_blank" class="btn-submit" style="background:#59ccc1;color:#101c38;">
             Open Feedback Form Portal
             <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
               <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line>
             </svg>
          </a>
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
  <script>
    // ── Toast Notification for form submission feedback ──
    (function() {
      const url = new URL(window.location.href);
      const hash = url.hash;
      // Parse query params from hash (e.g. #ask-librarian?status=success&msg=...)
      if (hash && hash.includes('?')) {
        const parts = hash.split('?');
        const section = parts[0];
        const params = new URLSearchParams(parts[1]);
        const status = params.get('status');
        const msg = params.get('msg');

        if (status && msg) {
          // Show toast
          const toast = document.createElement('div');
          toast.className = 'form-toast form-toast--' + status;
          toast.innerHTML = `
            <span class="form-toast__icon">${status === 'success' ? '✓' : '✗'}</span>
            <span class="form-toast__msg">${msg}</span>
            <button class="form-toast__close" onclick="this.parentElement.remove()">×</button>
          `;
          document.body.appendChild(toast);
          setTimeout(() => toast.classList.add('show'), 50);
          setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 400); }, 6000);

          // Clean the URL
          history.replaceState(null, '', window.location.pathname + section);
        }
      }
    })();
  </script>
  <style>
    .form-toast {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 10000;
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 16px 24px;
      border-radius: 12px;
      font-family: 'Inter', sans-serif;
      font-size: 0.95rem;
      font-weight: 600;
      box-shadow: 0 8px 32px rgba(0,0,0,0.15);
      transform: translateX(120%);
      transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1);
      max-width: 420px;
    }
    .form-toast.show { transform: translateX(0); }
    .form-toast--success { background: #16a34a; color: #fff; }
    .form-toast--error { background: #dc2626; color: #fff; }
    .form-toast__icon { font-size: 1.3rem; }
    .form-toast__close {
      background: none; border: none; color: rgba(255,255,255,0.7);
      font-size: 1.4rem; cursor: pointer; margin-left: auto; padding: 0 0 0 12px;
    }
    .form-toast__close:hover { color: #fff; }
  </style>

</body>
</html>








