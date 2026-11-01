/* ==========================================================================
   Sistema de Biblioteca — script.js
   --------------------------------------------------------------------------
   Este arquivo cuida SÓ da interface: abrir e fechar o menu no mobile.

   - O link da página atual no menu é marcado pelo PHP (views/layout/cabecalho.php).
   - As mensagens de sucesso/erro também vêm do PHP (views/layout/mensagens.php).
   - A validação de verdade acontece nos Controllers; os atributos "required"
     dos campos são só uma primeira checagem no navegador.
   ========================================================================== */

document.addEventListener("DOMContentLoaded", () => {
  ativarMenuMobile();
});

/* Menu mobile: só alterna uma classe que o CSS usa para mostrar/esconder
   a navegação em telas pequenas. Nenhum dado envolvido. */
function ativarMenuMobile() {
  const botao = document.querySelector(".nav-toggle");
  const nav = document.querySelector(".drawer-nav");
  if (!botao || !nav) return;

  botao.addEventListener("click", () => {
    const aberto = nav.classList.toggle("aberto");
    botao.setAttribute("aria-expanded", String(aberto));
  });
}
