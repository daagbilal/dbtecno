<?php require_once("../parts/config.php"); ?>
<?php require("../libs/functions.php") ?>
<?php session_start(); ?>
<?php
if (isLoggedIn()) {
    $musteri_id = $_SESSION["musteri_id"];
    $sql = "SELECT * FROM evaluations WHERE musteri_id = ? ORDER BY add_time DESC;";
    $stmt = mysqli_prepare($baglanti, $sql);
    mysqli_stmt_bind_param($stmt, "i", $musteri_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $evaluations = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    header("Location: ../login.php");
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Değerlendirmelerim</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"   />
</head>

<body style="background-color: #daddd678;">

    <?php include("../parts/index_header.php"); ?>
    <h2 class="sepetim-baslik" style="text-align: center;">Değerlendirmelerim</h2>
    <div class="sepet-content">
        <?php include("../parts/user_menu.php") ?>
        <?php if (!empty($evaluations)) : ?>
            <div class="evaluation-content">
                <?php foreach ($evaluations as $evaluation) : ?>
                    <div class="evaluation">
                        <h4 style="margin: 10px">
                            <?php echo $evaluation["urun"] ?>
                        </h4>
                        <div class="degerlendirme-head">
                            <div>Puan: <?php echo $evaluation["puan"] ?></div>
                            <div><?php echo $evaluation["add_time"] ?></div>
                            <button class="delete-evaluation" onclick="del_eval(<?php echo $evaluation['urun_kodu'] ?>)"><i class="fa-solid fa-trash-can fa-lg"></i></button>
                        </div>
                        <div class="degerlendirme-yorum">
                            <p><?php echo $evaluation["yorum"] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (empty($evaluations)) : ?>
            <div class="evaluation-content">
                <div style="font-size: 20px;">Hiçbir üründe değerlendirmeniz yok.</div>
            </div>
        <?php endif; ?>
    </div>
    <?php mysqli_close($baglanti) ?>
    <?php include("../parts/avantaj.php") ?>
    <?php include("../parts/footer.php") ?>
    <script src="../libs/app.js"></script>
</body>
</html>