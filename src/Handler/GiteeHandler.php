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

use Luffy\WebHook\Constants\Header;

/**
 * @see https://gitee.com/help/articles/4186
 */
class GiteeHandler extends AbstractHandler
{
    public function isPing(): bool
    {
        return $this->getRequest()->getHeaderLine(Header::GITEE_PING) === 'true';
    }

    public function getHookName(): string
    {
        return $this->get('hook_name');
    }

    public function getHookType(): string
    {
        return $this->get('noteable_type');
    }

    public function check(string $secret): bool
    {
        $password = $this->get('password');
        if (!empty($password)) {
            return $secret === $password;
        }
        $sign = $this->getRequest()->getHeaderLine(Header::GITEE_TOKEN);
        $timestamp = $this->getRequest()->getHeaderLine(Header::GITEE_TIMESTAMP);

        $secret_str = "{$timestamp}\n{$secret}";
        $compute_token = base64_encode(hash_hmac('sha256', $secret_str, $secret, true));
        if ($sign !== $compute_token) {
            return false;
        }

        return true;
    }

    public function getSender(): array
    {
        return $this->get('sender', []);
    }
}
