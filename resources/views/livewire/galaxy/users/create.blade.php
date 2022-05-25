<div class="md:w-1/2">
    <form wire:submit.prevent="save">
        <x-ui.card>
            <x-ui.card.header title="Profile"/>
            <div class="p-4 space-y-4">
                <x-form.group model="user.name" label="Name" type="text" />
                <x-form.group model="user.email" label="Email" type="email" />
                <x-form.group model="user.pronouns" label="Pronouns" type="text" />
                <x-form.group model="role" label="Role" type="select" placeholder="Select role (optional)" :options="$roles" />
            </div>
            <x-ui.card.footer>
                <button wire:click="save" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Save</button>
            </x-ui.card.footer>
        </x-ui.card>
    </form>
</div>
