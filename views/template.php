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

    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/layouts/produtos.css">
    
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/components/button.css">
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/components/input.css">
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/components/card.css">
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/components/header.css">
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/components/menu-option.css">
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/components/menu-content.css">
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/components/cardClient.css">
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/components/search.css">
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/components/chart.css">
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/components/list.css">
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/components/pagination.css">
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/components/modal.css">
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/components/form.css">
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/components/profile.css">


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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <section>
        <aside id="menu-content">
            <div class="container">
                <div id="close-trigger" class="close-trigger">
                    <i class="fa-solid fa-xmark"></i>
                </div>

                <img src="<?= BASE_DIR?>/src/assets/images/logo.png" alt="">

                <h2>Sistema de Gestão</h2>

                <form action="<?= BASE?>/search" method="GET"  class="search">
                    <input type="search" class="input-white" name="search" class="search" placeholder="Pesquisar">
                    <button class="btn-green"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>

                <nav>
                    <a href="<?= BASE?>/home" class="menu-option">
                        <span class="material-symbols-outlined">home</span>
                        Inicio
                    </a>
                    <a href="<?= BASE?>/produtos" class="menu-option">
                        <span class="material-symbols-outlined">inventory</span>
                        Produtos
                    </a>
                    <!-- <a href="<?= BASE?>/funcionarios" class="menu-option">
                        <span class="material-symbols-outlined">badge</span>
                        Funcionários
                    </a> -->
                    <a href="<?= BASE?>/clientes" class="menu-option">
                        <span class="material-symbols-outlined">groups</span>
                        Clientes
                    </a>
                    <?php if($_SESSION["cargo"] === "Administrador" || $_SESSION["cargo"] === "Gerente" ): ?>
                    <a href="<?= BASE?>/relatorio" class="menu-option">
                        <span class="material-symbols-outlined">description</span>
                        Relatórios
                    </a>
                    <?php endif;?>

                    
                    <?php if($_SESSION["cargo"] === "Administrador"|| $_SESSION["cargo"] === "Gerente" ):  ?>
                        <a href="<?= BASE?>/financeiro" class="menu-option">
                            <span class="material-symbols-outlined">paid</span>
                            Financeiro
                        </a>
                    <?php endif;?>
                </nav>
            </div>
        </aside>
        <aside id="system-content">
            <div class="container">
                <header>
                    <div id="menu-trigger" class="menu-trigger">
                        <i class="fa-solid fa-bars"></i>
                    </div>

                <form action="<?= BASE?>/search" method="GET"  class="search">
                    <input type="search" class="input-white" name="search" class="search" placeholder="Pesquisar">
                    <button class="btn-green"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>

                    <div class="profile" id="profile-trigger">
                        <i class="fa-regular fa-user"></i>
                    </div>
                </header>

                <?php 
                    $this->loadViewTemplate($viewName, $viewData);
                    $this->getFlashMessage();
                ?>

            </div>
        </aside>
    </section>

    <section class="profile-content">
        <div class="container">
            <div class="close-profile">
                <span class="material-symbols-outlined" id="close-profile">
                    cancel
                </span>
            </div>
            
            <div class="user-info">
                <div class="profile">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div class="text">
                    <h1><?= $_SESSION["name"]?></h1>
                    <h2><?= $_SESSION["cargo"]?></h2>
                </div>
            </div>

            <div class="options-profile">
                <!-- <a href="perfil.html" class="option">
                    <span class="material-symbols-outlined">
                        account_circle
                    </span>
                    <span>Meu Perfil</span>
                </a> -->
                <?php if($_SESSION["cargo"] === "Administrador" || $_SESSION["cargo"] === "Gerente" ): ?>

                <a href="<?= BASE?>/cadastro" class="option">
                    <span class="material-symbols-outlined">
                        person_add
                    </span>
                    <span>Adicionar Usuário</span>
                </a>
                <a href="<?= BASE?>/listar" class="option">
                    <span class="material-symbols-outlined">
                        contacts
                    </span>
                    <span>Listar Usuários</span>
                </a>
                <?php endif;?>
                <a href="<?= BASE?>/logout" class="option">
                    <span class="material-symbols-outlined">
                        logout
                    </span>
                    <span>Sair</span>
                </a>
            </div>

        </div>
    </section>

    <script src="<?= BASE_DIR?>/src/scripts/shared/menu.js"></script>
    <script src="<?= BASE_DIR?>/src/scripts/shared/modal.js"></script>
    <script src="<?= BASE_DIR?>/src/scripts/shared/profile.js"></script>
</body>
</html>