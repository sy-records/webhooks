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
 * @see https://docs.gitlab.com/ee/user/project/integrations/webhook_events.html
 */
class GitLabHandler extends AbstractHandler
{
    public function isPing(): bool
    {
        // No ping event
        return false;
    }

    public function getHookName(): string
    {
        $name = $this->get('object_kind');

        return !empty($name) ? $name : $this->get('event_name');
    }

    public function getHookType(): string
    {
        return $this->get('event_type');
    }

    public function check(string $secret): bool
    {
        return $secret === $this->getRequest()->getHeaderLine(Header::GITLAB_TOKEN);
    }

    public function getSender(): array
    {
        $user = $this->get('user', []);
        if (empty($user)) {
            $user = [
                'id' => $this->get('user_id', 0),
                'name' => $this->get('user_name'),
                'username' => $this->get('user_username'),
                'avatar_url' => $this->get('user_avatar'),
                'email' => $this->get('user_email'),
            ];
        }

        return $user;
    }

    public function getRepository(): array
    {
        $body = $this->getBody();

        if (isset($body['project'])) {
            return $body['project'];
        }

        return $body['repository'] ?? [];
    }
}
