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

$firstNumer = $_SESSION["currentPage"] - floor($pagination / 2 - (($pagination + 1) % 2));
$lastNumber = $_SESSION["currentPage"] + floor($pagination / 2);
//si estamos por inicio de la lista
if ($firstNumer < 1) {
    $firstNumer = 1;
    $lastNumber = $pagination;
}
//si estamos por el final de la lista
if ($lastNumber > $_SESSION["maxPages"]) {
    $firstNumer = $_SESSION["maxPages"] - ($pagination - 1);
    $lastNumber = $_SESSION["maxPages"];
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
        echo ("<li class='page-item'><a class='page-link' href='index.php?currentPage=" . $i . "'>" . ($i) . "</a></li>");
    }
}

echo ("
            <li class='page-item $nextActive'>
                <a class='page-link' $nextHref>Next</a>
            </li>
        </ul>
    </div>
");
//echo ("pagination: " . $pagination . " | firstNumer: " . $firstNumer . " | lastNumber: " . $lastNumber . " | session max pages: " . $_SESSION["maxPages"] . " | currentPage: " . $_SESSION["currentPage"] . " | a: " . (($pagination + 1) % 2));
