<?php
// public/index.php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/../src/Controller/PessoaController.php';

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        PessoaController::index();
        break;
    case 'create':
        PessoaController::create();
        break;
    case 'store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            PessoaController::store();
        } else {
            header('Location: /?action=index');
        }
        break;
    case 'edit':
        PessoaController::edit();
        break;
    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            PessoaController::update();
        } else {
            header('Location: /?action=index');
        }
        break;
    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            PessoaController::delete();
        } else {
            header('Location: /?action=index');
        }
        break;

    case 'sobre':
        // render simples da página Sobre reutilizando o layout
        (function(){
            require_once __DIR__ . '/../src/Controller/PessoaController.php';
            // Usar o helper de render do controller para manter o layout e CSRF
            $ref = new ReflectionClass('PessoaController');
            $method = $ref->getMethod('index'); // para acessar privados via closure não é 
            // simples; então duplicamos a lógica mínima
        })();
        // Fallback: render manual mínimo
        $title = 'Sobre';
        // Garante sessão/CSRF
        if (empty($_SESSION['csrf'])) { $_SESSION['csrf'] = bin2hex(random_bytes(16)); }
        $csrf = $_SESSION['csrf'];
        ob_start();
        include __DIR__ . '/../src/View/sobre.php';
        $content = ob_get_clean();
        include __DIR__ . '/../src/View/layout.php';
        break;
        default:
        http_response_code(404);
        echo 'Rota inválida.';
}
