# Repository Guidelines

## Project Structure & Module Organization
- `app/` holds Laravel application code (controllers, models, Livewire, services).
- `resources/` contains frontend assets (`css/`, `js/`) and Blade views (`views/`).
- `routes/` defines HTTP and console routes (`web.php`, `api.php`, `console.php`).
- `database/` includes migrations, factories, and seeders.
- `tests/` is split into `Feature/` and `Unit/` tests.
- `config/` stores framework and package configuration; `storage/` is runtime data.

## Build, Test, and Development Commands
- `composer install` installs PHP dependencies.
- `npm install` installs frontend dependencies.
- `npm run dev` starts Vite for asset development.
- `npm run build` builds production assets.
- `composer test` or `composer pest` runs the test suite.
- Docker demo: `cp .env.docker.example .env` then `docker-compose up`.
- Lando: `lando start` then `lando composer install` and `lando artisan migrate`.

## Coding Style & Naming Conventions
- Indentation: 4 spaces (see `.editorconfig`).
- PHP follows PSR-4 autoloading (`App\\` -> `app/`).
- Class names use `StudlyCase` and files match class names.
- Configuration keys and array keys follow Laravel conventions (snake case).

## Testing Guidelines
- Framework: Pest + PHPUnit (see `phpunit.xml`).
- Place unit tests in `tests/Unit` and feature tests in `tests/Feature`.
- Name tests with the `*Test.php` suffix.

## Commit & Pull Request Guidelines
- Commit messages: no established convention in history; use clear, imperative
  summaries (e.g., "Add product filter view").
- Pull requests should include a short description, testing notes, and relevant
  screenshots for UI changes.

## Security & Configuration Tips
- Copy an example env file before running (`.env.docker.example` or `.env.lando.example`).
- Do not commit secrets; keep credentials in `.env`.
