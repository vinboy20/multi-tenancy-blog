<form class="mx-auto max-w-md my-8" wire:submit="save">
    <div class="mb-5">
        <label for="title" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Title</label>
        <input type="text" wire:model="title" id="title" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500" required />
        <div>
            @error('title')
                <span class="text-red-400">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="mb-5">
        <label for="message" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Post</label>
        <textarea id="message" wire:model="content" rows="6" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"></textarea>
        <div>
            @error('content')
                <span class="text-red-400">{{ $message }}</span>
            @enderror
        </div>
    </div>
   
    <button type="submit" class="w-full rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 sm:w-auto dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
</form>
