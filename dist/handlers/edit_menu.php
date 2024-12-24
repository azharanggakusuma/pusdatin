<?php
include_once('../config/conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $name = $_POST['menu_name'];
    $url = $_POST['menu_url'];
    $status = $_POST['menu_status'];

    // Fetch old URL from the database
    $old_url_query = "SELECT url FROM menu WHERE id = ?";
    $stmt = $conn->prepare($old_url_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $old_url = $result->fetch_assoc()['url'];

    // Update the menu in the database
    $update_query = "UPDATE menu SET name = ?, url = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssii", $name, $url, $status, $id);
    if (!$stmt->execute()) {
        echo "Error updating record: " . $conn->error;
        exit;
    }

    // Check if URL has changed and rename the file
    if ($old_url != $url) {
        rename("../" . $old_url, "../" . $url);
    }

    $stmt->close();
    $conn->close();
    header("Location: ../pages/tables/manage_menu.php?messageedit=success");
}
?>
