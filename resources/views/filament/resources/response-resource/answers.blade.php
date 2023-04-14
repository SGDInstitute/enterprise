<x-dynamic-component :component="$getFieldWrapperView()" :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()" :hint="$getHint()" :hint-action="$getHintAction()" :hint-color="$getHintColor()" :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$getStatePath()">
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}').defer }" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <template x-for="(answer, key) in state">
            <div class="filament-forms-field-wrapper">
                <div class="space-y-2">
                    <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                        <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse">
                            <span x-text="key" class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300"></span>
                        </label>
                    </div>
                    <div x-html="answer" class="filament-forms-placeholder-component"></div>
                </div>
            </div>
        </template>
    </div>
</x-dynamic-component>