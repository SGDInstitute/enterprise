@props(['notification', 'key'])

<div class="w-64 mb-2 bg-white rounded-lg shadow-lg pointer-events-auto md:w-96" x-data="{ dismissed: false }"
    x-init="dismissed = false; setTimeout(function(){ dismissed = true; window.livewire.emit('dismiss', {{ $key }}) }, 3000)"
    x-show="!dismissed">
    <div class="overflow-hidden rounded-lg shadow-xs">
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    @if ($notification['type'] === 'success')
                    <x-heroicon-o-check-circle class="w-6 h-6 text-green-400" />
                    @elseif ($notification['type'] === 'error')
                    <x-heroicon-o-exclamation class="w-6 h-6 text-red-400" />
                    @elseif ($notification['type'] === 'info')
                    <x-heroicon-o-information-circle class="w-6 h-6 text-blue-400" />
                    @endif
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium leading-5 text-gray-800">
                        {{ $notification['message'] ?? 'no message' }}
                    </p>
                </div>
                <div class="flex flex-shrink-0 ml-4">
                    <button wire:click="dismiss({{ $key }})"
                        class="inline-flex text-gray-400 transition duration-150 ease-in-out focus:outline-none focus:text-gray-500">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
