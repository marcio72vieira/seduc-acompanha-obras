#!/bin/sh
set -e

main() {
    prepare_storage
    run_migrations
    optimize_app
    exec "$@"
}

prepare_storage() {
    mkdir -p /var/www/storage/framework/cache/data
    mkdir -p /var/www/storage/framework/sessions
    mkdir -p /var/www/storage/framework/views

    chown -R www-data:www-data /var/www/storage
    chown -R www-data:www-data /var/www/vendor/mpdf

    # Verifica se o link simbólico já existe antes de criar
    if [ ! -L /var/www/public/storage ]; then
        php artisan storage:link
    else
        echo "Link simbólico public/storage já existe."
    fi
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
