# Auth App

## Installation

```bash
git clone git@github.com:enterprise-it-ru/auth-app.git auth-app.local
cd auth-app.local
```

Copy the .env file and change the database connection settings

```bash
cp .env.example .env
```
```bash
composer install
```

```bash
php artisan key:generate
```

```bash
php artisan migrate
```

```bash
npm install
```

```bash
npm run prod
```

For development mode, use the command

```bash
npm run hot
```
