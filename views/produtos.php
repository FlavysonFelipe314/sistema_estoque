<section class="title-action">
    <h1>Produtos</h1>
    <?php if($_SESSION["cargo"] === "Administrador" || $_SESSION["cargo"] === "Gerente" ): ?>
    <button class="btn-green" id="active-modal">Cadastrar</button>
    <?php endif;?>

</section>

<?php if(!empty($produtos)){?>
    <section class="list">
        <?php foreach($produtos as $produto):?>
            <div class="content-list">
                <div class="first-side">
                    <div class="icon-product icon-green">
                        <span class="material-symbols-outlined">
                            inventory
                        </span>
                    </div>
                    <div class="text">
                        <h1><?= $produto->getName()?></h1>
                        <h2>Quantidade: <?= $produto->getQuantidade()?></h2>
                    </div>
                </div>
                <div class="price">
                    <h1>Total Hora:</h1>
                    <h2>R$ <?= str_replace(".", ",", $produto->getTotalHora())?></h2>
                </div>

                <div class="buttons">
                    <a href="<?= BASE?>/produto/edit/<?= $produto->getId()?>"><button class="btn-green">Editar</button></a>
                    <a href="<?= BASE?>/produtos/delete/<?= $produto->getId()?>"><button class="btn-red">Remover</button></a>
                    </div>
            </div>
        <?php endforeach;?>
    </section>

    <section class="pagination">
        <?php for($i=0; $i < $pages; $i++):?>
            <a href="<?= BASE?>/produtos?page=<?=$i+1?>" class="page"><?= $i+1?></a>
        <?php endfor;?>
    </section>

<?php }else{echo "Não há Produtos Para Mostrar";}?>

<section class="modal"  id="modal">
    <div class="container">
        <div class="modal-content">
            <div class="title-modal">
                <h1>Cadastro de Produto</h1>
                <span class="material-symbols-outlined" id="close-modal">
                    cancel
                </span>
            </div>
            <form action="<?= BASE?>/addProdutos" method="POST">
                <div class="wraper-100 space-input">
                    <input type="text" class="input-gray" name="name" placeholder="Nome do Produto">
                </div>
                <div class="wraper-100 space-input">
                    <input type="number" class="input-gray" name="quantidade" placeholder="Quantidade em Estoque">
                </div>
                <div class="wraper-100 space-input">
                    <input type="number" step="any" class="input-gray" name="total_hora" placeholder="Preço por Hora">
                </div>
                <br>
                <div class="wraper-button">
                    <button type="submit" class="btn-green">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</section>