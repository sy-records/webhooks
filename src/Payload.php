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
use Luffy\WebHook\Constants\Header;
use Luffy\WebHook\Exception\InvalidArgumentException;
use Luffy\WebHook\Handler\GiteaHandler;
use Luffy\WebHook\Handler\GiteeHandler;
use Luffy\WebHook\Handler\GitHubHandler;
use Luffy\WebHook\Handler\GitLabHandler;
use Luffy\WebHook\Interfaces\HandlerInterface;
use Luffy\WebHook\Interfaces\WebHookInterface;
use Psr\Http\Message\MessageInterface;

class Payload implements WebHookInterface
{
    protected $request;

    /** @var GiteeHandler|GitHubHandler|GitLabHandler */
    protected $handler;

    public $events = [
        'GITEA_EVENT' => GiteaHandler::class,
        'GITEE_EVENT' => GiteeHandler::class,
        'GITHUB_EVENT' => GitHubHandler::class,
        'GITLAB_EVENT' => GitLabHandler::class,
    ];

    public function __construct(MessageInterface $request = null)
    {
        $this->request = $request ?? ServerRequest::fromGlobals();

        foreach ($this->events as $event => $handlerClass) {
            $headerConstant = constant(Header::class . '::' . $event);
            if ($this->request->hasHeader($headerConstant)) {
                $this->handler = new $handlerClass($this->request);

                return;
            }
        }

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
        foreach ($this->events as $event => $_) {
            $headerConstant = constant(Header::class . '::' . $event);
            if ($this->request->hasHeader($headerConstant)) {
                return $this->request->getHeaderLine($headerConstant);
            }
        }

        return '';
    }
}
