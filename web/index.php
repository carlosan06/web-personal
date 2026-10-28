<?php
// Dirección de la API de C# (debe estar ejecutándose con "dotnet run")
$apiUrl = "http://localhost:5000/api/calculadora";

// Datos personales
$nombre = "Carlos Hugo Almachi Ñacato";
$titulo = "Desarrollador de Software";
$foto = "img/avatar.svg";
$ubicacion = "Quito, Ecuador";
$correo = "carlosan06@uniandes.edu.ec";
$linkedin = "https://www.linkedin.com/in/carlos-almachi-dev/";
$github = "https://github.com/carlosan06";

$descripcion = [
    "Hola, soy Hugo. Vivo en Quito y trabajo en desarrollo de software.",
    "Me gusta aprender cosas nuevas, trabajar en equipo y crear aplicaciones web útiles y sencillas de usar.",
];

$estudios = [
    ["nivel" => "Educación Superior", "institucion" => "Universidad Regional Autónoma de los Andes (UNIANDES)", "detalle" => "Informática de Software"],
    ["nivel" => "Educación Secundaria", "institucion" => "Instituto Técnico Superior \"Vicente León\"", "detalle" => "Bachiller en Ciencias Físico Matemático"],
    ["nivel" => "Idiomas", "institucion" => "Inglés", "detalle" => "Escrito: intermedio · Oral: intermedio"],
];

$experiencia = [
    ["empresa" => "Soluciones Web Andinas", "cargo" => "Desarrollador Web", "periodo" => "2022 - Actualidad",
     "descripcion" => "Desarrollo y mantenimiento de páginas web y formularios para pequeños negocios."],
    ["empresa" => "TecnoServicios Quito", "cargo" => "Asistente de Sistemas", "periodo" => "2019 - 2022",
     "descripcion" => "Soporte a usuarios, mantenimiento de equipos y apoyo en pequeños desarrollos internos."],
];

$habilidades = [
    "Lenguajes" => ["C#", "PHP", "JavaScript"],
    "Diseño web" => ["HTML", "CSS"],
    "Bases de datos" => ["MySQL"],
    "Herramientas" => ["Git", "Visual Studio Code"],
];

$certificaciones = [
    "Curso de Desarrollo Web con HTML y CSS",
    "Scrum Foundation Professional Certificate (SFPC)",
];

$operaciones = [
    "suma" => "Suma (+)",
    "resta" => "Resta (−)",
    "multiplicacion" => "Multiplicación (×)",
    "division" => "División (÷)",
];

$a = "";
$b = "";
$op = "suma";
$resultado = null;
$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $a = trim($_POST["a"] ?? "");
    $b = trim($_POST["b"] ?? "");
    $op = $_POST["op"] ?? "suma";

    if (!is_numeric($a) || !is_numeric($b)) {
        $error = "Ingrese dos números válidos.";
    } else {
        // Llamada a la API de C#
        $url = $apiUrl . "?" . http_build_query(["a" => $a, "b" => $b, "op" => $op]);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        $respuesta = curl_exec($curl);
        $codigo = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($respuesta === false) {
            $error = "No se pudo conectar con la API de C#. ¿Está ejecutándose en $apiUrl?";
        } else {
            $datos = json_decode($respuesta, true);
            if ($codigo === 200) {
                $resultado = $datos["resultado"];
            } else {
                $error = $datos["error"] ?? "Error desconocido en la API.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($nombre) ?> - Web Personal</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <img class="foto" src="<?= $foto ?>" alt="Foto de <?= htmlspecialchars($nombre) ?>">
        <h1><?= htmlspecialchars($nombre) ?></h1>
        <p><?= htmlspecialchars($titulo) ?></p>
        <p class="ubicacion"><?= htmlspecialchars($ubicacion) ?></p>
        <nav>
            <a href="#sobre-mi">Sobre mí</a>
            <a href="#experiencia">Experiencia</a>
            <a href="#habilidades">Habilidades</a>
            <a href="#calculadora">Calculadora</a>
            <a href="#contacto">Contacto</a>
        </nav>
    </header>

    <main>
        <section id="sobre-mi">
            <h2>Sobre mí</h2>
            <?php foreach ($descripcion as $parrafo): ?>
                <p><?= htmlspecialchars($parrafo) ?></p>
            <?php endforeach; ?>
        </section>

        <section id="formacion">
            <h2>Formación</h2>
            <?php foreach ($estudios as $estudio): ?>
                <div class="item">
                    <h3><?= htmlspecialchars($estudio["nivel"]) ?></h3>
                    <p><strong><?= htmlspecialchars($estudio["institucion"]) ?></strong></p>
                    <p><?= htmlspecialchars($estudio["detalle"]) ?></p>
                </div>
            <?php endforeach; ?>
        </section>

        <section id="experiencia">
            <h2>Experiencia laboral</h2>
            <?php foreach ($experiencia as $trabajo): ?>
                <div class="item">
                    <h3><?= htmlspecialchars($trabajo["cargo"]) ?></h3>
                    <p><strong><?= htmlspecialchars($trabajo["empresa"]) ?></strong> <span class="periodo"><?= htmlspecialchars($trabajo["periodo"]) ?></span></p>
                    <p><?= htmlspecialchars($trabajo["descripcion"]) ?></p>
                </div>
            <?php endforeach; ?>
        </section>

        <section id="habilidades">
            <h2>Habilidades</h2>
            <?php foreach ($habilidades as $categoria => $lista): ?>
                <h3><?= htmlspecialchars($categoria) ?></h3>
                <ul class="habilidades">
                    <?php foreach ($lista as $habilidad): ?>
                        <li><?= htmlspecialchars($habilidad) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        </section>

        <section id="certificaciones">
            <h2>Certificaciones</h2>
            <ul class="certificaciones">
                <?php foreach ($certificaciones as $certificacion): ?>
                    <li><?= htmlspecialchars($certificacion) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section id="calculadora">
            <h2>Calculadora</h2>
            <p class="nota">Los cálculos los realiza una API desarrollada en C#.</p>

            <form method="post" action="#calculadora">
                <input type="number" step="any" name="a" placeholder="Número 1" value="<?= htmlspecialchars($a) ?>" required>
                <select name="op">
                    <?php foreach ($operaciones as $valor => $texto): ?>
                        <option value="<?= $valor ?>" <?= $op === $valor ? "selected" : "" ?>><?= $texto ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="number" step="any" name="b" placeholder="Número 2" value="<?= htmlspecialchars($b) ?>" required>
                <button type="submit">Calcular</button>
            </form>

            <?php if ($resultado !== null): ?>
                <p class="resultado">Resultado: <strong><?= htmlspecialchars((string) $resultado) ?></strong></p>
            <?php elseif ($error !== null): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
        </section>

        <section id="contacto">
            <h2>Contacto</h2>
            <p>Correo: <a href="mailto:<?= htmlspecialchars($correo) ?>"><?= htmlspecialchars($correo) ?></a></p>
            <p>LinkedIn: <a href="<?= htmlspecialchars($linkedin) ?>" target="_blank"><?= htmlspecialchars($linkedin) ?></a></p>
            <p>GitHub: <a href="<?= htmlspecialchars($github) ?>" target="_blank"><?= htmlspecialchars($github) ?></a></p>
        </section>
    </main>

    <footer>
        <p>&copy; <?= date("Y") ?> <?= htmlspecialchars($nombre) ?></p>
    </footer>
</body>
</html>
