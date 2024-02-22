<div class="mx-auto max-w-5xl px-4 pb-12 pt-4 md:px-12 md:py-12">
    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                Donation Information

                <span>{{ auth()->user()->subscribed('recurring-monthly') }}</span>
            </h3>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">Full name</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        {{ $donation->name }}
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">Email address</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        {{ $donation->email }}
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">Is Anonymous</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        {{ $donation->is_anonymous ? 'Yes' : 'No' }}
                    </dd>
                </div>

                @if ($donation->is_company)
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500">Company Name</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ $donation->company_name }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500">Company Tax ID</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ $donation->tax_id }}
                        </dd>
                    </div>
                @endif

                @if ($donation->type === 'monthly')
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500">Invoices</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <ul role="list" class="divide-y divide-gray-200 rounded-md border border-gray-200">
                                <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                    <div class="flex w-0 flex-1 items-center">
                                        <!-- Heroicon name: solid/paper-clip -->
                                        <svg
                                            class="h-5 w-5 flex-shrink-0 text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        <span class="ml-2 w-0 flex-1 truncate">resume_back_end_developer.pdf</span>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                            Download
                                        </a>
                                    </div>
                                </li>
                                <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                    <div class="flex w-0 flex-1 items-center">
                                        <!-- Heroicon name: solid/paper-clip -->
                                        <svg
                                            class="h-5 w-5 flex-shrink-0 text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        <span class="ml-2 w-0 flex-1 truncate">coverletter_back_end_developer.pdf</span>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                            Download
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>
</div>
