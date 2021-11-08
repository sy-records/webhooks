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
namespace Luffy\WebHook\Handler;

use Luffy\WebHook\Interfaces\HandlerInterface;
use Psr\Http\Message\MessageInterface;

abstract class AbstractHandler implements HandlerInterface
{
    public function __construct(MessageInterface $request)
    {
        $this->request = $request;
    }

    public function getRequest(): MessageInterface
    {
        return $this->request;
    }

    private function normalizeParsedBody(): array
    {
        $data = $this->request->getParsedBody();

        if (empty($data)) {
            $contentType = strtolower($this->request->getHeaderLine('Content-Type'));
            if (strpos($contentType, 'application/json') === 0) {
                $data = json_decode($this->request->getBody()->getContents(), true) ?? [];
            }
        }

        return $data;
    }

    public function get(string $key = '', $default = '')
    {
        $body = $this->normalizeParsedBody();
        if ($key !== '') {
            if (isset($body[$key])) {
                return $body[$key];
            }

            return $default;
        }

        return $body;
    }

    public function getAfterCommitId(): string
    {
        return $this->get('after');
    }

    public function getCommitId(): string
    {
        return $this->getAfterCommitId();
    }

    public function getRepository(): array
    {
        return $this->get('repository', []);
    }
}
