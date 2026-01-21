<?php
// src/Controller/PessoaController.php
declare(strict_types=1);

require_once __DIR__ . '/../Model/Pessoa.php';

final class PessoaController
{
    public static function index(): void {
        $pessoas = Pessoa::all();
        self::render('pessoa/list.php', ['pessoas' => $pessoas, 'title' => 'Controle de Cadastro']);
    }

    public static function create(): void {
        self::ensureCsrf();
        self::render('pessoa/form.php', [
            'title' => 'Novo Cadastro',
            'pessoa' => ['id' => null, 'nome' => '', 'email' => '', 'telefone' => ''],
            'action' => 'store'
        ]);
    }

    public static function store(): void {
        self::checkCsrf();
        [$nome, $email, $telefone] = self::validateInputs();

        try {
            Pessoa::create($nome, $email, $telefone);
            self::redirectWithMessage('Pessoa cadastrada com sucesso!');
        } catch (Throwable $e) {
            self::redirectWithMessage('Erro ao cadastrar: ' . $e->getMessage(), 'error');
        }
    }

    public static function edit(): void {
        self::ensureCsrf();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $pessoa = Pessoa::find($id);
        if (!$pessoa) {
            self::redirectWithMessage('Registro não encontrado.', 'error');
            return;
        }
        self::render('pessoa/form.php', [
            'title' => 'Editar Cadastro',
            'pessoa' => $pessoa,
            'action' => 'update'
        ]);
    }

    public static function update(): void {
        self::checkCsrf();
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        [$nome, $email, $telefone] = self::validateInputs();

        try {
            if (!Pessoa::find($id)) {
                self::redirectWithMessage('Registro não encontrado.', 'error');
                return;
            }
            Pessoa::update($id, $nome, $email, $telefone);
            self::redirectWithMessage('Pessoa atualizada com sucesso!');
        } catch (Throwable $e) {
            self::redirectWithMessage('Erro ao atualizar: ' . $e->getMessage(), 'error');
        }
    }

    public static function delete(): void {
        self::checkCsrf();
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        try {
            Pessoa::delete($id);
            self::redirectWithMessage('Pessoa excluída com sucesso!');
        } catch (Throwable $e) {
            self::redirectWithMessage('Erro ao excluir: ' . $e->getMessage(), 'error');
        }
    }

    // ---------- Helpers ----------
    private static function render(string $view, array $data = []): void {
        extract($data);
        $csrf = self::ensureCsrf();
        $viewFile = __DIR__ . '/../View/' . $view;
        $layoutFile = __DIR__ . '/../View/layout.php';
        if (!file_exists($viewFile)) {
            http_response_code(500);
            die('View não encontrada: ' . htmlspecialchars($view));
        }
        ob_start();
        include $viewFile;
        $content = ob_get_clean();
        include $layoutFile;
    }

    private static function redirectWithMessage(string $msg, string $type = 'success'): void {
        $_SESSION['flash'] = ['message' => $msg, 'type' => $type];
        header('Location: /?action=index');
        exit;
    }

    private static function validateInputs(): array {
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');

        if ($nome === '' || $email === '') {
            self::redirectWithMessage('Nome e e-mail são obrigatórios.', 'error');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::redirectWithMessage('E-mail inválido.', 'error');
        }
        return [$nome, $email, $telefone !== '' ? $telefone : null];
    }

    private static function ensureCsrf(): string {
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(16));
        }
        return $_SESSION['csrf'];
    }

    private static function checkCsrf(): void {
        $token = $_POST['csrf'] ?? $_GET['csrf'] ?? '';
        if (!isset($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], (string)$token)) {
            http_response_code(400);
            die('CSRF inválido.');
        }
    }
}
