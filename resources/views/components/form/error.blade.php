@props(['error' => false])

@if ($error)
    <div class="mt-1 text-sm text-red-500">{{ $error }}</div>
@endif
