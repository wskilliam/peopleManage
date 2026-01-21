<?php
// src/View/pessoa/list.php
?>
<section class="card">
  <h2>Controle de Cadastro</h2>

  <?php if (empty($pessoas)): ?>
    <p>Nenhuma pessoa cadastrada ainda.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Telefone</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($pessoas as $p): ?>
          <tr>
            <td><?= (int)$p['id'] ?></td>
            <td><?= htmlspecialchars($p['nome']) ?></td>
            <td><?= htmlspecialchars($p['email']) ?></td>
            <td><?= htmlspecialchars($p['telefone'] ?? '') ?></td>
            <td class="acoes">
              <a class="btn" href="/?action=edit&id=<?= (int)$p['id'] ?>&csrf=<?= htmlspecialchars($csrf) ?>">Editar</a>
              <form method="post" action="/?action=delete" onsubmit="return confirmarExclusao();">
                <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
                <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                <button class="btn danger" type="submit">Excluir</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</section>
