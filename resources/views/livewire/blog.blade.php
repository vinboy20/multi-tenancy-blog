<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('posts.create') }}" 
           class="rounded-lg bg-gray-700 px-4 py-2 text-white hover:bg-gray-900">
            Create New Post
        </a>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-left text-sm text-gray-500">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">Title</th>
                    <th scope="col" class="px-6 py-3">Content</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr class="border-b border-gray-200 bg-white">
                        <td class="px-6 py-4">{{ $post->title }}</td>
                        <td class="px-6 py-4">{{ Str::limit($post->content, 50) }}</td>
                        <td class="px-6 py-4">
                            <a wire:navigate href="{{ route('posts.edit', $post->id) }}" class="text-blue-600 hover:text-blue-800 mr-2">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a wire:navigate href="{{ route('posts.edit', $post->id) }}" class="text-green-600 hover:text-green-800 mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button wire:click="delete({{ $post->id }})" 
                                    onclick="return confirm('Are you sure?')"
                                    class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-4 text-center text-gray-500">No posts found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush