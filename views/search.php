<section class="title-action">
    <h1>Resultados</h1>
</section>
                

<section class="list">
    
<?php if(!empty($results)){ foreach($results as $value){?>
    <?php if($value["origem"] === "produtos"): ?>

        <div class="content-list">
            <div class="first-side">
                <div class="icon-product icon-green">
                    <span class="material-symbols-outlined">
                        inventory
                    </span>
                </div>
                <div class="text">
                    <h1><?= $value["name"]?></h1>
                    <h2>Quantidade: <?= $value["email"]?></h2>
                </div>
            </div>
            <div class="price">
                <h1>Total Hora:</h1>
                <h2>R$ <?= str_replace(".", ",", $value["resultado"])?></h2>
            </div>

            <div class="buttons">
                <a href="<?= BASE?>/produto/edit/<?= $value["id"]?>"><button class="btn-green">Editar</button></a>
                <a href="<?= BASE?>/produtos/delete/<?= $value["id"]?>"><button class="btn-red">Remover</button></a>
            </div>
        </div>

    <?php endif; ?>

    <?php if($value["origem"] === "clientes"): ?>

        <div class="content-list">
            <div class="first-side">
                <div   div class="icon-product icon-blue">
                    <span class="material-symbols-outlined">
                        groups
                    </span>
                </div>
                <div class="text">
                    <h1><?= $value["name"]?></h1>
                    <h2><?= $value["resultado"]?></h2>
                </div>
            </div>



            <div class="buttons">
                <a href="<?= BASE?>/cliente/edit/<?= $value["id"]?>"><button class="btn-green">Editar</button></a>
                <a href="<?= BASE?>/cliente/delete/<?= $value["id"]?>"><button class="btn-red">Remover</button></a>
            </div>
        </div>

    <?php endif; ?>

    <?php if($value["origem"] === "users"): ?>

        <div class="content-list">
            <div class="first-side">
                <div class="icon-product icon-purple">
                    <span class="material-symbols-outlined">
                        badge
                    </span>
                </div>
                <div class="text">
                    <h1><?= $value["name"]?></h1>
                    <h2><?= $value["resultado"]?></h2>
                </div>
            </div>
            <div class="price">
                <h1>Cargo</h1>
                <h2><?= $value["email"]?></h2>
            </div>

            <div class="buttons">
                <a href="<?= BASE?>/delete/<?= $value["id"]?>"><button class="btn-red">Remover</button></a>
            </div>
        </div>
    

    <?php endif;}}else{echo "Não há Produtos Para Mostrar";}?>

    
</section>
