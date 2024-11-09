<div class="banner">
    <?php foreach ($banner as $item) : ?>
        <img src="<?php echo $item['img_url']; ?>" alt="<?php echo $item['title']; ?>">
    <?php endforeach; ?>
</div>