<?php
///////////////////////
//       DATOS       //
///////////////////////
$name = array(
    'Sofía',
    'Juan',
    'Ana',
    'Carlos',
    'Valentina',
    'Diego',
    'Andrea',
    'Pedro',
    'Camila',
    'Pablo',
    'Natalia',
    'Luis',
    'Lucía',
    'David',
    'Marcela',
    'Alejandro',
    'Martina',
    'Francisco',
    'Victoria',
    'Tomás',
    'Gabriela',
    'Manuel',
    'Carolina',
    'José',
    'Isabella',
    'Daniel',
    'Fernanda',
    'Rafael',
    'Miranda',
    'Gonzalo',
    'Renata',
    'Andrés',
    'Daniela',
    'Miguel',
    'Renzo',
    'Luciana',
    'Gabriel',
    'Olivia',
    'Emilio',
    'Julia',
    'Santiago',
    'Paula',
    'Leonardo',
    'Claudia',
    'Max',
    'Elena',
    'Esteban',
    'Lorena',
    'Ángel',
    'María'
);
//echo (eliminarTildesYMayusculas($name[0]));
for ($i = 0; $i < count($name); $i++) {
    $name[$i] = eliminarTildesYMayusculas($name[$i]);
    $name[$i] = strtolower($name[$i]);
}
$surename = array(
    'García',
    'Fernández',
    'González',
    'Pérez',
    'Sánchez',
    'López',
    'Martínez',
    'Gómez',
    'Rodríguez',
    'Ruiz',
    'Flores',
    'Torres',
    'Ramírez',
    'Castro',
    'Vargas',
    'Castro',
    'Medina',
    'Mendoza',
    'Herrera',
    'Hernández',
    'Ortiz',
    'Espinoza',
    'Cárdenas',
    'Franco',
    'Rivera',
    'Morales',
    'Ríos',
    'Romero',
    'Salazar',
    'Silva',
    'Zamora',
    'Valencia',
    'Álvarez',
    'Reyes',
    'Cabrera',
    'Escobar',
    'Muñoz',
    'Pérez',
    'De la Cruz',
    'Villanueva',
    'Carvajal',
    'Córdova',
    'León',
    'Navarro',
    'Gallegos',
    'Rojas',
    'Acosta',
    'Tapia',
    'Chávez',
    'Miranda'
);
$nick = array(
    'SofisticadaSofía',
    'JuanSinMiedo',
    'AnaMariposa',
    'CarlitosCool',
    'ValeArcoiris',
    'DieguitoAventura',
    'AndieMundo',
    'PedritoPoderoso',
    'CamiCandela',
    'PabloArtista',
    'NataDeFlores',
    'LucesLuis',
    'LucyEnLaNube',
    'DavidRockstar',
    'MarcelaMagia',
    'AlejoMisterio',
    'MartiMelodía',
    'FranLuz',
    'VickyViento',
    'TomásViajero',
    'GabiGolondrina',
    'ManuMaravilla',
    'CarolCielo',
    'JoseJazz',
    'IsabellaLuna',
    'DaniElRojo',
    'FernandaFantasía',
    'RafaRayo',
    'MiraMar',
    'GonzaGalaxia',
    'ReniRosa',
    'AndrésÁngel',
    'DanielaDelCielo',
    'MiguelMundo',
    'RenzoRetro',
    'LucianaLibélula',
    'GabrielGuitarra',
    'OliviaOla',
    'EmiEspejo',
    'JuliaJardín',
    'SantiSalsa',
    'PaulaPintora',
    'LeonardoLuz',
    'ClaudiaCaminante',
    'MaxMístico',
    'ElenaEterna',
    'EstebEstrella',
    'LoreLluvia',
    'ÁngelAlado',
    'MariposaMaría'
);
$listaAvatars = array(
    '1',
    '2',
    '3',
    '4',
    '5',
    '6'
);

///////////////////////
//      PROCESO      //
///////////////////////


$name = normalizar($name);
$surename = normalizar($surename);
$nick = normalizar($nick);
$listaAvatars = normalizar($listaAvatars);


for ($i = 0; $i < 50; $i++) {
    createQuery($i);
}


///////////////////////
//     FUNCIONES     //
///////////////////////

function avatarRandom($listaAvatars)
{
    shuffle($listaAvatars);
    return $listaAvatars[0];
}
function createQuery($contador)
{
    global $name;
    global $surename;
    global $nick;
    global $listaAvatars;
    $na = $name[$contador];
    $su = $surename[$contador];
    $ni = $nick[$contador];
    $av = avatarRandom($listaAvatars);
    echo ("INSERT INTO `users` 
            (`id`, `first_name`, `surename`, `nickname`, `email`, `password`, `id_avatar`, `sing_up_date`, `muted`, `credentials`)
    VALUES (NULL,'" . $na . "', '" . $su . "', '" . $ni . "', '" . $na . $su . "@gmail.com', '1234', '" . $av . "', current_timestamp(), '0', '0');");
    echo ('<br>');
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
