<?php

namespace App\Notifications;

use App\Models\Event;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Slack\BlockKit\Blocks\ActionsBlock;
use Illuminate\Notifications\Slack\BlockKit\Blocks\ContextBlock;
use Illuminate\Notifications\Slack\BlockKit\Blocks\SectionBlock;
use Illuminate\Notifications\Slack\SlackMessage;
use League\HTMLToMarkdown\HtmlConverter;

class PostCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Event $event, public Post $post)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['slack'];
    }

    public function toSlack(object $notifiable): SlackMessage
    {
        return (new SlackMessage)
            ->headerBlock("New {$this->event->name} Post")
            ->contextBlock(function (ContextBlock $block) {
                $block->text('User ' . $this->post->user->formattedName);
            })
            ->sectionBlock(function (SectionBlock $block) {
                $block->field($this->post->title);
                $block->field($this->post->tags->count() > 0 ? $this->post->tags->implode('name', ', ') : 'none');
            })
            ->sectionBlock(function (SectionBlock $block) {
                $markdown = (new HtmlConverter())->convert($this->post->content);
                $block->text($markdown)->markdown();
            })
            ->actionsBlock(function (ActionsBlock $block) {
                $block->button('Approve')->primary()->id('approve_post')->value($this->post->id);

                $block->button('Deny')->danger()->id('deny_post')->value($this->post->id);
            });
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
