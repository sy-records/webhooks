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

    public function getBody(): array
    {
        return $this->normalizeParsedBody();
    }

    private function normalizeParsedBody(): array
    {
        $data = $this->request->getParsedBody();

        $contentType = strtolower($this->request->getHeaderLine('Content-Type'));

        if (isset($data['payload']) && strpos($contentType, 'application/x-www-form-urlencoded') === 0) {
            return json_decode($data['payload'], true) ?? [];
        }

        if (empty($data)) {
            if (strpos($contentType, 'application/json') === 0) {
                $body = $this->request->getBody()->getContents();
                if (get_class($this->request->getBody()) instanceof \GuzzleHttp\Psr7\CachingStream || empty($body)) {
                    $body = (string) $this->request->getBody();
                }
                $data = json_decode($body, true) ?? [];
            }
        }

        return $data;
    }

    public function get(string $key, $default = '')
    {
        $body = $this->normalizeParsedBody();

        return $body[$key] ?? $default;
    }

    public function isPing(): bool
    {
        // No ping event
        return false;
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

    public function getBranch(bool $split = true): string
    {
        $branch = $this->get('ref');
        if ($split && !empty($branch)) {
            $branch = explode('refs/heads/', $branch)[1] ?? '';
        }

        return $branch;
    }

    public function getTag(bool $split = true): string
    {
        $tag = $this->get('ref');
        if ($split && !empty($tag)) {
            $tag = explode('refs/tags/', $tag)[1] ?? '';
        }

        return $tag;
    }

    public function getCommits(): array
    {
        return $this->get('commits', []);
    }

    public function getHeadCommit(): array
    {
        $body = $this->getBody();
        $commit = $body['head_commit'] ?? [];
        if (empty($commit)) {
            $commits = $body['commits'] ?? [];
            $commit = array_shift($commits);
        }

        return $commit;
    }

    public function getCommitMessage(int $index = 0): string
    {
        $commits = $this->getCommits();

        return $commits[$index]['message'] ?? '';
    }

    public function getSshUrl(): string
    {
        $repo = $this->getRepository();

        return $repo['ssh_url'] ?? '';
    }

    public function getHeaderEvent(): string
    {
        return $this->getHookName();
    }
}
