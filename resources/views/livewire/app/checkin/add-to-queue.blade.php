<div>
    <ul role="list">
        <li>
            <div class="relative pb-4 md:pb-8">
                <div class="relative flex items-center space-x-3">
                    <span class="flex items-center justify-center w-8 h-8 text-xl text-gray-100 bg-green-500 rounded-full">
                        1
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-gray-700 dark:text-gray-200">Are your name and pronouns correct?</p>
                    </div>
                </div>

                <div class="p-2 mt-2 ml-8 space-y-2">
                    <x-form.group type="email" model="user.name" label="Name" />
                    <x-form.group type="text" model="user.pronouns" label="Pronouns" />
                </div>
            </div>
        </li>
        <li>
            <div class="relative pb-4 md:pb-8">
                <div class="relative flex items-center space-x-3">
                    <span class="flex items-center justify-center w-8 h-8 text-xl text-gray-100 bg-green-500 rounded-full">
                        2
                    </span>
                    <div class="flex-1 min-w-0">
                        <label class="text-gray-700 dark:text-gray-200">How would you like to receive conference update notifications?</label>
                    </div>
                </div>

                <div class="p-2 mt-2 ml-8 space-y-2">
                    <x-form.checkbox wire:model="user.notifications_via" name="notifications_via" value="mail" id="notification-email" label="Email" />
                    <x-form.checkbox wire:model="user.notifications_via" name="notifications_via" value="vonage" id="notification-phone" label="SMS Texts" />
                    <x-form.help>Notifications may include schedule changes, important updates, and survey invitations.</x-form.help>
                </div>
            </div>
        </li>
        <li>
            <div class="relative pb-8">
                <div class="relative flex items-center space-x-3">
                    <span class="flex items-center justify-center w-8 h-8 text-xl text-gray-100 bg-green-500 rounded-full">
                        3
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-gray-700 dark:text-gray-200">Does your phone/email look correct?</p>
                    </div>
                </div>

                <div x-data class="p-2 mt-2 ml-8 space-y-2">
                    <x-form.group type="email" model="user.email" label="Email" />
                    <x-form.group type="text" x-mask="(999) 999-9999" placeholder="(123)-555-1234" model="user.phone" label="Phone Number" />
                    <x-form.help>We will never sell your data, for more information see our <a href="https://sgdinstitute.org/legal-privacy" target="_blank" class="underline">privacy policy</a>.</x-form.help>
                </div>
            </div>
        </li>
    </ul>

    <x-bit.button.flat.primary block wire:click="add">All Set!</x-bit.button.flat.primary>
</div>
