setup:
	cp .env.example
	composer i --ignore-platform-reqs
	php artisan key:generate
	php artisan migrate --seed
