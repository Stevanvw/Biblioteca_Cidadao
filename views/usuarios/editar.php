<h1 class="page-title">Editar usuário</h1>

<div class="ficha">
    <div class="ficha__cabecalho">
        <div><strong>Alterar informações do usuário</strong></div>
        <span class="ficha__codigo">edição #<?= e($usuario->getId()) ?></span>
    </div>

    <form method="POST" action="<?= e(url('/usuarios/editar?id=' . $usuario->getId())) ?>">
        <div class="campo">
            <label for="usuario-nome">Nome <span class="obrigatorio">*</span></label>
            <input
                type="text"
                id="usuario-nome"
                name="nome"
                value="<?= e(antigo('nome', $usuario->getNome())) ?>"
                minlength="3"
                maxlength="150"
                required />
        </div>

        <div class="campo">
            <label for="usuario-email">E-mail <span class="obrigatorio">*</span></label>
            <input
                type="email"
                id="usuario-email"
                name="email"
                value="<?= e(antigo('email', $usuario->getEmail())) ?>"
                maxlength="150"
                required />
        </div>

        <div class="campo">
            <label for="usuario-senha">Nova senha</label>
            <input
                type="password"
                id="usuario-senha"
                name="senha"
                minlength="8"
                autocomplete="new-password" />
            <small>Deixe em branco para manter a senha atual. Se desejar alterar, informe pelo menos 8 caracteres.</small>
        </div>

        <div class="acoes-ficha">
            <button type="submit" class="botao botao--primario">Salvar alterações</button>
            <a href="<?= e(url('/usuarios')) ?>" class="botao botao--secundario">Cancelar</a>
        </div>
    </form>
</div>