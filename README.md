# 🖥️ Products API — Desafio Técnico Laravel

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Blade](https://img.shields.io/badge/Blade-F05340?style=for-the-badge&logo=laravel&logoColor=white)

Uma interface visual, interativa e amigável para o gerenciamento completo de produtos no estoque, focada na melhor experiência do usuário final.


API REST para gerenciamento de produtos.

## Requisitos
- PHP >= 8.2
- Composer
- SQLite (ou MySQL/PostgreSQL)

## Instalação
```bash
git clone <repo>
cd desafio
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan cache:table && php artisan migrate
```

## Execução
```bash
php artisan serve
```

A API estará disponível em `http://localhost:8000/api/products`.

## Testes
```bash
php artisan test
```

## Endpoints
| Método | URI | Descrição |
|---|---|---|
| GET | /api/products | Lista produtos (com filtros e paginação) |
| POST | /api/products | Cria produto |
| GET | /api/products/{id} | Detalhes |
| PUT | /api/products/{id} | Atualiza |
| DELETE | /api/products/{id} | Remove |

### Filtros suportados (query params)
- `name` — busca parcial por nome
- `min_price`, `max_price` — faixa de preço
- `min_stock`, `max_stock` — faixa de estoque
- `per_page`, `page` — paginação

Exemplo:
`GET /api/products?name=mouse&min_price=50&max_price=200`

## Collection Insomnia
Arquivo `insomnia_collection.json` na raiz.

## Respostas Teóricas
Arquivo `respostas.md` na raiz.

