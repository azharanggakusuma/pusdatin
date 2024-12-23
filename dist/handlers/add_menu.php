<?php
include_once('../config/conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars(trim($_POST['menu_name']));
    $status = htmlspecialchars(trim($_POST['menu_status']));
    
    // Generate the URL based on the menu name
    $url = 'pages/forms/' . strtolower(str_replace(' ', '_', $name)) . '.php';

    // Query to insert the menu data into the database
    $query = "INSERT INTO menu (name, url, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $name, $url, $status);

    if ($stmt->execute()) {
        // Ensure directory exists
        $directoryPath = '../' . dirname($url);
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        // Path to the template file
        $templatePath = 'template_form.php'; // Ensure this path is correct
        $filePath = '../' . $url;

        if (!file_exists($filePath)) {
            // Read the content from the template file
            $templateContent = file_get_contents($templatePath);
            if ($templateContent === false) {
                die("Failed to read template file. Check file and permissions.");
            }
            
            // Replace placeholders with actual menu name
            $templateContent = str_replace('{MENU_TITLE}', $name, $templateContent);

            // Write the content to the new file
            if (file_put_contents($filePath, $templateContent) === false) {
                die("Failed to write to file. Check folder permissions.");
            }
        }
        
        // Redirect back to the manage menu page with success message
        header("Location: ../pages/tables/manage_menu.php?messageadd=success");
    } else {
        // Redirect with error message if something goes wrong
        header("Location: ../pages/tables/manage_menu.php?messageadd=error");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../pages/tables/manage_menu.php");
}
?>
