<?php

include("model/UserModel.php");
include("service/DBConnection.php");
include("service/ProductService.php");
include("service/ScoreService.php");
include("webSettings.php");
session_start();
$connnection = new DBConnection();
$scoreService = new ScoreService($connnection);

$maxPages = count($_SESSION["productsIdList"]) / $maxProductsAtHome;
$productsIdList = $_SESSION["productsIdList"];
//print_r(count($_SESSION["productsIdList"]));
//echo ($maxPages);

$productList = $_SESSION["productsList"];
//$productList = array();


//echo ("<pre>");


// $productService = new ProductService();
// for ($i = 0; $i < $maxProductsAtHome; $i++) {
//     array_push($productList, $productService->getAProduct($productsIdList[$i]));
// }

//print_r($productList);
// echo ("<pre>");
// print_r($productList[0]->getName());
// echo "<pre>";
// print_r($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous" />
    <link rel="stylesheet" href="style/home.css" />
</head>
<?php
include("html/components/nav.php");

include("html/components/pageNav.php");

for ($i = 0; $i < $maxProductsAtHome; $i++) {
    include("html/components/homeCard.php");
}

include("html/components/pageNav.php");
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script>
    function toggleClass(element, class1, class2) {
        if (element.classList.contains(class1) && !element.classList.contains(class2)) {
            element.classList.add(class2);
            element.classList.remove(class1);
        } else if (!element.classList.contains(class1) && element.classList.contains(class2)) {
            element.classList.add(class1);
            element.classList.remove(class2);
        }
    }
</script>
</body>

</html>