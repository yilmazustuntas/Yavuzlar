<?php
session_start();
include "./controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ./admin.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 0) {
    header("Location: index.php?message=403 Yetkisiz Giriş");
} else {
    include "./controllers/admin-controller.php";
    $companies = GetCompanies();
    require_once "header.php";
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./public/css/style.css">
        <title>Company List</title>
    </head>

    <body>
        <div class="centerDiv">
            <h1 class="searchbox">Firmalar</h1>
            <a href="./add-company.php" class="centerDiv cleanText"><button style="border-radius: 15px;">Firma Ekle</button></a>
            <?php if (empty($companies)) {
                echo "<p>Hiç müşteri bulunamadı.</p>";
            } else { ?>
                <div class="searchbox">
                    <input style="border-radius: 8px; width: 200px;" type="search" id="searchbox" placeholder="Firma Ara" />
                    <div>
                        <label for="isBanned">&nbsp;Banlı mı?</label>
                        <input type="checkbox" id="isBanned" />
                    </div>
                </div>
                <table class="dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ad</th>
                            <th>Açıklama</th>
                            <th>Fotoğraf</th>
                            <th>Erişim Engellendi</th>
                            <th>Yemekler</th>
                            <th>Güncelle</th>
                            <th>Erişim Engeli</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($companies as $company): ?>
                            <tr class="t<?php echo $_SESSION['role']; ?> dataElement dataTable" is-banned="<?php echo $company['deleted_at'] ? 'true' : 'false'; ?>">
                                <td>
                                    <p> <?php echo $company['id']; ?> </p>
                                </td>
                                <td>
                                    <p> <?php echo $company['name']; ?> </p>
                                </td>
                                <td>
                                    <p> <?php echo $company['description']; ?> </p>
                                </td>
                                <td>
                                    <img src="<?php echo $company['logo_path']; ?>" alt="Firma Logosu" class="company_logo" title="<?php echo $company['logo_path']; ?>">
                                </td>
                                <td>
                                    <p><?php echo $company['deleted_at'] ? $company['deleted_at'] : "Mevcut"; ?></p>
                                </td>
                                <td>
                                    <a href="company-foods.php?c_id=<?php echo $company['id']; ?>"><button style="border-radius: 15px;">Yemekleri Listele</button></a>
                                </td>
                                <td>
                                    <a href="update-company.php?c_id=<?php echo $company['id']; ?>"><button style="border-radius: 15px;">Firmayı Güncelle</button></a>
                                </td>
                                <td>
                                    <form action="./scripts/ban-company.php" method="post">
                                        <input type="hidden" name="company_id" value="<?php echo $company['id']; ?>" />
                                        <button style="border-radius: 15px;" type="submit">X</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
        <div class="centerDiv">
            <a href="index.php" style="margin-top: 1.5rem;" class="cleanText"><button style="border-radius: 15px;">Ana Sayfa</button></a>
        </div>
        <?php require_once "footer.php"; ?>
        <script src="./public/js/searchbox.js"></script>
    </body>

    </html>
<?php } ?>