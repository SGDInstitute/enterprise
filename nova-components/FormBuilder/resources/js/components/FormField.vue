<template>
    <field-wrapper>
        <div class="w-1/5 px-8 py-6">
            <slot>
                <form-label :for="field.name">
                    {{ field.name }}
                </form-label>

                <help-text>
                    {{ field.helpText }}
                </help-text>
            </slot>
        </div>
        <div class="w-4/5 px-8 py-6">

            <questions v-model="field.value" form="true"></questions>

            <p v-if="hasError" class="my-2 text-danger">
                {{ firstError }}
            </p>
        </div>
    </field-wrapper>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
          this.value = JSON.stringify(this.field.value);
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
          formData.append(this.field.attribute, this.value || '')
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
          this.value = value
        }
    },
    watch: {
        field: {
            handler(){
                console.log('changed question');
                this.value = JSON.stringify(this.field.value);
            },
            deep: true
        }
    }
}
</script>
