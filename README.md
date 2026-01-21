

# Controle de Cadastro — PHP

Este projeto é um Controle de Cadastro (nome, e-mail, telefone) usando **PHP + SQLite + HTML/CSS/JS**.
Organização estilo MVC, com **PDO**, **CSRF**, **validação** e **views** simples.

## Como rodar

1. Certifique-se de ter o PHP instalado (>= 7.4).
2. Crie a pasta de dados (caso não exista):
   ```bash

   Linux:

   mkdir -p data
   chmod 775 data
   ```
3. Suba o servidor embutido do PHP (a partir da raiz do projeto):
   ```bash
   php -S localhost:8000 -t public
   ```
4. Acesse: http://localhost:8000

Na primeira execução, o app criará automaticamente o arquivo `data/database.sqlite`, a tabela `pessoas` e a trigger de `updated_at`.

## Estrutura

```
crud-pessoas-php-sqlite/
├─ config/db.php
├─ data/
├─ public/
│  ├─ index.php
│  ├─ css/styles.css
│  └─ js/app.js
├─ src/
│  ├─ Controller/PessoaController.php
│  ├─ Model/Pessoa.php
│  └─ View/
│     ├─ layout.php
│     └─ pessoa/
│        ├─ list.php
│        └─ form.php
└─ sql/schema.sql (referência)
```

## Observações
- CSRF incluído em todas as operações de alteração.
- Saída protegida com `htmlspecialchars`.
- SQL portátil para facilitar migrações.
- Para inspecionar o banco: `sqlite3 data/database.sqlite`.

## Contribuindo

Contribuições são sempre bem-vindas!

Veja `contribuindo.md` para saber como começar.

Por favor, siga o `código de conduta` desse projeto.

