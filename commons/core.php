<?php

class CoreApp {
    private $connDbGlobal;

    public function __construct() {
        require_once join(DIRECTORY_SEPARATOR, array('.', 'commons', 'env.php')); // Khai báo biến môi trường
        require_once join(DIRECTORY_SEPARATOR, array('.', 'commons', 'route.php')); // Hàm hỗ trợ
        require_once join(DIRECTORY_SEPARATOR, array('.', 'commons', 'model.php')); // Controller cơ bản
        require_once join(DIRECTORY_SEPARATOR, array('.', 'commons', 'controller.php')); // Controller cơ bản
        require_once join(DIRECTORY_SEPARATOR, array('.', 'commons', 'view.php')); // View cơ bản
        require_once join(DIRECTORY_SEPARATOR, array('.', 'commons', 'auth.php')); // Auth cơ bản
    }

    public function initApp($prefix) {
        global $route;
        $this->loadControllers($prefix);
        $this->loadModels($prefix);

        require_once join(DIRECTORY_SEPARATOR, array('.', $prefix, 'router.php'));
    }

    private function loadAllFileWithStruct($directory, $struct) {
        $files = glob($directory . $struct);
        // Duyệt qua từng tệp và thực hiện require_once
        foreach ($files as $file) {
            require_once $file;
        }
    }

    private function loadControllers($directory) {
        $directory = join(DIRECTORY_SEPARATOR, array('.', $directory, 'controllers'));
        $this->loadAllFileWithStruct($directory,  '/*Controller.php');
    }

    private function loadModels($directory) {
        $directory = join(DIRECTORY_SEPARATOR, array('.', $directory, 'controllers'));
        $this->loadAllFileWithStruct($directory,  '/*.php');
    }

    // Kết nối CSDL qua PDO
    public function connectDB() {
        if ($this->connDbGlobal !== null) return $this->connDbGlobal;
        // Kết nối CSDL
        $host = DB_HOST;
        $port = DB_PORT;
        $dbname = DB_NAME;

        try {
            $this->connDbGlobal = new PDO("mysql:host=$host;port=$port;dbname=$dbname", DB_USERNAME, DB_PASSWORD);

            // cài đặt chế độ báo lỗi là xử lý ngoại lệ
            $this->connDbGlobal->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // cài đặt chế độ trả dữ liệu
            $this->connDbGlobal->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
            return $this->connDbGlobal;
        } catch (PDOException $e) {
            $this->debug("Connection failed: " . $e->getMessage());
        }
    }

    private function debug($data)
    {
        echo "<pre>";
        print_r($data);
        die();
    }
}