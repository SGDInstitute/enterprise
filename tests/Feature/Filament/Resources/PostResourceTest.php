<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Resources\PostResource;
use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PostResourceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group('http_happy_path')]
    public function can_view_message_board_posts(): void
    {
        $user = User::factory()->admin()->create();
        Post::factory()->count(2)->create();

        $this->actingAs($user)
            ->get(PostResource::getUrl('index'))
            ->assertOk();
    }

    #[Test]
    public function can_view_posts_list(): void
    {
        $posts = Post::factory()->count(2)->create();

        Livewire::test(ListPosts::class)
            ->assertCanSeeTableRecords($posts);
    }

    #[Test]
    public function can_filter_by_if_approved(): void
    {
        $unapprovedPosts = Post::factory()->count(2)->create();
        $approvedPosts = Post::factory()->count(2)->approved()->create();

        Livewire::test(ListPosts::class)
            ->assertCanSeeTableRecords($unapprovedPosts)
            ->assertCanSeeTableRecords($approvedPosts)
            ->filterTable('approved')
            ->assertCanNotSeeTableRecords($unapprovedPosts)
            ->assertCanSeeTableRecords($approvedPosts);
    }

    #[Test]
    public function can_filter_by_if_not_approved(): void
    {
        $unapprovedPosts = Post::factory()->count(2)->create();
        $approvedPosts = Post::factory()->count(2)->approved()->create();

        Livewire::test(ListPosts::class)
            ->assertCanSeeTableRecords($unapprovedPosts)
            ->assertCanSeeTableRecords($approvedPosts)
            ->filterTable('needs-review')
            ->assertCanSeeTableRecords($unapprovedPosts)
            ->assertCanNotSeeTableRecords($approvedPosts);
    }
}
