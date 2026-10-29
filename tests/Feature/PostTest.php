<?php

use App\Models\Post;
use App\Models\User;

test('guests are redirected to login when visiting posts', function () {
    $this->get(route('posts.index'))->assertRedirect(route('login'));
});

test('an authenticated user can create update view and delete a post', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('posts.store'), [
            'title' => 'First post',
            'body' => 'Post content',
        ])
        ->assertRedirect();

    $post = Post::where('title', 'First post')->firstOrFail();
    $this->assertSame($user->id, $post->user_id);

    $this->get(route('posts.show', $post))
        ->assertOk()
        ->assertSee('First post')
        ->assertSee('Post content');

    $this->put(route('posts.update', $post), [
        'title' => 'Updated post',
        'body' => 'Updated content',
    ])->assertRedirect(route('posts.show', $post));

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Updated post',
        'body' => 'Updated content',
    ]);

    $this->delete(route('posts.destroy', $post))
        ->assertRedirect(route('posts.index'));

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});

test('a user cannot view or change another users post', function () {
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = $owner->posts()->create([
        'title' => 'Private post',
        'body' => 'Only its author can manage this post.',
    ]);

    $this->actingAs($otherUser)
        ->get(route('posts.show', $post))
        ->assertNotFound();

    $this->put(route('posts.update', $post), [
        'title' => 'Changed by someone else',
        'body' => 'This should not be saved.',
    ])->assertNotFound();

    $this->delete(route('posts.destroy', $post))
        ->assertNotFound();

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Private post',
    ]);
});

test('post fields are required', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('posts.store'), [])
        ->assertSessionHasErrors(['title', 'body']);
});
