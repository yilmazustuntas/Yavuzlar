<?php
session_start();
include "./controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
}
include "./controllers/customer-controller.php";
$orders = GetOrders($_SESSION['user_id']);
require_once "header.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/style.css">
    <title>Orders</title>
</head>

<body>
    <div class="centerDiv">
        <h1>Siparişleriniz</h1>
        <a href="old-orders.php" class="container_obj b<?php echo $_SESSION['role']; ?>"><button style="border-radius: 15px; background-color: #59b471;">Eski Siparişler</button></a>
        <?php
        if (empty($orders)) {
            echo "<p>Mevcutta herhangi bir sipariş bulunamadı.</p>";
        } else { ?>
            <div class="searchbox">
                <input style="border-radius: 8px; width: 200px; height: 25px;" type="search" id="searchbox" placeholder="Sipariş Ara" />
            </div>
            <table class="dataTable">
                <thead>
                    <tr>
                        <th>Sipariş Durumu</th>
                        <th>Toplam Fiyat</th>
                        <th>Sipariş Tarihi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): if ($order['order_status'] == 0 || $order['order_status'] == 1) { ?>
                            <tr class="dataElement t<?php echo $_SESSION['role']; ?>">
                                <td>
                                    <p><?php switch ($order["order_status"]) {
                                            case 0:
                                                echo "Hazırlanıyor";
                                                break;
                                            case 1:
                                                echo "Yola Çıktı";
                                                break;
                                            case 2:
                                                echo "Teslim Edildi";
                                                break;
                                            default:
                                                echo "Hata!";
                                                break;
                                        }
                                        ?></p>
                                </td>
                                <td>
                                    <p><?php echo $order["total_price"]; ?></p>
                                </td>
                                <td>
                                    <p><?php echo $order["created_at"]; ?></p>
                                </td>
                            </tr>
                    <?php }
                    endforeach  ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
    <div class="centerDiv">
        <a href="index.php"><button style="border-radius: 15px; background-color: #59b471;">Ana Sayfa</button></a>
    </div>
    <?php require_once "footer.php"; ?>
</body>

</html>