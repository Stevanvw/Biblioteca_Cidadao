<?php
/** Mensagens de feedback (sucesso/erro) guardadas pelo Controller com Sessao::flash(). */
?>
<?php foreach ($flashes as $flash): ?>
    <div class="alerta alerta--<?= e($flash['tipo']) ?>" role="<?= $flash['tipo'] === 'erro' ? 'alert' : 'status' ?>">
      <?= e($flash['mensagem']) ?>
    </div>
<?php endforeach; ?>
