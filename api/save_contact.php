<?php
/**
 * Yenepoya Libraries — Contact Form Handler
 * 
 * Handles all 3 form types on contact.html:
 *   1. Ask a Librarian   (fields: name, email, subject, message)
 *   2. Recommend a Book   (fields: title, author, publisher, edition, yop, noc, message, 
 *                                  recommendedby, name, campus_id, course, college)
 *   3. Recommend a Journal (fields: title, typeofjournal, publisher, issn, description)
 * 
 * Form type is auto-detected based on which fields are present.
 * This is a standard form POST that redirects back to contact.html.
 */

require_once __DIR__ . '/config.php';

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../contact.html');
    exit;
}

// ─── Detect Form Type ───────────────────────────────────────
$formType = 'contact'; // default

if (isset($_POST['issn']) || isset($_POST['typeofjournal'])) {
    $formType = 'journal';
} elseif (isset($_POST['author']) || isset($_POST['publisher']) || isset($_POST['edition'])) {
    $formType = 'book';
}

// ─── Process Each Form Type ─────────────────────────────────

try {
    $db = getDB();

    switch ($formType) {

        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // FORM 1: Ask a Librarian (Direct Inquiry)
        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        case 'contact':
            $name    = clean($_POST['name']    ?? '');
            $email   = clean($_POST['email']   ?? '');
            $subject = clean($_POST['subject'] ?? '');
            $message = clean($_POST['message'] ?? '');

            // Validate
            $errors = [];
            if (empty($name))    $errors[] = 'Name is required.';
            if (empty($email))   $errors[] = 'Email is required.';
            if (empty($subject)) $errors[] = 'Subject is required.';
            if (empty($message)) $errors[] = 'Message is required.';
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email address.';
            }

            if (!empty($errors)) {
                redirectWithError('ask-librarian', $errors);
            }

            // Insert
            $stmt = $db->prepare(
                'INSERT INTO contacts (name, email, subject, message, ip_address)
                 VALUES (:name, :email, :subject, :message, :ip)'
            );
            $stmt->execute([
                ':name'    => $name,
                ':email'   => $email,
                ':subject' => $subject,
                ':message' => $message,
                ':ip'      => $_SERVER['REMOTE_ADDR'] ?? null,
            ]);

            $insertId = $db->lastInsertId();

            // Email notification
            $emailBody = buildEmailHtml(
                "📩 New Contact Message (#$insertId)",
                [
                    'Name'    => $name,
                    'Email'   => $email,
                    'Subject' => $subject,
                    'Message' => $message,
                ]
            );
            notifyAdmin("Contact: $subject — from $name", $emailBody);

            redirectWithSuccess('ask-librarian', 'Your message has been sent successfully! We will respond shortly.');
            break;

        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // FORM 2: Recommend a Book
        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        case 'book':
            $title         = clean($_POST['title']         ?? '');
            $author        = clean($_POST['author']        ?? '');
            $publisher     = clean($_POST['publisher']     ?? '');
            $edition       = clean($_POST['edition']       ?? '');
            $yop           = clean($_POST['yop']           ?? '');
            $noc           = (int)($_POST['noc']           ?? 1);
            $message       = clean($_POST['message']       ?? '');
            $recommendedby = clean($_POST['recommendedby'] ?? '');
            $name          = clean($_POST['name']          ?? '');
            $campus_id     = clean($_POST['campus_id']     ?? '');
            $course        = clean($_POST['course']        ?? '');
            $college       = clean($_POST['college']       ?? '');

            // Validate
            $errors = [];
            if (empty($title))         $errors[] = 'Book title is required.';
            if (empty($author))        $errors[] = 'Author is required.';
            if (empty($publisher))     $errors[] = 'Publisher is required.';
            if (empty($recommendedby)) $errors[] = 'Recommender name is required.';
            if (empty($name))          $errors[] = 'Your name is required.';

            if (!empty($errors)) {
                redirectWithError('recommend-book', $errors);
            }

            // Insert
            $stmt = $db->prepare(
                'INSERT INTO book_recommendations 
                    (title, author, publisher, edition, year_of_pub, num_copies, reason,
                     recommended_by, requester_name, campus_id, course, college, ip_address)
                 VALUES 
                    (:title, :author, :publisher, :edition, :yop, :noc, :reason,
                     :recommendedby, :name, :campus_id, :course, :college, :ip)'
            );
            $stmt->execute([
                ':title'         => $title,
                ':author'        => $author,
                ':publisher'     => $publisher,
                ':edition'       => $edition ?: null,
                ':yop'           => $yop ?: null,
                ':noc'           => $noc ?: 1,
                ':reason'        => $message ?: null,
                ':recommendedby' => $recommendedby,
                ':name'          => $name,
                ':campus_id'     => $campus_id ?: null,
                ':course'        => $course ?: null,
                ':college'       => $college ?: null,
                ':ip'            => $_SERVER['REMOTE_ADDR'] ?? null,
            ]);

            $insertId = $db->lastInsertId();

            // Email notification
            $emailBody = buildEmailHtml(
                "📚 New Book Recommendation (#$insertId)",
                [
                    'Book Title'     => $title,
                    'Author'         => $author,
                    'Publisher'      => $publisher,
                    'Edition'        => $edition ?: '—',
                    'Year'           => $yop ?: '—',
                    'Copies'         => $noc,
                    'Reason'         => $message ?: '—',
                    'Recommended By' => $recommendedby,
                    'Requester'      => $name,
                    'Campus ID'      => $campus_id ?: '—',
                    'Course'         => $course ?: '—',
                    'College'        => $college ?: '—',
                ]
            );
            notifyAdmin("Book Recommendation: $title by $author", $emailBody);

            redirectWithSuccess('recommend-book', 'Your book recommendation has been submitted! The acquisition team will review it.');
            break;

        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // FORM 3: Recommend a Journal
        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        case 'journal':
            $title         = clean($_POST['title']         ?? '');
            $typeofjournal = clean($_POST['typeofjournal'] ?? '');
            $publisher     = clean($_POST['publisher']     ?? '');
            $issn          = clean($_POST['issn']          ?? '');
            $description   = clean($_POST['description']   ?? '');

            // Validate
            $errors = [];
            if (empty($title))       $errors[] = 'Journal title is required.';
            if (empty($publisher))   $errors[] = 'Publisher is required.';
            if (empty($description)) $errors[] = 'Description is required.';

            if (!empty($errors)) {
                redirectWithError('recommend-journal', $errors);
            }

            // Insert
            $stmt = $db->prepare(
                'INSERT INTO journal_recommendations 
                    (title, type_of_journal, publisher, issn, description, ip_address)
                 VALUES 
                    (:title, :type, :publisher, :issn, :description, :ip)'
            );
            $stmt->execute([
                ':title'       => $title,
                ':type'        => $typeofjournal ?: null,
                ':publisher'   => $publisher,
                ':issn'        => $issn ?: null,
                ':description' => $description,
                ':ip'          => $_SERVER['REMOTE_ADDR'] ?? null,
            ]);

            $insertId = $db->lastInsertId();

            // Email notification
            $emailBody = buildEmailHtml(
                "📰 New Journal Recommendation (#$insertId)",
                [
                    'Journal Title' => $title,
                    'Type'          => $typeofjournal ?: '—',
                    'Publisher'     => $publisher,
                    'ISSN'          => $issn ?: '—',
                    'Description'   => $description,
                ]
            );
            notifyAdmin("Journal Recommendation: $title", $emailBody);

            redirectWithSuccess('recommend-journal', 'Your journal recommendation has been submitted for review!');
            break;
    }

} catch (PDOException $e) {
    // Log the error in production: error_log($e->getMessage());
    redirectWithError('ask-librarian', ['An unexpected error occurred. Please try again later.']);
}


// ═══════════════════════════════════════════════════════════
// Helper Functions
// ═══════════════════════════════════════════════════════════

/**
 * Redirect back to contact.html with a success message via query param.
 */
function redirectWithSuccess(string $section, string $message): void
{
    $url = '../contact.html#' . $section 
         . '?status=success'
         . '&msg=' . urlencode($message);
    header("Location: $url");
    exit;
}

/**
 * Redirect back to contact.html with error messages via query param.
 */
function redirectWithError(string $section, array $errors): void
{
    $url = '../contact.html#' . $section
         . '?status=error'
         . '&msg=' . urlencode(implode(' ', $errors));
    header("Location: $url");
    exit;
}

/**
 * Build a consistently styled HTML email body.
 */
function buildEmailHtml(string $heading, array $rows): string
{
    $tableRows = '';
    foreach ($rows as $label => $value) {
        $tableRows .= "
        <tr>
            <td style='padding: 10px 14px; font-weight: 600; border-bottom: 1px solid #f0f0f0; color: #283B6A; white-space: nowrap; vertical-align: top;'>$label</td>
            <td style='padding: 10px 14px; border-bottom: 1px solid #f0f0f0; color: #444;'>$value</td>
        </tr>";
    }

    return "
    <html>
    <body style='font-family: Inter, Arial, sans-serif; color: #333; background: #f8fafc; padding: 20px;'>
        <div style='max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08);'>
            <div style='background: #283B6A; padding: 20px 24px;'>
                <h2 style='color: #fff; margin: 0; font-size: 18px;'>$heading</h2>
            </div>
            <table style='border-collapse: collapse; width: 100%;'>
                $tableRows
            </table>
            <div style='padding: 16px 24px; background: #f8fafc; text-align: center;'>
                <p style='font-size: 12px; color: #999; margin: 0;'>Submitted via Yenepoya Libraries Website</p>
            </div>
        </div>
    </body>
    </html>";
}
