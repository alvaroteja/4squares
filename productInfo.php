<?php
include("service/AvatarService.php");
include("./model/UserModel.php");
include("./service/DBConnection.php");
include_once("model/ProductModel.php");

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>4squares</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous" />
    <link rel="stylesheet" href="./style/productInfo.css" />

</head>

<body>
    <?php
    include("html/components/nav.php");
    // echo "<pre>";
    // print_r($_SESSION["currentProduct"]);
    ?>
    <div class="container">
        <?php
        // echo ("<pre>");
        // print_r($_SESSION["currentProduct"]);
        ?>
        <div id="productId-2" class="carousel carousel-dark slide">
            <div class="carousel-inner">

                <div class="carousel-item active">
                    <img src="img/products/2-Monopoly/1.jpg" class="d-block w-100" alt="...">
                </div>

                <div class="carousel-item ">
                    <img src="img/products/2-Monopoly/2.jpg" class="d-block w-100" alt="...">
                </div>

                <div class="carousel-item ">
                    <img src="img/products/2-Monopoly/3.jpg" class="d-block w-100" alt="...">
                </div>

                <div class="carousel-item ">
                    <img src="img/products/2-Monopoly/4.jpg" class="d-block w-100" alt="...">
                </div>

                <div class="carousel-item ">
                    <img src="img/products/2-Monopoly/5.jpg" class="d-block w-100" alt="...">
                </div>

                <div class="carousel-item ">
                    <img src="img/products/2-Monopoly/6.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <div class="carousel-indicators">

                <button type="button" data-bs-target="#productId-2" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>

                <button type="button" data-bs-target="#productId-2" data-bs-slide-to="1" class="active" aria-current="true" aria-label="Slide 2"></button>

                <button type="button" data-bs-target="#productId-2" data-bs-slide-to="2" class="active" aria-current="true" aria-label="Slide 3"></button>

                <button type="button" data-bs-target="#productId-2" data-bs-slide-to="3" class="active" aria-current="true" aria-label="Slide 4"></button>

                <button type="button" data-bs-target="#productId-2" data-bs-slide-to="4" class="active" aria-current="true" aria-label="Slide 5"></button>

                <button type="button" data-bs-target="#productId-2" data-bs-slide-to="5" class="active" aria-current="true" aria-label="Slide 6"></button>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#productId-2" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productId-2" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</body>
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

</html>