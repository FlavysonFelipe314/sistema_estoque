<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="FM-tech">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <title>Orla Club</title>

    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/global.css">
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/vendor/reset.css">   

    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/layouts/login.css">

    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/components/form.css">
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/components/button.css">
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/components/input.css">

    <link rel="shortcut icon" href="<?= BASE_DIR?>/src/assets/icons/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" hr ef="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet"
    />
    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
    />

    <script src="https://kit.fontawesome.com/cacd8cf69e.js" crossorigin="anonymous"></script>
</head>
<body>
    <section>
        <aside>
            <div class="opacity"></div>
            <div class="container">
                <img src="<?= BASE_DIR?>/src/assets/images/logo.png" alt="">
                <h2>O Sistema de Gestao Que Vai <br>Revolucionar Seu Negócio</h2>
            </div>
        </aside>
        <aside>
            <div class="container">
                <img src="<?= BASE_DIR?>/src/assets/images/logo.png" alt="">
                <h3>Faça Login</h3>
                <form action="<?= BASE?>/login" method="POST">
                    <label class="wraper-100">
                        <input type="email" class="input-gray" name="email" id="email" placeholder="Email">
                    </label>

                    <label class="wraper-100 space-input">
                        <input type="password" class="input-gray" name="password" id="password" placeholder="Senha">
                    </label>

                    <label class="wraper-100">
                        <input type="checkbox" name="esqueci" id="esqueci">
                        <span>Mantenha-me Conectado</span>
                    </label>

                    <label class="wraper-button">
                        <button class="btn-blue" type="submit">Entrar</button>
                    </label>

                    <!-- <label for="" class="wraper-100">
                        <a href="">Esqueci Minha Senha</a>
                    </label> -->
                </form>
            </div>
        </aside>
    </section>

    <script type="module" src="<?= BASE_DIR?>/src/scripts/shared/login.js"></script>
</body>
</html>