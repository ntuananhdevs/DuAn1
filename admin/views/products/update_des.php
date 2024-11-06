<h3 class="mb-0 h4 font-weight-bolder mb-4">Edit Products</h3>

<?php
// Hàm xử lý tách câu ra thành từng dòng

function splitTextIntoLines($text)
{
    $lines = preg_split('/(?<=[.?!])\s+/', $text);
    return array_map('trim', $lines); 
}
?>

<div class="container">
    <form action="?act=post_update_des" method="post" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($value['product_id']); ?>">
        <label class="form-label mb-0 font-weight-bolder">Description Sentences</label>
        <ul>
            <?php
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
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
