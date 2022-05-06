<div class="pt-4 mt-8 space-y-6 border-t border-gray-200 dark:border-gray-800">
    <h2 class="text-xl dark:text-gray-200">Extra Questions</h2>

    @forelse ($form as $index => $question)
        @includeWhen($question['style'] === 'question', 'livewire.galaxy.forms.question')
        @includeWhen($question['style'] === 'content', 'livewire.galaxy.forms.content')
        @includeWhen($question['style'] === 'collaborators', 'livewire.galaxy.forms.collaborators')
    @empty
    <div class="p-4 rounded-md dark:bg-gray-700">
        <p class="dark:text-gray-200">This form is empty! Get started by adding a content section or a question below.</p>
    </div>
    @endforelse

    <x-bit.button.round.secondary wire:click="addQuestion">Add Question</x-bit.button.round.secondary>
</div>
