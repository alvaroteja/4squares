<?php
// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si hay archivos en el FormData
    if (!empty($_FILES)) {
        // Array para almacenar los nombres de las imágenes guardadas
        $imagesNames = array();

        // Ruta donde se guardarán las imágenes en el servidor
        $folderName = $_POST['name'];
        $finalPath = "../img/products/$folderName/";
        if (!is_dir($finalPath)) {
            mkdir($finalPath, 0777, true);
        }

        // Iterar sobre cada archivo
        foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
            // Obtener nombre y extensión del archivo
            $fileName = $_FILES['images']['name'][$index];
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

            // Generar un nombre único para el archivo
            $uniqueName = uniqid() . '.' . $fileExtension;

            // Ruta completa del archivo en el servidor
            $fullPath = $finalPath . $uniqueName;

            // Mover el archivo al destino final en el servidor
            move_uploaded_file($tmpName, $fullPath);

            // Almacenar el nombre del archivo guardado en el array
            $imagesNames[] = $uniqueName;
        }

        // Preparar la respuesta JSON
        $response = array(
            'success' => true,
            'message' => 'Imágenes guardadas correctamente',
            'imageNames' => $_POST["name"]
            //'imageNames' => $imagesNames
        );
    } else {
        // No se enviaron archivos en el FormData
        $response = array(
            'success' => false,
            'message' => 'No se encontraron imágenes en el FormData'
        );
    }
} else {
    // No se realizó una solicitud POST
    $response = array(
        'success' => false,
        'message' => 'No se realizó una solicitud POST'
    );
}

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json');

// Enviar la respuesta JSON
echo json_encode($response);
