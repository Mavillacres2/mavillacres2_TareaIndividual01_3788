<?php
// Constantes
define('MAX_CUBO', 1000000);
define('MIN_FIBO', 1);
define('MAX_FIBO', 50);

// Inicialización de variables
$opcion = "";
$mostrarCampos = false;
$mensajeResultado = "";

// Funciones

// Generar la serie Fibonacci
function generarFibonacci($cantidad) {
    $fibonacci = [1, 1];
    for ($i = 2; $i < $cantidad; $i++) {
        $fibonacci[] = $fibonacci[$i - 1] + $fibonacci[$i - 2];
    }
    return $fibonacci;
}

// Encontrar números que cumplen la condición de cubos de sus dígitos
function numerosCuboDigitos() {
    $numeros = [];
    for ($i = 1; $i <= MAX_CUBO; $i++) {
        $sumaCubo = 0;
        $temp = $i;
        while ($temp > 0) {
            $digito = $temp % 10;
            $sumaCubo += pow($digito, 3);
            $temp = intdiv($temp, 10);
        }
        if ($sumaCubo == $i) {
            $numeros[] = $i;
        }
    }
    return $numeros;
}

// Calcular fraccionarios: A + B * C - D
function calcularFraccionarios($numeradorA, $denominadorA, $numeradorB, $denominadorB, $numeradorC, $denominadorC, $numeradorD, $denominadorD) {
    $a = $numeradorA / $denominadorA;
    $b = $numeradorB / $denominadorB;
    $c = $numeradorC / $denominadorC;
    $d = $numeradorD / $denominadorD;
    return $a + ($b * $c) - $d;
}


// Procesar la primera parte: seleccionar opción
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['opcion'])) {
    $opcion = strtoupper(trim($_POST['opcion']));
    if (in_array($opcion, ['1', '2', '3'])) {
        $mostrarCampos = true; // Mostrar campos adicionales
    }      // Redirigir a salir.html si se selecciona 'S'
    if ($opcion === 'S') {
        header("Location: index.html");
        exit();
    } else {
        $mensajeResultado = "Opción no válida. Selecciona 1, 2, 3 o S.";
    }
}

// Procesar la segunda parte: calcular resultados
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calcular'])) {
    $opcion = $_POST['opcion_oculta'];
    switch ($opcion) {
        case '1': // Fibonacci
            $numero = isset($_POST['numero']) ? (int)$_POST['numero'] : null;
            if ($numero < MIN_FIBO || $numero > MAX_FIBO) {
                $mensajeResultado = "Por favor ingresa un número entre 1 y 50.";
            } else {
                $fibonacci = generarFibonacci($numero);
                $mensajeResultado = "Serie Fibonacci (primeros {$numero} términos): " . implode(", ", $fibonacci);
            }
            break;

        case '2': // Números cubo
            $numerosCubo = numerosCuboDigitos();
            $mensajeResultado = "Números donde la suma del cubo de sus dígitos es igual al número:<br>" . implode(", ", $numerosCubo);
            break;

        case '3': // Fraccionarios
            $numeradorA = $_POST['numeradorA']; $denominadorA = $_POST['denominadorA'];
            $numeradorB = $_POST['numeradorB']; $denominadorB = $_POST['denominadorB'];
            $numeradorC = $_POST['numeradorC']; $denominadorC = $_POST['denominadorC'];
            $numeradorD = $_POST['numeradorD']; $denominadorD = $_POST['denominadorD'];

            if ($denominadorA > 0 && $denominadorB > 0 && $denominadorC > 0 && $denominadorD > 0) {
                $resultado = calcularFraccionarios($numeradorA, $denominadorA, $numeradorB, $denominadorB, $numeradorC, $denominadorC, $numeradorD, $denominadorD);
                $mensajeResultado = "Resultado de la expresión A + B * C - D: " . $resultado;
            } else {
                $mensajeResultado = "Todos los denominadores deben ser positivos.";
            }
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú 02</title>
    <!-- Enlace a Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <h2 class="text-center mb-4">Menú 02 de Opciones</h2>

        <!-- Tabla de opciones -->
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
                    <td>Serie Fibonacci (1 a 50 términos)</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Números donde la suma del cubo de los dígitos es igual al número</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Operación con números fraccionarios: A + B * C - D</td>
                </tr>
                <tr>
                    <td>S</td>
                    <td>Salir del programa</td>
                </tr>
            </tbody>
        </table>

        <!-- Formulario para seleccionar la opción -->
        <form method="POST" class="text-center mt-4">
            <div class="mb-3">
                <label for="opcion" class="form-label">Selecciona una opción (1, 2, 3 o S):</label>
                <input type="text" id="opcion" name="opcion" class="form-control w-50 mx-auto" maxlength="1" required>
            </div>
            <button type="submit" class="btn btn-primary">Ejecutar</button>
        </form>

        <!-- Formulario dinámico según opción -->
        <?php if ($mostrarCampos): ?>
            <form method="POST" class="mt-4">
                <input type="hidden" name="opcion_oculta" value="<?= $opcion ?>">
                <?php if ($opcion == '1'): ?>
                    <div class="mb-3">
                        <label for="numero" class="form-label">Ingresa un número para Fibonacci (1-50):</label>
                        <input type="number" id="numero" name="numero" class="form-control w-50 mx-auto" min="<?= MIN_FIBO ?>" max="<?= MAX_FIBO ?>" required>
                    </div>
                <?php elseif ($opcion == '3'): ?>
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <div class="mb-3">
                            <label class="form-label">Numerador <?= $i ?>:</label>
                            <input type="number" name="numerador<?= chr(64 + $i) ?>" class="form-control w-50 mx-auto" required>
                            <label class="form-label">Denominador <?= $i ?>:</label>
                            <input type="number" name="denominador<?= chr(64 + $i) ?>" class="form-control w-50 mx-auto" min="1" required>
                        </div>
                    <?php endfor; ?>
                <?php endif; ?>
                <button type="submit" name="calcular" class="btn btn-success">Calcular</button>
            </form>
        <?php endif; ?>

        <!-- Resultado -->
        <?php if (!empty($mensajeResultado)): ?>
            <div class="alert alert-success text-center mt-4"><?= $mensajeResultado ?></div>
        <?php endif; ?>
    </div>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
