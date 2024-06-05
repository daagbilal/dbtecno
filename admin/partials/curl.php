<?php
require_once("./simplehtmldom/simple_html_dom.php");

require_once("../../parts/config.php");
require("../../libs/functions.php");
session_start();
if (isAdminLoggedIn() && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT mgzurl FROM stokfiyat Where urun_kodu = ?";
    $stmt = mysqli_prepare($baglanti, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $url = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        $ch = curl_init();


        curl_setopt($ch, CURLOPT_URL, $url['mgzurl']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);


        $response = curl_exec($ch);


        if ($response === false) {
            echo "cURL hatası: " . curl_error($ch);
            exit;
        }

        curl_close($ch);

        // echo $response;

        $dom = new simple_html_dom($response);

        $html = $dom->find('.a-price-whole', 0);

        if (!empty($html)) {

            $html = $html->plaintext;

            $fiyat = str_replace(['.', ','], '', $html);

            $sql1 = "UPDATE stokfiyat SET fiyat = ? WHERE urun_kodu = ?";
            $stmt1 = mysqli_prepare($baglanti, $sql1);
            mysqli_stmt_bind_param($stmt1, "ii", $fiyat,$id);
            if (mysqli_stmt_execute($stmt1)) {
                $mesaj = "Ürün fiyatı güncellendi.";
            }else {
                $mesaj = "Fiyat güncellemede hata oluştu.";
            }
            exit(json_encode(['mesaj' => $mesaj]));
        }
    }
}
