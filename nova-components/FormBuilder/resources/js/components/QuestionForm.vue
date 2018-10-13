<template>
    <div>
        <div class="flex">
            <div class="w-1/4 px-8 pb-4"><label for="id" class="inline-block text-80 pt-2 leading-tight">ID</label></div>
            <div class="w-1/2 px-8 pb-4">
                <input id="id" v-model="question.id" placeholder="ID" type="text"
                       class="w-full form-control form-input form-input-bordered">
            </div>
        </div>
        <div class="flex">
            <div class="w-1/4 px-8 pb-4"><label for="question" class="inline-block text-80 pt-2 leading-tight">Question</label></div>
            <div class="w-1/2 px-8 pb-4">
                <input id="question" v-model="question.question" placeholder="Question" type="text"
                       class="w-full form-control form-input form-input-bordered">
            </div>
        </div>
        <div class="flex">
            <div class="w-1/4 px-8 pb-4"><label for="type" class="inline-block text-80 pt-2 leading-tight">Type</label></div>
            <div class="w-1/2 px-8 pb-4">
                <select id="type" v-model="question.type" class="w-full form-control form-input form-input-bordered">
                    <option v-for="type in types" :value="type">{{ type }}</option>
                </select>
            </div>
        </div>
        <div class="flex">
            <div class="w-1/4 px-8 pb-4"><label for="rules" class="inline-block text-80 pt-2 leading-tight">Rules</label></div>
            <div class="w-1/2 px-8 pb-4">
                <input id="rules" v-model="question.rules" placeholder="Rules" type="text"
                       class="w-full form-control form-input form-input-bordered">
            </div>
        </div>
        <div class="flex">
            <div class="w-1/4 px-8 pb-4"><label for="description" class="inline-block text-80 pt-2 leading-tight">Description</label></div>
            <div class="w-1/2 px-8 pb-4">
                <input id="description" v-model="question.description" placeholder="Description" type="text"
                       class="w-full form-control form-input form-input-bordered">
            </div>
        </div>

        <div v-if="question.type === 'list' || question.type === 'select'">
            <div class="flex">
                <div class="w-1/4 px-8 pb-4"><label for="multiple" class="inline-block text-80 pt-2 leading-tight">Multiple Choice?</label></div>
                <div class="w-1/2 px-8 pb-4">
                    <input id="multiple" v-model="question.multiple" placeholder="Other Wording" type="checkbox">
                </div>
            </div>
            <div class="flex">
                <div class="w-1/4 px-8 pb-4"><label for="other" class="inline-block text-80 pt-2 leading-tight">Other Option?</label></div>
                <div class="w-1/2 px-8 pb-4">
                    <input id="other" v-model="question.other" placeholder="Other Wording" type="checkbox">
                </div>
            </div>
            <div class="flex" v-if="question.other">
                <div class="w-1/4 px-8 pb-4"><label for="other_wording" class="inline-block text-80 pt-2 leading-tight">Other Wording</label></div>
                <div class="w-1/2 px-8 pb-4">
                    <input id="other_wording" v-model="question.other_wording" placeholder="Other Wording" type="text"
                           class="w-full form-control form-input form-input-bordered">
                </div>
            </div>
            <choices v-model="question.choices"></choices>
        </div>

        <div v-if="question.form">
            <p class="mb-4"><strong>Form:</strong></p>
            <questions :questions="question.form" form="true"></questions>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['value'],

        data() {
            return {
                types: [
                    'list', 'opinion-scale', 'repeat', 'section', 'select', 'textarea', 'text'
                ],
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
