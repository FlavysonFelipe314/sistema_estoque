<section class="title-action">
    <h1>Usuários</h1>
</section>

<?php if(!empty($usuarios)){?>
    <section class="list">
        <?php foreach($usuarios as $usuario):?>
        <div class="content-list">
            <div class="first-side">
                <div class="icon-product icon-purple">
                    <span class="material-symbols-outlined">
                        badge
                    </span>
                </div>
                <div class="text">
                    <h1><?= $usuario->getName()?></h1>
                    <h2><?= $usuario->getEmail()?></h2>
                </div>
            </div>
            <div class="price">
                <h1>Cargo</h1>
                <h2><?= $usuario->getCargo()?></h2>
            </div>

            <div class="buttons">
                <a href="<?= BASE?>/delete/<?= $usuario->getId()?>"><button class="btn-red">Remover</button></a>
            </div>
        </div>
        <?php endforeach;?>
    </section>

    <section class="pagination">
        <?php for($i=0; $i < $pages; $i++):?>
            <a href="<?= BASE?>/usuarios?page=<?=$i+1?>" class="page"><?= $i+1?></a>
        <?php endfor;?>
    </section>

<?php }else{echo "Não há Resultados Para Mostrar";}?>
