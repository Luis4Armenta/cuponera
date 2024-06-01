<?php
/**
 * Función para sanitizar y validar entradas de $_GET y $_POST
 *
 * @param array $input El arreglo de entrada ($_GET o $_POST)
 * @param array $expected Un arreglo que especifica el contenido esperado y su tipo.
 * @param array $regex Validaciones adicionales con expresiones regulares (campo => regex).
 * @return array Arreglo sanitizado y validado.
 */
function sanitize_input(array $input, array $expected, array $regex = []): array {
    $sanitized = [];

    foreach ($expected as $key => $type) {
        if (isset($input[$key])) {
            switch ($type) {
                case 'string':
                    // Usar FILTER_UNSAFE_RAW con opciones para simular FILTER_SANITIZE_STRING
                    $sanitized[$key] = filter_var($input[$key], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
                    break;
                case 'email':
                    $sanitized[$key] = filter_var($input[$key], FILTER_SANITIZE_EMAIL);
                    break;
                case 'url':
                    $sanitized[$key] = filter_var($input[$key], FILTER_SANITIZE_URL);
                    break;
                case 'int':
                    $sanitized[$key] = filter_var($input[$key], FILTER_SANITIZE_NUMBER_INT);
                    break;
                case 'float':
                    $sanitized[$key] = filter_var($input[$key], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    break;
                case 'boolean':
                    $sanitized[$key] = filter_var($input[$key], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                    break;
                default:
                    // Si el tipo no es reconocido, no se sanitiza
                    $sanitized[$key] = $input[$key];
                    break;
            }
        } else {
            // Si la clave no existe en la entrada, puede agregar un valor predeterminado si se desea
            $sanitized[$key] = null; // o algún valor por defecto
        }
    }


    // Validación con expresiones regulares
    foreach ($regex as $key => $pattern) {
        if (isset($sanitized[$key])) {
            if (!preg_match($pattern, $sanitized[$key])) {
                // Si no pasa la validación, eliminar del arreglo sanitizado
                unset($sanitized[$key]);
            }
        }
    }
    var_dump($input);


    return $sanitized;
}
?>

