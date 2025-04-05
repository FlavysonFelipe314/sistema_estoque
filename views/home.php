<head>
    <style>

        .btn-options{
            display: flex;
            height: 100%;
            align-items: center;
            justify-content: end;
        }

        .btn-options > button {
            width: 150px;
        }

        .search-container {
            padding: 10px 15px;
            display: flex;
            gap: 0 10px;
        }

        .search-container input {
            width: 150px;
            padding: 8px 12px;
            display: none;
            border-radius: 4px;
        }
        
        .search-container button {
            width: 50px;
        }

        .search-container button:nth-child(1) {
            display: none;
        }


        .no-results {
            padding: 15px;
            text-align: center;
            color: #666;
            font-style: italic;
        }

        .produto-em-uso-item {
            display: flex;
        }

        @media screen and (max-width: 500px) {
            .card-single:nth-child(1) .top-card span{
                margin: 10px 0 0 0;
                font-size: 20px !important;
            }

            .top-card span{
                font-size: 20px !important;
            }

            .btn-options {
                justify-content: center;
            }
        }

    </style>
</head>

<section class="cards">
    <div class="card card-blue">
        <h3>Clientes</h3>
        <h1><?= $countClientes?></h1>
        <img src="<?= BASE_DIR?>/src/assets/icons/users.png" alt="">
    </div>
    <div class="card card-green">
        <h3>Produtos</h3>
        <h1><?= $countProdutos?></h1>
        <img src="<?= BASE_DIR?>/src/assets/icons/Barcode.png" alt="">
    </div>
    <div class="card card-yellow">
        <h3>Faturamento Diário</h3>
        <h1><?= str_replace(".",",", $total)?></h1>
        <img src="<?= BASE_DIR?>/src/assets/icons/CurrencyCircleDollar.png" alt="">
    </div>
</section>

<section class="clients">
    <div class="content-card">
        <div class="card-single">
            <div class="top-card">
                <span>Produtos em Uso</span>
                
                <div class="btn-options">
                    <div class="search-container">
                        <button class="btn-red" id="close-search"><i class="fa-solid fa-close"></i></button>
                        <input type="text" id="search-produtos-uso" class="input-white" placeholder="Buscar cliente...">
                        <button class="btn-green" id="search-client"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                    <button class="btn-transparent" id="active-modal">Registrar</button>
                </div>
            </div>
            

            <div class="content-client" id="produtos-em-uso-container">
                <?php if(!empty($compras)){foreach($compras as $compra):?>
                    <div class="client-single produto-em-uso-item">
                        <div class="first-side">
                            <div class="profile-icon">
                                <span class="material-symbols-outlined">
                                    person
                                </span>
                            </div>
                            <div class="info-user">
                                <h3 class="cliente-nome"><?= $compra->getClienteName()?></h3>
                                <h4 class="cliente-tel"><?= $compra->getClienteTel()?></h4>
                            </div>
                        </div>

                        <div class="info-produto">
                            <h3>Produto</h3>
                            <h4><?= $compra->getProdutoName()?></h4>
                        </div>

                        <a href="<?= BASE?>/entregue/<?= $compra->getId()?>" class="buttons">
                            <button class="btn-purple">Entregue</button>
                        </a>
                    </div>
                <?php endforeach;}else{echo "Não há Registros Para Mostrar";}?>
            </div>
        </div>


                <div class="card-single">
                    <div class="top-card">
                        <span>Entradas Totais</span>
                    </div>
                    <div class="content-client">
                        <?php if(!empty($entradas)){foreach($entradas as $entrada):?>
                        <div class="client-single">
                            <div class="first-side">
                                <div class="profile-icon">
                                    <span class="material-symbols-outlined">
                                        person
                                    </span>
                                </div>
                                <div class="info-user">
                                    <h3><?= $entrada->getClienteName()?></h3>
                                    <h4><?= $entrada->getClienteTel()?></h4>
                                </div>
                                </div>
                                <div class="info-user info-tot">
                                    <h3>Total</h3>
                                    <h4>R$ <?= str_replace(".",",", $entrada->getTotal())?></h4>
                            </div>
                            <div class="buttons">
                                <button class="btn-green active-info" value="<?= $entrada->getId()?>" name="infoEntrada">Ver Mais</button>
                            </div>
                        </div>
                        <?php endforeach;}else{echo "Não há Registros Para Mostrar";}?>
                    </div>
                </div>
            </div>

            <!-- <div class="content-card">
                <div class="card-single">
                    <div class="top-card">
                        <span>Fluxo de Caixa</span>
                        <div class="dates">
                            <input type="date" name="before" id="before" class="input-transparent">
                            <input type="date" name="after" id="after" class="input-transparent">
                        </div>                            
                    </div>
                    
                    <div class="content-client chart-content">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div> -->
        </section>
    </div>
</aside>
</section>

<section class="modal" id="modal">
    <div class="container">
        <div class="modal-content">
            <div class="title-modal">
                <h1>Retirada de Produto</h1>
                <span class="material-symbols-outlined" id="close-modal">
                    cancel
                </span>
            </div>
            <form action="<?= BASE?>/addCompras" method="POST">
                <div class="wraper-100 space-input">
                    <select name="produto" class="input-gray" id="produto">
                        <option value="">Nome do Produto</option>
                        <?php foreach($produtos as $produto):?>
                            <option value="<?= $produto->getId()?>" data-totalHora ="<?= $produto->getTotalHora()?>"><?= $produto->getName()?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="wraper-100 space-input">
                    <select name="cliente" class="input-gray" id="">
                        <option value="">Nome do Cliente</option>
                        <?php foreach($clientes as $cliente):?>
                            <option value="<?= $cliente->getId()?>" ><?= $cliente->getName()?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="wraper-100 space-input">
                    <input type="number" step="any" class="input-gray" placeholder="Tempo de Uso (Horas)" name="time" id="time">
                </div>
                <input type="hidden" name="vendedor" value="<?= $user->getName()?>">
                <div class="wraper-100 space-input">
                    <select name="pagamento" class="input-gray" id="pagamento">
                        <option value="">Metodo de Pagamento</option>
                        <option value="Dinheiro">Dinheiro</option>
                        <option value="Pix">Pix</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Cartão">Cartão</option>   
                    </select>
                </div>
                <div class="wraper-100 space-input">
                    <input type="text" class="input-gray" placeholder="Total" name="total" id="total">
                </div>
                <br>
                <div class="wraper-button">
                    <button type="submit" class="btn-green">Cadastrar</button>
                </div>
            </form> 
        </div>
    </div>
</section>

<section class="modal" id="modalInfo">
    <div class="container">
        <div class="modal-content">
            <div class="title-modal">
                <h1>Detalhes da Compra</h1>
                <span class="material-symbols-outlined" id="close-info">
                    cancel
                </span>
            </div><br>

            <div class="dados">

            </div>
            
        </div>
    </div>
</section>


<script src="<?= BASE_DIR?>/src/scripts/shared/total.js"></script>
<script src="<?= BASE_DIR?>/src/scripts/api/verMais.js"></script>

<script>
    const searchInput = document.getElementById('search-produtos-uso');
    const produtosItems = document.querySelectorAll('.produto-em-uso-item');
    const searchClient = document.getElementById('search-client');
    const closeSearch = document.getElementById('close-search');

    searchClient.addEventListener('click', function() {
        searchClient.style.display = 'none';
        // activeModal.style.display = 'none';
        searchInput.style.display = 'block';
        closeSearch.style.display = 'block';
    });

    closeSearch.addEventListener('click', function() {
        searchClient.style.display = 'block';
        // activeModal.style.display = 'block';
        searchInput.style.display = 'none';
        closeSearch.style.display = 'none';
    });
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        console.log(searchTerm);
        
        produtosItems.forEach(item => {
            const clienteNome = item.querySelector('.cliente-nome').textContent.toLowerCase();
            const clienteTel = item.querySelector('.cliente-tel').textContent.toLowerCase();
            
            if (clienteNome.includes(searchTerm) || clienteTel.includes(searchTerm)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>

<!-- 
    <script>
    const ctx = document.getElementById('myChart');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3, 3],
            borderWidth: 1,
            backgroundColor: [
  'rgb(255, 99, 132)',
  'rgb(255, 159, 64)',
  'rgb(255, 205, 86)',
  'rgb(75, 192, 192)',
  'rgb(54, 162, 235)',
  'rgb(153, 102, 255)',
  'rgb(201, 203, 207)'
],
        }]
    },
      options: {
        responsive: true,
        plugins: {
        legend: {
            position: 'top',
        },
        title: {
            display: true,
        }
        }
    }
    });
    </script> -->