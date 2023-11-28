<?php
if (isset($_SESSION["ad"])) {
    $name = $_SESSION["ad"];
}
?>


<div class="header">
    <a href="../index.php"><img src="../logo/2.png" alt="LOGO" class="logo"></a>
    <form class="search" method="get">
        <input class="search-1" type="search" name="search" placeholder="Arama">
        <button class="search-2" type="submit">Ara</button>
    </form>
    <?php
    if (isLoggedIn()) {
        echo "
                <div class='navbar'>
                    <ul>
                        <li>
                            <a class = 'button' style= 'margin-right: 5px;'>Hesabım</a>
                            <ul class='submenu'>
                                <li><h4 style='margin:0 ; padding:0 ;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>$name</h4></li>
                                <li><a href='../pages/siparis.php'>Siparişlerim</a></li>
                                <li><a href='../pages/profile.php'>Profilim</a></li>
                                <li><a href='../pages/favorites.php'>Beğendiklerim</a></li>
                                <li><a href='../pages/evaluations.php'>Değerlendirmelerim</a></li>
                                <li><a href='../libs/logout.php'>Çıkış</a></li>
                            </ul>
                        </li>
                        <li><a class = 'button' href= '../pages/sepet.php'>Sepetim</a><li>
                    </ul>
                </div>";
    } else {
        echo "
                <div class='navbar'>
                    <ul>
                        <li><a class = 'button' href='../login.php' style = 'margin-right: 5px;'>Giriş Yap</a><li>
                        <li><a class = 'button' href='../signup.php'>Üye Ol</a><li>
                    </ul>
                </div>";
    }
    ?>

</div>