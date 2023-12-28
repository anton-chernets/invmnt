## commands for db
````````
php artisan migrate
php artisan db:seed
````````
## for front-end work
````````
npm run dev
````````
## for schedule work
````````
php artisan schedule:work
````````
## for queue work
````````
php artisan horizon
````````
## or
````````
php artisan queue:work
````````

## custom functional commands
````````
php artisan app:get-currency-exchanges
php artisan parse:banknotes_bank_gov_ua
php artisan parse:coins_bank_gov_ua
````````

## for testing
````````
php artisan test
````````

## for parallel testing
````````
php artisan test --parallel --processes=2 --env=testing
````````
