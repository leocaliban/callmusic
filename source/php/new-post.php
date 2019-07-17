<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title>Criar postagem</title>
    <meta name="description" content="Call and download Music!" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/all.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.min.css" />
</head>

<body>
    <nav class="navbar navbar--novo-post">
        <div class="navbar__logo">
            <img class="navbar__logo__image" src="assets/images/logot.png" alt="Callmusic Logo">
            <div class="navbar__logo__title">CallMusic</div>
        </div>
        <ul class="navbar__menu navbar__menu--novo-post">
            <li class="navbar__menu__item navbar__menu__item--active"><a href="#">Novo CD</a></li>
            <li class="navbar__menu__item"><a href="index.php">Sair</a></li>
        </ul>
    </nav>

    <main class="main">
        <?php
        require_once('constants/app-vars.php');
        require_once('constants/connection-vars.php');

        if (isset($_POST['submit'])) {
            $banda = $_POST['banda'];
            $album = $_POST['album'];
            $genero = $_POST['genero'];
            $ano = $_POST['ano'];
            $tamanho = $_POST['tamanho'];
            $link = $_POST['link'];

            $imagem = $_FILES['imagem']['name'];
            $imagem_type = $_FILES['imagem']['type'];
            $imagem_size = $_FILES['imagem']['size'];

            if (!empty($banda) && !empty($album) && !empty($genero) && !empty($ano) && !empty($tamanho) && !empty($link) && !empty($imagem)) {
                if ((($imagem_type == 'image/gif') || ($imagem_type == 'image/jpeg')
                        || ($imagem_type == 'image/pjpeg') || ($imagem_type == 'image/png'))
                    && ($imagem_size > 0) && ($imagem_size <= CM_MAXFILESIZE)
                ) {
                    if ($_FILES['imagem']['error'] == 0) {
                        $file_name = time() . $imagem;
                        $target_path = CM_UPLOADPATH . $file_name;

                        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $target_path)) {
                            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                                or die('Erro de conexão com MySQL server.');

                            $query = "INSERT INTO post VALUES (0, '$banda', '$album', '$genero', '$ano', '$tamanho', '$file_name', '$link', NOW())";

                            mysqli_query($dbc, $query) or die('Ocorreu um erro na query.');

                            echo '<p>Sua postagem foi registrada com sucesso!</p>';

                            $banda = '';
                            $album = '';
                            $genero = '';
                            $ano = '';
                            $tamanho = '';
                            $link = '';

                            mysqli_close($dbc);
                        } else {
                            echo '<p class="error">Desculpe, ocorreu um problema como o envio da sua imagem.</p>';
                        }
                    }
                } else {
                    echo '<p class="error">Desculpe, sua imagem deve ser no formato GIF, JPEG ou PNG, tamanho máximo é de ' . (CM_MAXFILESIZE / 1024) . ' KB.</p>';
                }
                @unlink($_FILES['imagem']['tmp_name']);
            } else {
                echo '<p class="error">Por favor preencha todos os campos do formulário.</p>';
            }
        }

        ?>

        <h1 class="main__titulo">Postar novo CD</h1>
        <form class="main__form-novo" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="MAX_FILE_SIZE" value="2000000">

            <div class="main__form-novo__group">
                <label class="main__form-novo__group__label" for="banda">Banda</label>
                <input class="main__form-novo__group__input" type="text" id="banda" name="banda" required value="<?php if (!empty($banda)) echo $banda; ?>" />
            </div>

            <div class="main__form-novo__group">
                <label class="main__form-novo__group__label" for="album">Álbum</label>
                <input class="main__form-novo__group__input" type="text" id="album" name="album" required value="<?php if (!empty($album)) echo $album; ?>" />
            </div>

            <div class="main__form-novo__group">
                <label class="main__form-novo__group__label" for="genero">Gênero</label>
                <input class="main__form-novo__group__input" type="text" id="genero" name="genero" required value="<?php if (!empty($genero)) echo $genero; ?>" />
            </div>

            <div class="main__form-novo__group">
                <label class="main__form-novo__group__label" for="ano">Ano</label>
                <input class="main__form-novo__group__input" type="number" min="1950" max="2025" id="ano" name="ano" required value="<?php if (!empty($ano)) echo $ano; ?>" />
            </div>

            <div class="main__form-novo__group">
                <label class="main__form-novo__group__label" for="tamanho">Tamanho</label>
                <input class="main__form-novo__group__input" type="number" id="tamanho" name="tamanho" required value="<?php if (!empty($tamanho)) echo $tamanho; ?>" />
            </div>

            <div class="main__form-novo__group">
                <label class="main__form-novo__group__label" for="link">Link para download</label>
                <input class="main__form-novo__group__input" type="url" id="link" name="link" required value="<?php if (!empty($link)) echo $link; ?>" />
            </div>

            <div class="main__form-novo__group">
                <label class="main__form-novo__group__label" for="imagem">Capa do CD</label>
                <input class="main__form-novo__group__button main__form-novo__group__button--imagem" type="file" id="imagem" name="imagem" required>
            </div>

            <div class="main__form-novo__group">
                <input class="main__form-novo__group__button" type="submit" value="Enviar" name="submit" />
            </div>
        </form>
    </main>
</body>

</html>