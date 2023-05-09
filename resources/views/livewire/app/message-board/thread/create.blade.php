<div class="max-w-3xl mx-auto py-12">
    <h2 class="text-gray-900 dark:text-gray-200 text-2xl">Create a new post</h2>
    <p class="text-gray-700 dark:text-gray-400">Make sure you've read our rules before proceeding.</p>

    <form wire:submit.prevent="submit" class="mt-4">
        {{ $this->form }}
     
        <x-bit.button.flat.primary type="submit" class="mt-4">
            Submit
        </x-bit.button.flat.primary>
    </form>
</div>