# Data Model: Flash Messages

## Entities

### Flash Message (Transient)
Represents a temporary notification stored in the user session.

| Field | Type | Description |
|-------|------|-------------|
| `type` | String | 'success', 'danger' (error), 'warning', 'info' |
| `message`| String | The text to display to the user |

## State
- **Storage**: `$_SESSION['flash']`
- **Lifecycle**: Created before redirect -> Read after redirect -> Deleted immediately after display.
