<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
include("./model/UserModel.php");
include("./service/DBConnection.php");
//include("./service/ProductService.php");
include("./service/ScoreService.php");
include("./webSettings.php");
include_once("model/ProductModel.php");
include("service/AvatarService.php");
session_start();
// echo "<pre>";
// print_r($_SESSION);
//si se consigue llegar aqui sin una lista de productos en la sesion, manda a index para que se genere
if (!isset($_SESSION["productsIdList"])) {
    header("Location: index.php");
}

$connnection = new DBConnection();
//$scoreService = new ScoreService($connnection);

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

<body>
    <?php
    // echo "<pre>";
    // print_r($_SESSION);
    // echo "<pre>";
    // print_r($_SESSION["currentProduct"]);
    // print_r($_SESSION["productsList"][0]);
    include("./html/components/nav.php");

    include("./html/components/pageNav.php");

    //todo esto para asegurarnos que al llegar al final de la lista de productos, si queda alguno suelto, no salga outofbounds del array
    if (count($_SESSION['productsIdList']) - $_SESSION["currentPage"] * $maxProductsAtHome >= 0) {
        for ($i = 0; $i < $maxProductsAtHome; $i++) {
            include("./html/components/homeCard.php");
        }
    } else {
        $limit = $maxProductsAtHome - ($_SESSION["currentPage"] * $maxProductsAtHome - count($_SESSION['productsIdList']));
        for ($i = 0; $i < $limit; $i++) {
            include("./html/components/homeCard.php");
        }
    }


    include("./html/components/pageNav.php");
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script>
        //funcion para ocultar o publicar producto
        const hideProductIcons = document.querySelectorAll('.hideProductIcon');

        for (let i = 0; i < hideProductIcons.length; i++) {

            hideProductIcons[i].addEventListener('click', function() {
                //let hideProductIconId = this.id.split('-')[1];

                let currentProductCon = this.parentNode.parentNode.parentNode.parentNode.parentNode;
                let value = this.classList.contains("hideSvg-off") ? 1 : 0;
                let productId = currentProductCon.id.split('-')[1];

                fetch(`http://localhost/tfg/4squares/controller/productController.php?switchProductHideState=true&productId=${productId}&value=${value}`, {
                        method: 'GET'
                    })
                    .then(response => {
                        if (response.ok) {
                            //hago visible el producto
                            if (this.classList.contains("hideSvg-off")) {
                                this.classList.add("hideSvg");
                                this.classList.remove("hideSvg-off");
                                currentProductCon.classList.remove("productConHidden");
                            } //oculto el producto
                            else {
                                this.classList.remove("hideSvg");
                                this.classList.add("hideSvg-off");
                                currentProductCon.classList.add("productConHidden");
                            }
                        } else {
                            alert('No se pudo pudo modificar favoritos.');
                        }
                    })
                    .catch(error => {
                        alert('No se pudo pudo modificar favoritos.');
                    });
            });
        }


        //funcion para borrar un producto

        const deleteProductIcons = document.querySelectorAll('.deleteSvg');
        console.log(deleteProductIcons.length);

        for (let i = 0; i < deleteProductIcons.length; i++) {
            deleteProductIcons[i].addEventListener('click', function() {
                
                let currentProductCon = this.parentNode.parentNode.parentNode.parentNode.parentNode;
                let productId = currentProductCon.id.split('-')[1];

                if (confirm("¿Estás seguro de que quieres eliminar este producto? Esta acción eliminará definitivamente el producto.")) {
                    fetch(`http://localhost/tfg/4squares/controller/productController.php?deleteProduct=true&productId=${productId}`, {
                            method: 'GET'
                        })
                        .then(response => {
                            if (response.ok) {
                                //Si se borra el producto
                                alert('El producto ha sido eliminado.');
                                location.href = 'http://localhost/tfg/4squares/index.php';
                            } else {
                                alert('No se pudo eliminar el producto.');
                            }
                        })
                        .catch(error => {
                            alert('No se pudo eliminar el producto.');
                        });
                }
            });
        }
    </script>
</body>

</html>