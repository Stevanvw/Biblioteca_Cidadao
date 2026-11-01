    <h1 class="page-title">Painel</h1>

    <section class="card-grid">
      <article class="info-card">
        <h2>Livros</h2>
        <p>Título, autor, categoria, editora e ISBN.</p>
        <a href="<?= e(url('/livros')) ?>">Ir para o cadastro de livros</a>
      </article>

      <article class="info-card">
        <h2>Usuários</h2>
        <p>Nome, e-mail e senha para um novo usuário que irá utilizar o sistema.</p>
        <a href="<?= e(url('/usuarios')) ?>">Ir para o cadastro de usuários</a>
      </article>

      <article class="info-card">
        <h2>Empréstimos</h2>
        <p>Datas de empréstimo e devolução.</p>
        <a href="<?= e(url('/emprestimos')) ?>">Ir para o registro de empréstimos</a>
      </article>
    </section>
