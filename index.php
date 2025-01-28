<?php
//Inicio la sesión
session_start();

//Verifico si hay un mensaje de error o información del Pokémon en la sesión
$error = $_SESSION['error'] ?? null;
$pokemon = $_SESSION['pokemon'] ?? null;

//Limpio la sesión después de usar los datos
unset($_SESSION['error']);
unset($_SESSION['pokemon']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de Pokémon</title>
    <link rel="stylesheet" href="css/Tarea_9_DWES.css">
</head>
<body>
    <header>
    <h1>BUSCADOR DE POKÉMON</h1>
    <header>
    <form action="pokemon.php" method="GET">
        <label for="pokemon" id="info">Nombre o número en la Pokédex del Pokémon:</label>
        <input type="text" id="pokemon" name="pokemon" placeholder="Ej: Pikachu ó 25" required>
        <button type="submit">Buscar</button>
    </form>

    <!--Aquí se mostrará la información del Pokémon-->
    <div id="pokemon-info">
        <?php
        //Muestro mensaje de error si existe
        if ($error) {
            echo "<p class='error'>$error</p>";
        }
        //Muestro la información del Pokémon si existe
        elseif ($pokemon) {
            echo "<div class='pokemon-info'>";
            echo "<table class='pokemon-table'>";
            echo "<tr><td colspan='2' class='pokemon-image'><img src='" . htmlspecialchars($pokemon['image']) . "' alt='" . htmlspecialchars($pokemon['name']) . "'></td></tr>";
            echo "<tr><td><strong>Nombre:</strong></td><td>" . htmlspecialchars(ucfirst($pokemon['name'])) . "</td></tr>";
            echo "<tr><td><strong>Número de la pokedex:</strong></td><td>" . htmlspecialchars($pokemon['pokedex']) . "</td></tr>";
            echo "<tr><td><strong>Altura:</strong></td><td>" . htmlspecialchars($pokemon['height']) . " m</td></tr>";
            echo "<tr><td><strong>Peso:</strong></td><td>" . htmlspecialchars($pokemon['weight']) . " kg</td></tr>";
            echo "<tr><td><strong>Tipo(s):</strong></td><td>" . htmlspecialchars($pokemon['types']) . "</td></tr>";
            echo "</table>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>