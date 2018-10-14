<template>
    <div class="form-group" :class="{'has-error': form.errors.has(question.id)}">
        <div v-if="question.type !== 'select'">
            <label :for="question.id">
                <h2>{{ question.question }} <span v-show="question.required">*</span></h2>
            </label>
            <p v-show="question.description" v-html="question.description"></p></div>

        <component :is="question.type + '-input'" :question="question"
                   v-model="form[question.id]"></component>

        <span class="mt-2 rounded border border-red block bg-red-lightest px-4 py-2 text-red-darkest" v-show="form.errors.has(question.id)">
                        {{ form.errors.get(question.id) }}
                    </span>
        <a :href="nextId(index)" class="btn btn-primary smooth"
           v-if="nextIsSection(index) || question.type === 'section'">Next!</a>
    </div>
</template>

<script>
    export default {
        props: ['value'],

        data() {
            return {
                question: this.value,
            }
        },

        methods: {
            buildField(name, value, options) {
                let field = {
                    "component": "text-field",
                    "prefixComponent": true,
                    "indexName": _.capitalize(name),
                    "name": _.capitalize(_.replace(name, '_', ' ')),
                    "attribute": name,
                    "value": value,
                };

                if (options) {
                    field.options = options;
                }

                return field;
            }
        }
    }
</script>
