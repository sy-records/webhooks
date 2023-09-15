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

    public function getBranch(bool $split = true): string;

    public function getTag(bool $split = true): string;

    public function getCommits(): array;

    public function getHeadCommit(): array;

    public function getCommitMessage(int $index = 0): string;

    public function getSshUrl(): string;

    public function getHeaderEvent(): string;
}
