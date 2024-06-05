<?php
$result_categories = mysqli_query($baglanti, "SELECT * FROM categories");

$categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
?>
<div class="categories">
    <ul>
        <li><a href="../index.php" class="category-anasayfa">Anasayfa</a></li>
        <?php foreach ($categories as $categori) : ?>
            <li><a href="../index.php?id=<?php echo $categori["id"] ?>" class="category"><?php echo $categori["kategoriler"]; ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>