<?php
function connectDB()
{
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


function uploadFile($file, $folder)
{
    $pathStorage =  $folder . time() . $file['name'];
    $from = $file['tmp_name'];
    $to = PATH_ROOT . $pathStorage;

    if (move_uploaded_file($from, $to)) {
        return $pathStorage;
    } else {
        return null;
    }
}
function uploadFile2($file, $targetDir) {
    // Kiểm tra xem tệp có được tải lên mà không có lỗi không
    if ($file['error'] === UPLOAD_ERR_OK) {
        // Làm sạch tên tệp
        $fileName = basename($file['name']);
        $targetFile = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        
        // Kiểm tra xem thư mục đích có tồn tại không, nếu không sẽ tạo mới
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Di chuyển tệp tải lên vào thư mục đích
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $fileName; // Trả về tên tệp
        } else {
            return false; // Không thể di chuyển tệp
        }
    }
    return false; // Có lỗi khi tải lên tệp
}


function deleteFile($file)
{
    $path = PATH_ROOT . $file;
    if (file_exists($path)) {
        unlink($path);
    }
}
function removeLeadingDots($filePath){
    return preg_replace('/^\.\.\//', '', $filePath);
}
