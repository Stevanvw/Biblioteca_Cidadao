<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= e($titulo) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&family=PT+Serif:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>" />
</head>
<body<?= $semMenu ? ' class="pagina-login"' : '' ?>>

<?php if (!$semMenu): ?>
  <header class="site-header">
    <div class="site-header__identity">
      <a href="<?= e(url('/')) ?>">
        <span class="site-brand">Biblioteca Cidadão<span></span></span>
        <p class="site-tagline">Sistema interno de gestão da biblioteca</p>
      </a>
      <button class="nav-toggle" aria-expanded="false" aria-controls="menu-principal">Menu</button>
    </div>
    <nav class="drawer-nav" id="menu-principal" aria-label="Navegação principal">
      <ul>
        <?php
        $itensMenu = [
            'inicio'      => ['/', 'Início'],
            'livros'      => ['/livros', 'Livros'],
            'usuarios'    => ['/usuarios', 'Usuários'],
            'emprestimos' => ['/emprestimos', 'Empréstimos'],
            'sair'        => ['/logout', 'Encerrar sessão'],
        ];
        ?>
        <?php foreach ($itensMenu as $chave => [$rota, $rotulo]): ?>
          <li><a href="<?= e(url($rota)) ?>"<?= $menu === $chave ? ' aria-current="page"' : '' ?>><?= e($rotulo) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>
  </header>
<?php endif; ?>

  <main class="page-main<?= $semMenu ? ' page-main--login' : '' ?>">
