<template>
    <div>
        <form-text-field :field="buildField('id', question.id)"></form-text-field>
        <form-text-field :field="buildField('question', question.question)"></form-text-field>
        <form-select-field :field="buildField('type', question.type, types)"></form-select-field>
        <form-text-field :field="buildField('rules', question.rules)"></form-text-field>
        <form-text-field :field="buildField('description', question.description)"></form-text-field>

        <div v-if="question.type === 'list' || question.type === 'select'">
            Choices
            Is Multiple Choice
            Is other
            Other wording
        </div>

        <div v-if="question.form">
            <p class="mb-4"><strong>Form:</strong></p>
            <questions :questions="question.form" form="true"></questions>
        </div>
    </div>
</template>

<script>
export default {
    props: ['question'],

    data() {
        return {
            types: [
                {label: 'list', value: 'list'},
                {label: 'opinion-scale', value: 'opinion-scale'},
                {label: 'repeat', value: 'repeat'},
                {label: 'section', value: 'section'},
                {label: 'select', value: 'select'},
                {label: 'textarea', value: 'textarea'},
                {label: 'text', value: 'text'}
            ]
        }
    },

    methods: {
        buildField(name, value, options) {
            let field = {
                "component":"text-field",
                "prefixComponent":true,
                "indexName": _.capitalize(name),
                "name": _.capitalize(name),
                "attribute": name,
                "value": value,
            };

            if(options) {
                field.options = options;
            }

            return field;
        }
    }
}
</script>
