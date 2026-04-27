# Data Model: Material Catalog UI Refactor

## UI Entities

### Material Detail Card (Contextual)
- **ID**: \`materiais.id\`
- **SKU**: \`materiais.sku\`
- **Nome**: \`materiais.nome\`
- **Tipo Lavagem**: \`materiais.tipo_lavagem\` (ENUM: A, S)
- **Descrição**: \`materiais.descricao\`

### Search Suggestions (Datalist)
- **Label**: "SKU - Nome"
- **Value**: Used to lookup the specific Material record.

## State Transitions
- **Idle**: Card is hidden or shows a placeholder ("Select a material").
- **Selected**: Card displays material details in "View Mode".
- **Editing**: Card displays a form pre-populated with material data.
- **Adding**: Main view shows the "Create New" form (activated by "Novo Material" button).
