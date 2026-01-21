<?php
// src/View/layout.php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= isset($title) ? htmlspecialchars($title) . ' — ' : '' ?>Controle de Cadastro</title>
  <link rel="stylesheet" href="/css/styles.css" />
  <link rel="icon" href="https://img.icons8.com/ios-filled/100/process.png" type="image/png"/>
</head>
<body>
  <header>
    <h1><img class="logo" src="https://www.gov.br/mds/pt-br/canais_atendimento/disque-social-121/imagens/icone-registro.png/@@images/4a88ca31-08a8-44a1-af34-d07c4cbacde4.png" alt="ícone" /> Controle de Cadastro</h1>
    <nav>
      <a href="/?action=index">Listar</a>
      <a href="/?action=create&csrf=<?= htmlspecialchars($csrf) ?>">Cadastrar</a>
          <a href="/?action=sobre">Sobre</a>
    </nav>
  </header>

  <main>
    <?php if (!empty($_SESSION['flash'])): ?>
      <div class="flash <?= htmlspecialchars($_SESSION['flash']['type']) ?>">
        <?= htmlspecialchars($_SESSION['flash']['message']) ?>
      </div>
      <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <?= $content ?>
  </main>

  <footer>
    <small>William Rodrigues — Desenvolvedor © 2026</small>
  </footer>

  <script src="/js/app.js"></script>
</body>
</html>
