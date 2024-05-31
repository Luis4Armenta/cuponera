<?php
function sanitize_post_data($post_data) {
    $sanitized_data = array();
    
    foreach ($post_data as $key => $value) {
        if (is_array($value)) {
            // Recursively sanitize arrays
            $sanitized_data[$key] = sanitize_post_data($value);
        } else {
            // Apply different sanitizations based on the expected content type
            switch ($key) {
                case 'email':
                    $sanitized_data[$key] = filter_var($value, FILTER_SANITIZE_EMAIL);
                    break;
                case 'url':
                    $sanitized_data[$key] = filter_var($value, FILTER_SANITIZE_URL);
                    break;
                case 'int':
                    $sanitized_data[$key] = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                    break;
                case 'float':
                    $sanitized_data[$key] = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    break;
                case 'html':
                    $sanitized_data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                    break;
                default:
                    // Default sanitization for general input using htmlspecialchars
                    $sanitized_data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                    break;
            }
        }
    }
    
    return $sanitized_data;
}
?>
