<div class="space-y-4">
    <div class="w-1/2 p-4 bg-white rounded-md shadow dark:bg-gray-800">
        <p class="text-gray-900 dark:text-gray-200">ID: {{ $donation->id }}</p>
        <p class="text-gray-900 dark:text-gray-200">User:: {{ $donation->user->name }}</p>
        <p class="text-gray-900 dark:text-gray-200">Transaction ID: {{ $donation->transaction_id }}</p>
        <p class="text-gray-900 dark:text-gray-200">Subscription ID: {{ $donation->subscription_id }}</p>
        <p class="text-gray-900 dark:text-gray-200">Amount: {{ $donation->formattedAmount }}</p>
        <p class="text-gray-900 dark:text-gray-200">Type: {{ $donation->formattedType }}</p>
        <p class="text-gray-900 dark:text-gray-200">Status: {{ $donation->status }}</p>
    </div>

    <div class="w-1/2 p-4 bg-white rounded-md shadow dark:bg-gray-800">
        <p class="text-gray-900 dark:text-gray-200">Address: {{ $donation->user->formattedAddress }}</p>
    </div>
</div>
