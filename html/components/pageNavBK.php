<?php
////////////////////////////////////////////
//        Botones previous y next         //
////////////////////////////////////////////
$previousActive = "";
$previousHref = "";
$nextActive = "";
$nextHref = "";

if ($_SESSION["currentPage"] < 2) {
    $previousActive = "disabled";
} else {
    $previousHref = "href='index.php?currentPage=" . ($_SESSION["currentPage"] - 1) . "'";
}

if ($_SESSION["currentPage"] >= $_SESSION["maxPages"]) {
    $nextActive = "disabled";
} else {
    $nextHref = "href='index.php?currentPage=" . ($_SESSION["currentPage"] + 1) . "'";
}
echo ("
    <div class='pageNav'>
        <ul class='pagination'>
            <li class='page-item $previousActive'>
                <a class='page-link' $previousHref>Previous</a>
            </li>
");

////////////////////////////////////////////
//           Botones numericos            //
////////////////////////////////////////////

$pagination = $pageNavMaxNumbers;
if ($_SESSION["maxPages"] < $pageNavMaxNumbers) {
    $pagination = $_SESSION["maxPages"];
}

$middle = ceil($pagination / 2);
//$resto = $middle % 2;

if ($middle % 2 == 0) {
    $firstNumer = $_SESSION["currentPage"] - ($middle - 1);
    $lastNumber = $_SESSION["currentPage"] + ($middle);
} else {
    $firstNumer = $_SESSION["currentPage"] - ($middle - 1);
    $lastNumber = $_SESSION["currentPage"] + ($middle);
}
if ($firstNumer < 1) {
    $firstNumer = 1;
    $lastNumber = $pagination;
}
if ($lastNumber > $pagination) {
    $firstNumer = $_SESSION["currentPage"] - $pagination + 2;
    $lastNumber = $pagination;
}
$i = $firstNumer;

for ($i; $i <= $lastNumber; $i++) {

    if (($i) == $_SESSION["currentPage"]) {
        echo ("
            <li class='page-item active' aria-current='page'>
                <a class='page-link' href='#'>" . ($i) . "</a>
            </li>
        ");
    } else {
        echo ("<li class='page-item'><a class='page-link' href='#'>" . ($i) . "</a></li>");
    }
}

echo ("
            <li class='page-item $nextActive'>
                <a class='page-link' $nextHref>Next</a>
            </li>
        </ul>
    </div>
");
echo ("pagination: " . $pagination . " | middle: " . $middle . " | firstNumer: " . $firstNumer . " | lastNumber: " . $lastNumber . " | session max pages: " . $_SESSION["maxPages"] . " | currentPage: " . $_SESSION["currentPage"]);
