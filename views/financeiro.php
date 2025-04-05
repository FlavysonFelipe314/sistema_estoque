
<section class="cards">
    <div class="card card-blue">
        <h3>Faturamento Mensal</h3>
        <h1><?= str_replace(".",",",$totalMonth)?></h1>
        <img src="<?= BASE_DIR?>/src/assets/icons/CurrencyCircleDollar.png" alt="">
    </div>
    <div class="card card-green">
        <h3>Faturamento Semanal</h3>
        <h1><?= str_replace(".",",",$totalWeek)?></h1>
        <img src="<?= BASE_DIR?>/src/assets/icons/CurrencyCircleDollar.png" alt="">
    </div>
    <div class="card card-yellow">
        <h3>Faturamento Diário</h3>
        <h1><?= str_replace(".",",",$totalDay)?></h1>
        <img src="<?= BASE_DIR?>/src/assets/icons/CurrencyCircleDollar.png" alt="">
    </div>
</section>



<section class="title-action">
    <h1>Gráficos Financeiros</h1>
</section>

<section class="charts-container">
    <div class="chart-card">
        <div class="chart-header">
            <h2>Planejamento Semanal</h2>
            <?php if($_SESSION["cargo"] === "Administrador" || $_SESSION["cargo"] === "Gerente" ): ?>
            <button class="btn-green" id="set-weekly-goals">Definir Metas</button>
            <?php endif; ?>
        </div>
        <div class="chart-body">
            <canvas id="weeklyChart"></canvas>
        </div>
    </div>
    
    <div class="chart-card">
        <div class="chart-header">
            <h2>Comparativo Mensal</h2>
        </div>
        <div class="chart-body">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
</section>

<!-- Modal for setting weekly goals -->
<section class="modal" id="modalGoals">
    <div class="container">
        <div class="modal-content">
            <div class="title-modal">
                <h1>Definir Metas Semanais</h1>
                <span class="material-symbols-outlined" id="close-goals-modal">
                    cancel
                </span>
            </div>
            <form id="weekly-goals-form">
                <input type="hidden" name="year" value="<?= $currentYear ?>">
                <input type="hidden" name="week" value="<?= $currentWeek ?>">
                
                <div class="wraper-100 space-input">
                    <input type="number" class="input-gray" name="client_goal" id="client_goal" value="<?= $weeklyGoals['client_goal'] ?>" placeholder="Meta de Clientes">
                </div>
                
                <div class="wraper-100 space-input">
                    <input type="number" step="0.01" class="input-gray" name="revenue_goal" id="revenue_goal" value="<?= $weeklyGoals['revenue_goal'] ?>" placeholder="Meta de Faturamento (R$)">
                </div>
                
                <div class="wraper-button">
                    <button type="submit" class="btn-green">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
.charts-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
}

.chart-card {
    flex: 1;
    min-width: 300px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.chart-header button {
    width: 200px;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
}

.chart-header h2 {
    font-size: 18px;
    margin: 0;
}

.chart-body {
    height: 300px;
}

@media (max-width: 1000px) {
    .charts-container {
        flex-direction: column;
    }

    .chart-card {
        width: 100%;
    }

}

@media (max-width: 500px) {
    .chart-card {
        min-width: auto;
        height: 200px !important;
    }

    .chart-header {
        flex-direction: column;
    }

    .chart-header > button {
        margin: 20px 0 0 0 ;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Weekly Chart Data
    const weeklyData = <?= json_encode($weeklyData) ?>;
    const weeklyGoals = <?= json_encode($weeklyGoals) ?>;
    
    // Format data for weekly chart
    const weekDays = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
    const clientCounts = Array(7).fill(0);
    const dailyTotals = Array(7).fill(0);
    
    weeklyData.forEach(day => {
        const date = new Date(day.date);
        const dayIndex = date.getDay() === 0 ? 6 : date.getDay() - 1; // Adjust Sunday from 0 to 6
        clientCounts[dayIndex] = parseInt(day.client_count);
        dailyTotals[dayIndex] = parseFloat(day.daily_total);
    });
    
    // Calculate weekly totals
    const totalClients = clientCounts.reduce((sum, count) => sum + count, 0);
    const totalRevenue = dailyTotals.reduce((sum, total) => sum + total, 0);
    
    // Create weekly chart
    const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
    const weeklyChart = new Chart(weeklyCtx, {
        type: 'bar',
        data: {
            labels: weekDays,
            datasets: [
                {
                    label: 'Clientes',
                    data: clientCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    yAxisID: 'y'
                },
                {
                    label: 'Faturamento (R$)',
                    data: dailyTotals,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    type: 'line',
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Número de Clientes'
                    },
                    position: 'left'
                },
                y1: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Faturamento (R$)'
                    },
                    position: 'right',
                    grid: {
                        drawOnChartArea: false
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: `Meta: ${weeklyGoals.client_goal} clientes / R$ ${weeklyGoals.revenue_goal.toFixed(2)}`,
                    padding: {
                        bottom: 10
                    }
                },
                tooltip: {
                    callbacks: {
                        footer: function(tooltipItems) {
                            const datasetIndex = tooltipItems[0].datasetIndex;
                            if (datasetIndex === 0) { // Clients dataset
                                const percentage = (totalClients > 0) 
                                    ? ((totalClients / weeklyGoals.client_goal) * 100).toFixed(1) 
                                    : 0;
                                return `Total: ${totalClients} (${percentage}% da meta)`;
                            } else { // Revenue dataset
                                const percentage = (totalRevenue > 0) 
                                    ? ((totalRevenue / weeklyGoals.revenue_goal) * 100).toFixed(1) 
                                    : 0;
                                return `Total: R$ ${totalRevenue.toFixed(2)} (${percentage}% da meta)`;
                            }
                        }
                    }
                }
            }
        }
    });
    
    // Monthly Chart Data
    const monthlyData = <?= json_encode($monthlyData) ?>;
    const currentYear = <?= $currentYear ?>;
    
    // Format data for monthly chart
    const monthNames = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 
                        'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    const monthlyClients = Array(12).fill(0);
    const monthlyRevenue = Array(12).fill(0);
    
    monthlyData.forEach(month => {
        const monthIndex = parseInt(month.month) - 1; // Month is 1-based in SQL
        monthlyClients[monthIndex] = parseInt(month.client_count);
        monthlyRevenue[monthIndex] = parseFloat(month.monthly_total);
    });
    
    // Create monthly chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: monthNames,
            datasets: [
                {
                    label: 'Clientes',
                    data: monthlyClients,
                    backgroundColor: 'rgba(153, 102, 255, 0.5)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1,
                    yAxisID: 'y'
                },
                {
                    label: 'Faturamento (R$)',
                    data: monthlyRevenue,
                    backgroundColor: 'rgba(255, 159, 64, 0.5)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1,
                    type: 'line',
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Número de Clientes'
                    },
                    position: 'left'
                },
                y1: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Faturamento (R$)'
                    },
                    position: 'right',
                    grid: {
                        drawOnChartArea: false
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: `Comparativo Mensal ${currentYear}`,
                    padding: {
                        bottom: 10
                    }
                }
            }
        }
    });
    
    const modalGoals = document.getElementById('modalGoals');
    const setWeeklyGoalsBtn = document.getElementById('set-weekly-goals');
    const closeGoalsModalBtn = document.getElementById('close-goals-modal');
    const weeklyGoalsForm = document.getElementById('weekly-goals-form');
    
    if (setWeeklyGoalsBtn) {
        setWeeklyGoalsBtn.addEventListener('click', function() {
            modalGoals.classList.add('slide-modal');
        });
    }
    
    if (closeGoalsModalBtn) {
        closeGoalsModalBtn.addEventListener('click', function() {
            modalGoals.classList.remove('slide-modal');
        });
    }
    
    if (weeklyGoalsForm) {
        weeklyGoalsForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(weeklyGoalsForm);
            
            fetch('<?= BASE ?>/compra/saveWeeklyGoals', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Metas salvas com sucesso!');
                    location.reload();
                } else {
                    alert('Erro ao salvar metas: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erro ao salvar metas. Tente novamente.');
            });
        });
    }
});
</script>

<section class="title-action">
    <h1>Historico</h1>
</section>

<section class="list">
    <?php if(!empty($compras)) { foreach($compras as $compra):?>
    <div class="content-list">
        <div class="first-side">
            <div class="icon-product icon-purple">
                <span class="material-symbols-outlined">
                    badge
                </span>
            </div>
            <div class="text">
                <h1><?= $compra->getClienteName()?></h1>
                <h2><?= $compra->getVendedor()?></h2>
            </div>
        </div>
        <div class="price">
            <h1>Produto</h1>
            <h2><?= $compra->getProdutoName()?></h2>
        </div>

        <div class="price">
            <h1>Total</h1>
            <h2>R$ <?= $compra->getTotal()?></h2>
        </div>

        <div class="buttons">
        <button class="btn-purple active-info" value="<?= $compra->getId()?>" name="infoEntrada">Ver Mais</button>
        </div>
    </div>
    <?php endforeach;} else{echo "Não há registros para mostrar.";}?>
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

<script src="<?= BASE_DIR?>/src/scripts/api/verMais.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
