<?php
// src/Model/Pessoa.php
declare(strict_types=1);

require_once __DIR__ . '/../../config/db.php';

final class Pessoa
{
    public static function all(): array {
        $stmt = db()->query('SELECT * FROM pessoas ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array {
        $stmt = db()->prepare('SELECT * FROM pessoas WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(string $nome, string $email, ?string $telefone): int {
        $stmt = db()->prepare('INSERT INTO pessoas (nome, email, telefone) VALUES (?, ?, ?)');
        $stmt->execute([$nome, $email, $telefone]);
        return (int)db()->lastInsertId();
    }

    public static function update(int $id, string $nome, string $email, ?string $telefone): bool {
        $stmt = db()->prepare('UPDATE pessoas SET nome = ?, email = ?, telefone = ? WHERE id = ?');
        return $stmt->execute([$nome, $email, $telefone, $id]);
    }

    public static function delete(int $id): bool {
        $stmt = db()->prepare('DELETE FROM pessoas WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
