<?php

namespace App\controllers;

use App\core\Controller;
use App\services\AuthService;
use App\services\ClienteService;
use App\services\CompraService;
use App\services\ProdutoService;
use App\services\UserService;
use Exception;
use Mpdf\Mpdf;

class CompraController extends Controller{

    private $userInfo;
    private $CompraService;

    public function __construct()
    {
        $AuthService = new AuthService;
        $this->userInfo = $AuthService->checkToken();

        $this->CompraService = new CompraService;
        
    }

    public function cadastro(){
        
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $produto = filter_input(INPUT_POST, "produto");
            $vendedor = filter_input(INPUT_POST, "vendedor");
            $cliente = filter_input(INPUT_POST, "cliente");
            $tempo = filter_input(INPUT_POST, "time");
            $total = filter_input(INPUT_POST, "total");
            $pagamento = filter_input(INPUT_POST, "pagamento");

            try{
                $this->CompraService->create($vendedor, $produto, $cliente, $tempo, $total, $pagamento);
                header("Location: ".BASE."/");

            } catch(Exception $err){
                echo "Algo deu Errado: $err";
            }

        }
        
    }

    public function entregue($id){
        
        $compra = $this->CompraService->findBy("id", $id);

        $compra->setSituacao(1);

        try {
            $this->CompraService->update($compra);
            header("Location: ".BASE."/");
        } catch (Exception $err) {
            echo "Algo deu Errado: $err";
        }
    }



    public function relatorio(){

        $UserService = new UserService;
        $funcionarios = $UserService->findAll();

        $ClienteService = new ClienteService;
        $clientes = $ClienteService->findAll();

        $ProdutoService = new ProdutoService;
        $produtos = $ProdutoService->findAll();

        $data = [
            'user' => $this->userInfo,
            'funcionarios' => $funcionarios,
            'clientes' => $clientes,
            'produtos' => $produtos,
        ];

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $initial = filter_input(INPUT_POST, "initial-date");
            $end = filter_input(INPUT_POST, "end-date");
            $value = filter_input(INPUT_POST, "select");
            $key = filter_input(INPUT_POST, "key");

            $CompraService = new CompraService;
            $relatorio = $CompraService->relatorios($key, $value, $initial, $end);
            // var_dump($relatorio);
            // exit;
            ob_start();
            ?>
            <!DOCTYPE html>
                <html lang="pt-br">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Document</title>

                    <style>
                        *{
                            box-sizing: border-box;
                            margin: 0;
                            padding: 0;
                        }

                        body{
                            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
                        }

                        .logo{
                            width: 100%;
                            text-align: center;
                            margin: 0 0 10px 0;
                        }

                        img{
                            width: 170px;
                        }
                        
                        table{
                            width: 100%;
                        }

                        th{
                            background-color: #ddd;
                            font-size: 14px ;
                            padding: 10px;
                            color: #333;
                        }

                        td{
                            border-bottom: 1px solid #ccc;
                            font-size: 12px;
                            font-weight: 500;
                            padding: 10px;
                        }

                        h2{
                            font-size: 18px;
                            font-weight: 600;
                        }

                        h3{
                            font-size: 16px;
                            font-weight: 600;
                            color: #666;
                        }

                    </style>
                </head>
                <body>
                    <div class="logo">
                    <img src="<?= BASE?>/Public/src/assets/images/logo.png" alt="">
                        <h2>ORLA CLUB</h2>
                        <h3>RELATÓRIO COMPLETO</h3>
                    </div>

                        <table style="text-align:center;">
                            <thead>
                                <tr>
                                    <th>vendedor</th>
                                    <th>produto</th>
                                    <th>cliente</th>
                                    <th>tempo</th>
                                    <th>total</th>
                                    <th>pagamento</th>
                                    <th>telefone</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach($relatorio as $item):?>
                                <tr>
                                    <td><?= $item->getVendedor()?></td>
                                    <td><?= $item->getProdutoName()?></td>
                                    <td><?= $item->getClienteName()?></td>
                                    <td><?= $item->getHoraCompra()?></td>
                                    <td><?= $item->getTotal()?></td>
                                    <td><?= $item->getPagamento()?></td>
                                    <td><?= $item->getClienteTel()?></td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                </body>
                </html>
                <?php

            $html = ob_get_contents();
            ob_end_clean();

            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4-L',
                'orientation' => 'L',
            ]);
            $mpdf->WriteHTML($html);
            $name = "relatorio_" . time() . ".pdf";
            $caminhoPDF = __DIR__ . "/../../Public/tmp/$name";
            $mpdf->Output($caminhoPDF, 'F');

            header("Location: ".BASE."/Public/tmp/$name");
            
        }
        
        $this->loadTemplate("relatorio", $data);
    }

    public function financeiro(){
        $init_day = date('Y-m-d');
        $final_day = date('Y-m-d');
    
        $init_week = date('Y-m-d', strtotime('monday this week'));
        $final_week = date('Y-m-d', strtotime('sunday this week'));
    
        $init_month = date('Y-m-01');
        $final_month = date('Y-m-t');
    
        $totalDay = $this->CompraService->total($init_day, $final_day);
        $totalDay = (!empty($totalDay['total_soma'])) ? $totalDay['total_soma'] : 0;
    
        $totalWeek = $this->CompraService->total($init_week, $final_week);
        $totalWeek = (!empty($totalWeek['total_soma'])) ? $totalWeek['total_soma'] : 0;
    
        $totalMonth = $this->CompraService->total($init_month, $final_month);
        $totalMonth = (!empty($totalMonth['total_soma'])) ? $totalMonth['total_soma'] : 0;
    
        $compras = $this->CompraService->findAllBy("situacao", 1);
        
        // Get current year and week
        $currentYear = date('Y');
        $currentWeek = date('W');
        
        // Get weekly data for chart
        $weeklyData = $this->CompraService->getWeeklyData($currentYear, $currentWeek);
        
        // Get weekly goals
        $weeklyGoals = $this->CompraService->getWeeklyGoals($currentYear, $currentWeek);
        
        // Get monthly data for chart
        $monthlyData = $this->CompraService->getMonthlyData($currentYear);
        
        $data = [
            'user' => $this->userInfo,
            'totalDay' => $totalDay,
            'totalWeek' => $totalWeek,
            'totalMonth' => $totalMonth,
            'compras' => $compras,
            'weeklyData' => $weeklyData,
            'weeklyGoals' => $weeklyGoals,
            'monthlyData' => $monthlyData,
            'currentYear' => $currentYear,
            'currentWeek' => $currentWeek
        ];
    
        $this->loadTemplate("financeiro", $data);
    }
    
    public function saveWeeklyGoals() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $year = filter_input(INPUT_POST, "year", FILTER_VALIDATE_INT);
            $week = filter_input(INPUT_POST, "week", FILTER_VALIDATE_INT);
            $clientGoal = filter_input(INPUT_POST, "client_goal", FILTER_VALIDATE_FLOAT);
            $revenueGoal = filter_input(INPUT_POST, "revenue_goal", FILTER_VALIDATE_FLOAT);
            
            if ($year && $week && $clientGoal !== false && $revenueGoal !== false) {
                $result = $this->CompraService->saveWeeklyGoals($year, $week, $clientGoal, $revenueGoal);
                
                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to save goals']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
            }
            exit;
        }
    }
    

    public function getCompra($id){
        header("Content-Type: application/json");
        
        try{
            $compras = $this->CompraService->findAllBy("id", $id);

            $data = [
                "vendedor" => $compras[0]->getVendedor(),
                "cliente" => $compras[0]->getClienteName(),
                "produto" => $compras[0]->getProdutoName(),
                "total" => $compras[0]->getTotal(),
                "tempo" => $compras[0]->getHoraCompra(),
                "telefone" => $compras[0]->getClienteTel(),
                "pagamento" => $compras[0]->getPagamento(),
            ];
        } catch(Exception $err){
            $data = [
                "status" => "error",
                "message" => $err,
                "data" => []
            ];
        }

        echo json_encode($data);
    }

}

?>