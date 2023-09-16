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
 * @see https://gogs.io/docs/features/webhook
 */
class GogsHandler extends AbstractHandler
{
    public function getHookName(): string
    {
        return $this->getRequest()->getHeaderLine(Header::GOGS_EVENT);
    }

    public function getHookType(): string
    {
        return $this->getRequest()->getHeaderLine(Header::GOGS_EVENT);
    }

    public function check(string $secret): bool
    {
        $sign = $this->getRequest()->getHeaderLine(Header::GOGS_SIGN);
        $payloadHash = hash_hmac('sha256', $this->request->getBody()->getContents(), $secret, false);

        return $sign === $payloadHash;
    }

    public function getSender(): array
    {
        return $this->get('sender', []);
    }
}
