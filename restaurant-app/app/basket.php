<?php
session_start();
include "./controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 2) {
    header("Location: ./index.php?message=403 Yetkisiz Giriş");
}
include "./controllers/customer-controller.php";
$datas = GetBasket($_SESSION['user_id']);
require_once "header.php";

$totalPrice = 0;
$discountAmount = 0;
$hasCoupon = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['coupon_code'])) {
    $restaurantId = $datas[0]['food_restaurant_id']; 
    $coupon = GetCuponByRId($restaurantId);

    if ($coupon && isset($coupon['discount'])) {
        $hasCoupon = true;
        $discountAmount = $coupon['discount'];
    } else {
        $hasCoupon = false;
        echo "<p>Geçersiz kupon kodu veya restoran için kupon bulunamadı!</p>"; 
    }
}
foreach ($datas as $data) {
    if ($data['food_discount'] > 0) {
        $totalPrice += $data['basket_quantity'] * $data['food_price'] * (100 - $data['food_discount']) / 100;
    } else {
        $totalPrice += $data['basket_quantity'] * $data['food_price'];
    }
}

$discountedPrice = $totalPrice;

if ($hasCoupon) {
    $discountedPrice *= (100 - $discountAmount) / 100; 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/style.css">
    <title>Basket</title>
</head>

<body>
    <div>
        <h1 class="searchbox">Sepet</h1>
        <?php if (empty($datas)) {
            echo "<p class='searchbox'>Sepetiniz boş.</p>";
        } else { ?>
            <div class="searchbox">
                <input style="border-radius: 8px; width: 200px; height: 25px;" type="search" id="searchbox" placeholder="Yemek Ara" />
            </div>
            <div class="centerDiv">

                <table class="dataTable">
                    <thead>
                        <tr>
                            <th>Fotoğraf</th>
                            <th>Yemek</th>
                            <th>Açıklama</th>
                            <th>Fiyat</th>
                            <th>İndirim</th>
                            <th>Sipariş Notu</th>
                            <th>Sayı</th>
                            <th>Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($datas as $data): ?>
                            <tr class="dataElement t<?php echo $_SESSION['role']; ?>">
                                <td>
                                    <img class="food_photo" src="<?php echo $data["food_image_path"]; ?>" alt="Yemek Fotoğrafı">
                                </td>
                                <td>
                                    <p><?php echo $data["food_name"]; ?></p>
                                </td>
                                <td>
                                    <p style="text-wrap:nowrap;" class="description"><?php echo $data["food_description"]; ?></p>
                                </td>
                                <td>
                                    <p style="border-radius: 15px;" <?php echo $data['food_discount'] ? "class='highlight" . $_SESSION['role'] . "'>" . $data["food_price"] * (100 - $data['food_discount']) / 100 : ">" . $data['food_price']; ?></p>
                                </td>
                                <td>
                                    <p><?php echo $data['food_discount'] > 0 ? "%" . $data["food_discount"] . "!" : ""; ?></p>
                                </td>
                                <td>
                                    <p style="text-wrap:nowrap;" class="modalBtn description" data_id="<?php echo $data['basket_id']; ?>"><?php echo $data["basket_note"]; ?></p>
                                </td>
                                <td class="quantityContainer">
                                    <form action="./scripts/edit-quantity.php" method="post">
                                        <input type="hidden" name="basket_id" value="<?php echo $data['basket_id']; ?>">
                                        <input type="hidden" name="value" value="-1">
                                        <button style="border-radius: 15px; background-color: #59b471;" type="submit" class="editQuantity">-</button>
                                    </form>
                                    <p><?php echo $data["basket_quantity"]; ?></p>
                                    <form action="./scripts/edit-quantity.php" method="post">
                                        <input type="hidden" name="basket_id" value="<?php echo $data['basket_id']; ?>">
                                        <input type="hidden" name="value" value="1">
                                        <button style="border-radius: 15px; background-color: #59b471;" type="submit" class="editQuantity">+</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="./scripts/delete-basket-item.php" method="post">
                                        <input type="hidden" name="basket_id" value="<?php echo $data['basket_id']; ?>">
                                        <button type="submit" style="border-radius: 15px; background-color: white;">X</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="centerDiv">
                <p>Toplam Fiyat: <?php echo number_format($totalPrice, 2); ?></p>
                <?php if ($hasCoupon) : ?>
                    <p>İndirim: <?php echo $discountAmount; ?>%</p>
                    <p>İndirimli Fiyat: <?php echo number_format($discountedPrice, 2); ?></p>
                <?php endif; ?>
            </div>
            <div class="centerDiv">
                <form action="basket.php" method="post">
                    <input style="border-radius: 8px; width: 200px; height: 25px;" type="text" name="coupon_code" placeholder="Kupon Kodu Girin">
                    <button style="border-radius: 15px; background-color: #59b471;" type="submit">Kuponu Uygula</button>
                </form>
            </div>
            <div class="centerDiv">
                <form action="./scripts/confirm-basket.php" method="post">
                    <input type="hidden" name="total_price" value="<?php echo $hasCoupon ? $discountedPrice : $totalPrice; ?>">
                    <button style="border-radius: 15px; background-color: #59b471;" type="submit">Onayla</button>
                </form>
            </div>
        <?php } ?>
    </div>
    <div class="centerDiv">
        <a href="index.php" class="b<?php echo $_SESSION['role']; ?>"><button style="border-radius: 15px; background-color: #59b471;">Ana Sayfa</button></a>
    </div>
    <div id="modal" class="modal">
        <div class="modal-content centerDiv">
            <h3>Notu Güncelle</h3>
            <form action="./scripts/edit-note.php" method="post" class="centerDiv">
                <input style="border-radius: 8px; width: 200px; height: 25px;" hidden id="data_id" name="basket_id" value="">
                <input style="border-radius: 8px; width: 200px; height: 25px;" name="note" class="container_obj" type="text" placeholder="Notu güncelleyin">
                <button style="border-radius: 15px; background-color: #59b471;" type="submit" class="normal container_obj">Düzenle</button>
            </form>
            <button style="border-radius: 15px; background-color: #59b471;" class="close red">İptal</button>
        </div>
    </div>
    <?php require_once "footer.php"; ?>
</body>
<script src="./public/js/searchbox.js"></script>
<script src="./public/js/modal.js"></script>

</html>
