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

You need to configure the service provider so when the application got an error exception, it can be also send asyncrhonously with overriding the report method handler. 

Add the service provider into <b>config/app.php</b> file

```
/*
* Package Service Providers...
*/
Iqbalatma\LaravelTelegramBotChannelAsync\Providers\TelegramBotChannelServiceProvider::class,
```

You can log the application with Log class and different level. 
First parameter is string for log message, and then second parameter is array for log context (optional)

```
use Iqbalatma\LaravelTelegramBotChannelAsync\Log;

Log::debug("This is debug message");
Log::info("This is info message");
Log::notice("This is notice message");
Log::warning("This is warning message");
Log::error("This is error message");
Log::critical("This is critical message");
Log::emergency("This is emergency message", , ["problem" => "Some problem description"]);
```

 
