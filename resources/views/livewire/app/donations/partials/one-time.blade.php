<p class="text-lg font-bold text-center text-gray-900 dark:text-gray-200">Choose an amount to give today</p>

<div class="grid grid-cols-3 gap-2">
    @foreach ($oneTimeOptions as $option)
    <button class="btn btn-base btn-block {{ $form['amount'] == $option ? 'btn-green' : 'btn-gray' }}" id="one-time-button-{{ $option }}" wire:click="chooseAmount({{ $option }})">${{ $option }}</button>
    @endforeach
    @if($otherAmount)
    <x-bit.input.group for="other-amount" class="col-span-2" label="Other Amount" sr-only>
        <x-bit.input.text id="other-amount" class="block w-full" type="number" name="other-amount" wire:model="form.amount" placeholder="Other Amount" required leading-add-on="$" />
    </x-bit.input.group>
    @else
    <button class="col-span-2 btn-gray btn btn-base btn-block" wire:click="chooseOther">Other Amount</button>
    @endif
</div>
