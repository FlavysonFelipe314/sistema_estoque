<section class="title-action">
    <h1>Clientes</h1>

    <button class="btn-blue" id="active-modal">Cadastrar</button>
</section>
                

<?php if(!empty($clientes)){?>
    <section class="list">
        <?php foreach($clientes as $cliente):?>
        <div class="content-list">
            <div class="first-side">
                <div   div class="icon-product icon-blue">
                    <span class="material-symbols-outlined">
                        groups
                    </span>
                </div>
                <div class="text">
                    <h1><?= $cliente->getName()?></h1>
                    <h2><?= $cliente->getTel()?></h2>
                </div>
            </div>
            <div class="price">
                <h1>visitas</h1>
                <h2><?= $cliente->visitas?></h2>
            </div>


            <div class="buttons">
                <a href="<?= BASE?>/cliente/edit/<?= $cliente->getId()?>"><button class="btn-green">Editar</button></a>
                <a href="<?= BASE?>/cliente/delete/<?= $cliente->getId()?>"><button class="btn-red">Remover</button></a>
            </div>
        </div>
        <?php endforeach;?>
    </section>

    <section class="pagination">
        <?php for($i=0; $i < $pages; $i++):?>
            <a href="<?= BASE?>/clientes?page=<?=$i+1?>" class="page"><?= $i+1?></a>
        <?php endfor;?>
    </section>

<?php }else{echo "Não há Produtos Para Mostrar";}?>

<section class="modal" id="modal">
    <div class="container">
        <div class="modal-content">
            <div class="title-modal">
                <h1>Cadastrar Cliente</h1>
                <span class="material-symbols-outlined" id="close-modal">
                    cancel
                </span>
            </div>
            <form action="<?= BASE?>/addClientes" method="POST">
                <div class="wraper-100 space-input">
                    <input type="text" class="input-gray" name="name" placeholder="Nome do Cliente">
                </div>
                <div class="wraper-100 space-input">
                    <input type="text" class="input-gray" name="tel" placeholder="Telefone do Cliente">
                </div>
                <br>
                <div class="wraper-button">
                    <button type="submit" class="btn-green">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</section>
