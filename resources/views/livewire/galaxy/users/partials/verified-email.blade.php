<div class="mb-8 rounded-md border border-red-400 bg-red-50 p-4 dark:bg-red-700">
    <div class="flex">
        <div class="flex-shrink-0">
            <x-dynamic-component component="heroicon-o-x-circle" class="h-5 w-5 text-red-300" />
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium leading-5 text-red-700 dark:text-red-100">Account Not Verified</h3>
            <div class="mt-2 text-sm leading-5 text-red-700 dark:text-red-100">
                <p>This user has not verified their account. You can resend the verification email below.</p>
            </div>
            <div class="mt-4">
                <div class="-mx-2 -my-1.5 flex">
                    <button
                        wire:click="resendVerification"
                        class="rounded-md px-2 py-1.5 text-sm font-medium leading-5 text-red-800 hover:bg-red-50 focus:bg-red-50 focus:outline-none dark:text-red-100 dark:hover:bg-red-800"
                    >
                        Resend Verification Email
                    </button>
                    <button
                        wire:click="markAsVerified"
                        class="rounded-md px-2 py-1.5 text-sm font-medium leading-5 text-red-800 hover:bg-red-50 focus:bg-red-50 focus:outline-none dark:text-red-100 dark:hover:bg-red-800"
                    >
                        Mark as Verified
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
