<template>
    <div class="flex">
        <div class="w-1/4 px-8 pb-4"><label for="id" class="inline-block text-80 pt-2 leading-tight">Choices</label></div>
        <div class="w-2/3 px-8 pb-4">
            <ul>
                <li v-for="(choice, key) in choices">
                    <input :id="'id' + key" v-model="choices[key]" placeholder="Choice" type="text"
                           class="appearance-none bg-transparent border-none w-full text-80 py-1 px-2 leading-tight">
                </li>
            </ul>
            <button @click.prevent="addChoice" class="mt-4 btn btn-default btn-primary">Add Choice</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['value'],

        data() {
            return {
                choices: this.value,
            }
        },
        methods: {
            addChoice() {
                this.choices.push('');
            }
        }
    }
</script>
