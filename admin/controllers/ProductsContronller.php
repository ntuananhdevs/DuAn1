<?php
class ProductsController
{
    public $products;

    public function __construct()
    {
        $this->products = new Products();
    }

    public function views_products()
    {
        $listProducts = $this->products->get_products();
        require_once './views/products/products.php';
    }
    public function views_add()
    {
        $list_Category = $this->products->get_category();
        require_once './views/products/add_products.php';
    }
    public function viewPrd_Variant($id)
    {
        $listProducts = $this->products->get_products();
        $listPrd_Variant = $this->products->getPrd_Variant($id);
        $list_spect = $this->products->get_spect($id);
        require_once './views/products/product_variant.php';
    }

    public function add_product()
    {
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
    }
    public function deletePrd($id){
        $this->products->deletePrd($id);
        header('Location: ?act=products' . '&status=success');
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
        $listProducts = $this->products->get_products();
        require_once './views/products/add_variants.php';
    }

    public function add_variants(){
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

    }
    public function delete_variant() {
        if (isset($_GET['variant_id']) && isset($_GET['product_id'])) {
            $variant_id = $_GET['variant_id'];
            $product_id = $_GET['product_id'];
            
            $this->products->delete_variant($variant_id);

            header('Location: ?act=product_detail&id=' . $product_id . '&status=success');
            exit;
        } else {
            header('Location: ?act=product_list');
            exit;
        }
    }
    
    public function viewUpdate_variant() {
        $id = $_GET['variant_id'] ?? null;
        if ($id) {
            $variant = $this->products->get_variants($id); 
            require_once './views/products/update_variant.php'; 
        }
    }
    public function update_variants(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $variant_id = $_POST['variant_id'];
            $product_id = $_POST['product_id'];
            $color = $_POST['color'] ?? '';
            $ram = $_POST['ram'] ?? '';
            $storage = $_POST['storage'] ?? '';
            $quantity = $_POST['quantity'] ?? 0;
            $price = $_POST['price'] ?? 0;
    
            // Cập nhật thông tin biến thể trong database
            $this->products->update_variant($variant_id, $color, $ram, $storage, $price, $quantity);
    
            if (isset($_FILES['image']['name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
                $imageFile = [
                    'name' => $_FILES['image']['name'],
                    'tmp_name' => $_FILES['image']['tmp_name']
                ];
                $this->products->saveVariantImage($variant_id, $imageFile); // Cập nhật ảnh
            }
    
            header('Location: ?act=product_detail&id=' . $product_id . '&status=updated');
        } else {
            header('Location: ?act=product_list');
        }
    }
    
}