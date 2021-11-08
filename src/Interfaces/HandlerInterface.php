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
namespace Luffy\WebHook\Interfaces;

interface HandlerInterface
{
    public function isPing(): bool;

    public function getHookName(): string;

    public function getHookType(): string;

    public function getCommitId(): string;

    public function getAfterCommitId(): string;

    public function getRepository(): array;

    public function check(string $secret): bool;

    public function getSender(): array;
}
