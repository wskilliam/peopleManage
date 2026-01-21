<?php
// src/View/pessoa/form.php
$isEdit = !empty($pessoa['id']);
$rota   = $isEdit ? '/?action=update' : '/?action=store';
?>
<section class="card">
  <h2><?= $isEdit ? 'Editar Cadastro' : 'Novo Cadastro' ?></h2>

  <form method="post" action="<?= $rota ?>" onsubmit="return validarFormulario();">
    <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
    <?php if ($isEdit): ?>
      <input type="hidden" name="id" value="<?= (int)$pessoa['id'] ?>">
    <?php endif; ?>

    <div class="form-group">
      <label for="nome">Nome *</label>
      <input type="text" id="nome" name="nome" required maxlength="100"
             value="<?= htmlspecialchars($pessoa['nome'] ?? '') ?>">
    </div>

    <div class="form-group">
      <label for="email">E-mail *</label>
      <input type="email" id="email" name="email" required maxlength="150"
             value="<?= htmlspecialchars($pessoa['email'] ?? '') ?>">
    </div>

    <div class="form-group">
      <label for="telefone">Telefone</label>
      <input type="tel" id="telefone" name="telefone" maxlength="30"
             value="<?= htmlspecialchars($pessoa['telefone'] ?? '') ?>"
             placeholder="(11) 99999-9999">
    </div>

    <div class="form-actions">
      <button class="btn primary" type="submit"><?= $isEdit ? 'Salvar' : 'Cadastrar' ?></button>
      <a class="btn" href="/?action=index">Voltar</a>
    </div>
  </form>
</section>
