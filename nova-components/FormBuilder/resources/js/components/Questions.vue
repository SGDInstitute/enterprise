<template>
    <div>
        <div v-if="detail">
            <div v-for="(question, key) in questions" :key="question.id" class="border border-50 overflow-hidden">
                <a class="block bg-30 p-4 cursor-pointer border-b border-50 -mt-px" @click.prevent="open(key)">
                    <span v-if="question.question">{{ question.question }}</span>
                    <span v-else>Question {{ key + 1 }}</span>
                    <span v-if="question.type" class="ml-2 text-sm text-80">({{ question.type }})</span>
                </a>
                <div class="p-4" :class="[isOpen(key) ? '' : 'hidden']">
                    <question-detail :question="question"></question-detail>
                </div>
            </div>
        </div>
        <div v-else>
            <draggable v-model="questions" :options="{disabled: hasOpenedQuestion}" @start="drag=true" @end="drag=false">
                <div v-for="(question, key) in questions" :key="key" class="question border border-50 overflow-hidden">
                    <a class="block bg-30 p-4 cursor-pointer border-b border-50 -mt-px" @click.prevent="open(key)">
                        <svg class="handle fill-current mr-4 h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                        <span v-if="question.question">{{ question.question }}</span>
                        <span v-else>Question {{ key + 1 }}</span>
                        <span v-if="question.type" class="ml-2 text-sm text-80">({{ question.type }})</span>
                    </a>
                    <div class="p-4" :class="[isOpen(key) ? '' : 'hidden']">
                        <question-form v-model="questions[key]"></question-form>
                    </div>
                </div>
            </draggable>
            <button @click.prevent="addQuestion" class="mt-4 btn btn-default btn-primary">Add Question</button>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'

    export default {
        props: ['value', 'detail', 'form'],

        data() {
            return {
                opened: 0,
                questions: this.value,
            }
        },

        methods: {
            isOpen(key) {
                return this.opened === key;
            },
            open(key) {
                if (this.opened === key) {
                    this.opened = false;
                }
                else {
                    this.opened = key;
                }
            },
            addQuestion() {
                this.questions.push({});
            }
        },

        computed: {
            hasOpenedQuestion() {
                return this.opened !== false;
            }
        },

        watch: {
            questions() {
                this.$emit('input', this.questions);
            }
        },

        components: {
            draggable,
        },
    }
</script>
