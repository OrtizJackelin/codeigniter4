<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo esc($ky)?></title>
</head>
<body>
    <h1><?= esc($ky)?></h1>
    <h2>Esto es una prueba de la vista</h2>
    <h3>Noticia: <?= var_dump ($noticias) ?></h3>
</body>
</html>