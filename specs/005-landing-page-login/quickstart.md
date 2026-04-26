# Quickstart: Landing Page with Login

## Development Setup

1. **Verify Session**: Ensure `includes/auth_helper.php` is available.
2. **Access index.php**:
   - **Logout**: Visit `logout.php` first.
   - **Check Landing Page**: Navigate to root (`index.php`). You should see the service overview and Login button.
   - **Check Login**: Click Login, authenticate.
   - **Check Dashboard**: After login, you should be redirected to the Dashboard view of `index.php`.

## Verification Steps

### Test 1: Public Access
- Open incognito window.
- Visit root URL.
- **Expected**: Minimalist landing page with Recebimento, Lavagem, Expedição sections.

### Test 2: Login Redirection
- On Landing Page, click "Login".
- **Expected**: Redirect to `pages/login.php`.

### Test 3: Authenticated Access
- Log in.
- Visit root URL.
- **Expected**: Statistics Dashboard (not the landing page).
