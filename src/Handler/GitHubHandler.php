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

use Luffy\WebHook\Constants\Header;

/**
 * @see https://docs.github.com/en/developers/webhooks-and-events/webhooks/webhook-events-and-payloads
 */
class GitHubHandler extends AbstractHandler
{
    public function isPing(): bool
    {
        return $this->getRequest()->getHeaderLine(Header::GITHUB_EVENT) === 'ping';
    }

    public function getHookName(): string
    {
        return $this->getRequest()->getHeaderLine(Header::GITHUB_EVENT);
    }

    public function getHookType(): string
    {
        return $this->get('action');
    }

    public function check(string $secret): bool
    {
        $sign = $this->getRequest()->getHeaderLine(Header::GITHUB_SIGN);
        [$algo, $hash] = explode('=', $sign, 2);
        $payloadHash = hash_hmac($algo, $this->request->getBody()->getContents(), $secret);

        return $hash === $payloadHash;
    }

    public function getSender(): array
    {
        return $this->get('sender', []);
    }
}
