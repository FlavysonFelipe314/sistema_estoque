<section class="title-action">
    <h1>Editar Cliente</h1>
</section>

<form action="<?= BASE?>/cliente/edit" method="POST">
    <div class="wraper-100 space-input">
        <input type="text" class="input-white" name="name" value="<?= $cliente->getName()?>" placeholder="Nome do Cliente">
    </div>
    <div class="wraper-100 space-input">
        <input type="text" class="input-white" name="tel" value="<?= $cliente->getTel()?>" placeholder="Telefone do Cliente">
    </div>
    <input type="hidden" name="id" value="<?= $cliente->getId()?>">
    <br>
    <div class="wraper-button">
        <button type="submit" class="btn-green">Cadastrar</button>
    </div>
</form>