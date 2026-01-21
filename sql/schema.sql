-- SQLite schema (referência)
PRAGMA foreign_keys = ON;

CREATE TABLE IF NOT EXISTS pessoas (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  nome TEXT NOT NULL,
  email TEXT NOT NULL UNIQUE,
  telefone TEXT,
  created_at TEXT NOT NULL DEFAULT (datetime('now')),
  updated_at TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TRIGGER IF NOT EXISTS trg_pessoas_updated_at
AFTER UPDATE ON pessoas
FOR EACH ROW
BEGIN
  UPDATE pessoas SET updated_at = datetime('now') WHERE id = NEW.id;
END;
