<?php
//Inicio la sesión
session_start();

/**
 *Obtengo la información de un Pokémon desde la API de Pokémon.
 *
 *@param string $pokemonName El nombre del Pokémon a buscar.
 *@return array|null Un array con la información del Pokémon o null si no se encuentra.
 */
function getPokemonInfo($pokemonName) {
    $url = "https://pokeapi.co/api/v2/pokemon/{$pokemonName}";
    $response = @file_get_contents($url);//Uso @ para suprimir advertencias si la URL no existe

    if ($response === FALSE) {
        return null;//Retorno null si no se encuentra la respuesta
    }

    return json_decode($response, true);//Decodifico el JSON y lo retorno como un array asociativo
}

//Obtengo el nombre del Pokémon desde la URL
$pokemonName = $_GET['pokemon'] ?? '';

//Valido que el nombre no esté vacío
if (empty($pokemonName)) {
    $_SESSION['error'] = "Por favor, ingresa el nombre de un Pokémon.";
    header("Location: index.php");
    exit();
}

//Obtengo la información del Pokémon
$pokemonInfo = getPokemonInfo($pokemonName);

if ($pokemonInfo === null) {
    $_SESSION['error'] = "Pokémon no encontrado. Por favor, verifica el nombre e intenta de nuevo.";
    header("Location: index.php");
    exit();
}

//Convierto el peso a kilogramos y la altura a metros
$weightKg = $pokemonInfo['weight'] / 10;
$heightM = $pokemonInfo['height'] / 10;

//Obtengo los tipos del Pokémon
$types = array_map(function ($type) {
    return ucfirst($type['type']['name']);
}, $pokemonInfo['types']);
$typesString = implode(", ", $types);

//Guardo los datos del Pokémon en la sesión
$_SESSION['pokemon'] = [
    'pokedex' => $pokemonInfo['id'],
    'name' => $pokemonInfo['name'],
    'image' => $pokemonInfo['sprites']['front_default'],
    'height' => number_format($heightM, 2),//Formateo a 2 decimales
    'weight' => number_format($weightKg),
    'types' => $typesString,
];

//Redirijo a index.php
header("Location: index.php?pokemon=" . urlencode($pokemonName));
exit();
?>