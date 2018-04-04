<?php

$filesImageName = [];

if(isset($_POST['submit'])) {
    if (!empty($_FILES['files']['name'][0])) {
        foreach ($_FILES['files']['type'] as $type) {
            if ($type != 'image/jpeg' && $type != 'image/png' && $type != 'image/gif') {
                echo "Format non gere.";
            } else {
                foreach ($_FILES['files']['size'] as $size) {
                    if ($size > 1000000) {
                        echo "Image trop lourde desole";
                    } else {
                        $tcheck = 'ok';
                    }
                }
            }
        }
        foreach ($_FILES['files']['name'] as $i => $file_name) {
            $tmpFilePath = $_FILES['files']['tmp_name'][$i];
            if ($tmpFilePath != "") {
                $extension = pathinfo($_FILES['files']['name'][$i], PATHINFO_EXTENSION);
                $shortname = $_FILES['files']['name'][$i];
                $filePath = "img/" . 'image' . uniqid() . '.' . $extension;
                $files[] = substr($filePath, 4);

            }
            move_uploaded_file($tmpFilePath, $filePath);
        }
    }
        if (is_array($files)) {
            echo "<h1>Uploaded:</h1>";
            echo "<ul>";
            foreach ($files as $file) {
                echo "<li>$file</li>";
            }
            echo "</ul>";
        }
    }

$fileImage = 'img';
$fileList = array_diff(scandir($fileImage, 1), array('..', '.'));

if (!empty($_GET['suppr'])){
    if (file_exists($fileImage . '/' . $_GET['suppr'])){
        unlink($fileImage . '/' . $_GET['suppr']);
        header('Location: index.php');
        die;
    }

}


?>


<form action="" enctype="multipart/form-data" method="post">

    <div>
        <label for='files'>Add photo:</label>
        <input name="files[]" type="file" multiple="multiple" />
    </div>

    <p><input type="submit" name="submit" value="Submit"></p>

</form>

<?php
foreach ($fileList as $list){
    ?>
<ul>
    <li><img src="<?=$fileImage . '/' . $list?>"></li>
    <p><?=$list?></p>
    <p><a href="index.php?suppr=<?=$list?>">Supprimer</a></p>
</ul>
<?php
}
