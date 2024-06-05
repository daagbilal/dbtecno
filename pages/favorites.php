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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body style="background-color: #daddd678;">

    <?php include("../parts/index_header.php"); ?>
    <?php
    if (isLoggedIn()) {
        $musteri_id = $_SESSION["musteri_id"];
        $sql = "SELECT computers.urun_kodu,resim_adi,marka,model,seri,sf.fiyat FROM computers
        INNER JOIN stokfiyat sf ON sf.urun_kodu = computers.urun_kodu
        WHERE computers.urun_kodu IN (
            SELECT urun_kodu FROM favorites WHERE musteri_id = ?
        )
        UNION
        SELECT phones.urun_kodu,resim_adi,marka,model,seri,sf.fiyat FROM phones 
        INNER JOIN stokfiyat sf ON sf.urun_kodu = phones.urun_kodu
        WHERE phones.urun_kodu IN (
            SELECT urun_kodu FROM favorites WHERE musteri_id = ?
        )
        UNION
        SELECT televisions.urun_kodu,resim_adi,marka,model,seri,sf.fiyat FROM televisions 
        INNER JOIN stokfiyat sf ON sf.urun_kodu = televisions.urun_kodu
        WHERE televisions.urun_kodu IN (
            SELECT urun_kodu FROM favorites WHERE musteri_id = ?
        )
        UNION
        SELECT tablets.urun_kodu,resim_adi,marka,model,seri,sf.fiyat FROM tablets 
        INNER JOIN stokfiyat sf ON sf.urun_kodu = tablets.urun_kodu
        WHERE tablets.urun_kodu IN (
            SELECT urun_kodu FROM favorites WHERE musteri_id = ?
        )
        UNION
        SELECT smart_watchs.urun_kodu,resim_adi,marka,model,seri,sf.fiyat FROM smart_watchs 
        INNER JOIN stokfiyat sf ON sf.urun_kodu = smart_watchs.urun_kodu
        WHERE smart_watchs.urun_kodu IN (
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
                    <div class="product">
                        <a href="urun_detay.php?kod=<?php echo $urun['urun_kodu'] ?>" title="<?php echo "$urun[marka] $urun[model] $urun[seri]" ?>">
                            <img src="../image/<?php echo "$urun[resim_adi]" ?>" alt="<?php echo "$urun[marka] $urun[model] $urun[fiyat]" ?>">
                            <h3><?php echo "$urun[marka]" ?></h3>
                            <h3><?php echo "$urun[model]" ?></h3>
                            <h4><?php echo "$urun[fiyat] TL" ?></h4>
                        </a>
                        <button class="sepetekle1" type="submit" title="Sepete Ekle" onclick="sepetekle(<?php echo $urun['urun_kodu'] ?>)">Sepete Ekle</button>
                    </div>
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
    <script src="/libs/app.js"></script>
</body>

</html>