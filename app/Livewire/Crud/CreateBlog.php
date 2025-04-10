<?php

namespace App\Livewire\Crud;

use session;
use App\Models\Post;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class CreateBlog extends Component
{
    #[Validate('required')]
    public $title = '';

    #[Validate('required')]
    public $content = '';

    public function save()
    {
        $this->validate();

        $user = Auth::user(); // Gets the authenticated user
        if (!$user) {
            session()->flash('message', 'User not found');
            return;
        }
        // Check if the user is approved
        if ($user->status !== User::STATUS_APPROVED) {
            session()->flash('message', 'Your account is not approved yet');
        }

        Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => $user->id,
            'tenant_id' => $user->tenant_id,
        ]);

        // Reset the form fields
        $this->reset();
        // Optionally, you can redirect or show a success message
        session()->flash('message', 'Post successfully Created.');
        return redirect()->route('dashboard');
    }
    public function render()
    {
        return view('livewire.crud.create-blog');
    }
}
