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
    <form id="searchForm">
        <div class="searchBarContainer">
            <button onclick="toggleElement('extraOptionsContainer')" id="extraOptionsButton" class="searchBarContainerButton">
                <svg class="svg-icon" viewBox='0 0 20 20' fill='none' stroke='#ffffff' stroke-width='0.5' stroke-linecap='round' stroke-linejoin='round'>
                    <path fill="#ffffff" d="M14.613,10c0,0.23-0.188,0.419-0.419,0.419H10.42v3.774c0,0.23-0.189,0.42-0.42,0.42s-0.419-0.189-0.419-0.42v-3.774H5.806c-0.23,0-0.419-0.189-0.419-0.419s0.189-0.419,0.419-0.419h3.775V5.806c0-0.23,0.189-0.419,0.419-0.419s0.42,0.189,0.42,0.419v3.775h3.774C14.425,9.581,14.613,9.77,14.613,10 M17.969,10c0,4.401-3.567,7.969-7.969,7.969c-4.402,0-7.969-3.567-7.969-7.969c0-4.402,3.567-7.969,7.969-7.969C14.401,2.031,17.969,5.598,17.969,10 M17.13,10c0-3.932-3.198-7.13-7.13-7.13S2.87,6.068,2.87,10c0,3.933,3.198,7.13,7.13,7.13S17.13,13.933,17.13,10"></path>
                </svg>
            </button>
            <input id="serachInput" type="text" placeholder="Encuentra el juego que deseas...">
            <button type="submit" value="" id="searchFomSubmit" class="searchBarContainerButton">
                <svg class="svg-icon" viewBox='0 0 20 20' fill='#ffffff' stroke='#ffffff' stroke-width='0.5' stroke-linecap='round' stroke-linejoin='round'>
                    <path fill="#ffffff" d="M19.129,18.164l-4.518-4.52c1.152-1.373,1.852-3.143,1.852-5.077c0-4.361-3.535-7.896-7.896-7.896 c-4.361,0-7.896,3.535-7.896,7.896s3.535,7.896,7.896,7.896c1.934,0,3.705-0.698,5.078-1.853l4.52,4.519 c0.266,0.268,0.699,0.268,0.965,0C19.396,18.863,19.396,18.431,19.129,18.164z M8.567,15.028c-3.568,0-6.461-2.893-6.461-6.461 s2.893-6.461,6.461-6.461c3.568,0,6.46,2.893,6.46,6.461S12.135,15.028,8.567,15.028z"></path>
                </svg>
            </button>
        </div>
        <div id="extraOptionsContainer" class="hidden" style="display: none;">
            <div class="extraOption numberOption">
                <label for="minPlayersSeachImput">Jugadores mínimos</label>
                <input name="minPlayersSeachImput" id="minPlayersSeachImput" type="number" min="1" max="99">
            </div>
            <div class="extraOption numberOption">
                <label for="maxPlayersSeachImput">Jugadores máximos</label>
                <input name="maxPlayersSeachImput" id="maxPlayersSeachImput" type="number" type="number" min="1" max="99">
            </div>
            <div class="extraOption numberOption">
                <label for="lengthSeachImput">Duración</label>
                <input name="lengthSeachImput" id="lengthSeachImput" type="number" type="number" min="1" max="999">
            </div>
            <div class="extraOption numberOption">
                <label for="minAgeSeachImput" type="number">Edad mínima</label>
                <input name="minAgeSeachImput" id="minAgeSeachImput" type="number" min="0" max="99">
            </div>
            <div class="extraOption numberOption">
                <label for="minScoreSeachImput">Puntuación mínima</label>
                <input name="minScoreSeachImput" id="minScoreSeachImput" type="number" type="number" min="0" max="5">
            </div>
            <div class="extraOption numberOption">
                <label for="maxScoreSeachImput">Puntuación máxima</label>
                <input name="maxScoreSeachImput" id="maxScoreSeachImput" type="number" type="number" min="0" max="5">
            </div>
            <div class="extraOption selectOption">
                <label for="typeSeachImput">Tipo de juego</label>
                <select name="typeSeachImput" id="typeSeachImput">
                    <option value='' selected>Selecciona un tipo</option>
                </select>
            </div>
            <div class="extraOption selectOption">
                <label for="categorySeachImput">Categoría</label>
                <select name="categorySeachImput" id="categorySeachImput">
                    <option value='' selected>Selecciona una categoria</option>
                </select>
            </div>
            <div class="extraOption selectOption">
                <label for="publisherSeachImput">Editorial</label>
                <select name="publisherSeachImput" id="publisherSeachImput">
                    <option value='' selected>Selecciona una editorial</option>
                </select>
            </div>
            <div class="extraOption radioOption">
                <label for="hiddenSeachImput">Oculto</label>
                <input type="radio" name="hiddenSeachImput" value="yes" id="hiddenSeachImput" />
            </div>
        </div>
    </form>
    <script>
        function toggleOptions() {
            var optionsMenu = document.getElementById("options-menu");
            optionsMenu.classList.toggle("show");
        }
    </script>
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
        //console.log(deleteProductIcons.length);

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
        // Agregar evento de escucha a los botones de editar
        const editButtons = document.querySelectorAll(".editSvg");
        editButtons.forEach((button) => {
            button.addEventListener("click", getEditIconProductId);
        });

        function getEditIconProductId(event) {
            var parentContainer = "";
            if (event.target.nodeName == "path") {
                parentContainer = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
            } else {
                parentContainer = event.target.parentNode.parentNode.parentNode.parentNode.parentNode;
            }
            productId = parentContainer.id.substring("productIdCon-".length);
            location.href = `http://localhost/tfg/4squares/controller/editProductController.php?productId=${productId}`;
            console.log(productId);
        }

        function toggleElement(elementId) {
            event.preventDefault();
            var element = document.getElementById(elementId);

            if (element.style.display === "none") {
                element.style.display = "flex";
                setTimeout(function() {
                    element.classList.toggle("hidden");

                }, 100);
            } else {
                element.classList.toggle("hidden");
                setTimeout(function() {
                    element.style.display = "none";
                }, 300);
            }
        }
    </script>

</body>

</html>