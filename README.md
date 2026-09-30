# Biblioteca Cidadão

## Sobre o projeto

A Biblioteca Cidadão é uma aplicação web desenvolvida como projeto acadêmico para a disciplina de Web Servidor, na Universidade Tecnológica Federal do Paraná (UTFPR).

O sistema tem como objetivo disponibilizar funcionalidades relacionadas ao gerenciamento de livros de uma biblioteca, permitindo que usuários autenticados (funcionários) cadastrem e consultem livros presentes no sistema, além de possibilitar o gerenciamento de empréstimos de clientes da biblioteca.

O projeto foi desenvolvido utilizando PHP 8+, com processamento e validação dos dados no lado do servidor.

## Integrantes

- Luis Stevan
- Rayane Alves
- Gleice Emilly

## Atividades dos integrantes

### Luis Stevan

- Desenvolvimento e implementação das funcionalidades relacionadas ao gerenciamento de livros;
- Implementação de validações dos dados dos livros no lado do servidor;
- Desenvolvimento e integração de funcionalidades em PHP;
- Organização da estrutura do projeto;
- Participação na integração e controle de versões utilizando Git e GitHub.
- Desenvolvimento do front-end;

### Gleice Emilly

- Desenvolvimento das funcionalidades atribuídas ao gerenciamento de usuários;
- Implementação e integração das funcionalidades em PHP;
- Testes e correções das funcionalidades desenvolvidas.
- Participação na integração e controle de versões utilizando Git e GitHub.

### Rayane Alves

- Desenvolvimento da tela de login e da funcionalidade de autenticação dos usuários;
- Desenvolvimento das funcionalidades atribuídas ao gerenciamento de empréstimos;
- Implementação e integração das funcionalidades em PHP;
- Testes e correções das funcionalidades desenvolvidas.
- Participação na integração e controle de versões utilizando Git e GitHub.

## Objetivo

O projeto tem como objetivo aplicar conceitos de desenvolvimento web no lado do servidor, incluindo:

- Processamento de formulários com PHP;
- Validação de dados no servidor;
- Autenticação de usuários;
- Controle de acesso através de sessões;
- Separação entre lógica de aplicação e apresentação;
- Organização do projeto seguindo uma estrutura inspirada no padrão MVC;
- Manipulação e armazenamento de informações utilizando arquivos JSON.

## Funcionalidades

O sistema possui funcionalidades relacionadas a:

- Autenticação de usuários;
- Controle de acesso através de sessão;
- Cadastro e listagem de livros presentes na base de dados e suas respectivas informações;
- Cadastro e listagem de usuários presentes na base de dados e suas respectivas informações;
- Cadastro e listagem de empréstimos presentes na base de dados e suas respectivas informações;
- Validação dos dados enviados pelos formulários;
- Armazenamento dos dados em arquivos JSON.

## Tecnologias utilizadas

- PHP 8+
- HTML5
- CSS3
- JavaScript
- JSON
- XAMPP
- Git
- GitHub

## Estrutura do projeto

A aplicação está organizada de forma inspirada no padrão MVC, separando a apresentação, a lógica de controle e o acesso aos dados.

 Os principais componentes possuem as seguintes responsabilidades:

 - controllers/ — responsáveis pelo processamento das requisições e pela lógica de controle;
- models/ — responsáveis pela representação e manipulação dos dados;
- data/ — armazenamento das informações utilizadas pelo sistema em arquivos JSON;
- views/ — páginas responsáveis pela apresentação das informações ao usuário.

 ## Instalação e execução

 ### 1. Instalar o XAMPP

 Instale o XAMPP, contendo o Apache e o PHP.

 ### 2. Colocar o projeto no servidor

 Copie a pasta do projeto para a pasta htdocs do XAMPP.

 Exemplo:

```
C:\xampp\htdocs\Biblioteca_Cidadao
```

 ### 3. Iniciar o Apache

 Abra o XAMPP Control Panel e inicie o servidor Apache.

 ### 4. Acessar o projeto

 Abra o navegador (Google chrome ou similar) e acesse:

```
http://localhost/Biblioteca_Cidadao/views/login.php
```

 Usuário:

```
atendimento@bibliotecacidadao.gov.br
```

 Senha:

```
biblioteca2026
```

 ## Configuração do sistema

 O sistema utiliza arquivos JSON para armazenar os dados, não sendo necessário configurar um banco de dados para executar o projeto.

 Os arquivos de dados encontram-se na pasta:

```
data/
```

 Antes de executar o sistema, certifique-se de que o servidor Apache esteja iniciado e que o PHP esteja disponível através do XAMPP.

 Também é necessário garantir que os arquivos JSON utilizados pelo sistema estejam presentes na pasta data/ e possam ser acessados pelo PHP.

 ## Autenticação e controle de acesso

 O sistema utiliza sessões do PHP para controlar o acesso às funcionalidades que necessitam de autenticação.

 Usuários não autenticados são direcionados para a página de login ao tentar acessar diretamente determinadas áreas do sistema.

 ## Validação e processamento dos dados

 Os formulários do sistema são processados no lado do servidor utilizando PHP.

 As informações recebidas são submetidas a validações antes de serem utilizadas ou armazenadas. Dessa forma, as   validações não dependem exclusivamente do HTML ou JavaScript executado no navegador.

 ## Armazenamento dos dados

 Os dados são armazenados em arquivos no formato JSON, não sendo utilizado banco de dados.

 Entre os dados armazenados estão informações relacionadas a:

 - Usuários;
 - Livros;
 - Empréstimos.

 ## Limitações do sistema

 Como o foco do projeto é a parte de validação e processamento através do PHP, o sistema não possui:

 - A possibilidade de editar, alterar ou excluir um livro, usuário ou empréstimo cadastrado.
 - A possibilidade de alteração de senha ou nome do usuário dentro do próprio sistema.

 ## Funcionalidades faltantes

 Divisão correta de responsabilidades seguindo o padrão MVC em arquivos relacionados a:

 - Usuários
 - Empréstimos

 ## Observações

 Por utilizar arquivos JSON para armazenamento, o projeto não necessita de configuração ou instalação de um banco de dados para seu funcionamento.

 ## Controle de versão

 O desenvolvimento do projeto foi realizado utilizando Git para controle de versões e GitHub para armazenamento e colaboração no código-fonte.

 O repositório contém o código-fonte desenvolvido durante o projeto, bem como este documento com as informações de instalação, configuração e descrição das atividades realizadas pela equipe.
