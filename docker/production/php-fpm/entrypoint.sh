#!/bin/sh
set -e

main() {
    prepare_storage
    optimize_app
    run_migrations
    exec "$@"
}

prepare_storage() {
    mkdir -p /var/www/storage/framework/cache/data
    mkdir -p /var/www/storage/framework/sessions
    mkdir -p /var/www/storage/framework/views

    chown -R www-data:www-data /var/www/storage

    php artisan storage:link
}

wait_for_db() {
    echo "Esperando o banco de dados estar pronto..."
    until php artisan migrate:status 2>&1 | grep -q -E "(Migration table not found|Migration name)"; do
        sleep 1
    done
}

run_migrations() {
    php artisan migrate --force
}

optimize_app() {
    php artisan optimize:clear
    php artisan optimize
}

main "$@"
