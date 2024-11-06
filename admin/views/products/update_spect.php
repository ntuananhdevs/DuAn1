<h3 class="mb-0 h4 font-weight-bolder mb-4">Edit Spect</h3>
<form action="?act=post_update_spect" method="post" enctype="multipart/form-data" class="form-container">
    <div class="spec-item">
        <?php foreach ($list_spect as $index => $spec) : ?>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">
                    <input type="text" 
                           name="specifications[<?php echo $index; ?>][Specification_Name]" 
                           value="<?php echo htmlspecialchars($spec['Specification_Name']); ?>" 
                           class="form-control" 
                           placeholder="Tên thuộc tính">
                </label>
                <div class="col-sm-9">
                    <input type="text" 
                           name="specifications[<?php echo $index; ?>][Specification_Value]" 
                           value="<?php echo htmlspecialchars($spec['Specification_Value']); ?>" 
                           class="form-control" 
                           placeholder="Giá trị">
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>



<style>
.form-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 10px;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.spec-item {
    display: grid;
    gap: 1rem;
}

.form-group.row {
    display: flex;
    align-items: center;
}

.col-form-label {
    font-weight: bold;
    flex: 1;
}

.form-control {
    flex: 3;
    padding: 8px;
}



</style>