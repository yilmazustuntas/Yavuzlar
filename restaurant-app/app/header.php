<link rel="stylesheet" href="./public/css/header.css">
<div class="
<?php switch ($_SESSION['role']) {
    case 0:
        echo "admin_header";
        break;
    case 1:
        echo "company_header";
        break;
    case 2:
        echo "user_header";
        break;
} ?>">
    <a href="profile.php"><img class="profile_photo" src="./public/images/profile_logo.png" alt="Profil Logosu"></a>
    <a href="index.php" class="header_obj"><button style="border-radius: 15px;">Ana Sayfa</button></a>
    <?php switch ($_SESSION['role']) {
        case 0: ?>
            <a href="customer-list.php" class="header_obj"><button style="border-radius: 15px;">Müşteriler</button></a>
            <a href="company-list.php" class="header_obj"><button style="border-radius: 15px;">Firmalar</button></a>
            <a href="cupons.php" class="header_obj"><button style="border-radius: 15px;">Kuponlar</button></a>
        <?php break;
        case 1: ?>
            <a href="company.php" class="header_obj"><button style="border-radius: 15px;">Firma</button></a>
            <a href="food-list.php" class="header_obj"><button style="border-radius: 15px;">Yemekler</button></a>
            <a href="restaurant-list.php" class="header_obj"><button style="border-radius: 15px;">Restoranlar</button></a>
            <a href="customer-orders.php" class="header_obj"><button style="border-radius: 15px;">Müşteri Siparişleri</button></a>
        <?php break;
        case 2: ?>
            <a href="foods.php" class="header_obj"><button style="border-radius: 15px;">Yemekler</button></a>
            <a href="orders.php" class="header_obj"><button style="border-radius: 15px;">Siparişler</button></a>
            <a href="basket.php" class="header_obj"><button style="border-radius: 15px;">Sepet</button></a>
            <a href="campaign.php" class="header_obj"><button style="border-radius: 15px;">Kampanyalar</button></a>
    <?php break;
    } ?>
    <form action="logout.php" method="post"><button style="border-radius: 15px;" class="logout_btn" type="submit">Çıkış Yap</button></form>
</div>