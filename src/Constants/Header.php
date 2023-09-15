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

namespace Luffy\WebHook\Constants;

class Header
{
    public const GITEE_EVENT = 'x-gitee-event';

    public const GITEE_PING = 'x-gitee-ping';

    public const GITEE_TOKEN = 'x-gitee-token';

    public const GITEE_TIMESTAMP = 'x-gitee-timestamp';

    public const GITHUB_EVENT = 'x-github-event';

    public const GITHUB_SIGN = 'x-hub-signature-256';

    public const GITLAB_EVENT = 'x-gitlab-event';

    public const GITLAB_TOKEN = 'x-gitlab-token';

    public const GITEA_EVENT = 'x-gitea-event';

    public const GITEA_SIGN = 'x-gitea-signature';
}
