    <h1 class="page-title">Cadastro de usuários</h1>

    <div class="ficha">
      <div class="ficha__cabecalho">
        <div><strong>Informações para o cadastro do usuário</strong></div>
        <span class="ficha__codigo">novo cadastro</span>
      </div>

      <form method="POST" action="<?= e(url('/usuarios')) ?>">
        <div class="campo">
          <label for="usuario-nome">Nome <span class="obrigatorio">*</span></label>
          <input type="text" id="usuario-nome" name="nome" value="<?= e(antigo('nome')) ?>" required />
        </div>

        <div class="campo">
          <label for="usuario-email">E-mail <span class="obrigatorio">*</span></label>
          <input type="email" id="usuario-email" name="email" value="<?= e(antigo('email')) ?>" required />
        </div>

        <div class="campo">
          <label for="usuario-senha">Senha <span class="obrigatorio">*</span></label>
          <input type="password" id="usuario-senha" name="senha" required autocomplete="new-password" />
        </div>

        <div class="acoes-ficha">
          <button type="submit" class="botao botao--primario">Cadastrar</button>
          <a href="<?= e(url('/usuarios')) ?>" class="botao botao--secundario">Limpar</a>
        </div>
      </form>
    </div>

    <div class="tabela-wrapper">
      <table>
        <thead>
          <tr>
            <th scope="col">Nome</th>
            <th scope="col">E-mail</th>
            <th scope="col">Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($usuarios)): ?>
            <tr>
              <td colspan="3">Nenhum usuário cadastrado.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($usuarios as $usuario): ?>
              <tr>
                <td><?= e($usuario->getNome()) ?></td>
                <td><?= e($usuario->getEmail()) ?></td>
                <td>
                  <a
                    href="<?= e(url('/usuarios/editar?id=' . $usuario->getId())) ?>"
                    class="botao botao--secundario">
                    Editar
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>