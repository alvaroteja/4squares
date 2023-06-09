<?php
include("./model/UserModel.php");
include("./service/DBConnection.php");
include("./service/ScoreService.php");
include("./webSettings.php");
include_once("model/ProductModel.php");
include("service/AvatarService.php");
session_start();

//si se consigue llegar aqui sin una lista de productos en la sesion, manda a index para que se genere
if (!isset($_SESSION["productsIdList"])) {
    header("Location: index.php");
}

$connnection = new DBConnection();

$maxPages = count($_SESSION["productsIdList"]) / $maxProductsAtHome;
$productsIdList = $_SESSION["productsIdList"];

$typesList = $_SESSION["typesList"];
$categoriesList = $_SESSION["categoriesList"];
$publishersList = $_SESSION["publishersList"];

$productList = $_SESSION["productsList"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>4squares - home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous" />
    <link rel="stylesheet" href="style/home.css" />
    <link rel="icon" href="./img/icons/favicon.ico">
</head>

<body>

    <?php
    include("./html/components/nav.php");
    ?>
    <form id="searchForm" action="./controller/homeController.php" method="post">
        <input type="hidden" name="filterRequest" value="true">
        <div class="searchBarContainer">
            <button onclick="toggleElement('extraOptionsContainer')" id="extraOptionsButton" class="searchBarContainerButton">
                <svg class="svg-icon" viewBox='0 0 20 20' fill='none' stroke='#ffffff' stroke-width='0.5' stroke-linecap='round' stroke-linejoin='round'>
                    <path fill="#ffffff" d="M14.613,10c0,0.23-0.188,0.419-0.419,0.419H10.42v3.774c0,0.23-0.189,0.42-0.42,0.42s-0.419-0.189-0.419-0.42v-3.774H5.806c-0.23,0-0.419-0.189-0.419-0.419s0.189-0.419,0.419-0.419h3.775V5.806c0-0.23,0.189-0.419,0.419-0.419s0.42,0.189,0.42,0.419v3.775h3.774C14.425,9.581,14.613,9.77,14.613,10 M17.969,10c0,4.401-3.567,7.969-7.969,7.969c-4.402,0-7.969-3.567-7.969-7.969c0-4.402,3.567-7.969,7.969-7.969C14.401,2.031,17.969,5.598,17.969,10 M17.13,10c0-3.932-3.198-7.13-7.13-7.13S2.87,6.068,2.87,10c0,3.933,3.198,7.13,7.13,7.13S17.13,13.933,17.13,10"></path>
                </svg>
            </button>
            <input id="searchInput" name="searchInput" type="text" placeholder="Encuentra el juego que deseas..." value="<?php if ((isset($_SESSION['filterValues']['searchInput']) && !empty($_SESSION['filterValues']['searchInput']) && trim($_SESSION['filterValues']['searchInput']) != "")) {
                                                                                                                                echo trim($_SESSION['filterValues']['searchInput']);
                                                                                                                            } ?>">
            <button type="submit" value="" id="searchFormSubmit" class="searchBarContainerButton">
                <svg class="svg-icon" viewBox='0 0 20 20' fill='#ffffff' stroke='#ffffff' stroke-width='0.5' stroke-linecap='round' stroke-linejoin='round'>
                    <path fill="#ffffff" d="M19.129,18.164l-4.518-4.52c1.152-1.373,1.852-3.143,1.852-5.077c0-4.361-3.535-7.896-7.896-7.896 c-4.361,0-7.896,3.535-7.896,7.896s3.535,7.896,7.896,7.896c1.934,0,3.705-0.698,5.078-1.853l4.52,4.519 c0.266,0.268,0.699,0.268,0.965,0C19.396,18.863,19.396,18.431,19.129,18.164z M8.567,15.028c-3.568,0-6.461-2.893-6.461-6.461 s2.893-6.461,6.461-6.461c3.568,0,6.46,2.893,6.46,6.461S12.135,15.028,8.567,15.028z"></path>
                </svg>
            </button>
        </div>
        <?php
        $class = "class='hidden' style='display: none;'";
        if (isset($_SESSION['filterValues'])) {
            foreach ($_SESSION['filterValues'] as $key => $value) {
                if (isset($value) && !empty($value) && trim($value != "") && $key != "filterRequest" && $key != "searchInput") {
                    $class = "";
                }
            }
        }


        ?>
        <div id="extraOptionsContainer" <?php echo $class; ?>>
            <div class="extraOption numberOption">
                <label for="minPlayersSeachImput">Jugadores mínimos</label>
                <input name="minPlayersSeachImput" id="minPlayersSeachImput" type="number" min="1" max="99" value="<?php if ((isset($_SESSION['filterValues']['minPlayersSeachImput']) && !empty($_SESSION['filterValues']['minPlayersSeachImput']) && trim($_SESSION['filterValues']['minPlayersSeachImput']) != "")) {
                                                                                                                        echo trim($_SESSION['filterValues']['minPlayersSeachImput']);
                                                                                                                    } ?>">
            </div>
            <div class="extraOption numberOption">
                <label for="maxPlayersSeachImput">Jugadores máximos</label>
                <input name="maxPlayersSeachImput" id="maxPlayersSeachImput" type="number" type="number" min="1" max="99" value="<?php if ((isset($_SESSION['filterValues']['maxPlayersSeachImput']) && !empty($_SESSION['filterValues']['maxPlayersSeachImput']) && trim($_SESSION['filterValues']['maxPlayersSeachImput']) != "")) {
                                                                                                                                        echo trim($_SESSION['filterValues']['maxPlayersSeachImput']);
                                                                                                                                    } ?>">
            </div>
            <div class="extraOption numberOption">
                <label for="minLengthSeachImput">Duración mínima</label>
                <input name="minLengthSeachImput" id="minLengthSeachImput" type="number" type="number" min="1" max="999" value="<?php if ((isset($_SESSION['filterValues']['minLengthSeachImput']) && !empty($_SESSION['filterValues']['minLengthSeachImput']) && trim($_SESSION['filterValues']['minLengthSeachImput']) != "")) {
                                                                                                                                    echo trim($_SESSION['filterValues']['minLengthSeachImput']);
                                                                                                                                } ?>">
            </div>
            <div class="extraOption numberOption">
                <label for="maxLengthSeachImput">Duración máxima</label>
                <input name="maxLengthSeachImput" id="maxLengthSeachImput" type="number" type="number" min="1" max="999" value="<?php if ((isset($_SESSION['filterValues']['maxLengthSeachImput']) && !empty($_SESSION['filterValues']['maxLengthSeachImput']) && trim($_SESSION['filterValues']['maxLengthSeachImput']) != "")) {
                                                                                                                                    echo trim($_SESSION['filterValues']['maxLengthSeachImput']);
                                                                                                                                } ?>">
            </div>
            <div class="extraOption numberOption">
                <label for="minAgeSeachImput" type="number">Edad mínima</label>
                <input name="minAgeSeachImput" id="minAgeSeachImput" type="number" min="0" max="99" value="<?php if ((isset($_SESSION['filterValues']['minAgeSeachImput']) && !empty($_SESSION['filterValues']['minAgeSeachImput']) && trim($_SESSION['filterValues']['minAgeSeachImput']) != "")) {
                                                                                                                echo trim($_SESSION['filterValues']['minAgeSeachImput']);
                                                                                                            } ?>">
            </div>
            <div class="extraOption numberOption">
                <label for="minScoreSeachImput">Puntuación mínima</label>
                <input name="minScoreSeachImput" id="minScoreSeachImput" type="number" type="number" min="0" max="5" value="<?php if (isset($_SESSION['filterValues']['minScoreSeachImput']) && !empty($_SESSION['filterValues']['minScoreSeachImput']) && trim($_SESSION['filterValues']['minScoreSeachImput']) != "") {
                                                                                                                                echo trim($_SESSION['filterValues']['minScoreSeachImput']);
                                                                                                                            } ?>">
            </div>
            <div class="extraOption numberOption">
                <label for="maxScoreSeachImput">Puntuación máxima</label>
                <input name="maxScoreSeachImput" id="maxScoreSeachImput" type="number" type="number" min="0" max="5" value="<?php if (isset($_SESSION['filterValues']['maxScoreSeachImput']) && !empty($_SESSION['filterValues']['maxScoreSeachImput']) && trim($_SESSION['filterValues']['maxScoreSeachImput']) != "") {
                                                                                                                                echo trim($_SESSION['filterValues']['maxScoreSeachImput']);
                                                                                                                            } ?>">
            </div>
            <div class="extraOption selectOption">
                <label for="typeSeachImput">Tipo de juego</label>
                <select name="typeSeachImput" id="typeSeachImput">
                    <option value='' selected>...</option>
                    <?php
                    if ((isset($_SESSION['filterValues']['typeSeachImput']) && !empty($_SESSION['filterValues']['typeSeachImput']) && trim($_SESSION['filterValues']['typeSeachImput']) != "")) {
                        $currenterType = $_SESSION['filterValues']['typeSeachImput'];
                    } else {
                        $currenterType = "";
                    }
                    foreach ($typesList as $key => $value) {
                        $selected = "";
                        if ($value == $currenterType) {
                            $selected = "selected";
                        }
                        echo "
                                    <option value='$value' $selected>$value</option>
                                ";
                    }
                    ?>
                </select>
            </div>
            <div class="extraOption selectOption">
                <label for="categorySeachImput">Categoría</label>
                <select name="categorySeachImput" id="categorySeachImput">
                    <option value='' selected>...</option>
                    <?php
                    if ((isset($_SESSION['filterValues']['categorySeachImput']) && !empty($_SESSION['filterValues']['categorySeachImput']) && trim($_SESSION['filterValues']['categorySeachImput']) != "")) {
                        $currenterType = $_SESSION['filterValues']['categorySeachImput'];
                    } else {
                        $currenterType = "";
                    }
                    foreach ($categoriesList as $key => $value) {
                        $selected = "";
                        if ($value == $currenterType) {
                            $selected = "selected";
                        }
                        echo "
                                    <option value='$value' $selected>$value</option>
                                ";
                    }
                    ?>
                </select>
            </div>
            <div class="extraOption selectOption">
                <label for="publisherSeachImput">Editorial</label>
                <select name="publisherSeachImput" id="publisherSeachImput">
                    <option value='' selected>...</option>
                    <?php
                    if ((isset($_SESSION['filterValues']['publisherSeachImput']) && !empty($_SESSION['filterValues']['publisherSeachImput']) && trim($_SESSION['filterValues']['publisherSeachImput']) != "")) {
                        $currenterType = $_SESSION['filterValues']['publisherSeachImput'];
                    } else {
                        $currenterType = "";
                    }
                    foreach ($publishersList as $key => $value) {
                        $selected = "";
                        if ($value == $currenterType) {
                            $selected = "selected";
                        }
                        echo "
                                    <option value='$value' $selected>$value</option>
                                ";
                    }
                    ?>
                </select>
            </div>
            <?php
            if ((isset($_SESSION['filterValues']['hiddenSeachImput']) && !empty($_SESSION['filterValues']['hiddenSeachImput']) && trim($_SESSION['filterValues']['hiddenSeachImput']) != "")) {
                $checked = "checked";
            } else {
                $checked = "";
            }
            if (isset($_SESSION["user"]) && $_SESSION["user"]->getCredentials() == 1) {
                echo "
                        <div class='extraOption checkboxOption'>
                            <label for='hiddenSeachImput'>Oculto</label>
                            <input type='checkbox' name='hiddenSeachImput' value='yes' id='hiddenSeachImput' $checked />
                        </div>
                    ";
            }
            ?>

        </div>
    </form>
    <?php
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
    if (count($_SESSION['productsIdList']) == 0) {
        //meter aqui lo que va a salir cuando no haya productos en la lista
        echo '<img id="noProductFoundImg" src="./img/resources/no_products_found_3.svg" alt="" >';
    }


    include("./html/components/pageNav.php");
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script>
        //funcion para ocultar o publicar producto
        const hideProductIcons = document.querySelectorAll('.hideProductIcon');

        for (let i = 0; i < hideProductIcons.length; i++) {

            hideProductIcons[i].addEventListener('click', function() {

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

        function toggleOptions() {
            var optionsMenu = document.getElementById("options-menu");
            optionsMenu.classList.toggle("show");
        }

        //funcion para que al pulsar enter en el buscador, se ejecute el boton de buscar

        // Obtener referencia al campo de entrada y al botón deseado
        var searchInput = document.getElementById('searchInput');
        var searchFormSubmit = document.getElementById('searchFormSubmit');

        searchInput.addEventListener('keydown', function(event) {

            if (event.keyCode === 13) {
                event.preventDefault();
                searchFormSubmit.click();
            }
        });
    </script>

</body>

</html>
<?php
unset($_SESSION['filterValues']);
?>