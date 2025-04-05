<section class="title-action">
    <h1>Editar Cliente</h1>
</section>

<form action="<?= BASE?>/produtos/edit" method="POST">
    <div class="wraper-100 space-input">
        <input type="text" class="input-white" name="name" value="<?= $produto->getName()?>" placeholder="Nome do Produto">
    </div>
    <div class="wraper-100 space-input">
        <input type="number" class="input-white" name="quantidade" placeholder="Quantidade em Estoque" value="<?= $produto->getQuantidade()?>">
    </div>
    <div class="wraper-100 space-input">
        <input type="number" step="any" class="input-white" name="total_hora" placeholder="Preço por Hora" value="<?= $produto->getTotalHora()?>">
    </div>
    <input type="hidden" name="id" value="<?= $produto->getId()?>">
    <br>
    <div class="wraper-button">
        <button type="submit" class="btn-green">Cadastrar</button>
    </div>
</form>