<?php
// Procesamiento del formulario de contacto
$nombre = "";
$correo = "";
$mensaje = "";
$errores = [];
$enviado = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recuperar y limpiar los datos enviados
    $nombre = trim($_POST["nombre"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $mensaje = trim($_POST["mensaje"] ?? "");

    // Validar los campos
    if ($nombre === "") {
        $errores[] = "Por favor ingresa tu nombre.";
    }

    if ($correo === "") {
        $errores[] = "Por favor ingresa un correo.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Por favor ingresa un correo válido.";
    }

    if ($mensaje === "") {
        $errores[] = "Por favor escribe un mensaje.";
    }

    // Si no hay errores, mostrar confirmación
    if (empty($errores)) {
        $enviado = true;
        // Aquí se podría integrar mail() o un servicio de correo.
    }
}

// Evitar que los datos ingresados puedan insertar HTML en la página
function escapar($valor) {
    return htmlspecialchars($valor, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de contacto</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <main class="contenedor">
        <section class="tarjeta">
            <h1>Formulario de contacto</h1>
            <p class="descripcion">Completa los siguientes campos para ponerte en contacto.</p>

            <?php if (!empty($errores)): ?>
                <div class="alerta error" role="alert">
                    <?php foreach ($errores as $error): ?>
                        <p><?php echo escapar($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($enviado): ?>
                <div class="alerta exito" role="status">
                    ¡Gracias, <?php echo escapar($nombre); ?>! Los datos del formulario fueron validados correctamente.
                </div>
            <?php endif; ?>

            <form action="" method="POST" novalidate>
                <div class="grupo">
                    <label for="nombre">Nombre:</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        placeholder="Nombre"
                        value="<?php echo escapar($nombre); ?>"
                    >
                </div>

                <div class="grupo">
                    <label for="correo">Correo:</label>
                    <input
                        type="text"
                        id="correo"
                        name="correo"
                        placeholder="Correo"
                        value="<?php echo escapar($correo); ?>"
                    >
                </div>

                <div class="grupo">
                    <label for="mensaje">Mensaje:</label>
                    <textarea
                        id="mensaje"
                        name="mensaje"
                        placeholder="Escribe tu mensaje"
                        rows="6"
                    ><?php echo escapar($mensaje); ?></textarea>
                </div>

                <div class="acciones">
                    <button type="submit">Enviar Correo</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
