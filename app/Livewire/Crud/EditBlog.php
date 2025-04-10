<?php

namespace App\Livewire\Crud;

use session;
use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Validate;

class EditBlog extends Component
{
    public Post $post;
    #[Validate('required')]
    public $title = '';

    #[Validate('required')]
    public $content = '';

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->fill($post->only('title', 'content'));
    }

    public function edit()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $this->post->update([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        session()->flash('message', 'Post updated!');
        return redirect()->route('dashboard');
    }
    public function render()
    {
        return view('livewire.crud.edit-blog');
    }
}
