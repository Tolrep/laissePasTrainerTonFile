<?php

$filesImageName = [];
$files = [];

if(isset($_POST['submit'])) {
    if (!empty($_FILES['files']['name'][0])) {
        foreach ($_FILES['files']['type'] as $type) {
            if ($type != 'image/jpeg' && $type != 'image/png' && $type != 'image/gif') {
                header('Location: index.php');
                echo "Format non gere.";
                die;
            } else {
                $tcheckType = 'ok';
            }
        }
        foreach ($_FILES['files']['size'] as $size) {
            if ($size > 1000000) {
                echo "Image trop lourde desole";
                die;
            } else {
                $tcheckSize = 'ok';
            }
        }
        if ($tcheckSize === 'ok'&& $tcheckType === 'ok') {
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

<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<div class="container">
    <div class="row justify-content">
        <div class="addFileForm text-center thumbnail col-x-12">
            <form action="" enctype="multipart/form-data" method="post">
                    <h3>Add photo:</h3>
                    <input name="files[]" type="file" multiple="multiple" />
                <p><input type="submit" name="submit" value="Submit"></p>

            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <?php
        foreach ($fileList as $list){
        ?>
        <div class="img-thumbnail text-center">
            <div class="col-4">
            <img src="<?=$fileImage . '/' . $list?>">
                <?=$list . '<br>'?>
                <a class="btn btn-danger text-center" href="index.php?suppr=<?=$list?>">Delete</a>
            </div>
        </div>
        <?php
        }?>
        </div>
    </div>

