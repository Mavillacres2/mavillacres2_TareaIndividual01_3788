<?php
// Definimos constantes
define('MINIMO', 0);
define('MAXIMO', 10);

// Función para calcular el factorial de un número
function calcularFactorial($numero) {
    $factorial = 1;
    for ($i = 1; $i <= $numero; $i++) {
        $factorial *= $i;
    }
    return $factorial;
}

// Función para verificar si un número es primo
function esNumeroPrimo($numero) {
    if ($numero <= 1) return false;
    for ($i = 2; $i <= sqrt($numero); $i++) {
        if ($numero % $i == 0) return false;
    }
    return true;
}

// Función para calcular la serie matemática
function calcularSerieMatematica($terminos) {
    $resultado = 0;
    for ($contador = 1; $contador <= $terminos; $contador++) {
        $terminoActual = pow($contador, 2) / calcularFactorial($contador);
        $resultado += ($contador % 2 == 0) ? -$terminoActual : $terminoActual;
    }
    return $resultado;
}

// Procesar la opción seleccionada
$mensajeResultado = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $opcion = strtoupper(trim($_POST['opcion'])); // Convertimos a mayúscula
    $numeroIngresado = isset($_POST['numero']) ? (int)$_POST['numero'] : null;

    // Redirigir a salir.html si se selecciona 'S'
    if ($opcion === 'S') {
        header("Location: index.html");
        exit();
    }

    if (!in_array($opcion, ['1', '2', '3'])) {
        $mensajeResultado = "Opción no válida. Por favor, selecciona 1, 2, 3 o S.";
    } elseif ($numeroIngresado < MINIMO || $numeroIngresado > MAXIMO) {
        $mensajeResultado = "El número ingresado está fuera del rango permitido. Intenta de nuevo.";
    } else {
        switch ($opcion) {
            case '1':
                $mensajeResultado = "El factorial de {$numeroIngresado} es: " . calcularFactorial($numeroIngresado);
                break;
            case '2':
                $mensajeResultado = "El número {$numeroIngresado} " . (esNumeroPrimo($numeroIngresado) ? "es primo" : "no es primo");
                break;
            case '3':
                $mensajeResultado = "El resultado de la serie matemática con {$numeroIngresado} términos es: " . calcularSerieMatematica($numeroIngresado);
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú 01</title>
    <!-- Enlace a Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <!-- Título -->
        <h2 class="text-center mb-4">Menú 01 de Opciones</h2>

        <!-- Tabla -->
        <table class="table table-bordered table-striped mx-auto w-75">
            <thead class="table-dark">
                <tr>
                    <th>Opción</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Calcular Factorial</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Verificar si un Número es Primo</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Calcular la Serie Matemática</td>
                </tr>
                <tr>
                    <td>S</td>
                    <td>Salir del Programa</td>
                </tr>
            </tbody>
        </table>

        <!-- Formulario -->
        <form method="POST" class="mt-4 text-center">
            <div class="mb-3">
                <label for="opcion" class="form-label">Selecciona una opción (1, 2, 3 o S):</label>
                <input type="text" id="opcion" name="opcion" class="form-control w-50 mx-auto" maxlength="1" required>
            </div>
            <div class="mb-3">
                <label for="numero" class="form-label">Ingresa un número entre <?= MINIMO ?> y <?= MAXIMO ?> (si seleccionas 1, 2 o 3):</label>
                <input type="number" id="numero" name="numero" class="form-control w-50 mx-auto" min="<?= MINIMO ?>" max="<?= MAXIMO ?>" placeholder="0">
            </div>
            <button type="submit" class="btn btn-primary">Ejecutar</button>
        </form>

        <!-- Resultado -->
        <?php if (!empty($mensajeResultado)): ?>
            <div class="alert alert-success text-center mt-4"><?= $mensajeResultado ?></div>
        <?php endif; ?>
    </div>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
