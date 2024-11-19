<style>
    body {
        background-color: #fcfcfc;
    }

    .product-header {
        margin-bottom: 20px;
    }

    .product-title {
        font-size: 1.8rem;
        font-weight: bold;
    }

    .star-rating {
        color: #ffc107;
    }

    .product-image {
        border-radius: 5px;
        padding: 10px;
        box-shadow: 0 0 4px 2px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }


    .thumbnail:hover,
    .thumbnail.selected {
        border-color: #007bff;
    }

    .spec-table th,
    .spec-table td {
        padding: 10px;

    }


    .spec-table th {
        background-color: #f8f9fa;
    }

    .review-section {
        margin-top: 20px;
    }

    .review-title {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .rating-bar {
        background-color: #f1f1f1;
        border-radius: 5px;
        height: 10px;
        margin: 5px 0;
    }

    .rating-bar-fill {
        background-color: #ffc107;
        border-radius: 5px;
    }



        .star-rating span {
            color: #ffc107;
            font-size: 25px;
        }

    .text-muted {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .thumbnail {
        box-shadow: 0 0 4px 2px rgba(0, 0, 0, 0.1);
    }

    .box-option{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
    .option{
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        height: 50px;
        justify-content: center;
        width: 130px;
    }
    .box-option-color{
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    .option-color{
        gap: 5px;
        width: 190px;
        border-radius: 5px;
        padding: 10px;
        border: 1px solid #ccc;
    }

    
</style>

<div class="container mt-4">
    <!-- Header sản phẩm -->
    <div class="product-header">
        <div class="d-flex align-items-center gap-3 ">
            <div class="name_prd ms-3">
                <p class="product-title mb-1">iPhone 16 Pro Max</p>
            </div>

            <div class="star-rating mb-2">
                <span>&#9733;&#9733;&#9733;&#9733;&#9733;</span>
            </div>
            <span class="text-muted mb-1">(8 đánh giá)</span>
        </div>
    </div>


    <!-- Hình ảnh sản phẩm -->
    <div class="row">
        <div class="box_products_details col-md-6">
            <div class="product-image d-flex justify-content-center align-items-center">
                <img src="uploads/Products/673a293d4ef22_iphone-16-1.webp" alt="iPhone 16 Pro Max" class="img-fluid mb-3 d-flex justify-content-center align-items-center   " style="width: 200px; height: 200px; ">
            </div>
            <!-- Hình ảnh thu nhỏ -->
            <div class=" d-flex mt-3 gap-2">
                <img src="uploads/Products/673a293d4ef22_iphone-16-1.webp" alt="Thumbnail 1" class="thumbnail img-thumbnail " style="width: 100px; height: 100px;">
                <img src="uploads/Products/673a293d4ef22_iphone-16-1.webp" alt="Thumbnail 1" class="thumbnail img-thumbnail " style="width: 100px; height: 100px;">
                <img src="uploads/Products/673a293d4ef22_iphone-16-1.webp" alt="Thumbnail 1" class="thumbnail img-thumbnail " style="width: 100px; height: 100px;">
                <img src="uploads/Products/673a293d4ef22_iphone-16-1.webp" alt="Thumbnail 1" class="thumbnail img-thumbnail " style="width: 100px; height: 100px;">
                <img src="uploads/Products/673a293d4ef22_iphone-16-1.webp" alt="Thumbnail 1" class="thumbnail img-thumbnail " style="width: 100px; height: 100px;">
                <img src="uploads/Products/673a293d4ef22_iphone-16-1.webp" alt="Thumbnail 1" class="thumbnail img-thumbnail " style="width: 100px; height: 100px;">

            </div>
        </div>

        <!-- Thông tin và lựa chọn sản phẩm -->
        <div class="col-md-6">
            <div class="option-group">
                <div class="box-option">
                    <div class="option">
                        <span class="fw-bold">1TB</span>
                        <p>46.490.000 đ</p>                        
                    </div>
                    <div class="option">
                        <span class="fw-bold">1TB</span>
                        <p>46.490.000 đ</p>                        
                    </div>
                </div>
            </div>

       <div class="option-group-color mt-4">
                <h5>Chọn màu để xem giá và chi nhánh có hàng</h5>
                <div class="box-option-color">
                    <div class="option-color d-flex justify-content-center align-items-center">
                        <img src="uploads/Products/673a293d4ef22_iphone-16-1.webp" alt="Titan Tự Nhiên" style="width: 40px; height: 40px;">
                        <p clas                                                                                     s="fw-bold justify-content-center align-items-center">Titan Tự Nhiên</p>
                    </div>
                    <div class="option-color d-flex justify-content-center align-items-center">
                        <img src="uploads/Products/673a293d4ef22_iphone-16-1.webp" alt="Titan Tự Nhiên" style="width: 40px; height: 40px;">
                        <p class="fw-bold justify-content-center align-items-center">Titan Tự Nhiên</p>
                    </div>
                    <div class="option-color d-flex justify-content-center align-items-center">
                        <img src="uploads/Products/673a293d4ef22_iphone-16-1.webp" alt="Titan Tự Nhiên" style="width: 40px; height: 40px;">
                        <p class="fw-bold justify-content-center align-items-center">Titan Tự Nhiên</p>
                    </div>
                    <div class="option-color d-flex justify-content-center align-items-center">
                        <img src="uploads/Products/673a293d4ef22_iphone-16-1.webp" alt="Titan Tự Nhiên" style="width: 40px; height: 40px;">
                        <p class="fw-bold justify-content-center align-items-center">Titan Tự Nhiên</p>
                    </div>
                    
                </div>
            </div> 

            <div class="btn-details mt-5 d-flex justify-content-center align-items-center gap-3">
                <button type="button" class="btn btn-danger w-25">Mua ngay</button>
                <button type="button" class="btn btn-danger ">Them vao gio hang</button>
            </div>
        </div> 

            <!-- Giá sản phẩm -->

    </div>
    <div class="row mt-4 d-flex gap-3">
        <!-- Đặc điểm nổi bật -->

        <div class="description d-flex gap-4">
            <div class="col-md-8 p-3 border rounded">
                <h4 class="text-danger">Đặc Điểm Nổi Bật Của iPhone 16 Pro Max 512GB | Chính Hãng VN/A</h4>
                <ul>
                    <li>Màn hình Super Retina XDR 6.9 inches, đem đến cảm giác tuyệt vời khi cầm trên tay.</li>
                    <li>Điều khiển Camera - Chỉ cần trượt ngón tay để điều chỉnh camera.</li>
                    <li>Thiết kế titan 5 lớp mới nhất, nhẹ và bền.</li>
                    <li>Cài sẵn hệ điều hành iOS 18 với nhiều tính năng hữu ích.</li>
                </ul>
                <p>
                    iPhone 16 Pro Max phiên bản bộ nhớ trong 512GB có màn hình lớn Super Retina XDR OLED.
                    Máy có thiết kế mới với nút điều khiển camera, nút action cùng với màu titan sa mạc ấn tượng.
                </p>
            </div>
            <div class="col-md-4 p-3 border rounded">
            <h4 class="text-dark">Thông số kỹ thuật</h4>
            <table class="table table-bordered spec-table" >
                <tr>
                    <th>Kích thước màn hình</th>
                    <td>6.9 inches</td>
                </tr>
                <tr>
                    <th>Kích thước màn hình</th>
                    <td>6.9 inches</td>
                </tr>
                <tr>
                    <th>Công nghệ màn hình</th>
                    <td>Super Retina XDR OLED</td>
                </tr>
                <tr>
                    <th>Camera sau</th>
                    <td>Camera chính: 48MP, Telephoto 12MP, Camera góc siêu rộng 48MP</td>
                </tr>
                <tr>
                    <th>Chipset</th>
                    <td>Apple A18 Pro</td>
                </tr>
                <tr>
                    <th>Bộ nhớ trong</th>
                    <td>512 GB</td>
                </tr>
                <tr>
                    <th>Hệ điều hành</th>
                    <td>iOS 18</td>
                </tr>
                
            </table>
        </div>
        </div>
        
        <!-- Thông số kỹ thuật -->
        
    </div>


    <!-- Đánh giá sản phẩm -->
    <div class="review-section mt-4">
        <h4 class="review-title">Đánh giá & nhận xét iPhone 16 Pro Max 512GB | Chính hãng VN/A</h4>
        <div class="d-flex align-items-center">
            <div class="star-rating mr-3" style="font-size: 2rem;">
                &#9733;&#9733;&#9733;&#9733;&#9733;
            </div>
            <div>
                <span>5.0/5</span> (8 đánh giá)
            </div>
        </div>
        <div class="mt-3">
            <h5>Đánh giá theo trải nghiệm</h5>
            <div class="d-flex justify-content-between align-items-center">
                <span>5 sao</span>
                <div class="rating-bar">
                    <div class="rating-bar-fill" style="width: 100%;"></div>
                </div>
                <span>8 đánh giá</span>
            </div>
            <!-- Thêm phần cho các đánh giá từ 1 đến 4 sao tương tự -->
        </div>
    </div>
</div>

<script>
    // const options = document.querySelectorAll('.option');

    // options.forEach(option => {
    //     option.addEventListener('click', () => {
    //         // Loại bỏ trạng thái active trước đó
    //         document.querySelectorAll('.option.active').forEach(active => active.classList.remove('active'));
    //         // Thêm trạng thái active cho phần tử được chọn
    //         option.classList.add('active');
    //     });
    // });
</script>