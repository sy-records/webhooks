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

class Type
{
    public const GITHUB_PUSH = 'push';

    public const GITHUB_TAG_PUSH = 'push';

    public const GITEE_PUSH = 'push_hooks';

    public const GITEE_TAG_PUSH = 'tag_push_hooks';

    public const GITLAB_PUSH = 'push';

    public const GITLAB_TAG_PUSH = 'tag_push';
}
