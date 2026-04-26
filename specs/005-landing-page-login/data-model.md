# Data Model: Landing Page with Login

## Entities

### User Session (Existing)
- **Source**: `$_SESSION` via `SessionManager`
- **Fields**: `user_id`, `username`, `perfil`
- **Role**: Determines which view of `index.php` is displayed.

### Dashboard Stats (Existing)
- **Source**: `pedidos` table
- **Fields**: `status`
- **Role**: Displayed on the Dashboard view when a user is logged in.

## State Transitions
- **Public**: `isLoggedIn() == false` -> Shows Landing Page.
- **Login Action**: Redirects to `pages/login.php`.
- **Authenticated**: `isLoggedIn() == true` -> Redirects to Dashboard.
