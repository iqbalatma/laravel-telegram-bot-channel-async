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
	....,
	telegram" => [
		"driver" => "custom",
            	"via" => new TelegramLogger(env('TELEGRAM_APP_KEY'), env('TELEGRAM_CHANNEL'), true),
            	"level" => "debug"
	]
]
```
