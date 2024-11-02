<?php
function connectDB() {
    $host = DB_HOST;
    $port = DB_PORT;
    $dbname = DB_NAME;

    try {
        $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", DB_USERNAME, DB_PASSWORD);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
        return $conn;
    } catch (PDOException $e) {
        echo ("Connection failed: " . $e->getMessage());
    }
}

function uploadFile($file, $destination) {
    // Ensure $file is an array and contains the expected keys
    if (!is_array($file) || !isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        throw new InvalidArgumentException("Invalid file input provided to uploadFile()");
    }

    // Generate a unique filename to avoid conflicts
    $filename = uniqid() . '_' . basename($file['name']);
    $targetPath = rtrim($destination, '/') . '/' . $filename;

    // Attempt to move the uploaded file to the destination directory
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $targetPath;
    } else {
        throw new RuntimeException("Failed to upload file to the specified destination.");
    }
}

function deleteFile($file){
    $path = PATH_ROOT . $file;
    if (file_exists($path)) {
        unlink($path);
    }
}

?>