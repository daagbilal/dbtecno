<?php require_once("../parts/config.php"); ?>
<?php require("../libs/functions.php") ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorilerim</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body style="background-color: #daddd678;">

    <?php include("../parts/index_header.php"); ?>
    <?php
    if (isLoggedIn()) {
        $musteri_id = $_SESSION["musteri_id"];
        $sql = "SELECT urun_kodu,resim_adi,marka,model,seri,fiyat FROM computers WHERE urun_kodu IN (
            SELECT urun_kodu FROM favorites WHERE musteri_id = ?
        )
        UNION
        SELECT urun_kodu,resim_adi,marka,model,seri,fiyat FROM phones WHERE urun_kodu IN (
            SELECT urun_kodu FROM favorites WHERE musteri_id = ?
        )
        UNION
        SELECT urun_kodu,resim_adi,marka,model,seri,fiyat FROM televisions WHERE urun_kodu IN (
            SELECT urun_kodu FROM favorites WHERE musteri_id = ?
        )
        UNION
        SELECT urun_kodu,resim_adi,marka,model,seri,fiyat FROM tablets WHERE urun_kodu IN (
            SELECT urun_kodu FROM favorites WHERE musteri_id = ?
        )
        UNION
        SELECT urun_kodu,resim_adi,marka,model,seri,fiyat FROM smart_watchs WHERE urun_kodu IN (
            SELECT urun_kodu FROM favorites WHERE musteri_id = ?
        );";
        $stmt = mysqli_prepare($baglanti, $sql);
        mysqli_stmt_bind_param($stmt, "iiiii", $musteri_id, $musteri_id, $musteri_id, $musteri_id, $musteri_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $favorites = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        header("Location: ../login.php");
    }
    ?>
    <h2 class="sepetim-baslik" style="text-align: center;">Favorilerim</h2>
    <div class="sepet-content">
        <?php include("../parts/user_menu.php") ?>
        <?php if (!empty($favorites)) : ?>
            <div class="favorites-content">
                <?php foreach ($favorites as $urun) : ?>
                    <a href="urun_detay.php?kod=<?php echo $urun['urun_kodu'] ?>" class="product" title="<?php echo "$urun[marka] $urun[model] $urun[seri]" ?>">
                        <form action="../libs/sepete_ekle.php" method="post">
                            <img src="../image/<?php echo "$urun[resim_adi]" ?>" alt="<?php echo "$urun[marka] $urun[model] $urun[fiyat]" ?>">
                            <h3><?php echo "$urun[marka]" ?></h3>
                            <h3><?php echo "$urun[model]" ?></h3>
                            <h4><?php echo "$urun[fiyat] TL" ?></h4>
                            <input type="hidden" name="product_id" value="<?php echo "$urun[urun_kodu]" ?>">
                            <button class="sepetekle1" type="submit" title="Sepete Ekle">Sepete Ekle</button>
                        </form>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (empty($favorites)) : ?>
            <div style="text-align: center; width: 75%;">
                <div style="font-size: 20px;">Favori ürününüz yok.</div>
            </div>
        <?php endif; ?>
    </div>
    <?php mysqli_close($baglanti) ?>
    <?php include("../parts/avantaj.php") ?>
    <?php include("../parts/footer.php") ?>
</body>

</html>