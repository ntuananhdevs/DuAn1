<?php
class ProductsController
{
    public $products;

    public function __construct(){
        $this->products = new Products();
    }

    public function views_products() {
        // Kiểm tra nếu có từ khóa tìm kiếm
        if (isset($_GET['search'])) {
            $searchTerm = $_GET['search'];
            $listProducts = $this->products->search_prd($searchTerm); // Gọi hàm tìm kiếm
        } else {
            $listProducts = $this->products->get_products(); // Lấy tất cả sản phẩm nếu không có từ khóa tìm kiếm
        }
        
        // Hiển thị trang sản phẩm và truyền biến $listProducts
        require_once './views/products/products.php';
    }
    
    public function views_add()
    {
        $list_Category = $this->products->get_category();
        require_once './views/products/add_products.php';
    }
    public function viewPrd_Variant($id)
    {

        $listPrd_Variant = $this->products->getPrd_Variant($id);
        $list_spect = $this->products->get_spect($id);
        $product = $this->products->get_prdbyid($id);
        if ($product) {
            $product = $product[0];
        require_once './views/products/product_variant.php';
        }
    }

    public function add_product(){
        try {   
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $productName = $_POST['name'] ?? '';
                $category = $_POST['category'] ?? '';
                $description = $_POST['description'] ?? '';
    
                // Thêm sản phẩm
                $products_id = $this->products->addProduct($productName, $category, $description);
    
                if ($products_id) {
                    $spect = [
                        'Kích thước màn hình' => $_POST['screen_size'] ?? '',
                        'Độ phân giải màn hình' => $_POST['screen_resolution'] ?? '',
                        'Tính năng màn hình' => $_POST['screen_features'] ?? '',
                        'Camera sau' => $_POST['rear_camera'] ?? '',
                        'Quay video' => $_POST['video_resolution'] ?? '',
                        'Chipset' => $_POST['chip'] ?? '',
                        'GPU' => $_POST['gpu'] ?? ''
                    ];
    
                    foreach ($spect as $key => $value) {
                        if (!empty($value)) {
                            $this->products->add_Products_spect($products_id, $key, $value);
                        }
                    }
                }
    
                // Thêm các biến thể
                if (isset($_POST['variants']) && is_array($_POST['variants'])) {
                    foreach ($_POST['variants'] as $index => $variant) {
                        $color = $variant['color'];
                        $ram = $variant['ram'];
                        $storage = $variant['storage'];
                        $quantity = $variant['quantity'];
                        $price = $variant['price'];
    
                        $variants_id = $this->products->add_variants($products_id, $color, $ram, $storage, $price, $quantity);
                        if (isset($_FILES['variants']['name'][$index]['image']) && is_uploaded_file($_FILES['variants']['tmp_name'][$index]['image'])) {
                            $imageFile = [
                                'name' => $_FILES['variants']['name'][$index]['image'],
                                'tmp_name' => $_FILES['variants']['tmp_name'][$index]['image']
                            ];
                            $this->products->saveVariantImage($variants_id, $imageFile);
                        }
                    }
                }
            }
            header('Location: ?act=products');
        }catch (Exception $e) {
            $errorMessage = $e->getMessage();
            header('Location: ?act=products&status=error&message=' . urlencode($errorMessage));
             
        }
    
    }
    public function deletePrd($id){
        try {
            $this->products->deletePrd($id);
            // Nếu không có lỗi, redirect về trang danh sách sản phẩm và hiển thị thông báo thành công
            header('Location: ?act=products&status=success');
            exit();  // Đảm bảo script dừng lại ngay sau khi redirect
        } catch (PDOException $e) {
            // Lưu thông báo lỗi vào biến errorMessage
            $errorMessage = $e->getMessage();
            // Trả về trang sản phẩm với thông báo lỗi
            header('Location: ?act=products&status=error&message=' . urlencode($errorMessage));
            exit();
        }
    }

    public function updateProductDescription() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? null;
            $description = $_POST['description'] ?? '';
    
            if ($id && !empty($description)) {
                $this->products->updateDescription($id, $description);
            } else {
                echo "Product ID or description is missing.";
            }
        } 

        header('Location: ?act=product_detail&id=' .$id);
    }
    

    public function views_update_product($id)
    {
        $list_Category = $this->products->get_category();
        $product_variant = $this->products->get_prdbyid($id);
        $list_spect = $this->products->get_spect($id);
        $list_value = $this->products->get_spect($id);

        if ($product_variant && $list_value) {
            $value = $product_variant[0];
            $list_value = $list_value[0];
            require_once './views/products/update_products.php';
        } else {
            echo 'Không tìm thấy sản phẩm hoặc thông số kỹ thuật';
        }
    }
    
    public function views_update_des($id)
    {
        $list_Category = $this->products->get_category();
        $product_variant = $this->products->get_prdbyid($id);
        $list_spect = $this->products->get_spect($id);
        $list_value = $this->products->get_spect($id);

        if ($product_variant && $list_value) {
            $value = $product_variant[0];
            $list_value = $list_value[0];
            require_once './views/products/update_des.php';
        }else{
            echo 'Khong tim thay san pham';
        }
    
    }

    public function views_update_spect($id)
    {
        $list_Category = $this->products->get_category();
        $product_variant = $this->products->get_prdbyid($id);
        $list_spect = $this->products->get_spect($id);
        $list_value = $this->products->get_spect($id);

        if ($product_variant && $list_value) {
            $value = $product_variant[0];
            $list_value = $list_value[0];
            require_once './views/products/update_spect.php';
        } else {
            echo 'Không tìm thấy sản phẩm hoặc thông số kỹ thuật';
        }
    }
    
    public function update_products() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $category = $_POST['category'];
            $description = $_POST['description'];
            
            $products = $this->products->updatePrd($id, $name, $category, $description);
            
            if ($products) {
                if (isset($_POST['specifications']) && is_array($_POST['specifications'])) {
                    foreach ($_POST['specifications'] as $spec) {
                        $specName = $spec['Specification_Name'] ?? '';
                        $specValue = $spec['Specification_Value'] ?? '';
    
                        if (!empty($specName) && !empty($specValue)) {
                            $existingSpec = $this->products->get_Products_spect($id, $specName);
                            if ($existingSpec) {
                                $this->products->update_Products_spect($id, $specName, $specValue);
                            } else {
                                $this->products->add_Products_spect($id, $specName, $specValue);
                            }
                        }
                    }
                }
            } else {
                echo "Update product information failed.";
            }
    
            header('Location: ?act=products');
            exit;
        } else {
            echo "Request method is not POST.";
        }
    }
    public function update_spect() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $productId = $_POST['id'] ?? null;
        $specifications = $_POST['specifications'] ?? null;
    
        if ($productId && is_array($specifications)) {
            foreach ($specifications as $spec) {
                $specName = $spec['Specification_Name'] ?? '';
                $specValue = $spec['Specification_Value'] ?? '';
    
                if (!empty($specName) && !empty($specValue)) {
                    $existingSpec = $this->products->get_Products_spect($productId, $specName);
                    
                    if ($existingSpec) {
                        $this->products->update_Products_spect($productId, $specName, $specValue);
                    } else {
                        $this->products->add_Products_spect($productId, $specName, $specValue);
                    }
                }
            }
        }
    }
    header('Location: ?act=product_detail&id=' . $productId);
}
    
    
    public function viewAdd_variant() {
        $id = $_GET['id'];
        $product = $this->products->get_prdbyid($id);
        if ($product) {
            $product = $product[0];
                    require_once './views/products/add_variants.php';
        }
    }

    public function add_variants(){
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $products_id = $_POST['product_id'];
                if (isset($_POST['variants']) && is_array($_POST['variants'])) {
                    foreach ($_POST['variants'] as $index => $variant) {
                        $color = $variant['color'] ?? '';
                        $ram = $variant['ram'] ?? '';
                        $storage = $variant['storage'] ?? '';
                        $quantity = $variant['quantity'] ?? 0;
                        $price = $variant['price'] ?? 0;
    
                        $variants_id = $this->products->add_variants($products_id, $color, $ram, $storage, $price, $quantity);
                        if (isset($_FILES['variants']['name'][$index]['image']) && is_uploaded_file($_FILES['variants']['tmp_name'][$index]['image'])) {
                            $imageFile = [
                                'name' => $_FILES['variants']['name'][$index]['image'],
                                'tmp_name' => $_FILES['variants']['tmp_name'][$index]['image']
                            ];
                            $this->products->saveVariantImage($variants_id, $imageFile);
                        }
                    }
                }
            }
            header('Location: ?act=product_detail&id='.$products_id);
        }catch (Exception $e) {
            $errorMessage = $e->getMessage();
            header('Location: ?act=add_variant&id=' . $products_id . '&status=error&message=' . urlencode($errorMessage));
        }
        

    }
    public function delete_variant() {
        try {
            if (isset($_GET['variant_id']) && isset($_GET['product_id'])) {
                $variant_id = $_GET['variant_id'];
                $product_id = $_GET['product_id'];
                
                $this->products->delete_variant($variant_id);
    
                header('Location: ?act=product_detail&id=' . $product_id . '&status=success');
                exit;
            }
        } catch (PDOException $e) {
            $product_id = $_GET['product_id'];
            // Lưu thông báo lỗi vào biến
            $errorMessage = $e->getMessage();
            // Chuyển hướng tới trang chi tiết sản phẩm kèm thông báo lỗi
            header('Location: ?act=product_detail&id=' . $product_id . '&status=error&message=' . urlencode($errorMessage));
            exit;
        }
    }
    
    public function viewUpdate_variant() {
        $variant_id = $_GET['variant_id'];
        
        $variant = $this->products->get_variant($variant_id);
        if ($variant) {
            $product_id = $variant['product_id'];
            $product = $this->products->get_prdbyid($product_id);
    
            if ($product) {
                require_once './views/products/update_variants.php';
            } else {
                echo 'Không tìm thấy sản phẩm';
            }
        } else {
            echo 'Không tìm thấy biến thể';
        }
    }
    
    public function update_variants() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $variant_id = $_POST['variant_id'] ?? null;
            $product_id = $_POST['product_id'] ?? null;
    
            if (!$variant_id || !$product_id) {
                echo 'Thiếu ID sản phẩm hoặc ID biến thể';
                return;
            }
    
            $color = $_POST['color'] ?? '';
            $ram = $_POST['ram'] ?? '';
            $storage = $_POST['storage'] ?? '';
            $quantity = $_POST['quantity'] ?? 0;
            $price = $_POST['price'] ?? 0;
    
            $this->products->updateVariant($variant_id, $color, $ram, $storage, $quantity, $price);
    
            if (isset($_FILES['image']['name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
                $old_image = $_POST['old_image'] ?? '';
    
                if (!empty($old_image) && file_exists($old_image)) {
                    unlink($old_image);
                }
    
                $imageFile = [
                    'name' => $_FILES['image']['name'],
                    'tmp_name' => $_FILES['image']['tmp_name']
                ];
                $this->products->updateVariantImage($variant_id, $imageFile);
            }
    
            // Chuyển hướng tới trang chi tiết sản phẩm
            header('Location: ?act=product_detail&id=' . $product_id);
            exit;
        }
    }   
}