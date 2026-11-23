# ClimaTempo DW

## Site reproduzido

[Climatempo](https://www.msn.com/pt-br/clima/)

## Integrantes

- André Luiz Vicenzi Rigo
- William Kunzler
- Yasmin Maria Zerbielli

## Descrição

Reprodução do site Climatempo, feita para a disciplina de Desenvolvimento Web I com HTML, CSS e JavaScript.

Páginas:

- `index.php`: página inicial, com busca de cidade
- `pages/preview.php`: prévia da previsão
- `pages/principal.php`: previsão completa (precisa de login)
- `pages/planos.php`: planos de assinatura
- `pages/login.php`: login
- `pages/cadastro.php`: cadastro
- `pages/perfil.php`: perfil do usuário e cidades favoritas (precisa de login)
- `admin/`: painel do administrador, com cadastro, edição e exclusão de cidades e lista de usuários

A versão estática da Parte 2 (só HTML, CSS e JavaScript) fica na pasta `docs/` e está publicada em https://williamkunzler.github.io/clima_tempo_dw/.

Regras de negócio:

- O plano Gratuito pode ter até 3 cidades favoritas e o Premium até 5. Só é possível cancelar o Premium com até 3 favoritas.
- Não é possível criar duas contas com o mesmo e-mail.

## Como usar

### Com Docker

1. Clone o repositório:
   ```bash
   git clone https://github.com/WilliamKunzler/clima_tempo_dw.git
   ```
2. Na pasta do projeto, rode:
   ```bash
   docker compose up -d --build
   ```
3. Acesse http://localhost:8080. O banco é criado automaticamente com o script `database/clima_tempo.sql`.

### Com XAMPP

1. Copie a pasta do projeto para `htdocs`.
2. No phpMyAdmin, importe o arquivo `database/clima_tempo.sql`.
3. Acesse http://localhost/clima_tempo_dw/public/.

As configurações do banco ficam em `includes/config.php`.

## Usuários de teste

| Tipo | E-mail | Senha |
| --- | --- | --- |
| Administrador | admin@climatempo.test | admin123 |
| Usuário Premium | ana.silva@exemplo.com | senha1234 |
| Usuário Gratuito | carlos.souza@exemplo.com | senha1234 |

O painel fica em `/admin/login.php` (link no rodapé do site).

## Estrutura

```
clima_tempo_dw/
├── docs/              (Parte 2, GitHub Pages)
├── database/
│   └── clima_tempo.sql
├── includes/
│   ├── config.php, conexao.php, iniciar.php
│   ├── funcoes.php, dados.php, regras.php
│   └── header.php, menu.php, footer.php
└── public/
    ├── index.php
    ├── pages/
    ├── admin/
    └── assets/
        ├── css/
        ├── js/
        └── img/
```
