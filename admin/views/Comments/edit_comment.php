<div class="container">
    <h3 class="mb-0 h4 font-weight-bolder mb-4">Edit Comment</h3>
    <form method="post" action="index.php?act=edit&id=<?= $comment['ID']; ?>">
        <div class="form-group">
            <label for="content">Comment Content</label>
            <textarea id="content" name="newContent" class="form-control" required><?= htmlspecialchars($comment['Content']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Comment</button>
        <a href="index.php?act=view_comments&product_id=<?= $_GET['product_id']; ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
