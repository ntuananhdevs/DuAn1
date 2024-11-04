<?php
class ProductsController
{
    public $producsts;

    public function __construct()
    {
        $this->producsts = new Products();
    }

    public function views_products()
    {
        $listProducts = $this->producsts->get_products();
        require_once './views/products/products.php';
    }
    public function views_add()
    {
        $list_Category = $this->producsts->get_category();
        require_once './views/products/add_products.php';
    }
    public function viewPrd_Variant($id)
    {
        $description = $this->producsts->get_products();
        $listPrd_Variant = $this->producsts->getPrd_Variant($id);
        $list_spect = $this->producsts->get_spect($id);
        require_once './views/products/product_variant.php';
    }
    public function add_product()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productName = $_POST['name'] ?? '';
            $category = $_POST['category'] ?? '';
            $description = $_POST['description'] ?? '';

            // Thêm sản phẩm
            $products_id = $this->producsts->addProduct($productName, $category, $description);

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
                        $this->producsts->add_Products_spect($products_id, $key, $value);
                    }
                }
            }

            // Thêm các biến thể
            if (isset($_POST['variants']) && is_array($_POST['variants'])) {
                foreach ($_POST['variants'] as $index => $variant) {
                    $color = $variant['color'] ?? '';
                    $ram = $variant['ram'] ?? '';
                    $storage = $variant['storage'] ?? '';
                    $quantity = $variant['quantity'] ?? 0;
                    $price = $variant['price'] ?? 0;

                    $variants_id = $this->producsts->add_variants($products_id, $color, $ram, $storage, $price, $quantity);
                    if (isset($_FILES['variants']['name'][$index]['image']) && is_uploaded_file($_FILES['variants']['tmp_name'][$index]['image'])) {
                        $imageFile = [
                            'name' => $_FILES['variants']['name'][$index]['image'],
                            'tmp_name' => $_FILES['variants']['tmp_name'][$index]['image']
                        ];
                        $this->producsts->saveVariantImage($variants_id, $imageFile);
                    }
                }
            }
        }
        header('Location: ?act=products');
    }
    public function deletePrd($id)
    {
        $this->producsts->deletePrd($id);
        header('Location: ?act=products');
    }
    public function views_update($id)
    {
        $des_value = $this->producsts->getPrd_Variant($id);
        if($des_value){
            $des_value = $des_value[0];
            require_once './views/products/update_des.php';
        }else{

        }
    }
}
