<?php

$string = "asadasda as dassÜdç";
if (preg_match("/[a-zA-Z0-9á-úÁ-Úä-üÄ-ÜñÑçÇ\s]{3,15}$/", $string)) {

    echo "da true";
} else {
    echo "aa";
}
