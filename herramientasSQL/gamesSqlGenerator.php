<?php
///////////////////////
//       DATOS       //
///////////////////////
$name = array(
    "Ajedrez",
    "Monopoly",
    "Scrabble",
    "Risk",
    "Trivial Pursuit",
    "Catan",
    "Carcassonne",
    "Dominion",
    "Pandemic",
    "Clue",
    "Jenga",
    "Twister",
    "Puerto Rico",
    "Ticket to Ride",
    "Battleship",
    "Stratego",
    "Dixit",
    "Splendor",
    "Azul",
    "Santorini",
    "Codenames",
    "Munchkin",
    "Magic: The Gathering",
    "King of Tokyo",
    "Bang!",
    "Betrayal at Baldur's Gate",
    "Boss Monster",
    "Dead of Winter",
    "Spyfall",
    "The Resistance",
    "Gloomhaven",
    "Hive",
    "Photosynthesis",
    "Sushi Go!",
    "Machi Koro",
    "Forbidden Island",
    "Hanabi",
    "Spy Alley",
    "The Settlers of Catan",
    "Terraforming Mars",
    "Power Grid",
    "Small World",
    "Arkham Horror",
    "A Game of Thrones: The Board Game",
    "7 Wonders",
    "Lords of Waterdeep",
    "Sheriff of Nottingham",
    "Scythe",
    "Talisman",
    "Dominion: Intrigue"
);
$description = array(
    "Un juego de estrategia en el que dos jugadores se enfrentan en un tablero de 64 casillas con piezas como el rey, la reina, los caballos, etc. El objetivo es dar jaque mate al rey del oponente.",
    "Un juego de negociación y comercio en el que los jugadores compran y venden propiedades, construyen edificios y cobran alquiler a otros jugadores. El objetivo es hacer que los demás jugadores quiebren y ser el último en pie.",
    "Un juego de palabras en el que los jugadores forman palabras con las letras que tienen en su poder en un tablero de 15x15 casillas. Cada letra tiene un valor y el objetivo es obtener la mayor cantidad de puntos.",
    "Un juego de estrategia en el que los jugadores deben conquistar territorios y defenderlos de los ataques de otros jugadores. El objetivo es dominar el mundo.",
    "Un juego de preguntas y respuestas en el que los jugadores deben responder correctamente preguntas en seis categorías diferentes. El objetivo es completar un 'quesito' de cada categoría y luego llegar al centro del tablero.",
    "Un juego de estrategia en el que los jugadores construyen y comercian en una isla ficticia llamada Catan. El objetivo es obtener puntos construyendo ciudades, carreteras y colonias.",
    "Un juego de colocación de losetas en el que los jugadores construyen la ciudad de Carcassonne y sus alrededores. El objetivo es obtener la mayor cantidad de puntos completando ciudades, caminos y monasterios.",
    "Un juego de construcción de mazos en el que los jugadores construyen sus propios mazos de cartas y compiten por puntos. El objetivo es obtener la mayor cantidad de puntos comprando cartas y construyendo un mazo eficiente.",
    "Un juego cooperativo en el que los jugadores trabajan juntos para detener la propagación de enfermedades por todo el mundo. El objetivo es curar las cuatro enfermedades antes de que se propague por todo el mundo.",
    "Un juego de deducción en el que los jugadores deben descubrir quién mató al Sr. Black, con qué arma y en qué habitación. Los jugadores hacen preguntas y deducen la solución del crimen.",
    "Un juego de habilidad en el que los jugadores deben retirar bloques de madera de una torre y colocarlos en la parte superior sin hacer que se derrumbe.",
    "Un juego físico en el que los jugadores deben colocar sus manos y pies en círculos de colores en un tapete. El objetivo es no caerse mientras los otros jugadores hacen lo mismo.",
    "Un juego de estrategia en el que los jugadores construyen edificios y plantaciones en la isla de Puerto Rico. El objetivo es obtener la mayor cantidad de puntos comerciando con las plantaciones y los edificios.",
    "Un juego de mesa de estrategia en el que los jugadores construyen vías de tren entre ciudades para obtener puntos.",
    "Un juego de mesa de estrategia en el que dos jugadores se turnan para tratar de hundir los barcos del oponente.",
    "Un juego de mesa de estrategia en el que los jugadores intentan capturar la bandera del oponente mientras protegen la suya.",
    "Un juego de cartas en el que los jugadores deben describir una carta con una frase o una palabra. Los demás jugadores deben elegir una carta de su mano que mejor se ajuste a esa descripción.",
    "Un juego de mesa de estrategia en el que los jugadores compiten por puntos a través de la compra de gemas y cartas de desarrollo.",
    "Un juego de mesa de estrategia en el que los jugadores crean patrones de azulejos en una pared. El objetivo es obtener la mayor cantidad de puntos.",
    "Un juego de mesa de estrategia en el que los jugadores construyen edificios en una isla y tratan de llegar a la cima de la montaña. El objetivo es ser el primero en alcanzar la cima o bloquear a los oponentes.",
    "Un juego de palabras en el que los jugadores deben adivinar la palabra correcta a partir de una pista dada por su compañero de equipo.",
    "Un juego de cartas en el que los jugadores asumen el papel de aventureros en un mundo de fantasía y luchan contra monstruos para obtener niveles y tesoros.",
    "Un juego de cartas coleccionable en el que los jugadores construyen mazos de cartas con diferentes habilidades y hechizos para derrotar a su oponente.",
    "Un juego de mesa de dados en el que los jugadores juegan como monstruos gigantes que luchan por el control de la ciudad de Tokio.",
    "Un juego de mesa de deducción en el que los jugadores juegan como forajidos del Viejo Oeste que intentan matar al Sheriff o al Vice-Sheriff mientras evitan ser descubiertos.",
    "Un juego de mesa de aventuras en el que los jugadores exploran una ciudad de fantasía y se enfrentan a criaturas malignas. Uno de los jugadores se convierte en el traidor y debe luchar contra los demás.",
    "Un juego de mesa de construcción de mazos en el que los jugadores juegan como jefes de mazmorra que construyen mazmorras para atraer a los aventureros y matarlos.",
    "Un juego de mesa de supervivencia en el que los jugadores intentan sobrevivir en un mundo post-apocalíptico infestado de zombis. Los jugadores tienen que reunir recursos, luchar contra los zombis y cumplir con objetivos secretos.",
    "Un juego de mesa de deducción en el que los jugadores juegan como espías que intentan adivinar la ubicación secreta mientras evitan ser descubiertos.",
    "Un juego de roles en el que los jugadores se dividen en dos equipos, los rebeldes y los espías. Los espías deben sabotear las misiones de los rebeldes sin ser descubiertos.",
    "Un juego de mesa de aventuras en el que los jugadores controlan un grupo de mercenarios en un mundo de fantasía y completan misiones para ganar puntos y experiencia.",
    "Un juego de mesa de estrategia en el que los jugadores juegan como insectos que intentan rodear a la abeja reina del oponente.",
    "Un juego de mesa de estrategia en el que los jugadores juegan como árboles que intentan crecer y reproducirse para obtener la mayor cantidad de puntos de luz solar.",
    "Un juego de mesa de recolección de cartas en el que los jugadores intentan construir la mejor comida de sushi posible a partir de cartas de diferentes tipos de sushi.",
    "Un juego de mesa de construcción de ciudades en el que los jugadores construyen edificios y establecimientos para mejorar su ciudad y obtener la mayor cantidad de monedas posible.",
    "Un juego de mesa cooperativo en el que los jugadores deben trabajar juntos para recuperar artefactos valiosos de una isla antes de que se hunda en el mar.",
    "Un juego de cartas cooperativo en el que los jugadores trabajan juntos para crear un espectáculo de fuegos artificiales perfecto, pero cada jugador solo puede ver las cartas de los demás.",
    "Un juego de mesa de deducción en el que los jugadores juegan como espías encubiertos que intentan descubrir la identidad del espía enemigo mientras evitan ser descubiertos.",
    "Un juego de mesa de estrategia en el que los jugadores construyen asentamientos y ciudades en una isla mientras recolectan recursos y comercian con otros jugadores.",
    "Un juego de mesa de estrategia en el que los jugadores juegan como corporaciones que intentan terraformar el planeta Marte para que sea habitable para los humanos.",
    "Un juego de mesa de estrategia económica en el que los jugadores intentan construir y gestionar una red eléctrica para suministrar energía a diferentes ciudades.",
    "Un juego de mesa de estrategia en el que los jugadores controlan razas fantásticas y luchan por el control de territorios y recursos.",
    "Un juego de mesa de aventuras en el que los jugadores juegan como investigadores que intentan evitar que los monstruos de Lovecraft destruyan la ciudad de Arkham.",
    "The Board Game: Basado en los libros y la serie de televisión, este juego de mesa es una simulación de guerra y diplomacia entre varias familias de Westeros. Los jugadores tratan de conquistar y controlar los territorios para ganar el control del Trono de Hierro. El juego incluye elementos de estrategia, intriga y traición.",
    "Un juego de mesa de estrategia en el que los jugadores construyen ciudades antiguas y maravillas del mundo para obtener puntos.",
    "Este juego de mesa de estrategia es ambientado en la ciudad ficticia de Waterdeep en el universo de Dungeons & Dragons. Los jugadores asumen el papel de señores encubiertos y compiten por la influencia en la ciudad mediante la adquisición de aventureros y la realización de misiones. El juego incluye una mecánica de colocación de trabajadores y un elemento de ocultamiento de información.",
    "Sheriff of Nottingham: Un juego de mesa de negociación y engaño en el que los jugadores asumen el papel de mercaderes y deben pasar mercancía a través de la aduana mientras tratan de engañar al sheriff.",
    "Un juego de estrategia ambientado en una Europa alternativa en los años 20 en el que los jugadores construyen mechas y luchan por el control del territorio.",
    "Este juego de mesa es un juego de aventuras de fantasía donde los jugadores se mueven por un tablero y luchan contra monstruos y recolectan tesoros. Cada jugador selecciona un personaje con habilidades y atributos únicos y utiliza cartas para influir en los resultados de los dados. El objetivo del juego es llegar al centro del tablero y enfrentarse al poderoso Talismán. El juego incluye una gran cantidad de cartas y piezas, lo que lo hace muy temático y variado.",
    "Intrigue: Una expansión del juego Dominion en la que se añaden nuevas cartas y se pueden jugar partidas con más jugadores."
);
//Ajedrez, Monopoly, Scrabble, Risk, Trivial Pursuit, Catan, Carcassonne, Dominion, Pandemic, Clue, Jenga, Twister, Puerto Rico, Ticket to Ride, Battleship, Stratego, Dixit, Splendor, Azul, Santorini, Codenames, Munchkin, Magic: The Gathering, King of Tokyo, Bang!, Betrayal at Baldur's Gate, Boss Monster, Dead of Winter, Spyfall, The Resistance, Gloomhaven, Hive, Photosynthesis, Sushi Go!, Machi Koro, Forbidden Island, Hanabi, Spy Alley, The Settlers of Catan, Terraforming Mars, Power Grid, Small World, Arkham Horror, A Game of Thrones, 7 Wonders, Lords of Waterdeep, Scythe, Talisman, Dominion
$type = array(
    "Tablero",
    "Tablero",
    "Tablero",
    "Tablero",
    "Tablero",
    "Tablero",
    "Tablero",
    "Cartas",
    "Tablero",
    "Tablero",
    "Dados",
    "Dados",
    "Rol",
    "Tablero",
    "Tablero",
    "Tablero",
    "Cartas",
    "Cartas",
    "Tablero",
    "Tablero",
    "Cartas",
    "Cartas",
    "Cartas",
    "Dados",
    "Cartas",
    "Rol",
    "Cartas",
    "Rol",
    "Cartas",
    "Cartas",
    "Rol",
    "Tablero",
    "Tablero",
    "Cartas",
    "Dados",
    "Tablero",
    "Cartas",
    "Rol",
    "Tablero",
    "Tablero",
    "Tablero",
    "Tablero",
    "Rol",
    "Rol",
    "Cartas",
    "Tablero",
    "Tablero",
    "Rol",
    "Cartas",
    "Cartas"
);

$categories = array(
    "Terror",
    "Misterio",
    "Ingenio",
    "Humor",
    "Fantasía",
    "Familiares",
    "Estrategia",
    "Cooperativos",
    "Ciencia Ficción",
    "Aventuras"
);
$publisher = array();


///////////////////////
//      PROCESO      //
///////////////////////

for ($i = 0; $i < 50; $i++) {
    createQuery($i);
}


///////////////////////
//     FUNCIONES     //
///////////////////////

function valorRandomDeLista($lista)
{
    shuffle($lista);
    return $lista[0];
}
function createQuery($contador)
{
    global $name;
    global $description;
    global $type;
    global $listaAvatars;
    global $publisher;
    global $categories;

    $na = $name[$contador];
    $des = $description[$contador];
    $lin = "https://www.amazon.es/s?k=" . convertirEspaciosEnMas($name[$contador]);
    $max = rand(2, 12);
    $len = rand(20, 150);
    $age = rand(0, 12);
    $ty = idTypeConvertor($type[$contador]);
    $ca = rand(1, 10);
    $pu = rand(1, 169);;
    echo ('INSERT INTO `products` 
            (`id`, `name`, `description`, `shopping_link`, `min_players`, `max_players`, `length`, `minimum_age`, `type`, `category`, `publisher`, `add_date`, `hidden`)
    VALUES (NULL, "' . $na . '", "' . $des . '", "' . $lin . '", "2", "' . $max . '", "' . $len . '", "' . $age . '", "' . $ty . '", "' . $ca . '", "' . $pu . '", current_timestamp(), "0");');
    echo ('<br>');
}

function idTypeConvertor($type)
{
    switch ($type) {
        case 'Tablero':
            return 1;
        case 'Cartas':
            return 2;
        case 'Rol':
            return 3;
        case 'Dados':
            return 4;
        default:
            return 1;
    }
}

function normalizar($array)
{
    for ($i = 0; $i < count($array); $i++) {
        $array[$i] = eliminarTildesYMayusculas($array[$i]);
        $array[$i] = strtolower($array[$i]);
    }
    return $array;
}
function eliminarTildesYMayusculas($cadena)
{

    //Ahora reemplazamos las letras
    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cadena
    );

    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena
    );

    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena
    );

    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena
    );

    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena
    );

    return $cadena;
}

function convertirEspaciosEnMas($cadena)
{
    $cadena = str_replace(
        array(' '),
        array('+'),
        $cadena
    );
    return $cadena;
}
