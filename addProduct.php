<?php
// include("service/AvatarService.php");
include("./model/UserModel.php");
// include("./service/DBConnection.php");
// include_once("model/ProductModel.php");
// include("./dto/reviewDto.php");
session_start();

if (!isset($_SESSION["user"]) || $_SESSION["user"]->getCredentials() != 1 || !isset($_SESSION['redireccion']) || empty($_SESSION['redireccion']) || $_SESSION['redireccion'] != "addProductController") {
    header("Location: ./controller/addProductController.php");
    exit;
} else {
    unset($_SESSION['redireccion']);
}

$typesList = $_SESSION["typesList"];
$categoriesList = $_SESSION["categoriesList"];
$publishersList = $_SESSION["publishersList"];
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
    ?>
    <div class="container">
        <h2 style="text-align: center">Agrega un juego a la web</h2>
        <form id="myForm" enctype="multipart/form-data">
            <div id="nameContainer" class="width100">
                <label for="name">*Nombre:</label>
                <input type="text" name="name" id="name" placeholder="El señor de los anillos (juego de mesa)" />
            </div>
            <div id="buyLinkContainer">
                <label for="buyLink">*Link de compra:</label>
                <input type="text" name="buyLink" id="buyLink" placeholder="https://www.amazon.es/s?k=El+señor+de+los+anillos+juego+de+mesa" />
            </div>

            <div id="descriptionCopntainer">
                <label for="description">*Descripción:</label>
                <textarea name="description" id="description" class="width100" cols="30" rows="10" placeholder="Viajes por la Tierra Media es un juego de mesa totalmente cooperativo de fantasía y aventura..."></textarea>
            </div>
            <div id="playersContainer">
                <div id="minPlayersContainer" class="colum50">
                    <label for="minPlayers">*Jugadores mínimos:</label>
                    <input type="number" name="minPlayers" id="minPlayers" class="width100" placeholder="1" />
                </div>
                <div id="maxPlayersContainer" class="colum50">
                    <label for="maxPlayers">*Jugadores máximos:</label>
                    <input type="number" name="maxPlayers" id="maxPlayers" class="width100" placeholder="10" />
                </div>
            </div>
            <div id="lengthAndAgeContainer">
                <div id="lengthContainer" class="colum50">
                    <label for="length">*Duración (mins):</label>
                    <input type="number" name="length" id="length" class="width100" placeholder="90" />
                </div>
                <div id="minAgeContainer" class="colum50">
                    <label for="minAge">*Edad mínima:</label>
                    <input type="number" name="minAge" id="minAge" class="width100" placeholder="7" />
                </div>
            </div>
            <div id="typeAndCategoryContainer">
                <div id="typeContainer" class="colum50">
                    <label for="type">*Tipo:</label>
                    <select name="type" id="type" class="width100" required>
                        <option disabled="disabled" selected="selected">Selecciona tipo</option>
                        <?php
                        foreach ($typesList as $key => $value) {
                            echo "
                                    <option value='$value'>$value</option>
                                ";
                        }
                        ?>
                    </select>
                </div>
                <div id="categoryContainer" class="colum50">
                    <label for="category">*Categoría:</label>
                    <select name="category" id="category" class="width100" required>
                        <option disabled="disabled" selected="selected">Selecciona categoría</option>
                        <?php
                        foreach ($categoriesList as $key => $value) {
                            echo "
                                    <option value='$value'>$value</option>
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
                        <option class="firstOption" disabled="disabled" selected="selected">Selecciona editorial</option>
                        <?php
                        foreach ($publishersList as $key => $value) {
                            echo "
                                    <option value='$value'>$value</option>
                                ";
                        }
                        ?>
                    </select>
                </div>
                <div id="hiddenContainer" class="colum50">
                    <label for="hidden">*Oculto:</label>
                    <div id="hiddenRadioButtonContainer">
                        <div id="hiddenRadioButtonYesContainer">
                            <label for="hiddenRadioButtonYes">Sí</label>
                            <input type="radio" name="hidden" value="yes" id="hiddenRadioButtonYes" />
                        </div>
                        <div id="hiddenRadioButtonNoContainer">
                            <label for="hiddenRadioButtonNo">No</label>
                            <input type="radio" name="hidden" value="no" var formData=id="hiddenRadioButtonNo" checked />
                        </div>
                    </div>
                </div>
            </div>
            <div id="mediaLinkContainer">
                <label for="videoLink">Link del video:</label>
                <input type="text" name="videoLink" id="videoLink" placeholder="Inserta aquí el link del vídeo." />
            </div>
            <!-- <input type="file" id="file-input" multiple> -->
            <div class="custom-file-input button1s">
                <label for="file-input">Seleccionar archivos</label>
                <input type="file" id="file-input" accept=".jpg, .jpeg, .png" multiple />
            </div>
            <div id="preview-container" class="displayNone"></div>

            <button id="submitButton" type="submit" class="button1" style="border-style: none">Enviar</button>
            <input type="hidden" name="sendingForm" value="true">
        </form>
        <div id="errorInfo"></div>
    </div>
</body>
<script>
    const formData = new FormData();
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
                    // primero lo subimos al objeto formData
                    //formData.append('images[]', files[i]);
                    formData.append(fileName, files[i]);
                    // console.log([...formData]);
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
        console.log([...formData]);

        fileInput.value = "";
    }

    // Función para manejar el clic en la equis (x) para eliminar la imagen
    function handleDeleteImage(event) {
        var thumbnailContainer = "";
        if (event.target.nodeName == "path") {
            thumbnailContainer = event.target.parentNode.parentNode.parentNode;
        } else {
            thumbnailContainer = event.target.parentNode.parentNode;
        }

        //detecto en que indice se encuentra la imagen a borrar
        const index = Array.from(previewContainer.children).indexOf(thumbnailContainer);

        //Elimino la imagen del FormData
        //console.log(selectedImages[index]["name"]);
        formData.delete(selectedImages[index]["name"]);
        //deleteImageFromFormData(selectedImages[index]["name"]);
        console.log([...formData]);
        console.log(formData);
        for (var key of formData.keys()) {
            var values = formData.getAll(key);

            for (var value of values) {
                if (value instanceof File) {
                    console.log('Archivo:', value);
                }
            }
        }

        // Eliminar la imagen del array de imágenes seleccionadas
        selectedImages.splice(index, 1);

        // Eliminar la imagen de la previsualización
        previewContainer.removeChild(thumbnailContainer);

        if (selectedImages.length == 0) previewContainer.classList.add("displayNone");
        fileInput.value = "";
    }

    // // Función para manejar el envío del formulario
    // function handleSubmit(event) {
    //     event.preventDefault();

    //     // Eliminar todas las imágenes de la previsualización
    //     while (previewContainer.firstChild) {
    //         previewContainer.removeChild(previewContainer.firstChild);
    //     }

    //     // Crear un objeto FormData para enviar los archivos
    //     const formData = new FormData();

    //     // Agregar cada archivo previamente seleccionado al FormData
    //     for (let i = 0; i < selectedImages.length; i++) {
    //         formData.append("images[]", selectedImages[i]);
    //     }

    //     // Realizar la solicitud Fetch al servidor
    //     fetch("tu_archivo_php.php", {
    //             method: "POST",
    //             body: formData,
    //         })
    //         .then((response) => {
    //             // Manejar la respuesta del servidor
    //             console.log("Imágenes enviadas correctamente");
    //         })
    //         .catch((error) => {
    //             // Manejar errores
    //             console.error("Error al enviar las imágenes:", error);
    //         });
    // }

    document.getElementById("myForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Evita que el formulario se envíe de forma predeterminada

        // Obtén los datos del formulario
        const formData = new FormData(event.target);

        // Realiza la solicitud Fetch al controlador
        fetch("./controller/addProductController.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json()) // Convierte la respuesta a JSON
            .then(data => {
                // Maneja la respuesta del controlador
                console.log(data.message); // Muestra el mensaje del controlador

                const errorInfoDiv = document.getElementById("errorInfo");
                errorInfoDiv.innerHTML = "";

                const errorMessage = data.message;
                for (let key in errorMessage) {
                    // Crea un párrafo con el contenido del error y lo agrega al div
                    const p = document.createElement("p");
                    p.textContent = `${errorMessage[key]}`;
                    errorInfoDiv.appendChild(p);
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

    // // Agregar evento de escucha al formulario para enviarlo
    // const form = document.getElementById("myForm");
    // form.addEventListener("submit", handleSubmit);
</script>

</html>