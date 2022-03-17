@if ($item['type'] === 'textarea')
    @include('livewire.app.forms.partials.question-textarea')
@elseif ($item['type'] === 'text')
    @include('livewire.app.forms.partials.question-text')
@elseif ($item['type'] === 'list')
    @include('livewire.app.forms.partials.question-list')
@elseif ($item['type'] === 'matrix')
    @include('livewire.app.forms.partials.question-matrix')
@else
    {!! json_encode($item) !!}
@endif
