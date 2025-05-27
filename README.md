## commands for db
````````bash
php artisan migrate
php artisan db:seed
````````
## for front-end work
````````bash
npm run dev
````````
## for schedule work
````````bash
php artisan schedule:work
````````
## for queue work
````````bash
php artisan horizon
````````
## or
````````bash
php artisan queue:work
php artisan queue:listen --queue=default,telegram,news
````````

## custom functional commands
````````bash
php artisan app:get-currency-exchanges
php artisan parse:banknotes_bank_gov_ua
php artisan parse:coins_bank_gov_ua
````````

## for testing
````````bash
php artisan test
````````

## for parallel testing
````````bash
php artisan test --parallel --processes=2 --env=testing
````````
## for front
````````bash
npm run build
````````
# urls
```aiignore
http://localhost/api/documentation
http://localhost/horizon
```
# nginx:
```bash
sudo service nginx start
cd /etc/nginx/sites-available
nano default
nginx -s reload
nano /etc/php/8.2/cli/php.ini
nano /etc/nginx/nginx.conf
cd /var/log/nginx/
ls
```
# ssl free
```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx
```
# swagger
```bash
php artisan l5-swagger:generate
```
# telegram bot webhook url address set
```bash
curl -X POST "https://api.telegram.org/bot<TELEGRAM_BOT_TOKEN>/setWebhook" \
-d "url=<NGROK_ADDRESS>/api/telegram/webhook"
```
# chat GPT billing
```aiignore
https://platform.openai.com/account/billing/overview
https://platform.openai.com/settings/organization/usage
```
# artisan
```bash
php artisan extract:news 
php artisan horizon:clear --queue=default
php artisan route:clear
php artisan config:clear
php artisan optimize
php artisan tinker
php artisan route:list
php artisan migrate:rollback --step=1
php artisan ide-helper:models --dir='modules'
composer dump-autoload
php artisan l5-swagger:generate
```
# systemd
```bash
sudo nano /etc/systemd/system/laravel-worker.service
````
```aiignore
ExecStart=/usr/bin/php8.2 artisan queue:listen --queue=default,news,telegram --timeout=13600 --tries=2)
````
```bash
sudo systemctl stop laravel-worker
sudo systemctl start laravel-worker
sudo systemctl daemon-reload
sudo journalctl --unit=laravel-worker.service -n 100 --no-pager
````
