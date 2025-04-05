<section class="title-action">
    <h1>Funcionarios</h1>
    <button class="btn-purple" id="active-modal">Cadastrar</button>
</section>


<?php if(!empty($funcionarios)){?>
    <section class="list">
        <?php foreach($funcionarios as $funcionario):?>
        <div class="content-list">
            <div class="first-side">
                <div class="icon-product icon-purple">
                    <span class="material-symbols-outlined">
                        badge
                    </span>
                </div>
                <div class="text">
                    <h1><?= $funcionario->getName()?></h1>
                    <h2><?= $funcionario->getCpf()?></h2>
                </div>
            </div>
            <div class="price">
                <h1>Vendas</h1>
                <h2>---</h2>
            </div>

            <div class="buttons">
                <button class="btn-green">Editar</button>
                <a href="<?= BASE?>/funcionarios/delete/<?= $funcionario->getId()?>"><button class="btn-red">Remover</button></a>
            </div>
        </div>
        <?php endforeach;?>
    </section>

    <section class="pagination">
        <?php for($i=0; $i < $pages; $i++):?>
            <a href="<?= BASE?>/funcionarios?page=<?=$i+1?>" class="page"><?= $i+1?></a>
        <?php endfor;?>
    </section>

<?php }else{echo "Não há Produtos Para Mostrar";}?>

<section class="modal">
    <div class="container">
        <div class="modal-content">
            <div class="title-modal">
                <h1>Cadastrar Funcionario</h1>
                <span class="material-symbols-outlined" id="close-modal">
                    cancel
                </span>
            </div>
            <form action="<?= BASE?>/addFuncionarios" method="POST">
                <div class="wraper-100 space-input">
                    <input type="text" class="input-gray" name="name" placeholder="Nome do Funcionário">
                </div>
                <div class="wraper-100 space-input">
                    <input type="text" class="input-gray" name="cpf" placeholder="CPF do Funcionário">
                </div>
                <br>
                <div class="wraper-button">
                    <button type="submit" class="btn-green">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</section>
