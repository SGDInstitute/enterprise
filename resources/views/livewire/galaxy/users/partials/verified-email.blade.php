<div class="p-4 mb-8 border border-red-400 rounded-md bg-red-50 dark:bg-red-700">
    <div class="flex">
        <div class="flex-shrink-0">
            <x-dynamic-component component="heroicon-o-x-circle" class="w-5 h-5 text-red-300" />
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium leading-5 text-red-700 dark:text-red-100">
                Account Not Verified
            </h3>
            <div class="mt-2 text-sm leading-5 text-red-700 dark:text-red-100">
                <p>
                    This user has not verified their account. You can resend the verification email below.
                </p>
            </div>
            <div class="mt-4">
                <div class="-mx-2 -my-1.5 flex">
                    <button wire:click="resendVerification" class="px-2 py-1.5 rounded-md text-sm leading-5 font-medium text-red-800 dark:text-red-100 hover:bg-red-50 dark:hover:bg-red-800 focus:outline-none focus:bg-red-50">
                        Resend Verification Email
                    </button>
                    <button wire:click="markAsVerified" class="px-2 py-1.5 rounded-md text-sm leading-5 font-medium text-red-800 dark:text-red-100 hover:bg-red-50 dark:hover:bg-red-800 focus:outline-none focus:bg-red-50">
                        Mark as Verified
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
