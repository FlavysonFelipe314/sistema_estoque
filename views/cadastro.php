<section class="title-action">
    <h1>Cadastrar Usuário</h1>
</section>

<form action="<?= BASE?>/cadastro" method="POST">
    <label class="wraper-100 space-input">
        <input type="text" class="input-white" name="name" id="name" placeholder="name">
    </label>
    
    <label class="wraper-100 space-input">
        <input type="email" class="input-white" name="email" id="email" placeholder="Email">
    </label>

    <label class="wraper-100 space-input">
        <input type="password" class="input-white" name="password" id="password" placeholder="Senha">
    </label>

    <label class="wraper-100 space-input">
        <select name="cargo" id="cargo" class="input-white">
            <option value="">Selecione o Cargo</option>
            <option value="Administrador">Administrador</option>
            <option value="Gerente">Gerente</option>
            <option value="Funcionario">Funcionario</option>
        </select>
    </label>

    <label class="wraper-button space-input">
        <button class="btn-blue space-input" type="submit">Entrar</button>
    </label>

</form>