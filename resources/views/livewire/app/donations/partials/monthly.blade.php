<p class="text-lg font-bold text-center text-gray-900 dark:text-gray-200">Choose amount to give monthly</p>

<div class="grid grid-cols-3 gap-2">
    @foreach ($monthlyOptions as $option)
    <button class="btn btn-base btn-block {{ $form['amount'] == $option ? 'btn-green' : 'btn-gray' }}" id="monthly-button-{{ $option }}" wire:click="chooseAmount({{ $option }})">${{ $option }}</button>
    @endforeach
</div>
