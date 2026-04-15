### 4.1 API Resources
- **Objetivo:** transformar modelos e coleções em estruturas JSON consistentes, desacoplando a representação da entidade do banco.
- **Utilidade:** controlar exatamente quais campos expor, formatar valores (datas, decimais), adicionar campos calculados/relações condicionais, padronizar a saída da API, versionar respostas e esconder atributos sensíveis.

### 4.2 Validação em classes específicas (Form Requests)
- **Organização:** controllers ficam enxutos e focados em orquestrar.
- **Manutenção:** regras centralizadas; mudanças afetam um único arquivo.
- **Reutilização:** o mesmo Request pode ser usado em múltiplos endpoints; mensagens personalizadas e autorização ficam no mesmo lugar; fácil de testar isoladamente.
- Outros benefícios: injeção automática no controller, retorno 422 padronizado, suporte a `prepareForValidation`, `authorize`, `after`, etc.

### 4.3 Testes Automatizados
1. **Para que servem:** garantir que o comportamento esperado da aplicação se mantém após mudanças; documentam o contrato; previnem regressões; dão confiança em refatorações e deploys.
2. **Como testar um endpoint:**
   - **Onde:** em `tests/Feature/`, usando uma classe que estende `Tests\TestCase` com a trait `RefreshDatabase` para banco limpo a cada teste.
   - **Como testar:** usar métodos HTTP do TestCase (`$this->getJson()`, `postJson()`, etc.), preparar o estado com factories, chamar o endpoint e usar asserts (`assertOk`, `assertStatus`, `assertJson`, `assertJsonPath`, `assertDatabaseHas`).
   - **Como rodar:** `php artisan test` (ou `vendor/bin/phpunit`). Para filtrar: `php artisan test --filter=ProductApiTest`.