<div x-data="{tab: @entangle('tab').live}" class="lg:grid lg:grid-cols-12 lg:gap-x-5">
    <x-ui.aside colspan="lg:col-span-2">
        <x-ui.aside.button tab="info" icon="heroicon-o-information-circle">Information</x-ui.aside.button>
        <x-ui.aside.button tab="builder" icon="heroicon-o-cursor-arrow-rays">Builder</x-ui.aside.button>
    </x-ui.aside>

    <div x-show="tab === 'info'" class="space-y-6 sm:px-6 lg:px-0 lg:col-span-10">
        <form wire:submit="saveInfo">
            <x-ui.card>
                <div class="px-4 py-6 space-y-6 sm:p-6">
                    <div>
                        <h2 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">Information</h2>
                    </div>
                    <div x-data="{type: @entangle('form.type').live}" class="grid grid-cols-2 gap-6">
                        <x-form.group model="form.type" label="Type" type="select" placeholder="Select Form Type" :options="$types" />

                        <x-form.group x-show="type && type === 'review' || type === 'availability' || type === 'confirmation' || type === 'finalize'" model="form.parent_id" label="Parent Form" type="select" placeholder="Select Parent Form" :options="$forms" />
                        <x-form.group x-show="type" model="form.name" label="Name of Form" type="text" />
                        <x-form.group x-show="type" model="form.event_id" label="Event" type="select" placeholder="Select Event" :options="$events" />
                        <x-form.group x-show="type" model="formattedStart" label="Availability Start" type="date" />
                        <x-form.group x-show="type" model="formattedEnd" label="Availability End" type="date" />
                        <x-form.group x-show="type" model="form.timezone" label="Timezone" type="select" placeholder="Select Timezone" :options="$timezones" />
                        <x-form.group x-show="type" model="form.auth_required" label="Auth Required" type="boolean" />
                        <x-form.group x-show="type" model="form.is_internal" label="Internal" type="boolean" />

                        @if ($form->form && $form->form->isNotEmpty())
                        <x-form.group x-show="type" model="searchable" label="Visable columns" type="select" :options="$searchableFields" multiple />
                        @endif
                    </div>
                </div>
                <x-ui.card.footer>
                    <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Save</button>
                </x-ui.card.footer>
            </x-ui.card>
        </form>
    </div>

    <div x-show="tab === 'builder'" class="lg:col-span-10">
        @if ($form->type === 'rubric')
        <livewire:galaxy.builder.table :table="$builder" :model="$form" />
        @else
        <livewire:galaxy.builder.form :form="$builder" :model="$form" />
        @endif
    </div>

</div>