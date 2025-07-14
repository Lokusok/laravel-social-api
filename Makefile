setup:
	cp .env.example .env
	composer i --ignore-platform-reqs
	php artisan key:generate
	php artisan migrate --seed
