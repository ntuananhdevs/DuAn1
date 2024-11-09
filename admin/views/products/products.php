<div class="container">
  <h3 class="mb-0 h4 font-weight-bolder mb-4">Products</h3>
  <a href="?act=add-product" class="btn btn-primary">Add Product</a>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Image</th>
        <th scope="col">Brand</th>
        <th scope="col">Total color</th>
        <th scope="col">Quantity</th>
        <th scope="col">Views</th>
        <th scope="col">Lowest Price</th>
        <th scope="col">Highest price</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($listProducts as $key => $value) : ?>
        <tr>
          <td><?php echo $value['ID'] ?></td>
          <td><?php echo $value['Name'] ?></td>
          <td><img src="<?php echo $value['Image']; ?>" alt="img" style="width:50px;height:auto;"></td>
          <td><?php echo $value['Category_name'] ?></td>
          <td><?php echo $value['Total_color'] ?></td>
          <td><?php echo $value['Quantity'] ?></td>
          <td><?php echo $value['Views'] ?></td>
          <td><?php echo number_format(floatval(str_replace('.', '', $value['Lowest_Price'])), 0, ',', '.'); ?> vnđ</td>
          <td><?php echo number_format(floatval(str_replace('.', '', $value['Highest_Price'])), 0, ',', '.'); ?> vnđ</td>
          <td>
            <a href="?act=product_detail&id=<?php echo $value['ID'] ?>" class="btn btn-primary">Details</a>
            <a href="?act=update_product&id=<?php echo $value['ID'] ?>" class="btn btn-warning">Edit</a>
            <a href="#" class="btn btn-danger" onclick="openModal(event, '<?php echo $value['ID'] ?>')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- Delete Confirmation Modal -->
<div id="confirmModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Xác nhận xóa</h5>
      </div>
      <div class="modal-body">
        <p>Bạn có chắc chắn muốn xóa sản phẩm này không?</p>
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
  function openModal(event, productId) {
    event.preventDefault();
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'), { backdrop: false });
    document.getElementById('confirmModal').dataset.productId = productId;
    confirmModal.show();
  }

  function confirmDelete() {
    const productId = document.getElementById('confirmModal').dataset.productId;
    window.location.href = `?act=delete_product&id=${productId}`;
  }
</script>
