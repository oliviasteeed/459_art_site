<?php
require('initialize.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "hit";

    $object_id = $_POST['object_id'] ?? null;
    $username = trim($_POST['username'] ?? '');
    $comment = trim($_POST['comment'] ?? '');

    if (!$object_id || $username === '' || $comment === '') {
        header("Location: ../public/pages/object-details.php?object_id=" . urlencode($object_id));
        exit;
    }

    $stmt = $db->prepare("INSERT INTO comments (object_id, username, comment, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $object_id, $username, $comment);
    $stmt->execute();
    $stmt->close();

    header("Location: ../public/pages/object-details.php?object_id=" . urlencode($object_id));
    exit;

}

?>