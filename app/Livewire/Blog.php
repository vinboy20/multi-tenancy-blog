<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Blog extends Component
{
    public $posts;
   
    public function mount()
    {
        $this->loadPosts();
    }

    public function loadPosts()
    {
        $this->posts = Post::where('user_id', Auth::id())->latest()->get();
    }

    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('message', 'Post deleted successfully');
        $this->loadPosts();
    }

  
    public function render()
    {
        return view('livewire.blog');
    }
}
