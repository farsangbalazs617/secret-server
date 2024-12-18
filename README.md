# Secret Server

A secure API service for sharing secrets with time-based and view-based expiration.

## Features

- Create and store secrets securely
- Access secrets via unique hash
- Automatic expiration based on:
  - Number of views
  - Time duration

## Requirements

- PHP 8.0 or higher
- Composer
- Web server (Apache/Nginx)

## Installation

1. Clone the repository:
git clone https://github.com/yourusername/secret-server.git

cd secret-server

composer install

## API Endpoints

### Create Secret
- **URL**: \`/v1/secret\`
- **Method**: \`POST\`
- **Content-Type**: \`application/json\`
- **Request Body**:
{
    \"secret\": \"Your secret message\",
    \"expireAfterViews\": 1,
    \"expireAfter\": 10
}
- **Response**: Returns hash identifier for the secret

### View Secret
- **URL**: \`/v1/secret/{hash}\`
- **Method**: \`GET\`
- **Response**: Returns secret details and content

## Configuration

The application uses a configuration system located in the \`config\` directory. Make sure to set up your environment variables if needed.

## DEMO PATH

Create a new secret:
[POST] https://secret-server-m4b8.onrender.com/v1/secret

Retrieve a secret:
[GET] https://secret-server-m4b8.onrender.com/v1/secret/{your-hash-here}

## Security

- Secrets are stored with encryption
- Automatic cleanup of expired secrets
- View-based access control
- Time-based expiration

## License

MIT License

## Author

Farsang Balázs <farsang.balazs617@gmail.com>