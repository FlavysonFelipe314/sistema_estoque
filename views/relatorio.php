<head>
    <link rel="stylesheet" href="<?= BASE_DIR?>/src/css/layouts/relatorios.css">
</head>

<section class="relatorios">
    <div class="relatorio rel-green">
        <div class="top-icon">
            <span class="material-symbols-outlined">badge</span>
        </div>

        <h2>Vendedor</h2>

        <form action="<?= BASE?>/relatorio" method="POST">
            <div class="wraper-50">
                <input type="date" name="initial-date" id="" class="input-transparent">
            </div>
            <div class="wraper-50">
                <input type="date" name="end-date" id="" class="input-transparent">
            </div>
            <input type="hidden" name="key" value="vendedor" class="select-m1">

            <div class="wraper-100">
                <select name="select" id="" class="input-transparent">
                    <option value="">Selecione o Funcionário</option>

                    <?php if(!empty($funcionarios)){ foreach($funcionarios as $f):?>
                        <option value="<?= $f->getName()?>"><?= $f->getName()?></option>
                        <?php endforeach;}else{echo "Não há funcionarios para mostrar";}?>
                </select>
            </div>
            <div class="wraper-button">
                <button class="btn-transparent">Gerar</button>
            </div>
        </form>
    </div>

    <div class="relatorio rel-purple">
        <div class="top-icon">
            <span class="material-symbols-outlined">groups</span>
        </div>

        <h2>Cliente</h2>

        <form action="<?= BASE?>/relatorio" method="POST">
            <div class="wraper-50">
                <input type="date" name="initial-date" id="" class="input-transparent">
            </div>
            <div class="wraper-50">
                <input type="date" name="end-date" id="" class="input-transparent">
            </div>
            <input type="hidden" name="key" value="id_cliente" class="select-m1">
            <div class="wraper-100">
                <select name="select" id="" class="input-transparent">
                    <option value="">Selecione o Cliente</option>

                    <?php if(!empty($clientes)){ foreach($clientes as $c):?>
                        <option value="<?= $c->getId()?>"><?= $c->getName()?></option>
                    <?php endforeach;}else{echo "Não há clientes para mostrar";}?>
                </select>
            </div>
            <div class="wraper-button">
                <button class="btn-transparent">Gerar</button>
            </div>
        </form>
    </div>

    <div class="relatorio rel-blue">
        <div class="top-icon">
            <span class="material-symbols-outlined">inventory</span>
        </div>

        <h2>Produto</h2>

        <form action="<?= BASE?>/relatorio" method="POST">
            <div class="wraper-50">
                <input type="date" name="initial-date" id="" class="input-transparent">
            </div>
            <div class="wraper-50">
                <input type="date" name="end-date" id="" class="input-transparent">
            </div>
            <input type="hidden" name="key" value="id_produto" class="select-m1">
            <div class="wraper-100">
                <select name="select" id="" class="input-transparent">
                    <option value="">Selecione o Produto</option>

                    <?php if(!empty($produtos)){ foreach($produtos as $p):?>
                        <option value="<?= $p->getId()?>"><?= $p->getName()?></option>
                    <?php endforeach;}else{echo "Não há produtos para mostrar";}?>
                </select>
            </div>
            <div class="wraper-button">
                <button class="btn-transparent">Gerar</button>
            </div>
        </form>
    </div>

    <div class="relatorio rel-yellow">
        <div class="top-icon">
            <span class="material-symbols-outlined">
                apps
                </span>
            </div>

        <h2>Geral</h2>

        <form action="<?= BASE?>/relatorio" method="POST">
            <div class="wraper-50">
                <input type="date" name="initial-date" id="" class="input-transparent">
            </div>
            <div class="wraper-50">
                <input type="date" name="end-date" id="" class="input-transparent">
            </div>
            <input type="hidden" name="key" value="id_cliente" class="select-m1">
            <input type="hidden" name="select" value="*" class="select-m1">
            
            <!-- <div class="wraper-100">
                <select name="" id="" class="input-transparent">
                    <option value="">Nome do Funcionario</option>
                </select>
            </div> -->
            <div class="wraper-button">
                <button class="btn-transparent">Gerar</button>
            </div>
        </form>
    </div>
</section>      