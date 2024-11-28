<div class="container">
    <h2 class="mb-0 h4 font-weight-bolder mb-4">Add Variants</h2>
    <form action="?act=add_variants_post" method="post" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo $product['id'] ?>" name="product_id">
 
           <div id="variants-container">
            <div class="variant">
                <div class="color" style="display: flex; gap: 10px; align-items: center;">
                    <label class="form-label mb-0 font-weight-bolder">Chọn màu sắc:</label>
                    <select name="variants[0][color]" id="colorSelect0" class="form-select" style="width: 15%;">
                        <option value="" selected class="text-center">Chọn Màu</option>
                        <option value="Black">Đen</option>
                        <option value="Red">Đỏ</option>
                        <option value="Silver ">Bạc</option>
                        <option value="Gold">Vàng</option>
                        <option value="Purple">Tím</option>
                        <option value="Pink ">Hồng</option>
                        <option value="Midnight Green">Xanh rêu</option>
                        <option value="Graphite">Xám than chì</option>
                        <option value="Sierra Blue ">Xanh dương nhạt</option>
                        <option value="Space Gray ">Xám không gian</option>
                        <option value="Green">Xanh lá</option>
                        <option value="Blue">Xanh dương</option>
                        <option value="Titan Black">Titan Đen</option>
                        <option value="Titan White">Titan Trắng</option>
                        <option value="Titan Sa Mạc">Titan Sa Mạc</option>
                        <option value="Titan Natural ">Titan Tự Nhiên</option>
                        <option value="Titan Blue">Titan Xanh Dương</option>
                       
                    </select>

                    <label class="form-label mb-0 font-weight-bolder" style="margin-right: 37px;">Hình ảnh:</label>
                    <input type="file" class="form-control" name="variants[0][image]" accept="image/*" onchange="previewImage(this, 0) " style="width: 26%;">
                    <img id="imagePreview0" src="" alt="Image Preview" style="display:none; width: 50px; height: 50px; ">
                </div>

                <!-- RAM -->
                <div class="ram" style="display: flex; gap: 10px; align-items: center; margin-top: 10px;">
                    <label class="form-label mb-0 font-weight-bolder me-4">Chọn Ram:</label>
                    <select name="variants[0][ram]" id="ramSelect0" class="form-select" required style="width: 15%;">
                        <option value="">Ram</option>
                        <option value="4GB">4GB</option>
                        <option value="8GB">8GB</option>
                        <option value="12GB">12GB</option>
                        <option value="16GB">16GB</option>
                    </select>
                    <label class="form-label mb-0 font-weight-bolder me-2">Chọn Storage:</label>
                    <select name="variants[0][storage]" id="storageSelect0" class="form-select" required style="width: 15%;">
                        <option value="">Storage</option>
                        <option value="64GB">64GB</option>
                        <option value="128GB">128GB</option>
                        <option value="256GB">256GB</option>
                        <option value="512GB">512GB</option>
                    </select>
                </div>

                <!-- Storage -->
                <div class="storage" style="display: flex; gap: 10px; align-items: center; margin-top: 10px;">

                </div>
                <div class="quantity-price" style="display: flex; gap: 10px; align-items: center; margin-top: 10px;">
                    <label class="form-label mb-0 font-weight-bolder me-3">Quantity:</label>
                    <input type="text" name="variants[0][quantity]" min="1" class="form-control ms-3" required style="width: 15%;">

                    <label class="form-label mb-0 font-weight-bolder me-6" style="margin-right: 45px;">Price:</label>
                    <input type="text" name="variants[0][price]" min="0" class="form-control" required style="width: 15%;">
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
            <div style="display: flex; justify-content: flex-start;">
                <button type="button" class="btn btn-danger" onclick="removeVariant(this)">Remove</button>
            </div>
            <div class="color" style="display: flex; gap: 10px; align-items: center;">
                <label class="form-label mb-0 font-weight-bolder">Chọn màu sắc:</label>
                <select name="variants[${variantIndex}][color]" id="colorSelect${variantIndex}" class="form-select" style="width: 10%;">
                        <option value="" selected class="text-center">Chọn Màu</option>
                        <option value="Black">Đen</option>
                        <option value="Red">Đỏ</option>
                        <option value="Silver ">Bạc</option>
                        <option value="Gold">Vàng</option>
                        <option value="Purple">Tím</option>
                        <option value="Pink ">Hồng</option>
                        <option value="Midnight Green">Xanh rêu</option>
                        <option value="Graphite">Xám than chì</option>
                        <option value="Sierra Blue ">Xanh dương nhạt</option>
                        <option value="Space Gray ">Xám không gian</option>
                        <option value="Green">Xanh lá</option>
                        <option value="Blue">Xanh dương</option>
                        <option value="Titan Black">Titan Đen</option>
                        <option value="Titan White">Titan Trắng</option>
                        <option value="Titan Sa Mạc">Titan Sa Mạc</option>
                        <option value="Titan Natural ">Titan Tự Nhiên</option>
                        <option value="Titan Blue">Titan Xanh Dương</option>
                </select>
                <input type="text" placeholder="Thêm màu mới" id="colorInput${variantIndex}" onblur="addOptionOnBlur('colorSelect${variantIndex}', 'colorInput${variantIndex}')" class="form-control" style="width: 12%;">

                <label class="form-label mb-0 font-weight-bolder">Hình ảnh:</label>
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
                <input type="text" placeholder="Thêm RAM mới" id="ramInput${variantIndex}" onblur="addOptionOnBlur('ramSelect${variantIndex}', 'ramInput${variantIndex}')" class="form-control" style="width: 20%;">
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
                <input type="text" placeholder="Thêm Storage mới" id="storageInput${variantIndex}" onblur="addOptionOnBlur('storageSelect${variantIndex}', 'storageInput${variantIndex}')" class="form-control" style="width: 20%;">
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

    function removeVariant(el) {
        el.closest(".variant").remove();
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

    function addOptionOnBlur(selectId, inputId) {
        const input = document.getElementById(inputId);
        const select = document.getElementById(selectId);
        const value = input.value.trim();

        if (value) {
            const option = new Option(value, value);
            select.add(option);
            select.value = value; // Đặt giá trị vừa thêm vào làm lựa chọn hiện tại
            input.value = ""; // Xóa nội dung trong ô input
        }
    }
</script>


<?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] == 'success'): ?>
        <div id="alertMessage" class="alert alert-success alert-dismissible slide-in position-fixed top-0 end-0 m-3" role="alert" style="z-index: 1050; max-width: 400px;">
            Xóa sản phẩm thành công!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($_GET['status'] == 'error'): ?>
        <div id="alertMessage" class="alert alert-danger alert-dismissible slide-in position-fixed top-0 end-0 m-3" role="alert" style="z-index: 1050; max-width: 400px;">
            Biến thể đã tồn tại
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
<?php endif; ?>

<style>
  /* Hiệu ứng slide vào từ phải */
  .slide-in {
    transform: translateX(100%);
    animation: slideIn 0.5s forwards;
  }

  /* Hiệu ứng slide ra từ trái sang phải */
  .slide-out {
    animation: slideOut 0.5s forwards;
  }

  @keyframes slideIn {
    from {
      transform: translateX(100%);
    }
    to {
      transform: translateX(0);
    }
  }

  @keyframes slideOut {
    from {
      transform: translateX(0);
    }
    to {
      transform: translateX(100%);
    }
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
      var alertElement = document.getElementById('alertMessage');
      if (alertElement) {
        alertElement.classList.remove('slide-in');
        alertElement.classList.add('slide-out');
        setTimeout(function() {
          alertElement.remove();
        }, 500); // Đợi 0.5 giây để hiệu ứng slide-out hoàn thành
      }

      // Xóa các tham số `status` và `message` khỏi URL, giữ lại `act=products`
      var url = new URL(window.location.href);
      url.searchParams.delete('status');
      url.searchParams.delete('message');
      window.history.replaceState({}, '', url);
    }, 3000); // Hiển thị thông báo trong 3 giây trước khi trượt ra
  });
</script>


