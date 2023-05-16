
<?php
$productId = $userPanelFavoriteList[$i]->getProductId();
echo "
<div class='favoriteProduct'>
    <figure>
    <img class='favoriteProduct-img' src='./img/products/$prodImg' alt=''/>
    </figure> 
    <div class='favoriteProduct-dataContainer'>
        <h2>$prodName</h2>
        <div id='score-container'>
            <div id='product-score-number'>
                <p>$aveScor</p>
            </div>
            <div id='stars'>
";
for ($j = 0; $j < 5; $j++) {
    $class = "starSvgFilled";
    if (round($userPanelFavoriteList[0]->getAverageScore()) < $j + 1) {
        $class = "starSvgEmpty";
    }
    echo ("
    <svg class='$class' xmlns='http://www.w3.org/2000/svg' width='24' viewBox='0 0 24 24' fill='none' stroke='#000000' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'>
        <polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'></polygon>
    </svg>
");
}
echo "
            </div>
        </div>
        <a class='verLink' href='./controller/productInfoController.php?id=$productId'>Ver</a>
        <button id='deleteButtonId-$productId' class='eliminarBoton'>Eliminar</button>
    </div>
</div>
";
