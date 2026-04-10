# PHP Yggdrasil API Server

A PHP implementation of the Yggdrasil API for Minecraft authentication servers.  
A part of [HRPAuth](https://github.com/HRPAuth/HRPAuth)

## Features

- ✅ Authentication endpoints (authenticate, refresh, validate, invalidate, signout)
- ✅ Session endpoints (join, hasJoined)
- ✅ Profile endpoints (profileQuery, batchProfiles)
- ✅ Texture endpoints (uploadTexture, deleteTexture)
- ✅ Meta endpoint
- ✅ MySQL database integration
- ✅ Demo data included

## Requirements

- PHP 7.4+
- MySQL 5.7+
- Web server (Apache, Nginx, etc.)

## Installation

1. **Clone the repository**

2. **Configure the database**
   - Create a MySQL database
   - Update the database configuration in `config/config.php`

3. **Import the database schema**
   ```bash
   mysql -u root -p < database.sql
   ```

4. **Import demo data** (optional)
   ```bash
   mysql -u root -p yggdrasil_api < demo_data.sql
   ```

5. **Configure web server**
   - Set document root to the project directory
   - Enable URL rewriting (for clean URLs)

## Configuration

Edit `config/config.php` to customize server settings:

- Database connection details
- Server metadata
- Security settings
- Feature flags

## API Endpoints

### Authentication
- `POST /authserver/authenticate` - User login
- `POST /authserver/refresh` - Refresh access token
- `POST /authserver/validate` - Validate token
- `POST /authserver/invalidate` - Invalidate token
- `POST /authserver/signout` - Sign out user

### Session
- `POST /sessionserver/session/minecraft/join` - Join server session
- `GET /sessionserver/session/minecraft/hasJoined` - Check if user joined server

### Profile
- `GET /sessionserver/session/minecraft/profile/{uuid}` - Get profile by UUID
- `POST /api/profiles/minecraft` - Batch profile lookup by names

### Texture
- `PUT /api/user/profile/{uuid}/{textureType}` - Upload texture
- `DELETE /api/user/profile/{uuid}/{textureType}` - Delete texture

### Meta
- `GET /` - Server metadata

## Demo Credentials

Use these credentials to test the API:

- Email: `user@samuelchest.com`
- Password: `password123`
- Username: `PlayerOne`

## Testing

You can test the API using tools like Postman or curl. Example curl command for authentication:

```bash
curl -X POST http://auth.samuelchest.com/authserver/authenticate \
  -H "Content-Type: application/json" \
  -d '{
    "username": "user@samuelchest.com",
    "password": "password123",
    "agent": {
      "name": "Minecraft",
      "version": 1
    }
  }'
```

## License

MIT
