<?php
/**
 * Libraries Manager — Backend Logic (included by libraries-manager.php)
 */
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: ../login.php");
  exit;
}
require_once '../../db.php';
require_once '../../includes/library_helpers.php';

$message = "";
$msg_type = "";

// Image upload helper
function handleLibraryImageUpload($file, $prefix = 'lib') {
    $allowed = ['image/jpeg','image/png','image/webp'];
    if (!in_array($file['type'], $allowed) || $file['size'] > 5*1024*1024) return "";
    $dir = "../../uploads/libraries/";
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $name = $prefix . "_" . time() . "_" . rand(100,999) . "." . $ext;
    if (move_uploaded_file($file['tmp_name'], $dir . $name)) {
        return "uploads/libraries/" . $name;
    }
    return "";
}

// DELETE (soft - toggle to inactive)
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if (mysqli_query($conn, "UPDATE libraries SET status='inactive' WHERE id=$id")) {
        $message = "Library deactivated!"; $msg_type = "success";
    } else {
        $message = "Error: " . mysqli_error($conn); $msg_type = "error";
    }
}

// ACTIVATE
if (isset($_GET['activate'])) {
    $id = (int)$_GET['activate'];
    if (mysqli_query($conn, "UPDATE libraries SET status='active' WHERE id=$id")) {
        $message = "Library activated!"; $msg_type = "success";
    } else {
        $message = "Error: " . mysqli_error($conn); $msg_type = "error";
    }
}

// DELETE gallery image
if (isset($_GET['delete_gallery'])) {
    $gid = (int)$_GET['delete_gallery'];
    $back = isset($_GET['lib']) ? (int)$_GET['lib'] : 0;
    mysqli_query($conn, "DELETE FROM library_gallery WHERE id=$gid");
    $message = "Gallery image removed!"; $msg_type = "success";
    if ($back) header("Location: libraries-manager.php?edit=$back&msg=gallery_deleted");
}

// ADD
if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['add_library'])) {
    $name = clean($conn, $_POST['library_name']);
    $slug = clean($conn, $_POST['slug']);
    $label = clean($conn, $_POST['section_label'] ?: 'Constituent Library');
    $short = mysqli_real_escape_string($conn, $_POST['short_description']);
    $full = mysqli_real_escape_string($conn, $_POST['full_description']);
    $year = clean($conn, $_POST['established_year']);
    $campus = clean($conn, $_POST['campus']);
    $subject = clean($conn, $_POST['subject_area']);
    $programmes = clean($conn, $_POST['programmes']);
    $books = clean($conn, $_POST['books_count']);
    $journals = clean($conn, $_POST['journals_count']);
    $back_vol = clean($conn, $_POST['back_volumes']);
    $theses = clean($conn, $_POST['theses_count']);
    $ejournals = clean($conn, $_POST['ejournals_count']);
    $meta = clean($conn, $_POST['card_meta']);
    $icon = clean($conn, $_POST['icon_name'] ?: 'book');
    $email = clean($conn, $_POST['contact_email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact_info']);
    $order = (int)$_POST['display_order'];
    $status = clean($conn, $_POST['status'] ?: 'active');
    $hours_json = mysqli_real_escape_string($conn, $_POST['working_hours_json']);

    $thumb = "";
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error']==0) {
        $thumb = handleLibraryImageUpload($_FILES['thumbnail'], 'thumb');
    }

    if (empty($name) || empty($slug)) {
        $message = "Name and slug are required!"; $msg_type = "error";
    } else {
        $q = "INSERT INTO libraries (library_name,slug,section_label,short_description,full_description,established_year,campus,subject_area,programmes,books_count,journals_count,back_volumes,theses_count,ejournals_count,thumbnail,card_meta,icon_name,working_hours,contact_info,contact_email,display_order,status) VALUES ('$name','$slug','$label','$short','$full','$year','$campus','$subject','$programmes','$books','$journals','$back_vol','$theses','$ejournals','$thumb','$meta','$icon','$hours_json','$contact','$email',$order,'$status')";
        if (mysqli_query($conn, $q)) {
            $lib_id = mysqli_insert_id($conn);
            // Gallery uploads
            if (isset($_FILES['gallery'])) {
                foreach ($_FILES['gallery']['tmp_name'] as $i => $tmp) {
                    if ($_FILES['gallery']['error'][$i] == 0) {
                        $gfile = ['name'=>$_FILES['gallery']['name'][$i],'type'=>$_FILES['gallery']['type'][$i],'tmp_name'=>$tmp,'error'=>0,'size'=>$_FILES['gallery']['size'][$i]];
                        $gpath = handleLibraryImageUpload($gfile, 'gallery');
                        if ($gpath) {
                            $gcap = clean($conn, $_POST['gallery_captions'][$i] ?? '');
                            mysqli_query($conn, "INSERT INTO library_gallery (library_id,image_path,caption,sort_order) VALUES ($lib_id,'$gpath','$gcap',$i)");
                        }
                    }
                }
            }
            $message = "Library added!"; $msg_type = "success";
        } else {
            $message = "Error: " . mysqli_error($conn); $msg_type = "error";
        }
    }
}

// EDIT
if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['edit_library'])) {
    $id = (int)$_POST['library_id'];
    $name = clean($conn, $_POST['library_name']);
    $slug = clean($conn, $_POST['slug']);
    $label = clean($conn, $_POST['section_label'] ?: 'Constituent Library');
    $short = mysqli_real_escape_string($conn, $_POST['short_description']);
    $full = mysqli_real_escape_string($conn, $_POST['full_description']);
    $year = clean($conn, $_POST['established_year']);
    $campus = clean($conn, $_POST['campus']);
    $subject = clean($conn, $_POST['subject_area']);
    $programmes = clean($conn, $_POST['programmes']);
    $books = clean($conn, $_POST['books_count']);
    $journals = clean($conn, $_POST['journals_count']);
    $back_vol = clean($conn, $_POST['back_volumes']);
    $theses = clean($conn, $_POST['theses_count']);
    $ejournals = clean($conn, $_POST['ejournals_count']);
    $meta = clean($conn, $_POST['card_meta']);
    $icon = clean($conn, $_POST['icon_name'] ?: 'book');
    $email = clean($conn, $_POST['contact_email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact_info']);
    $order = (int)$_POST['display_order'];
    $status = clean($conn, $_POST['status'] ?: 'active');
    $hours_json = mysqli_real_escape_string($conn, $_POST['working_hours_json']);

    $thumb_sql = "";
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error']==0) {
        $thumb = handleLibraryImageUpload($_FILES['thumbnail'], 'thumb');
        if ($thumb) $thumb_sql = ", thumbnail='$thumb'";
    }

    $q = "UPDATE libraries SET library_name='$name',slug='$slug',section_label='$label',short_description='$short',full_description='$full',established_year='$year',campus='$campus',subject_area='$subject',programmes='$programmes',books_count='$books',journals_count='$journals',back_volumes='$back_vol',theses_count='$theses',ejournals_count='$ejournals',card_meta='$meta',icon_name='$icon',working_hours='$hours_json',contact_info='$contact',contact_email='$email',display_order=$order,status='$status' $thumb_sql WHERE id=$id";

    if (mysqli_query($conn, $q)) {
        // New gallery uploads
        if (isset($_FILES['gallery'])) {
            $existing = mysqli_fetch_assoc(mysqli_query($conn, "SELECT MAX(sort_order) as mx FROM library_gallery WHERE library_id=$id"));
            $sort_start = ($existing['mx'] ?? 0) + 1;
            foreach ($_FILES['gallery']['tmp_name'] as $i => $tmp) {
                if ($_FILES['gallery']['error'][$i] == 0) {
                    $gfile = ['name'=>$_FILES['gallery']['name'][$i],'type'=>$_FILES['gallery']['type'][$i],'tmp_name'=>$tmp,'error'=>0,'size'=>$_FILES['gallery']['size'][$i]];
                    $gpath = handleLibraryImageUpload($gfile, 'gallery');
                    if ($gpath) {
                        $gcap = clean($conn, $_POST['gallery_captions'][$i] ?? '');
                        mysqli_query($conn, "INSERT INTO library_gallery (library_id,image_path,caption,sort_order) VALUES ($id,'$gpath','$gcap',".($sort_start+$i).")");
                    }
                }
            }
        }
        $message = "Library updated!"; $msg_type = "success";
    } else {
        $message = "Error: " . mysqli_error($conn); $msg_type = "error";
    }
}

// Fetch all libraries
$libraries_result = mysqli_query($conn, "SELECT * FROM libraries ORDER BY display_order ASC, id ASC");

// Edit mode
$edit_lib = null;
$edit_gallery = [];
if (isset($_GET['edit'])) {
    $eid = (int)$_GET['edit'];
    $edit_lib = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM libraries WHERE id=$eid LIMIT 1"));
    $gr = mysqli_query($conn, "SELECT * FROM library_gallery WHERE library_id=$eid ORDER BY sort_order ASC");
    while ($g = mysqli_fetch_assoc($gr)) $edit_gallery[] = $g;
}

$icon_options = ['home','shield','heartbeat','grid','graduation','pharmacy','book','microscope','stethoscope'];
?>
