<div class="container">
    <h2 class="mb-0 h4 font-weight-bolder mb-4">Thêm Sản Phẩm và Biến Thể</h2>
    <form action="?act=post-product" method="post" enctype="multipart/form-data">
        <div class="col-md-7">
            <label for="name" class="form-label mb-0 font-weight-bolder">Tên Sản Phẩm</label>
            <input type="text" class="form-control" id="name" name="name" required style="width: 40%;">
        </div>
        <div class="col-md-7">
        <label class="form-label mb-0 font-weight-bolder">Brand</label>
                    <select class="form-select text-center" style="width: 40%;" name="category">
                        <option value="" selected class="text-center">Brand</option>
                        <?php foreach ($list_Category as $key) : ?>
                            <option value="<?php echo $key['id']; ?>"><?php echo $key['category_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
        </div>
        <div class="col-md-7">
            <label for="description" class="form-label mb-0 font-weight-bolder">Mô Tả</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <hr>
        <!-- Thông tin chi tiết khác của sản phẩm -->
        <div class="container">
            <h3 class="mb-0 h4 font-weight-bolder mb-4">Thông số chi tiết sản phẩm</h3>
            <!-- Màn hình -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="screenSize" class="form-label mb-0 font-weight-bolder">Kích thước màn hình</label>
                    <input type="text" class="form-control" id="screenSize" name="screen_size" placeholder="12.4 inches">
                </div>
                <div class="col-md-3">
                    <label for="screenResolution" class="form-label mb-0 font-weight-bolder">Độ phân giải màn hình</label>
                    <input type="text" class="form-control" id="screenResolution" name="screen_resolution" placeholder="2560 x 1600 (WQXGA)">
                </div>
                <div class="col-md-3">
                    <label for="screenFeatures" class="form-label mb-0 font-weight-bolder">Tính năng màn hình</label>
                    <input type="text" class="form-control" id="screenFeatures" name="screen_features" placeholder="Tần số quét 90Hz, Gam màu DCI-P3">
                </div>
            </div>

            <!-- Camera -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="rearCamera" class="form-label mb-0 font-weight-bolder">Camera sau</label>
                    <input type="text" class="form-control" id="rearCamera" name="rear_camera" placeholder="8 MP + 8 MP (góc siêu rộng)">
                </div>
                <div class="col-md-3">
                    <label for="videoResolution" class="form-label mb-0 font-weight-bolder">Quay video</label>
                    <input type="text" class="form-control" id="videoResolution" name="video_resolution" placeholder="UHD 4K (3840 x 2160)@30fps">
                </div>
            </div>

            <!-- Vi xử lý & đồ họa -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="chipset" class="form-label mb-0 font-weight-bolder">Chipset</label>
                    <input type="text" class="form-control" id="chipset" name="chip" placeholder="Exynos 1380">
                </div>
                <div class="col-md-3">
                    <label for="gpu" class="form-label mb-0 font-weight-bolder">GPU</label>
                    <input type="text" class="form-control" id="gpu" name="gpu" placeholder="Mali-G68 MP5">
                </div>
            </div>

<!-- RAM & lưu trữ -->

        </div>
        <hr>
        <div id="variants-container">
            <h3>Thêm Biến Thể</h3>
            <div class="variant">
                <!-- Color và Image -->
                <div class="color" style="display: flex; gap: 10px; align-items: center;">
                    <label class="form-label mb-0 font-weight-bolder">Chọn màu sắc:</label>
                    <select name="variants[0][color]" id="colorSelect0" class="form-select" style="width: 10%;">
                        <option value="" selected class="text-center">Chọn Màu</option>
                        <option value="black">Đen</option>
                        <option value="red">Đỏ</option>
                        <option value="green">Xanh lá</option>
                        <option value="blue">Xanh dương</option>
                    </select>
                    <input type="text" placeholder="Thêm màu mới" onkeypress="addOption(event, 'colorSelect0')" class="form-control" style="width: 12%;">

                    <label>Hình ảnh:</label>
                    <input type="file" class="form-control" name="variants[0][image]" accept="image/*" onchange="previewImage(this, 0) " style="width: 26%;">
                    <img id="imagePreview0" src="" alt="Image Preview" style="display:none; width: 50px; height: 50px; ">
                </div>

                <!-- RAM -->
                <div class="ram" style="display: flex; gap: 10px; align-items: center; margin-top: 10px;">
                    <label class="form-label mb-0 font-weight-bolder me-4">Chọn Ram:</label>
                    <select name="variants[0][ram]" id="ramSelect0" class="form-select" required style="width: 20%;">
                        <option value="">Ram</option>
                        <option value="4GB">4GB</option>
                        <option value="8GB">8GB</option>
                        <option value="12GB">12GB</option>
                        <option value="16GB">16GB</option>
                    </select>
                    <input type="text" placeholder="Thêm RAM mới" onkeypress="addOption(event, 'ramSelect0')" class="form-control" style="width: 20%;">
                </div>

                <!-- Storage -->
                <div class="storage" style="display: flex; gap: 10px; align-items: center; margin-top: 10px;">
                    <label class="form-label mb-0 font-weight-bolder me-1">Chọn Storage:</label>
                    <select name="variants[0][storage]" id="storageSelect0" class="form-select" required style="width: 20%;">
                        <option value="">Storage</option>
                        <option value="64GB">64GB</option>
                        <option value="128GB">128GB</option>
                        <option value="256GB">256GB</option>
                        <option value="512GB">512GB</option>
                    </select>
                    <input type="text" placeholder="Thêm Storage mới" onkeypress="addOption(event, 'storageSelect0')" class="form-control" style="width: 20%;">
                </div>

                <!-- Quantity và Price -->
                <div class="quantity-price" style="display: flex; gap: 10px; align-items: center; margin-top: 10px;">
                    <label class="form-label mb-0 font-weight-bolder me-3">Quantity:</label>
                    <input type="text" name="variants[0][quantity]" min="1" class="form-control ms-3" required style="width: 15%;">

                    <label class="form-label mb-0 font-weight-bolder me-3">Price:</label>
                    <input type="text" name="variants[0][price]" min="0" class="form-control" required style="width: 20%;">
                </div>
            </div>
        </div>

        <button type="button" onclick="addVariant()" class="btn btn-primary mt-2">Thêm Biến Thể Khác</button>
        <br><br>

        <button type="submit" class="btn btn-success">Thêm sản phẩm và biến thể</button>
    </form>
</div>

<script>
    let variantIndex = 1;

    function addVariant() {
        const container = document.getElementById("variants-container");
        const variantHtml = `
        <div class="variant">
            <hr>
            <div class="color" style="display: flex; gap: 10px; align-items: center;">
                <label class="form-label mb-0 font-weight-bolder">Chọn màu sắc:</label>
                <select name="variants[${variantIndex}][color]" id="colorSelect${variantIndex}" class="form-select"  style="width: 10%;>
                    <option value="">Chọn Màu</option>
                    <option value="black">Đen</option>
                    <option value="red">Đỏ</option>
                    <option value="green">Xanh lá</option>
                    <option value="blue">Xanh dương</option>
                </select>
                <input type="text" placeholder="Thêm màu mới" onkeypress="addOption(event, 'colorSelect${variantIndex}')" class="form-control" style="width: 12%;">
                
                <label>Hình ảnh:</label>
                <input type="file" name="variants[${variantIndex}][image]" accept="image/*" onchange="previewImage(this, ${variantIndex})" class="form-control" style="width: 26%;">
                <img id="imagePreview${variantIndex}" src="" alt="Image Preview" style="display:none; width: 50px; height: 50px; margin-left: 10px;">
            </div>

            <div class="ram" style="display: flex; gap: 10px; align-items: center; margin-top: 10px;">
                <label class="form-label mb-0 font-weight-bolder me-4">Chọn Ram:</label>
                <select name="variants[${variantIndex}][ram]" id="ramSelect${variantIndex}" class="form-select" required style="width: 20%;">
                    <option value="">Ram</option>
                    <option value="4GB">4GB</option>
                    <option value="8GB">8GB</option>
                    <option value="12GB">12GB</option>
                    <option value="16GB">16GB</option>
                </select>
                <input type="text" placeholder="Thêm RAM mới" onkeypress="addOption(event, 'ramSelect${variantIndex}')" class="form-control" style="width: 20%;">
            </div>

            <div class="storage" style="display: flex; gap: 10px; align-items: center; margin-top: 10px;">
                <label class="form-label mb-0 font-weight-bolder me-1">Chọn Storage:</label>
                <select name="variants[${variantIndex}][storage]" id="storageSelect${variantIndex}" class="form-select" required style="width: 20%;">
                    <option value="">Storage</option>
                    <option value="64GB">64GB</option>
                    <option value="128GB">128GB</option>
                    <option value="256GB">256GB</option>
                    <option value="512GB">512GB</option>
                </select>
                <input type="text" placeholder="Thêm Storage mới" onkeypress="addOption(event, 'storageSelect${variantIndex}')" class="form-control" style="width: 20%;">
            </div>

            <div class="quantity-price" style="display: flex; gap: 10px; align-items: center; margin-top: 10px;">
                <label class="form-label mb-0 font-weight-bolder me-3">Quantity:</label>
                <input type="text" name="variants[${variantIndex}][quantity]" min="1" class="form-control ms-3" required style="width: 15%;">

                <label class="form-label mb-0 font-weight-bolder me-3">Price:</label>
                <input type="text" name="variants[${variantIndex}][price]" min="0" class="form-control" required style="width: 20%;">
            </div>
        </div>
    `;
        container.insertAdjacentHTML("beforeend", variantHtml);
        variantIndex++;
    }

    function previewImage(input, index) {
        const preview = document.getElementById(`imagePreview${index}`);
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'inline';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
            preview.style.display = 'none';
        }
    }

    function addOption(event, selectId) {
        if (event.key === 'Enter') {
            event.preventDefault();
            const input = event.target;
            const select = document.getElementById(selectId);
            const value = input.value.trim();

            if (value) {
                const option = new Option(value, value);
                select.add(option);
                select.value = value;
                input.value = "";
            }
        }
    }
</script>