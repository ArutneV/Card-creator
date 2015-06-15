<?php
$id = "";
if(isset($_GET["id"]) && $_GET["id"] != ""){
    $id = preg_replace('#[^a-zA-Z0-9]#', '', $_GET['id']);
} else {
    header("location: index.php");
    exit();
}
?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Card <?php echo $id; ?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<style>
body{ font-family: Arial, Helvetica, sans-serif; }
button{ padding:5px 10px; font-size:17px; cursor:pointer; }
</style>
</head>
<body>
<h1>Save the image bolew by right clicking it and selcting "save image as"</h1>

    <img src="<?php echo "card-images/".$id.".png"; ?>" alt="card">


</body>
</html>
