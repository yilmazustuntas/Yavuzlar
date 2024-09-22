<link rel="stylesheet" href="./public/css/footer.css">
<div class="footer     
<?php switch ($_SESSION['role']) {
    case 1:
        echo "secondary";
        break;
    case 2:
        echo "accent";
        break;
} ?>">
    <?php switch ($_SESSION['role']) {
        case 0: ?>
            <div>
                <p style="margin-top: 20px;" class="footer_obj">Admin Sayfasına Hoşgeldiniz!</p>
            </div>
        <?php break;
        case 1: ?>
        <?php break;
        case 2: ?>

    <?php break;
    } ?>
        <div>
            <a target="_blank" rel="noopener noreferrer" href="https://yavuzlar.org">
            <div style="display: flex; justify-content: center; align-items: center;">
                <img src="./public/images/logo.png" alt="Yavuzlar Logo" class="yavuzlar_logo" width="150">
            </div>
            </a>
            <p style="margin-bottom: 20px;" class="footer_obj">
                Yavuzlar Restoran Uygulaması <a href="https://github.com/yilmazustuntas" target="_blank" rel="noopener noreferrer">yilmazustuntas</a> tarafından geliştirilmiştir.
            </p>
    </div>
</div>