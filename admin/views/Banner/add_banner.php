

<div class="container-fluid">

   

    <div class="card">
        <div class="card-header">
            <h3 class="m-0 font-weight-bold text-primary">Thêm Banner Mới</h3>
        </div>
        <div class="card-body">
            <!-- Form để thêm mới banner -->
            <form action="index.php?act=add-banner-post" method="POST" enctype="multipart/form-data">
                <!-- Tiêu đề -->
                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input type="text" name="title" class="form-control" >
                </div>


                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
                
   
                <div class="form-group">
                    <label>Hình ảnh</label>
                    <input class="form-control" type="file" name="img_url"  required>
                </div>
                
   
                <div class="form-group">
                    <label>Vị trí</label>
                    <input type="text" name="position" class="form-control" value="homepage">
                </div>
                
                
                <div class="form-group">
                    <label>Ngày bắt đầu</label>
                    <input type="datetime-local" name="start_date"  id = "start_date" class="form-control" required>
                </div>
                
             
                <div class="form-group">
                    <label>Ngày kết thúc</label>
                    <input type="datetime-local" name="end_date" id = "end_date" class="form-control">
                </div>
                
           
                <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                
                <br>
                <br>
                <button type="submit" class="btn btn-primary">Add Banner</button>
                <a href="?act=banners" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const startDateInput = document.getElementById("start_date");
    const endDateInput = document.getElementById("end_date");

    function validateDates() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        if (endDate && startDate && endDate <= startDate) {
            alert("Ngày kết thúc phải sau ngày bắt đầu");
            endDateInput.value = "";  // Clear invalid date
        }
    }

    startDateInput.addEventListener("change", validateDates);
    endDateInput.addEventListener("change", validateDates);
});
</script>