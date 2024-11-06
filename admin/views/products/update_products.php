<div class="container">
    <h2 class="mb-0 h4 font-weight-bolder mb-4">Update Products</h2>
    <form action="?act=update-product-post" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?php echo $value['id']; ?>">

        <div class="col-md-7">
            <label for="name" class="form-label mb-0 font-weight-bolder">Tên Sản Phẩm</label>
            <input type="text" class="form-control" id="name" name="name" required style="width: 40%;" value="<?php echo $value['product_name']; ?>">
        </div>

        <div class="col-md-5">
            <label class="form-label mb-0 font-weight-bolder">Brand</label>
            <select class="form-select text-center" style="width: 40%;" name="category">
                <?php foreach ($list_Category as $key) : ?>
                    <option value="<?php echo $key['id']; ?>" <?php echo ($key['id'] == $value['category_id']) ? 'selected' : ''; ?>>
                        <?php echo $key['category_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
</div>

<div class="col-md-9 mt-3">
    <label class="form-label mb-0 font-weight-bolder">Description Sentences</label>
    <ul>
        <?php
        function splitTextIntoLines($text)
        {
            return preg_split('/(?<=[.!?])\s+/', trim($text));
        }

        $sentences = splitTextIntoLines($value['description']);
        foreach ($sentences as $sentence) {
            echo "<li>" . nl2br(htmlspecialchars($sentence)) . "</li>";
        }
        ?>
    </ul>
    <div class="mb-3">
        <label for="des" class="form-label mb-0 font-weight-bolder">Edit Description</label>
        <textarea class="form-control" id="des" name="description" rows="5"><?php echo htmlspecialchars($value['description']); ?></textarea>
    </div>
</div>
<hr>
<div class="container">
    <h3 class="mb-0 h4 font-weight-bolder mb-4">Thông số chi tiết sản phẩm</h3>
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

</div>

<button type="submit" class="btn btn-success mt-5">Cập nhật sản phẩm</button>
</form>
</div>



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