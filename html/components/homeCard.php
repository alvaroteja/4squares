<?php
//echo "<pre>";
// print_r($productList[$i]->getMedia_list()[0]) 
$averageScore = $scoreService->getAverageScore($productList[$i]->getId_product());
$userCredentials = 0;
if (isset($_SESSION["user"])) {
    $userCredentials = $_SESSION["user"]->getCredentials();
}
?>

<div class="productCon">
    <div id="<?php echo ("productId-" . ($productList[$i]->getId_product())) ?>" class="carousel carousel-dark slide">
        <div class="carousel-inner">
            <?php
            for ($j = 0; $j < count($productList[$i]->getMedia_list()); $j++) {
                $urlMedia = $productList[$i]->getMedia_list()[$j]['url'];
                $typeMedia = $productList[$i]->getMedia_list()[$j]['type'];
                if ($typeMedia == "image" || $typeMedia == "notFound") {
                    if ($j == 0) {
                        $active = "active";
                    } else {
                        $active = "";
                    }
                    echo ('
                        <div class="carousel-item ' . $active . '">    
                            <img src="img/products/' . $urlMedia . '" class="d-block w-100" alt="..." />
                        </div>
                    ');
                }
            }
            ?>
        </div>
        <div class="carousel-indicators">
            <?php
            for ($j = 0; $j < count($productList[$i]->getMedia_list()); $j++) {
                $urlMedia = $productList[$i]->getMedia_list()[$j]['url'];
                $typeMedia = $productList[$i]->getMedia_list()[$j]['type'];
                if ($typeMedia == "image" || $typeMedia == "notFound") {
                    if ($j == 0) {
                        $active = 'class="active" aria-current="true"';
                    } else {
                        $active = "";
                    }
                    echo ('
                        <button type="button" data-bs-target="#productId-' . $productList[$i]->getId_product() . '" data-bs-slide-to="' . $j . '" ' . $active . ' aria-label="Slide ' . ($j + 1) . '"></button>
                    ');
                }
            }
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo ("productId-" . ($productList[$i]->getId_product())) ?>" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#<?php echo ("productId-" . ($productList[$i]->getId_product())) ?>" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="productCon-infoCon">
        <div class="productCon-infoCon-con1">
            <div class="productCon-infoCon-header">
                <div class="productCon-infoCon-header-scoreInfo">
                    <div class="productCon-infoCon-header-scoreInfo-scoreNumber">
                        <p><?php echo $averageScore ?></p>
                    </div>
                    <div class="productCon-infoCon-header-scoreInfo-scoreStrars">
                        <?php
                        for ($j = 0; $j < 5; $j++) {
                            $class = "starSvgFilled";
                            if (round($averageScore) < $j + 1) {
                                $class = "starSvgEmpty";
                            }
                            echo ("
                                <svg class='$class' xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
                                    <polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'></polygon>
                                </svg>
                            ");
                        }
                        ?>
                        <!-- <svg class="starSvgFilled" xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                        <svg class="starSvgFilled" xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                        <svg class="starSvgFilled" xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                        <svg class="starSvgEmpty" xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                        <svg class="starSvgEmpty" xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg> -->
                    </div>
                </div>
                <div class="productCon-infoCon-header-buttons">
                    <?php
                    if ($userCredentials == 1) {
                        echo ('
                        
                    <svg onclick="toggleClass(this,\'hideSvg\',\'hideSvg-off\')" class="hideSvg" xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <svg class="deleteSvg" xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                    ');
                    }
                    ?>
                    <svg onclick="toggleClass(this,'favoriteSvg','favoriteSvg-on')" class="favoriteSvg" xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <a class="productCon-infoCon-header-buttons-amazon" href="<?php echo ($productList[$i]->getShopping_link()) . "+juego+de+mesa"; ?>">
                        <img class="button-amazon-hover" src="img/buttons/button-amazon-hover.png" alt="" />
                        <img class="button-amazon" src="img/buttons/button-amazon.png" alt="" />
                    </a>
                </div>
            </div>
            <h2 class="productCon-infoCon-title"><?php echo ($productList[$i]->getName()); ?></h2>
            <p class="productCon-infoCon-description">
                <?php echo ($productList[$i]->getDescription()); ?>
            </p>
        </div>
        <div class="productCon-infoCon-con2">
            <a class="buttonMoreInfo" href="./controller/productInfoController.php?id=<?php echo ($productList[$i]->getId_product()) ?>">
                <div class="buttonMoreInfoBox">Ver más...</div>
            </a>
        </div>
    </div>
</div>