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
namespace Luffy\WebHook\Interfaces;

interface WebHookInterface
{
    public function isGiteeEvent(): bool;

    public function isGitHubEvent(): bool;

    public function isGitLabEvent(): bool;

    public function getHeaderEvent(): string;
}
