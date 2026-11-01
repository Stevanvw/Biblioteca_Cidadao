 <div class="ficha ficha-login">
      <span class="site-brand">Bem-vindo!<span></span></span>
      <p class="site-tagline">Sistema interno de gestão da Biblioteca Cidadão exclusivo para funcionários</p>

      <p class="aviso-dev">
        Dúvidas sobre suas informações de login? entre em contato com:
        secretariaEstadualDoParana@gov.edu.br
      </p>

      <h1 class="page-title page-title--centro">Entrar</h1>

      <form method="POST" action="<?= e(url('/login')) ?>">
        <div class="campo">
          <label for="login-email">E-mail <span class="obrigatorio">*</span></label>
          <input type="email" id="login-email" name="email" value="<?= e(antigo('email')) ?>" required autocomplete="username" />
        </div>

        <div class="campo">
          <label for="login-senha">Senha <span class="obrigatorio">*</span></label>
          <input type="password" id="login-senha" name="senha" required autocomplete="current-password" />
        </div>

        <button type="submit" class="botao botao--primario botao--cheio">Entrar</button>
      </form>
    </div>
