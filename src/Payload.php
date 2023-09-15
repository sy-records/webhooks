<?php

declare(strict_types=1);
/**
 * This file is part of WebHooks.
 *
 * @link     https://github.com/sy-records/webhooks
 * @contact  Lu Fei <lufei@simps.io>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Luffy\WebHook;

use GuzzleHttp\Psr7\ServerRequest;
use Luffy\WebHook\Exception\InvalidArgumentException;
use Luffy\WebHook\Handler\GiteaHandler;
use Luffy\WebHook\Handler\GiteeHandler;
use Luffy\WebHook\Handler\GitHubHandler;
use Luffy\WebHook\Handler\GitLabHandler;
use Luffy\WebHook\Handler\GogsHandler;
use Luffy\WebHook\Handler\HandlerFactory;
use Luffy\WebHook\Interfaces\HandlerInterface;
use Luffy\WebHook\Interfaces\WebHookInterface;
use Psr\Http\Message\MessageInterface;

class Payload implements WebHookInterface
{
    protected $request;

    /** @var GiteaHandler|GiteeHandler|GitHubHandler|GitLabHandler|GogsHandler */
    protected $handler;

    public function __construct(MessageInterface $request = null)
    {
        $this->request = $request ?? ServerRequest::fromGlobals();
        $this->handler = HandlerFactory::create($this->request);

        if ($this->handler === null) {
            throw new InvalidArgumentException('Invalid event type');
        }
    }

    public function getRequest(): MessageInterface
    {
        return $this->request;
    }

    public function getHandler(): HandlerInterface
    {
        return $this->handler;
    }

    public function getHeaderEvent(): string
    {
        return $this->getHandler()->getHookName();
    }
}
