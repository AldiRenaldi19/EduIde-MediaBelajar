# EduIde — Media Belajar

EduIde is a Laravel-based learning platform. This repository contains the application code for a course catalog, enrollment, user authentication (including Google OAuth), and testimonial features.

**Status:** Development (local)

## Quick links

- Repo: https://github.com/AldiRenaldi19/EduIde-MediaBelajar

## Requirements

- PHP 8.2+
- Composer
- MySQL (or compatible database)
- Node.js & npm

## Setup (development)

1. Clone and install dependencies:

```bash
git clone https://github.com/AldiRenaldi19/EduIde-MediaBelajar.git
cd EduIde-MediaBelajar
composer install
```

2. Environment and keys (DO NOT commit `.env`):

```bash
cp .env.example .env
# edit .env with your local DB, mail, cloudinary and google oauth values
php artisan key:generate
```

3. Database migration & seed (optional):

```bash
php artisan migrate
php artisan db:seed
```

4. Frontend assets and dev server:

```bash
npm install
npm run dev
php artisan serve
```

Open http://127.0.0.1:8000 in your browser.

## Security notes

- `.env` must never be committed. This repo includes `.env.example` as a template.
- If any secret was exposed in a pushed commit, rotate the key and remove it from history.

## Recent changes

- Added `.env.example` and sanitized hard-coded secrets in configs.
- Updated Cloudinary to use env vars and fixed minor model/migration issues.

## Tests

Run the test suite:

```bash
composer test
```

## Contributing

Open an issue or a PR. For changes involving credentials or deployment, coordinate before adding secrets.

## License

MIT (see `composer.json`).
