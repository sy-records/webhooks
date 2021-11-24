<?php

declare(strict_types=1);
/**
 * This file is part of WebHooks.
 *
 * @link     https://github.com/sy-records/webhooks
 * @contact  Lu Fei <i@lufei.dev>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace Luffy\WebHook;

use GuzzleHttp\Psr7\ServerRequest;
use Luffy\WebHook\Constants\Header;
use Luffy\WebHook\Exception\InvalidArgumentException;
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

    public function __construct(MessageInterface $request = null)
    {
        if ($request !== null) {
            $this->request = $request;
        } else {
            $this->request = ServerRequest::fromGlobals();
        }

        if ($this->isGiteeEvent()) {
            $this->handler = new GiteeHandler($this->request);
        }
        if ($this->isGitHubEvent()) {
            $this->handler = new GitHubHandler($this->request);
        }
        if ($this->isGitLabEvent()) {
            $this->handler = new GitLabHandler($this->request);
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

    public function isGiteeEvent(): bool
    {
        return $this->request->hasHeader(Header::GITEE_EVENT);
    }

    public function isGitHubEvent(): bool
    {
        return $this->request->hasHeader(Header::GITHUB_EVENT);
    }

    public function isGitLabEvent(): bool
    {
        return $this->request->hasHeader(Header::GITLAB_EVENT);
    }

    public function getHeaderEvent(): string
    {
        if ($this->isGiteeEvent()) {
            return $this->request->getHeaderLine(Header::GITEE_EVENT);
        }
        if ($this->isGitHubEvent()) {
            return $this->request->getHeaderLine(Header::GITHUB_EVENT);
        }
        if ($this->isGitLabEvent()) {
            return $this->request->getHeaderLine(Header::GITLAB_EVENT);
        }

        return '';
    }
}
