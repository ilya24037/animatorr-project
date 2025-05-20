
# Animatorr

⛓️ Каталог 3D-аниматоров и их работ.  
Full-stack: **Laravel 12 · Inertia.js · Vue 3 · Tailwind CSS**.

## Скриншот
![Главная](docs/screenshot-home.png)

## Быстрый старт

```bash
git clone https://github.com/ilya24037/animatorr-project.git
cd animatorr-project

cp .env.example .env        # настроить соединение с БД
composer install
npm install

php artisan key:generate
php artisan migrate --seed  # демо-данные
npm run dev                 # Vite + Hot Reload
php artisan serve
