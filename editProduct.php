<?php
// include("service/AvatarService.php");
include("./model/UserModel.php");
include("./model/ProductModel.php");
// include("./service/DBConnection.php");
// include_once("model/ProductModel.php");
// include("./dto/reviewDto.php");
session_start();

if (!isset($_SESSION["user"]) || $_SESSION["user"]->getCredentials() != 1 || !isset($_SESSION['redireccion']) || empty($_SESSION['redireccion']) || $_SESSION['redireccion'] != "editProductController") {
    header("Location: ./controller/editProductController.php");
    exit;
} else {
    unset($_SESSION['redireccion']);
}

$typesList = $_SESSION["typesList"];
$categoriesList = $_SESSION["categoriesList"];
$publishersList = $_SESSION["publishersList"];

$linkVideo = "";
$mediaList = $_SESSION["currentEditingProduct"]->getMedia_list();
foreach ($mediaList as $elemento) {
    if ($elemento['type'] == 'video') {
        $linkVideo = $elemento['url'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous" />
    <link rel="stylesheet" href="style/addProduct.css" />
</head>

<body>
    <?php
    include("html/components/nav.php");
    print_r($_SESSION["currentEditingProduct"]->getMedia_list());
    ?>
    <div class="container">
        <h2 style="text-align: center">Editando <?php echo $_SESSION["currentEditingProduct"]->getName() ?></h2>
        <form id="myForm" enctype="multipart/form-data">
            <div id="nameContainer" class="width100">
                <label for="name">*Nombre:</label>
                <input type="text" name="name" id="name" placeholder="El señor de los anillos (juego de mesa)" value="<?php echo $_SESSION["currentEditingProduct"]->getName() ?>" />
            </div>
            <div id="buyLinkContainer">
                <label for="buyLink">Link de compra:</label>
                <input type="text" name="buyLink" id="buyLink" placeholder="https://www.amazon.es/s?k=El+señor+de+los+anillos+juego+de+mesa" value="<?php echo $_SESSION["currentEditingProduct"]->getShopping_link() ?>" />
            </div>

            <div id="descriptionCopntainer">
                <label for="description">*Descripción:</label>
                <textarea name="description" id="description" class="width100" cols="30" rows="10" placeholder="Viajes por la Tierra Media es un juego de mesa totalmente cooperativo de fantasía y aventura..."><?php echo $_SESSION["currentEditingProduct"]->getDescription() ?></textarea>
            </div>
            <div id="playersContainer">
                <div id="minPlayersContainer" class="colum50">
                    <label for="minPlayers">*Jugadores mínimos:</label>
                    <input type="number" name="minPlayers" id="minPlayers" class="width100" placeholder="1" value="<?php echo $_SESSION["currentEditingProduct"]->getMin_playes() ?>" />
                </div>
                <div id="maxPlayersContainer" class="colum50">
                    <label for="maxPlayers">*Jugadores máximos:</label>
                    <input type="number" name="maxPlayers" id="maxPlayers" class="width100" placeholder="10" value="<?php echo $_SESSION["currentEditingProduct"]->getMax_players() ?>" />
                </div>
            </div>
            <div id="lengthAndAgeContainer">
                <div id="lengthContainer" class="colum50">
                    <label for="length">*Duración (mins):</label>
                    <input type="number" name="length" id="length" class="width100" placeholder="90" value="<?php echo $_SESSION["currentEditingProduct"]->getLength() ?>" />
                </div>
                <div id="minAgeContainer" class="colum50">
                    <label for="minAge">*Edad mínima:</label>
                    <input type="number" name="minAge" id="minAge" class="width100" placeholder="7" value="<?php echo $_SESSION["currentEditingProduct"]->getMinimum_age() ?>" />
                </div>
            </div>
            <div id="typeAndCategoryContainer">
                <div id="typeContainer" class="colum50">
                    <label for="type">*Tipo:</label>
                    <select name="type" id="type" class="width100" required>
                        <?php

                        foreach ($typesList as $key => $value) {
                            $selected = "";
                            if ($value == $_SESSION["currentEditingProduct"]->getType()) {
                                $selected = " selected='selected'";
                            }
                            echo "
                                    <option value='$value' $selected>$value</option>
                                ";
                        }
                        ?>
                    </select>
                </div>
                <div id="categoryContainer" class="colum50">
                    <label for="category">*Categoría:</label>
                    <select name="category" id="category" class="width100" required>
                        <?php

                        foreach ($categoriesList as $key => $value) {
                            $selected = "";
                            if ($value == $_SESSION["currentEditingProduct"]->getCategory()) {
                                $selected = " selected='selected'";
                            }
                            echo "
                                    <option value='$value' $selected>$value</option>
                                ";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div id="publisherAndHiddenContainer">
                <div id="publisherContainer" class="colum50">
                    <label for="publisher">*Editorial:</label>
                    <select name="publisher" id="publisher" class="width100" required>
                        <?php

                        foreach ($publishersList as $key => $value) {
                            $selected = "";
                            if ($value == $_SESSION["currentEditingProduct"]->getPublisher()) {
                                $selected = " selected='selected'";
                            }
                            echo "
                                    <option value='$value' $selected>$value</option>
                                ";
                        }
                        ?>
                    </select>
                </div>
                <div id="hiddenContainer" class="colum50">
                    <label>*Oculto:</label>
                    <div id="hiddenRadioButtonContainer">
                        <div id="hiddenRadioButtonYesContainer">
                            <label for="hiddenRadioButtonYes">Sí</label>
                            <input type="radio" name="hidden" value="yes" id="hiddenRadioButtonYes" />
                        </div>
                        <div id="hiddenRadioButtonNoContainer">
                            <label for="hiddenRadioButtonNo">No</label>
                            <input type="radio" name="hidden" value="no" id="hiddenRadioButtonNo" checked />
                        </div>
                    </div>
                </div>
            </div>
            <div id="mediaLinkContainer">
                <label for="videoLink">Link del video:</label>
                <input type="text" name="videoLink" id="videoLink" placeholder="Inserta aquí el link del vídeo." value="<?php echo $linkVideo; ?>" />
            </div>
            <!-- <input type="file" id="file-input" multiple> -->
            <div class="custom-file-input button1s">
                <label for="file-input">Seleccionar archivos</label>
                <input type="file" id="file-input" accept=".jpg, .jpeg, .png" multiple />
            </div>
            <div id="preview-container" class="displayNone"></div>
            <!-- <input type="file" name="images[]" multiple> -->
            <button id="submitButton" type="submit" class="button1" style="border-style: none">Enviar</button>
            <input type="hidden" name="sendingForm" value="true">
        </form>
        <div id="errorInfo"></div>
    </div>
    <div id="overlay" class="overlay">
        <div class="popup">
            <p class="mensaje">El juego ha sido creado correctamente.</p>
            <button class="button1" onclick="closePopup()">Aceptar</button>
        </div>
    </div>

    </div>
</body>
<script>
    var formDataImages = new FormData();
    // Contenedor de previsualización de imágenes
    const previewContainer = document.getElementById("preview-container");

    // Agregar evento de escucha al botón "Elegir archivo"
    const fileInput = document.getElementById("file-input");
    fileInput.addEventListener("change", handleFileSelect);

    // Array para almacenar las imágenes seleccionadas
    let selectedImages = [];

    // Función para manejar la selección de archivos
    function handleFileSelect(event) {
        const files = event.target.files;

        // Recorrer los archivos seleccionados
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const fileName = file["name"];
            //console.log(file);
            if (validateFileExtension(fileName)) {
                // ver si esta foto ya esta subida
                var alreadyUploaded = false;
                for (let j = 0; j < selectedImages.length; j++) {
                    if (fileName == selectedImages[j].name) {
                        alreadyUploaded = true;
                    }
                }
                //si el archivo no está subido, se sube
                if (!alreadyUploaded) {
                    // primero lo subimos al objeto formDataImages
                    formDataImages.append('images[]', files[i]);

                    // console.log([...formDataImages]);
                    // Crear un objeto URL para previsualizar la imagen
                    const imageURL = URL.createObjectURL(file);

                    // Crear un contenedor para la miniatura de imagen y la equis (x)
                    const thumbnailContainer = document.createElement("div");
                    thumbnailContainer.classList.add("thumbnail-container");

                    // Crear un elemento de imagen para la previsualización
                    const imagePreview = document.createElement("img");
                    imagePreview.src = imageURL;
                    imagePreview.classList.add("preview-image");
                    thumbnailContainer.appendChild(imagePreview);

                    // Crear un elemento de equis (x) para eliminar la imagen
                    const deleteIcon = document.createElement("span");
                    deleteIcon.innerHTML =
                        "<svg class='svg-icon del-ic' viewBox='0 0 20 20'><path d='M10.185,1.417c-4.741,0-8.583,3.842-8.583,8.583c0,4.74,3.842,8.582,8.583,8.582S18.768,14.74,18.768,10C18.768,5.259,14.926,1.417,10.185,1.417 M10.185,17.68c-4.235,0-7.679-3.445-7.679-7.68c0-4.235,3.444-7.679,7.679-7.679S17.864,5.765,17.864,10C17.864,14.234,14.42,17.68,10.185,17.68 M10.824,10l2.842-2.844c0.178-0.176,0.178-0.46,0-0.637c-0.177-0.178-0.461-0.178-0.637,0l-2.844,2.841L7.341,6.52c-0.176-0.178-0.46-0.178-0.637,0c-0.178,0.176-0.178,0.461,0,0.637L9.546,10l-2.841,2.844c-0.178,0.176-0.178,0.461,0,0.637c0.178,0.178,0.459,0.178,0.637,0l2.844-2.841l2.844,2.841c0.178,0.178,0.459,0.178,0.637,0c0.178-0.176,0.178-0.461,0-0.637L10.824,10z'></path></svg>";
                    deleteIcon.classList.add("delete-icon");
                    thumbnailContainer.appendChild(deleteIcon);

                    // Agregar el contenedor al contenedor de previsualización
                    previewContainer.appendChild(thumbnailContainer);

                    // Agregar evento de escucha a los botones de eliminación
                    const deleteButtons = document.querySelectorAll(".delete-icon");
                    deleteButtons.forEach((button) => {
                        button.addEventListener("click", handleDeleteImage);
                    });

                    // Agregar el archivo al array de imágenes seleccionadas
                    selectedImages.push(file);
                    previewContainer.classList.remove("displayNone");
                } else {
                    alert(`El archivo ${fileName} ya está subido.`);
                }
            } else {
                alert("Formato de archivo no válido");
            }
        }
        console.log([...formDataImages]);

        fileInput.value = "";
    }

    // Función para manejar el clic en la x para eliminar la imagen
    function handleDeleteImage(event) {
        var thumbnailContainer = "";
        if (event.target.nodeName == "path") {
            thumbnailContainer = event.target.parentNode.parentNode.parentNode;
        } else {
            thumbnailContainer = event.target.parentNode.parentNode;
        }

        //detecto en que indice se encuentra la imagen a borrar
        const index = Array.from(previewContainer.children).indexOf(thumbnailContainer);

        //Elimino la imagen del FormDataImage

        nombreImagen = selectedImages[index]["name"];

        formDataImages = eliminarImagen(formDataImages, nombreImagen);
        //console.log([...formDataImages]);

        // Eliminar la imagen del array de imágenes seleccionadas
        selectedImages.splice(index, 1);

        // Eliminar la imagen de la previsualización
        previewContainer.removeChild(thumbnailContainer);

        if (selectedImages.length == 0) previewContainer.classList.add("displayNone");
        fileInput.value = "";
    }

    //******************************************************************//
    // Esta es la funcion para mandar los datos de texto del formulario //
    //******************************************************************//

    document.getElementById("myForm").addEventListener("submit", function(event) {
        // Evita que el formulario se envíe de forma predeterminada
        event.preventDefault();

        // Obtén los datos del formulario
        const formData = new FormData(event.target);
        //agrego los files de formDataImages al nuevo formData con los datos del formulario
        for (const [key, value] of formDataImages.entries()) {
            formData.append(key, value);
        }
        //console.log([...formDataImages]);
        //console.log([...formData]);
        // Realiza la solicitud Fetch al controlador
        fetch("./controller/addProductController.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json()) // Convierte la respuesta a JSON
            .then(data => {
                // Maneja la respuesta del controlador
                console.log(data.message); // Muestra el mensaje del controlador
                console.log(data);


                const errorInfoDiv = document.getElementById("errorInfo");
                errorInfoDiv.innerHTML = "";
                if (!data.success) {
                    const errorMessage = data.message;
                    for (let key in errorMessage) {
                        // Crea un párrafo con el contenido del error y lo agrega al div
                        const p = document.createElement("p");
                        p.textContent = `${errorMessage[key]}`;
                        errorInfoDiv.appendChild(p);
                    }
                } else {
                    resetForm();
                    showPopup();
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
    });



    //funcion para validar el tipo de archivo subido
    function validateFileExtension(fileName) {
        var fileExtension = fileName.split(".").pop().toLowerCase();

        if (fileExtension === "jpg" || fileExtension === "jpeg" || fileExtension === "png") {
            return true;
        } else {
            return false;
        }
    }
    // Función para eliminar una imagen específica de un objeto FormData
    function eliminarImagen(formData, nombreImagen) {
        const formDataNuevo = new FormData();

        for (const [key, value] of formData.entries()) {
            if (value.name !== nombreImagen) {
                formDataNuevo.append(key, value);
            }
        }
        return formDataNuevo;
    }

    function showPopup() {
        var overlay = document.getElementById("overlay");
        overlay.style.display = "block";
    }

    function closePopup() {
        var overlay = document.getElementById("overlay");
        overlay.style.display = "none";
    }

    function resetForm() {
        document.getElementById("myForm").reset();
        formDataImages = new FormData();
        selectedImages.length = 0;
        fileInput.value = "";
        previewContainer.innerHTML = "";
        previewContainer.classList.add("displayNone");
    }
    // // Agregar evento de escucha al formulario para enviarlo
    // const form = document.getElementById("myForm");
    // form.addEventListener("submit", handleSubmit);
</script>

</html>