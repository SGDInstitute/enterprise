<template>
    <div>
        <div v-for="(question) in form">
            <answer-detail v-if="type === 'detail'" :question="question" :answers="answers"></answer-detail>
            <answer-form v-else :question="question" :answers="answers"></answer-form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['value', 'type', 'form'],

        data() {
            return {
                answers: this.value,
            }
        }
    }
</script>
