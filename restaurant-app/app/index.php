<?php
session_start();
include "./controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
}
if ($_SESSION['role'] == 2) {
    include "./controllers/admin-controller.php";
    $restaurant_cupons = GetCupons();

    $cupons = array_filter($restaurant_cupons, function ($cupon) {
        return $cupon['restaurant_id'] > 0;
    });
}
require_once "header.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/style.css">
    <title>Restaurant App</title>
</head>

<body>
<?php if ($_SESSION['role'] == 2 && $cupons) {?>
        <h2 style="text-align: center;">Fırsatlar</h2><?php
        foreach ($cupons as $cupon) {
            $restaurantName = GetRestaurantName($cupon['restaurant_id']); ?>
            <p class="headerText notification"><?php echo $restaurantName; ?> Restoranında %<?php echo $cupon['discount']; ?> indirim!</p>
    <?php }
    } ?>
    <div class="container">
        <div class="login t<?php echo $_SESSION['role']; ?>">

            <h2>Yavuzlar Restoran Uygulaması</h2>
            <h3>Hoşgeldin <?php echo $_SESSION['username']; ?>! </h3>
            <div>
                <a href="profile.php"><button style="border-radius: 15px;" class="container_obj">Profil</button></a><br>
                <div class="container_obj">
                <?php switch ($_SESSION['role']) {
                    case 0: ?>
                        <a href="customer-list.php"><button style="border-radius: 15px;" class="container_obj">Müşteriler</button></a>
                        <a href="company-list.php"><button style="border-radius: 15px;" class="container_obj">Firmalar</button></a>
                        <a href="cupons.php"><button style="border-radius: 15px;" class="container_obj">Kuponlar</button></a>
                    <?php break;
                    case 1: ?>
                        <a href="company.php"><button style="border-radius: 15px;" class="container_obj">Firma</button></a>
                        <a href="food-list.php"><button style="border-radius: 15px;" class="container_obj">Yemekler</button></a>
                        <a href="restaurant-list.php"><button style="border-radius: 15px;" class="container_obj">Restoranlar</button></a>
                        <a href="customer-orders.php"><button style="border-radius: 15px;" class="container_obj">Müşteri Siparişleri</button></a>
                    <?php break;
                    case 2: ?>
                        <a href="foods.php"><button style="border-radius: 15px;" class="container_obj">Yemekler</button></a>
                        <a href="orders.php"><button style="border-radius: 15px;" class="container_obj">Siparişler</button></a>
                        <a href="basket.php"><button style="border-radius: 15px;" class="container_obj">Sepet</button></a>
                <?php break;
                } ?>
                </div>
                <form action="logout.php" method="post"><button style="border-radius: 15px;">Çıkış Yap</button></form>
            </div>
        </div>
    </div>
    <?php
    require_once "footer.php";
    ?>
</body>

</html>