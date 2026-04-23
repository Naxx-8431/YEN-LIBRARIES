<?php
/**
 * ═══════════════════════════════════════════════════════════
 * Yenepoya Libraries — Library Helper Functions
 * ═══════════════════════════════════════════════════════════
 * 
 * Shared functions for rendering dynamic library content.
 * Include this file wherever library data is needed:
 *   require_once 'includes/library_helpers.php';
 */


/**
 * getLibraryIconSvg() — Returns SVG markup for a given icon name
 * 
 * Icons are mapped to simple names so admins don't need to edit raw SVG.
 * Used in sidebar navigation and library cards.
 */
function getLibraryIconSvg($icon_name) {
    $icons = [
        'home' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
            <polyline points="9 22 9 12 15 12 15 22" />
        </svg>',

        'shield' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
        </svg>',

        'heartbeat' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
        </svg>',

        'grid' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="18" height="18" rx="2" />
            <path d="M3 9h18M9 21V9" />
        </svg>',

        'graduation' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
            <path d="M6 12v5c3 3 9 3 12 0v-5" />
        </svg>',

        'pharmacy' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18" />
        </svg>',

        'book' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
        </svg>',

        'microscope' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M6 18h8" /><path d="M3 22h18" /><path d="M14 22a7 7 0 1 0 0-14h-1" />
            <path d="M9 14h2" /><path d="M9 12a2 2 0 0 1-2-2V6h6v4a2 2 0 0 1-2 2Z" />
            <path d="M12 6V3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3" />
        </svg>',

        'stethoscope' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.2.2 0 1 0 .3.3" />
            <path d="M8 15v1a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6v-4" />
            <circle cx="20" cy="10" r="2" />
        </svg>',
    ];

    return $icons[$icon_name] ?? $icons['book'];
}


/**
 * getActiveLibraries() — Fetch all active libraries ordered by display_order
 */
function getActiveLibraries($conn) {
    $query = "SELECT * FROM libraries WHERE status = 'active' ORDER BY display_order ASC";
    $result = mysqli_query($conn, $query);
    
    $libraries = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $libraries[] = $row;
        }
    }
    return $libraries;
}


/**
 * getAllGalleryImages() — Fetch ALL gallery images in one query, grouped by library_id
 * 
 * Returns an associative array: [ library_id => [ [image_path, caption], ... ] ]
 * This avoids N+1 query problem — one query for all libraries.
 */
function getAllGalleryImages($conn) {
    $query = "SELECT library_id, image_path, caption FROM library_gallery ORDER BY library_id ASC, sort_order ASC";
    $result = mysqli_query($conn, $query);
    
    $gallery = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $lid = $row['library_id'];
            if (!isset($gallery[$lid])) {
                $gallery[$lid] = [];
            }
            $gallery[$lid][] = $row;
        }
    }
    return $gallery;
}


/**
 * renderWorkingHoursTable() — Render working hours from JSON data
 * 
 * Expected JSON structure:
 * {
 *   "columns": ["", "Week Days", "Sundays & Holidays"],
 *   "rows": [
 *     {"label": "Working Hours", "values": ["09.00 am to 12.00 Midnight", "09.00 am to 12.00 Midnight"]},
 *     {"label": "During Examinations", "values": ["09.00 am to 12.00 Midnight"], "colspan": true}
 *   ]
 * }
 */
function renderWorkingHoursTable($json_string) {
    if (empty($json_string)) return '';
    
    $data = json_decode($json_string, true);
    if (!$data || !isset($data['columns']) || !isset($data['rows'])) return '';
    
    $html = '<h3 style="margin-top:24px;margin-bottom:10px;font-size:16px;font-weight:700;color:var(--clr-primary);">Working Hours</h3>';
    $html .= '<table class="hours-table">';
    
    // Header
    $html .= '<thead><tr>';
    foreach ($data['columns'] as $col) {
        $html .= '<th>' . htmlspecialchars($col) . '</th>';
    }
    $html .= '</tr></thead>';
    
    // Body
    $html .= '<tbody>';
    $col_count = count($data['columns']);
    foreach ($data['rows'] as $row) {
        $html .= '<tr>';
        $html .= '<td><strong>' . htmlspecialchars($row['label']) . '</strong></td>';
        
        if (!empty($row['colspan']) && $row['colspan'] === true) {
            // Span across all remaining columns
            $colspan = $col_count - 1;
            $html .= '<td colspan="' . $colspan . '" style="text-align:center;">' . htmlspecialchars($row['values'][0]) . '</td>';
        } else {
            foreach ($row['values'] as $val) {
                $html .= '<td>' . htmlspecialchars($val) . '</td>';
            }
        }
        
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
    
    return $html;
}


/**
 * renderInfoBoxes() — Render the info-grid boxes for a library
 * Only renders boxes where data exists.
 */
function renderInfoBoxes($lib) {
    $boxes = [];
    
    if (!empty($lib['established_year'])) {
        $boxes[] = ['label' => 'Established', 'value' => $lib['established_year']];
    }
    if (!empty($lib['books_count'])) {
        $boxes[] = ['label' => 'Books', 'value' => $lib['books_count']];
    }
    if (!empty($lib['journals_count'])) {
        $boxes[] = ['label' => 'Journals', 'value' => $lib['journals_count']];
    }
    if (!empty($lib['back_volumes'])) {
        $boxes[] = ['label' => 'Back Volumes', 'value' => $lib['back_volumes']];
    }
    if (!empty($lib['theses_count'])) {
        $boxes[] = ['label' => 'Theses & Dissertations', 'value' => $lib['theses_count']];
    }
    if (!empty($lib['ejournals_count'])) {
        $boxes[] = ['label' => 'E-Journals', 'value' => $lib['ejournals_count']];
    }
    if (!empty($lib['campus'])) {
        $boxes[] = ['label' => 'Campus', 'value' => $lib['campus']];
    }
    if (!empty($lib['subject_area'])) {
        $boxes[] = ['label' => 'Subject Area', 'value' => $lib['subject_area']];
    }
    if (!empty($lib['programmes'])) {
        $boxes[] = ['label' => 'Programmes', 'value' => $lib['programmes']];
    }
    
    if (empty($boxes)) return '';
    
    $html = '<div class="info-grid">';
    foreach ($boxes as $box) {
        $html .= '<div class="info-box">';
        $html .= '<div class="info-box__label">' . htmlspecialchars($box['label']) . '</div>';
        $html .= '<div class="info-box__value">' . htmlspecialchars($box['value']) . '</div>';
        $html .= '</div>';
    }
    $html .= '</div>';
    
    return $html;
}
?>
