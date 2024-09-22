<?php
session_start();
include "./controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ./admin.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 0) {
    header("Location: ./index.php?message=403 Yetkisiz Giriş");
} else {
    include "./controllers/admin-controller.php";
    $restaurants = GetRestaurants();
    require_once "header.php";
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./public/css/style.css">
        <title>Add Cupon</title>
    </head>

    <body>
        <div class="container">
            <div class="login t<?php echo $_SESSION['role']; ?>">
                <h3>Kupon Ekle</h3>
                <form action="./scripts/add-cupon-query.php" method="post" enctype="multipart/form-data">
                    <div class="container_obj">
                        <label for="name">Kupon Adı</label><br>
                        <input style="border-radius: 15px; width: 200px; padding: 5px; margin-top: 10px;" type="text" name="name" placeholder="Kupon Adı" required />
                    </div>
                    <div class="container_obj">
                        <label for="discount">İndirim</label><br>
                        <input style="border-radius: 15px; width: 200px; padding: 5px; margin-top: 10px;" type="number" min="1" max="100" name="discount" placeholder="İndirim" required />
                    </div>
                    <div class="container_obj">
                        <label for="restaurant">Restoran:</label><br>
                        <select style="border-radius: 15px; width: 200px; padding: 5px; margin-top: 10px;" name="restaurant">
                            <option value="" selected="selected">Genel</option>
                            <?php foreach ($restaurants as $restaurant): ?>
                                <option value="<?php echo $restaurant['id']; ?>"><?php echo $restaurant['name']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <button style="border-radius: 15px;" type="submit">Kaydet</button>
                </form>
            </div>
        </div>
        <?php require_once "footer.php"; ?>
    </body>

    </html>
<?php } ?>