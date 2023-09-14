# webhooks

WebHook Handler for GitHub, Gitee and GitLab.

[![Latest Stable Version](http://poser.pugx.org/sy-records/webhooks/v)](https://packagist.org/packages/sy-records/webhooks)
[![Total Downloads](http://poser.pugx.org/sy-records/webhooks/downloads)](https://packagist.org/packages/sy-records/webhooks)
[![Latest Unstable Version](http://poser.pugx.org/sy-records/webhooks/v/unstable)](https://packagist.org/packages/sy-records/webhooks)
[![License](http://poser.pugx.org/sy-records/webhooks/license)](https://packagist.org/packages/sy-records/webhooks)
[![PHP Version Require](http://poser.pugx.org/sy-records/webhooks/require/php)](https://packagist.org/packages/sy-records/webhooks)

## Install

```bash
composer require sy-records/webhooks
```

## Usage

```php
use Luffy\WebHook\Payload;
use Luffy\WebHook\Interfaces\HandlerInterface;

// 如果存在实现MessageInterface的request对象，可以传入
// 不传则从全局变量中获取
$payload = new Payload();
/** @var HandlerInterface $handler */
$handler = $payload->getHandler();
```
