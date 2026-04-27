# LuvaSul - Sistema de Gestão de Lavanderia Industrial

Sistema web desenvolvido em PHP puro (No-Framework) para digitalização completa dos processos de uma lavanderia industrial. O foco central é a **Rastreabilidade Digital** e a **Integridade do Processo**, garantindo que cada item seja acompanhado desde o recebimento até a expedição final.

## 📜 Princípios Fundamentais (Constituição)

1.  **Rastreabilidade Digital (QR Code First)**: Todo material gera um QR Code único. O registro manual é proibido nas etapas críticas.
2.  **Integridade do Processo**: Fluxo obrigatório: Recebimento → Lavagem → Expedição. O sistema impede saltos de etapa.
3.  **Simplicidade Estruturada**: Código em PHP estruturado e Bootstrap 5, sem dependência de frameworks pesados para garantir manutenção a longo prazo.
4.  **Fidelidade de Dados**: Dashboards em tempo real e relatórios gerenciais focados em KPIs (Lead Time, Volume, Backlog).
5.  **Design Operacional Responsivo**: Interface otimizada para tablets e dispositivos móveis no chão de fábrica.

## 🚀 Funcionalidades Principais

-   **Dashboard Gerencial**: Visualização de contadores dinâmicos, métricas de OKR (comparativo mensal) e progresso visual dos pedidos.
-   **Recebimento Aprimorado**: Busca inteligente de categorias por SKU ou Nome, suporte a unidades flexíveis (UN/KG) com precisão decimal e geração instantânea de etiquetas.
-   **Módulo de Lavagem**: Painel operacional com card de detalhes lateral, validação de QR Code e visualização do significado do SKU do catálogo.
-   **Módulo de Expedição**: Painel em abas (Aguardando vs. Pronto para Entrega) para gestão de fluxo de saída.
-   **Catálogo de Materiais**: Gestão completa de SKUs com busca avançada, edição local e definição de tipo de lavagem (Água/Seco).
-   **Relatórios e Exportação**: Relatórios filtráveis com exportação segura para CSV e drill-down de detalhes sem troca de página.
-   **Impressão de Etiquetas**: Layout otimizado (100x50mm) para impressoras térmicas industriais.

## 📋 Requisitos e Instalação

### Requisitos
- PHP 7.4+
- MySQL 5.7+ / MariaDB
- Extensões PHP: `mysqli`, `gd`
- Composer (opcional para geração local de QR Code)

### Instalação e Configuração
1.  Clone o repositório.
2.  Configure as variáveis de ambiente para o banco de dados (Recomendado):
    - `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`
    - Fallback: Edite as credenciais em `config/config.php` (apenas para ambiente de desenvolvimento).
3.  O sistema inicializa o banco de dados automaticamente na primeira execução através da função `inicializarDB()`.
4.  Garanta que o diretório `qrcodes/` tenha permissão de escrita (`chmod 755`).

## 📁 Estrutura do Projeto

-   `assets/`: Estilos CSS modernos e lógica JavaScript centralizada (Clipboard, Tooltips).
-   `config/`: Configurações globais e constantes do sistema.
-   `includes/`: Lógica compartilhada (Autenticação, Serviços de Pedidos/Materiais, Helpers de QR).
-   `pages/`: Módulos operacionais e administrativos da aplicação.
-   `specs/`: Documentação técnica completa de cada funcionalidade implementada.

## 🔒 Segurança

O sistema passou por uma auditoria de segurança rigorosa e inclui:
- Proteção contra SQL Injection (Prepared Statements).
- Proteção global contra XSS (`htmlspecialchars`).
- Proteção de rotas e exportações (Sessão obrigatória).
- Sanitização de caminhos de arquivos (Path Traversal prevention).

---
**Desenvolvido para LuvaSul Lavanderia Industrial** 🏭
