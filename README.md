# Laravel Telegram Log Bot Channel Async

This is a laravel package that used to send application log with Monolog library via telegram channel asynchronously. 

## Install

Use composer from your terminal to intall this package

```
composer require iqbalatma/laravel-telegram-bot-channel-async
```

Define Telegram Bot Token and chat id (channel id) and set into <b>.env</b> file

```
TELEGRAM_APP_KEY=12345:asdngasd13rcffas12r
TELEGRAM_CHANNEL="@atmadevlogging"
```

Add new channel into <b>config/logging.php</b>

```php
"channels" => [
	...,
	"telegram" => [
		"driver" => "custom",
            	"via" => new Iqbalatma\LaravelTelegramBotChannelAsync\TelegramLogger(env('TELEGRAM_APP_KEY'), env('TELEGRAM_CHANNEL'), true),
            	"level" => "debug"
	]
]
```

If you are using log channel type is stack, you can add channel name "telegram" into the array set like this

```php
"stack" => [
    	"driver" => "stack",
	"channels" => ["single", "telegram"],
]
```

This package using laravel queue, so the message send asynchronously with Job Class. Before you can use this application you need to set the queue and running the worker. For example you can change the QUEUE_CONNECTION into database (you can use any other driver to do this, like redis).

```
QUEUE_CONNECTION=database
```

After you change the queue env config, you need to run the migration and the worker with this command
```
php artisan queue:table
php artisan migrate
php artisan queue:work
```

