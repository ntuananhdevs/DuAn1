<div class="container">
    <h3 class="mb-0 h4 font-weight-bolder mb-4">Products Variant</h3>
        <a href="?act=add_variant&id=<?php echo $product['id'] ?>" class="btn btn-primary">Add Variant</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Color</th>
                <th scope="col">Ram</th>
                <th scope="col">Storage</th>
                <th scope="col">Sale</th>
                <th scope="col">Original Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listPrd_Variant as $key => $value) : ?>
                <tr>
                    <td><?php echo $value['variant_id'] ?></td>
                    <td><?php echo $value['product_name'] ?> | <?php echo $value['ram'] ?> | <?php echo $value['storage'] ?></td>
                    <td><img src="<?php echo $value['img']; ?>" alt="img" style="width:50px;height:auto;"></td>
                    <td><?php echo $value['color'] ?></td>
                    <td><?php echo $value['ram'] ?></td>
                    <td><?php echo $value['storage'] ?></td>
                    </td>
                    <td></td>
                    <td><?php echo number_format(floatval(str_replace('.', '', $value['price'])), 0, ',', '.'); ?> vnđ</p>
                    <td><?php echo $value['quantity'] ?></td>
                    <td>
                      <a href="?act=update_variant&variant_id=<?php echo $value['variant_id']; ?>&product_id=<?php echo $value['product_id']; ?>" class="btn btn-primary">Edit</a>
                      <a href="#"  class="btn btn-danger" onclick="openModal(event, '<?php echo $value['variant_id']; ?>', '<?php echo $value['product_id']; ?>')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <div class="des border p-3 bg-light rounded table">
        <h3 class="mb-0 h4 font-weight-bolder mb-4 text-center">Description</h3>
        <ul>
            <?php
                function splitTextIntoLines($text){
                    return preg_split('/(?<=[.!?])\s+/', trim($text));
                }

                $sentences = splitTextIntoLines($value['description']);
                foreach ($sentences as $sentence) {
                    echo "<li>" . nl2br(htmlspecialchars($sentence)) . "</li>";
                }
            ?>
        </ul>
        <a href="?act=update_des&id=<?php echo $value['product_id'] ?>" class="btn btn-primary mt-2">Edit</a>
    
    
    
        <hr>
        <h3 class="mb-0 h4 font-weight-bolder mb-4 text-center">Thông số kỹ thuật</h3>
        <table class="table table-bordered">
            <tbody>
                <?php foreach ($list_spect as $index => $spec) : ?>
                    <tr class="<?php echo $index % 2 == 0 ? 'bg-light' : ''; ?>">
                        <td class="font-weight-bold" style="width: 20%;"><?php echo htmlspecialchars($spec['Specification_Name']); ?></td>
                        <td><?php echo htmlspecialchars($spec['Specification_Value']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="?act=update_spect&id=<?php echo $value['product_id'] ?>" class="btn btn-primary mt-2">Edit</a>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="confirmModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Xác nhận xóa</h5>
      </div>
      <div class="modal-body">
        <p>Bạn có chắc chắn muốn xóa biến thể này?</p>
      </div>
      <div class="modal-footer gap-2">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" style="width: 100px;">Hủy</button>
        <button type="button" class="btn btn-danger" onclick="confirmDelete()" style="width: 100px;">Xóa</button>
      </div>
    </div>
  </div>
</div>

<?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] == 'success'): ?>
        <div id="alertMessage" class="alert alert-success alert-dismissible slide-in position-fixed top-0 end-0 m-3" role="alert" style="z-index: 1050; max-width: 400px;">
            Xóa sản phẩm thành công!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($_GET['status'] == 'error'): ?>
        <div id="alertMessage" class="alert alert-danger alert-dismissible slide-in position-fixed top-0 end-0 m-3" role="alert" style="z-index: 1050; max-width: 400px;">
            Không thể xóa sản phẩm lúc này
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




<script>
function openModal(event, variantId, productId) {
    event.preventDefault();
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'), { backdrop: false });
    document.getElementById('confirmModal').dataset.variantId = variantId;
    document.getElementById('confirmModal').dataset.productId = productId;
    confirmModal.show();
}

function confirmDelete() {
    const variantId = document.getElementById('confirmModal').dataset.variantId;
    const productId = document.getElementById('confirmModal').dataset.productId;
    window.location.href = `?act=delete_variant&variant_id=${variantId}&product_id=${productId}`;
}

</script>
