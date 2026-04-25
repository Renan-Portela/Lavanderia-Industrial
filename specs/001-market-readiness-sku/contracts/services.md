# Service Contracts: Market Readiness

## AuthService
Handles user authentication and session management.
- `login(string $username, string $password): bool`
- `logout(): void`
- `isAuthenticated(): bool`
- `getCurrentUser(): ?User`

## MaterialService
Handles Material Catalog CRUD and validation.
- `createMaterial(array $data): int`
- `getMaterial(int $id): ?Material`
- `listMaterials(): array`
- `validateSKU(string $sku): bool`
- `generateSKU(string $cat, string $mat, string $siz): string`

## OrderService
Handles Order processing and status transitions.
- `createOrder(array $data): int`
- `updateStatus(int $id, string $newStatus): bool`
- `generateQRCode(int $orderId): string`
- `isValidTransition(string $currentStatus, string $newStatus): bool`
