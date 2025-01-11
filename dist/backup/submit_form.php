<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = $_POST['fields'];

    // Mulai konten form HTML
    $formHTML = "<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n";
    $formHTML .= "    <meta charset=\"UTF-8\">\n";
    $formHTML .= "    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n";
    $formHTML .= "    <title>Generated Form</title>\n";
    $formHTML .= "    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css\">\n";
    $formHTML .= "</head>\n<body>\n<div class=\"container\">\n<h2 class=\"text-center\">Generated Form</h2>\n";
    $formHTML .= "<form action=\"#\" method=\"POST\">\n";

    // Loop untuk setiap field
    foreach ($fields as $field) {
        $label = htmlspecialchars($field['label']);
        $type = htmlspecialchars($field['type']);
        $required = isset($field['required']) && $field['required'] === 'yes' ? 'required' : '';
        $value = htmlspecialchars($field['value']);

        if ($type === 'select') {
            $options = explode(',', $value);
            $formHTML .= "<div class=\"form-group\">\n<label>{$label}</label>\n<select class=\"form-control\" name=\"{$label}\" {$required}>\n";
            foreach ($options as $option) {
                $option = trim($option);
                $formHTML .= "<option value=\"{$option}\">{$option}</option>\n";
            }
            $formHTML .= "</select>\n</div>\n";
        } elseif ($type === 'checkbox' || $type === 'radio') {
            $options = explode(',', $value);
            $formHTML .= "<div class=\"form-group\">\n<label>{$label}</label>\n<br>\n";
            foreach ($options as $option) {
                $option = trim($option);
                $formHTML .= "<label class=\"{$type}-inline\">\n";
                $formHTML .= "<input type=\"{$type}\" name=\"{$label}\" value=\"{$option}\" {$required}> {$option}\n";
                $formHTML .= "</label>\n";
            }
            $formHTML .= "</div>\n";
        } else {
            $placeholder = htmlspecialchars($field['placeholder']);
            $formHTML .= "<div class=\"form-group\">\n";
            $formHTML .= "<label>{$label}</label>\n";
            $formHTML .= "<input type=\"{$type}\" class=\"form-control\" name=\"{$label}\" placeholder=\"{$placeholder}\" {$required}>\n";
            $formHTML .= "</div>\n";
        }
    }

    // Akhiri form dan konten HTML
    $formHTML .= "<button type=\"submit\" class=\"btn btn-primary\">Submit</button>\n";
    $formHTML .= "</form>\n</div>\n</body>\n</html>";

    // Tentukan lokasi folder (sama dengan lokasi file ini)
    $folderPath = __DIR__;

    // Nama file unik berdasarkan waktu
    $filename = $folderPath . '/form_' . time() . '.html';

    // Simpan file ke lokasi yang sama
    file_put_contents($filename, $formHTML);

    echo "<p>Form berhasil dibuat dan disimpan di <a href='" . basename($filename) . "' target='_blank'>" . basename($filename) . "</a>.</p>";
}
