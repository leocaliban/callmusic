<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title>CALLMUSIC</title>
    <meta name="description" content="Call and download Music!" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/all.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.min.css" />
</head>

<body>
    <header class="header">
    </header>
    <nav class="navbar">
        <div class="navbar__logo">
            <img class="navbar__logo__image" src="assets/images/logot.png" alt="Callmusic Logo">
            <div class="navbar__logo__title">CallMusic</div>
        </div>
        <ul class="navbar__menu">
            <li class="navbar__menu__item navbar__menu__item--active"><a href="#">Início</a></li>
            <li class="navbar__menu__item"><a href="#">Gêneros</a></li>
            <li class="navbar__menu__item"><a href="#">Bandas</a></li>
            <li class="navbar__menu__item"><a href="#">CallMusic</a></li>
            <li class="navbar__menu__item"><a href="#">Admin</a></li>
        </ul>
    </nav>

    <section class="section">
        <aside class="section__bandas">
            <div class="section__bandas__titulo">
                <i class="fas fa-headphones section__bandas__titulo__icon"></i>Bandas
            </div>
            <ol class="section__bandas__lista">
                <?php
                require_once('constants/connection-vars.php');
                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or die('Erro de conexão com MySQL server.');

                $query = "SELECT banda FROM post ORDER BY banda ASC";
                $data = mysqli_query($dbc, $query);

                while ($row = mysqli_fetch_array($data)) {
                    echo ('<li><a class="section__bandas__lista__item" href="#" rel="noopener" target="_blank">' . $row['banda'] . '</a></li>');
                }
                ?>
            </ol>
        </aside>
        <main class="section__main">
            <?php
            $queryPosts = "SELECT * FROM post ORDER BY data_envio DESC";
            $dataPosts = mysqli_query($dbc, $queryPosts);
            while ($row = mysqli_fetch_array($dataPosts)) {
                echo ('<article class="section__main__post">');
                echo ('<img class="section__main__post__capa" src="assets/images/' . $row['imagem'] . '" alt="Capa de CD - ' . $row['album'] . '">');
                echo ('<div class="section__main__post__cd">');
                echo ('<div><strong>Banda: </strong>' . $row['banda'] . '</div>');
                echo ('<div><strong>Álbum: </strong>' . $row['album'] . '</div>');
                echo ('<div><strong>Ano: </strong>' . $row['ano'] . '</div>');
                echo ('<div><strong>Gênero: </strong>' . $row['genero'] . '</div>');
                echo ('<div><strong>Tamanho: </strong>' . $row['tamanho'] . 'MB</div>');
                echo ('<a href="' . $row['link']  . '" rel="noopener" target="_blank">');
                echo ('<button class="section__main__post__cd__download section__main__post__cd__download">');
                echo ('<i class="fas fa-download"></i> Baixar</button></a></div></article>');
            }
            mysqli_close($dbc);
            ?>
        </main>
    </section>
</body>

</html>