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
    <div class="container">
        <div class="login t<?php echo $_SESSION['role']; ?>">

            <h2>Kampanyalar</h2>
            <h3>Hoşgeldin <?php echo $_SESSION['username']; ?>! </h3>
            <div>

            <?php if ($_SESSION['role'] == 2 && $cupons) {
            foreach ($cupons as $cupon) {
                $restaurantName = GetRestaurantName($cupon['restaurant_id']); ?>
                <p style="border: 2px solid #333; padding: 10px; margin: 20px; border-radius: 5px; background-color: #f9f9f9;  width: 300px;" >
                    <?php echo $restaurantName; ?> Restoranında %<?php echo $cupon['discount']; ?> indirim! <br>
                    Kupon Kodu: <strong><?php echo htmlspecialchars($cupon['name']); ?></strong>
                </p>
    <?php }
    } ?>
                <div class="container_obj">
                        <a href="foods.php"><button style="border-radius: 15px;" class="container_obj">Yemekler</button></a>
                        <a href="orders.php"><button style="border-radius: 15px;" class="container_obj">Siparişler</button></a>
                        <a href="basket.php"><button style="border-radius: 15px;" class="container_obj">Sepet</button></a>
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