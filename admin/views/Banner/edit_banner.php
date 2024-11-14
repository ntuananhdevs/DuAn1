<form action="?act=edit_banner&id=<?= $banner['id'] ?>" method="POST" enctype="multipart/form-data" class="p-4 border rounded bg-light">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($banner['title']) ?>" required class="form-control">
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" class="form-control"><?= htmlspecialchars($banner['description']) ?></textarea>
    </div>

    <div class="form-group">
        <label for="position">Position</label>
        <select id="position" name="position" class="form-control">
            <option value="homepage" <?= $banner['position'] === 'homepage' ? 'selected' : '' ?>>Homepage</option>
            <option value="sidebar" <?= $banner['position'] === 'sidebar' ? 'selected' : '' ?>>Sidebar</option>
            <option value="footer" <?= $banner['position'] === 'footer' ? 'selected' : '' ?>>Footer</option>
        </select>
    </div>

    <div class="form-group">
        <label for="start_date">Start Date</label>
        <input type="datetime-local" id="start_date" name="start_date" 
               value="<?= date('Y-m-d\TH:i', strtotime($banner['start_date'])) ?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="end_date">End Date</label>
        <input type="datetime-local" id="end_date" name="end_date" 
               value="<?= $banner['end_date'] ? date('Y-m-d\TH:i', strtotime($banner['end_date'])) : '' ?>" class="form-control">
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select id="status" name="status" class="form-control">
            <option selected disabled>Status</option>
            <option value="active" <?= $banner['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
            <option value="inactive" <?= $banner['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
            <option value="expired" <?= $banner['status'] == 'expired' ? 'selected' : ''; ?>>Expired</option>
        </select>
    </div>
<br>
    <div class="form-group">
        <label for="img_url">Image</label>
        <input type="file" id="img_url" name="img_url"  class="form-control" >
        <?php if ($banner['img_url']): ?>
            <div class="mt-2">
                <img src="../uploads/BannerIMG/<?= $banner['img_url'] ?>" alt="Current Image" width="200px" class="img-thumbnail">
              
        <?php endif; ?>
    </div>

    <br>
    <button type="submit" class="btn btn-primary">Update Banner</button>
</form>
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
