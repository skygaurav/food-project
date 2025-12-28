# Food Project — Laravel skeleton helper

Files added to help run the existing app folder as a Laravel project. Follow these steps locally:

1. Install PHP and Composer (PHP 8.1+).
2. From the project root run:

```bash
composer install
cp .env.example .env
php artisan key:generate
mkdir -p database && touch database/database.sqlite
php artisan migrate
php artisan serve
```

Notes:
- This repo contains the application code under `app/`, routes and migrations. Composer will install Laravel framework into `vendor/`.
- If you prefer MySQL/Postgres, update `.env` accordingly and create the DB before running migrations.

DDEV (MySQL) quickstart

- Install ddev: https://ddev.com
- From project root run:

```bash
ddev start
# copy .env and enable MySQL values
cp .env.example .env
# enable MySQL in .env (or run: sed -i 's/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/' .env)
php artisan key:generate
ddev ssh -- php artisan migrate --force
ddev launch
```

Notes:
- The included `.ddev/config.yaml` configures PHP 8.0 and MySQL 8.0. DDEV will create the `db` service and make `DB_HOST=db` available inside the web container.
- If you prefer a different MySQL version, change `db_version` in `.ddev/config.yaml`.

Node.js (npm) in DDEV

- A custom web container is provided to include Node.js and npm. After adding the Dockerfile, rebuild the web container:

```bash
# From project root
ddev restart --omit-snapshot
```

- You can then run `ddev ssh` and use `node` / `npm` inside the web container.

- The Dockerfile accepts a build-arg `NODE_VERSION` (default 18). To change the Node version, rebuild with:

```bash
# Example: build web container with Node 20
ddev restart --omit-snapshot --build-arg NODE_VERSION=20
```

- A DDEV `post-start` hook is included that runs `npm ci` inside the web container if a `package.json` exists. If you don't want this, remove the `hooks.post-start` entry from `.ddev/config.yaml`.
