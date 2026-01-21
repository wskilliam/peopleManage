<?php
// config/db.php
declare(strict_types=1);

/**
 * Retorna uma conexão PDO (SQLite) e garante:
 * - Criação automática do arquivo de banco e pasta /data
 * - Execução de migrações básicas (tabela + trigger)
 */
function db(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $baseDir = dirname(__DIR__);
    $dataDir = $baseDir . DIRECTORY_SEPARATOR . 'data';
    if (!is_dir($dataDir)) {
        mkdir($dataDir, 0775, true);
    }

    $dbPath = $dataDir . DIRECTORY_SEPARATOR . 'database.sqlite';
    $dsn = 'sqlite:' . $dbPath;

    try {
        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->exec('PRAGMA foreign_keys = ON;');
        $pdo->exec('PRAGMA journal_mode = WAL;');

        // Migração mínima (idempotente)
        $pdo->exec(<<<'SQL'
        CREATE TABLE IF NOT EXISTS pessoas (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          nome TEXT NOT NULL,
          email TEXT NOT NULL UNIQUE,
          telefone TEXT,
          created_at TEXT NOT NULL DEFAULT (datetime('now')),
          updated_at TEXT NOT NULL DEFAULT (datetime('now'))
        );
        SQL);

        // Trigger para manter updated_at
        $pdo->exec(<<<'SQL'
        CREATE TRIGGER IF NOT EXISTS trg_pessoas_updated_at
        AFTER UPDATE ON pessoas
        FOR EACH ROW
        BEGIN
          UPDATE pessoas SET updated_at = datetime('now') WHERE id = NEW.id;
        END;
        SQL);

        return $pdo;
    } catch (PDOException $e) {
        http_response_code(500);
        die('Erro ao inicializar SQLite: ' . htmlspecialchars($e->getMessage()));
    }
}
