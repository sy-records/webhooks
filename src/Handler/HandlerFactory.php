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
use Luffy\WebHook\Interfaces\HandlerInterface;
use Psr\Http\Message\MessageInterface;

class HandlerFactory
{
    public static function create(MessageInterface $request): ?HandlerInterface
    {
        if ($request->hasHeader(Header::GITHUB_EVENT) && $request->hasHeader(Header::GOGS_EVENT) && !$request->hasHeader(Header::GITEA_EVENT)) {
            return new GogsHandler($request);
        }
        if ($request->hasHeader(Header::GITHUB_EVENT) && $request->hasHeader(Header::GITEA_EVENT) && $request->hasHeader(Header::GOGS_EVENT)) {
            return new GiteaHandler($request);
        }
        if ($request->hasHeader(Header::GITEE_EVENT)) {
            return new GiteeHandler($request);
        }
        if ($request->hasHeader(Header::GITHUB_EVENT)) {
            return new GitHubHandler($request);
        }
        if ($request->hasHeader(Header::GITLAB_EVENT)) {
            return new GitLabHandler($request);
        }

        return null;
    }
}
