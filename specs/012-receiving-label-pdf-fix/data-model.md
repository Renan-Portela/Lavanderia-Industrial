# Data Model: Receiving Label PDF Fix

## Print-Time View Model

### Label Record
- **ID**: `pedidos.id` (Primary Identifier, bold/large)
- **Client**: `pedidos.cliente`
- **Material**: `materiais.nome` (via JOIN)
- **Quantity**: `pedidos.quantidade` + `pedidos.unidade`
- **QR Path**: `pedidos.codigo_qr` (resolves to filesystem path)
- **Obs**: `pedidos.observacao` (conditional display)

## Layout Constraints
- **Orientation**: Landscape (Width > Height)
- **Contrast**: Pure Black (#000) on Pure White (#FFF)
- **Scaling**: QR Code must occupy ~40% of horizontal width.
