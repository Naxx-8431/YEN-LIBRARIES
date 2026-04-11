<?php
/**
 * ═══════════════════════════════════════════════════════════
 * YEN-Bot — Setup Chat FAQs Table
 * ═══════════════════════════════════════════════════════════
 * 
 * Run this ONCE via browser: http://localhost/YEN-LIBRARY/api/setup_chatbot.php
 * It creates the chat_faqs table and inserts predefined Q&A pairs.
 */

require_once '../db.php';

// ─── Create the chat_faqs table ─────────────────────────────
$create_table = "
CREATE TABLE IF NOT EXISTS `chat_faqs` (
  `id`        INT AUTO_INCREMENT PRIMARY KEY,
  `keywords`  VARCHAR(500) NOT NULL COMMENT 'Comma-separated keywords to match against',
  `question`  VARCHAR(500) NOT NULL COMMENT 'The expected user question (for admin reference)',
  `answer`    TEXT NOT NULL COMMENT 'The predefined answer to return',
  `category`  VARCHAR(100) DEFAULT 'general' COMMENT 'Category grouping for organization',
  `active`    TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if (mysqli_query($conn, $create_table)) {
    echo "✅ chat_faqs table created successfully!<br><br>";
} else {
    echo "❌ Error creating table: " . mysqli_error($conn) . "<br>";
}

// ─── Insert predefined FAQ entries ──────────────────────────
$faqs = [
    // Timings & Hours
    ['timings,timing,hours,open,close,when,time,schedule', 
     'What are the library timings?', 
     'Our libraries operate on the following schedule:\n• **Central Library (Medical):** Mon–Sat: 8:00 AM – 11:00 PM, Sun: 9:00 AM – 5:00 PM\n• **Dental Library:** Mon–Sat: 8:30 AM – 8:00 PM\n• **Pharmacy Library:** Mon–Sat: 9:00 AM – 6:00 PM\n\nDuring exams, hours may be extended. Check the notice board for updates!', 
     'timings'],

    // OPAC
    ['opac,catalog,catalogue,search book,find book,book search,search', 
     'How do I search for books?', 
     'You can search our entire collection using the **OPAC (Online Public Access Catalogue)**.\n\n🔗 Visit: [OPAC Portal](https://opac.yenepoya.edu.in)\n\nYou can search by title, author, subject, or ISBN. The OPAC also shows real-time availability and location of each book.', 
     'opac'],

    // Remote Access
    ['remote,remote access,access from home,myloft,knimbus,off campus,offcampus,vpn', 
     'How do I access e-resources from home?', 
     'You can access all subscribed e-resources remotely using **MyLOFT / Knimbus**.\n\n🔗 Visit: [Remote Access Portal](https://knimbus.com)\n\nJust log in with your institutional credentials. If you face issues, contact the library help desk.', 
     'access'],

    // Library Card / Membership
    ['library card,membership,member,card,join,register,registration,id card', 
     'How do I get a library card?', 
     'To get your library card:\n1. Visit the **Central Library** with your college ID\n2. Fill out the membership form\n3. Submit a passport-size photo\n4. Your card will be issued within 2 working days\n\nAll students, faculty, and staff of Yenepoya are eligible for free membership.', 
     'membership'],

    // Borrowing Rules
    ['borrow,borrowing,issue,how many books,book limit,return,due date,renew,renewal', 
     'What are the borrowing rules?', 
     'Borrowing rules at Yenepoya Libraries:\n• **UG Students:** 3 books for 14 days\n• **PG Students:** 5 books for 14 days\n• **Faculty:** 10 books for 30 days\n\nBooks can be renewed once if no reservation exists. Late returns attract a fine of ₹2/day per book.', 
     'borrowing'],

    // E-Resources
    ['e-resource,eresource,database,pubmed,scopus,clinicalkey,elsevier,journal,e-journal,ebook,e-book', 
     'What e-resources are available?', 
     'We provide access to a wide range of e-resources:\n• **ClinicalKey** (Elsevier)\n• **Scopus** (Elsevier)\n• **ProQuest Medical Library**\n• **PubMed / PubMed Central**\n• **DOAJ** (Open Access)\n\n🔗 Explore all: [E-Resources Page](/YEN-LIBRARY/e-resources.php)', 
     'eresources'],

    // Contact / Help
    ['contact,help,phone,email,call,reach,helpdesk,support,librarian', 
     'How do I contact the library?', 
     'You can reach us through:\n• **Email:** library@yenepoya.edu.in\n• **Phone:** +91-824-2204668 (Ext. 2255)\n• **In Person:** Visit the Central Library help desk\n• **Online:** Use the [Contact Form](/YEN-LIBRARY/contact.php) on our website\n\nOur librarians are happy to help!', 
     'contact'],

    // Location
    ['location,where,address,campus,direction,map,find library', 
     'Where is the library located?', 
     'Yenepoya has **6 library branches** across its campuses:\n1. **Central Library** — University Main Campus, Deralakatte\n2. **Medical Library** — YMC Building\n3. **Dental Library** — YDSC Building\n4. **Pharmacy Library** — YPC Building\n5. **Nursing Library** — YCON Building\n6. **Ayurveda Library** — YIAC Building\n\nThe Central Library is the largest with the most comprehensive collection.', 
     'location'],

    // Plagiarism / Turnitin
    ['plagiarism,turnitin,similarity,check,thesis check,dissertation', 
     'How do I check for plagiarism?', 
     'We provide **Turnitin** plagiarism detection service:\n1. Submit your thesis/paper to the library\n2. We will generate a similarity report\n3. Reports are usually ready within 2–3 working days\n\nContact the Research Support desk or email library@yenepoya.edu.in with your document.', 
     'research'],

    // Reference Management
    ['zotero,reference,citation,bibliography,mendeley,endnote,reference manager', 
     'Do you provide reference management tools?', 
     'Yes! We recommend **Zotero** — a free, open-source reference manager.\n• Free to download: [zotero.org](https://zotero.org)\n• The library conducts regular **Zotero training workshops**\n• Check our [Events Page](/YEN-LIBRARY/events.php) for upcoming sessions\n\nWe can also help with Mendeley and EndNote queries.', 
     'research'],

    // Events
    ['event,events,workshop,seminar,training,orientation,upcoming', 
     'What events does the library organize?', 
     'We regularly organize:\n• 📚 **Book exhibitions** and displays\n• 🔬 **Database search workshops** (PubMed, Scopus)\n• 🎓 **Library orientation** for new batches\n• 📝 **Reference management training** (Zotero)\n• 🏆 **Library Week** celebrations\n\n🔗 See all events: [Events Page](/YEN-LIBRARY/events.php)', 
     'events'],

    // About
    ['about,history,established,yenepoya', 
     'Tell me about Yenepoya Libraries', 
     'Yenepoya Libraries is part of **Yenepoya (Deemed to be University)**, Mangalore. We serve over 5,000+ students and faculty across 6 campus libraries.\n\nOur collection includes:\n• 53,000+ Print Books\n• 2.1M+ E-Resources\n• 8,000+ E-Journals\n• 1,200+ Print Journals\n\n🔗 Learn more: [About Us](/YEN-LIBRARY/about.php)', 
     'general'],

    // Greetings
    ['hi,hello,hey,good morning,good afternoon,good evening,greetings', 
     'Hello / Greeting', 
     'Hello! 👋 I\'m **YEN-Bot**, your virtual library assistant. I can help you with:\n• 📖 Finding books (via OPAC)\n• 🌐 Remote access to e-resources\n• ⏰ Library timings & rules\n• 📅 Upcoming events\n• 📞 Contact information\n\nWhat would you like to know?', 
     'greeting'],

    // Thank you
    ['thank,thanks,thank you,thankyou,thx,great,awesome,helpful', 
     'Thank you', 
     'You\'re welcome! 😊 If you have any more questions, feel free to ask. Happy studying!', 
     'greeting'],

    // Bye
    ['bye,goodbye,see you,later,done,exit,quit', 
     'Goodbye', 
     'Goodbye! 👋 Have a great day. Remember, the library is always here to help you. Happy learning!', 
     'greeting'],
];

$inserted = 0;
foreach ($faqs as $faq) {
    $keywords = mysqli_real_escape_string($conn, $faq[0]);
    $question = mysqli_real_escape_string($conn, $faq[1]);
    $answer = mysqli_real_escape_string($conn, $faq[2]);
    $category = mysqli_real_escape_string($conn, $faq[3]);
    
    $query = "INSERT INTO chat_faqs (keywords, question, answer, category) 
              VALUES ('$keywords', '$question', '$answer', '$category')";
    if (mysqli_query($conn, $query)) {
        $inserted++;
    }
}

echo "✅ Inserted $inserted FAQ entries successfully!<br><br>";
echo "🎉 Phase 1 complete — Your knowledge base is ready!";
?>
