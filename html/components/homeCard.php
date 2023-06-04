<?php

$averageScore = $productList[$i]->getAverageScore();
$userCredentials = 0;
if (isset($_SESSION["user"])) {
    $userCredentials = $_SESSION["user"]->getCredentials();
}
?>
<?php $productConHidden = $productList[$i]->getHiden() ? 'productConHidden' : ''; ?>
<div id="productIdCon-<?php echo $productList[$i]->getId_product() ?>" class="productCon <?php echo $productConHidden ?>">
    <div id="productId-<?php echo ($productList[$i]->getId_product()) ?>" class="carousel carousel-dark slide">
        <div class="carousel-inner">
            <?php
            $activeDone = false;
            for ($j = 0; $j < count($productList[$i]->getMedia_list()); $j++) {
                $urlMedia = $productList[$i]->getMedia_list()[$j]['url'];
                $typeMedia = $productList[$i]->getMedia_list()[$j]['type'];

                $active = "";
                if ($typeMedia != "video" && !$activeDone) {
                    $active = "active";
                    $activeDone = true;
                }
                if ($typeMedia == "image" || $typeMedia == "notFound") {
                    echo ('
                        <div class="carousel-item ' . $active . '">    
                            <img src="img/products/' . $urlMedia . '" class="d-block w-100" alt="..." />
                        </div>
                    ');
                }
            }
            if (count($productList[$i]->getMedia_list()) == 1 && $productList[$i]->getMedia_list()[0]['type'] == "video") {
                echo ('
                        <div class="carousel-item active">    
                            <img src="img/products/0-notFoundMedia/1.jpg" class="d-block w-100" alt="..." />
                        </div>
                    ');
            }
            ?>
        </div>
        <div class="carousel-indicators">
            <?php
            $activeDone = false;
            $count = 0;
            for ($j = 0; $j < count($productList[$i]->getMedia_list()); $j++) {
                $urlMedia = $productList[$i]->getMedia_list()[$j]['url'];
                $typeMedia = $productList[$i]->getMedia_list()[$j]['type'];

                $active = "";
                if ($typeMedia != "video" && !$activeDone) {
                    $active = 'class="active" aria-current="true"';
                    $activeDone = true;
                }
                if ($typeMedia == "image" || $typeMedia == "notFound") {
                    echo ('
                        <button type="button" data-bs-target="#productId-' . $productList[$i]->getId_product() . '" data-bs-slide-to="' . $count . '" ' . $active . ' aria-label="Slide ' . ($j + 1) . '"></button>
                    ');
                    $count++;
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
                                <svg class='$class' xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
                                    <polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'></polygon>
                                </svg>
                            ");
                        }
                        ?>
                    </div>
                </div>
                <div class="productCon-infoCon-header-buttons">
                    <?php
                    if ($userCredentials == 1) {
                        $hideProductIconClass = $productList[$i]->getHiden() ? 'hideSvg-off' : 'hideSvg';
                        echo "
                            <svg id='hideProductIcon-$i' class='hideProductIcon $hideProductIconClass' xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                                <path d='M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z'></path>
                                <circle cx='12' cy='12' r='3'></circle>
                            </svg>
                        ";
                        echo ("
                            <svg id='deleteProductIcon' class='deleteSvg' xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                                <polyline points='3 6 5 6 21 6'></polyline>
                                <path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path>
                                <line x1='10' y1='11' x2='10' y2='17'></line>
                                <line x1='14' y1='11' x2='14' y2='17'></line>
                            </svg>
                        ");

                        echo ("
                            <svg id='editProductIcon-$i'class='editSvg' xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 20 20'>
                                <path fill='none' d='M19.404,6.65l-5.998-5.996c-0.292-0.292-0.765-0.292-1.056,0l-2.22,2.22l-8.311,8.313l-0.003,0.001v0.003l-0.161,0.161c-0.114,0.112-0.187,0.258-0.21,0.417l-1.059,7.051c-0.035,0.233,0.044,0.47,0.21,0.639c0.143,0.14,0.333,0.219,0.528,0.219c0.038,0,0.073-0.003,0.111-0.009l7.054-1.055c0.158-0.025,0.306-0.098,0.417-0.211l8.478-8.476l2.22-2.22C19.695,7.414,19.695,6.941,19.404,6.65z M8.341,16.656l-0.989-0.99l7.258-7.258l0.989,0.99L8.341,16.656z M2.332,15.919l0.411-2.748l4.143,4.143l-2.748,0.41L2.332,15.919z M13.554,7.351L6.296,14.61l-0.849-0.848l7.259-7.258l0.423,0.424L13.554,7.351zM10.658,4.457l0.992,0.99l-7.259,7.258L3.4,11.715L10.658,4.457z M16.656,8.342l-1.517-1.517V6.823h-0.003l-0.951-0.951l-2.471-2.471l1.164-1.164l4.942,4.94L16.656,8.342z'></path>
                            </svg>
                        ");
                    }
                    ?>
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