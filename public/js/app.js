function validarEmail(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(String(email).toLowerCase());
}

function validarFormulario() {
  const nome = document.getElementById('nome').value.trim();
  const email = document.getElementById('email').value.trim();

  if (!nome || !email) {
    alert('Nome e e-mail são obrigatórios.');
    return false;
  }
  if (!validarEmail(email)) {
    alert('E-mail inválido.');
    return false;
  }
  return true;
}

function confirmarExclusao() {
  return confirm('Tem certeza que deseja excluir este registro?');
}
