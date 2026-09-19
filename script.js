/* ==========================================================================
   Sistema de Biblioteca — script.js
   --------------------------------------------------------------------------
   Este arquivo cuida SÓ de navegação/interface:
     1) abrir e fechar o menu no mobile
     2) marcar automaticamente o link da página atual como ativo

   O envio dos formulários agora é o comportamento padrão do HTML: cada
   <form> dá POST direto para o script PHP indicado em "action". A
   validação de verdade (conferir e-mail duplicado, senha, datas etc.)
   acontece no PHP, lendo/gravando o .json que faz o papel de banco de
   dados. Os atributos "required"/"pattern" que já existem nos campos
   continuam servindo como uma primeira checagem no navegador, antes de
   chegar no servidor.
   ========================================================================== */

document.addEventListener("DOMContentLoaded", () => {
  ativarMenuMobile();
  marcarLinkAtivo();
});

/* -------------------------------------------------------------------------
   1) Menu mobile: só alterna uma classe que o CSS usa para mostrar/esconder
      a navegação em telas pequenas. Nenhum dado envolvido.
   ------------------------------------------------------------------------- */
function ativarMenuMobile() {
  const botao = document.querySelector(".nav-toggle");
  const nav = document.querySelector(".drawer-nav");
  if (!botao || !nav) return;

  botao.addEventListener("click", () => {
    const aberto = nav.classList.toggle("aberto");
    botao.setAttribute("aria-expanded", String(aberto));
  });
}

/* -------------------------------------------------------------------------
   2) Marca com aria-current="page" o link cujo href bate com a página
      atual. Cada página já define isso manualmente no HTML, mas esta
      função garante que fique certo mesmo se você reorganizar arquivos.
   ------------------------------------------------------------------------- */
function marcarLinkAtivo() {
  const paginaAtual = window.location.pathname.split("/").pop() || "index.html";
  document.querySelectorAll(".drawer-nav a").forEach((link) => {
    const destino = link.getAttribute("href");
    if (destino === paginaAtual) {
      link.setAttribute("aria-current", "page");
    } else {
      link.removeAttribute("aria-current");
    }
  });
}
