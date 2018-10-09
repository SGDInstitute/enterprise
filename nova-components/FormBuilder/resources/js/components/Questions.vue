<template>
    <div>
        <div v-for="(question, key) in questions" class="border border-50 overflow-hidden">
            <a class="block bg-30 p-4 cursor-pointer border-b border-50 -mt-px" @click.prevent="opened = key">
                Question {{ key + 1 }}
            </a>
            <div class="p-4" :class="[isOpen(key) ? '' : 'hidden']">
                <question-detail v-if="detail" :question="question"></question-detail>
                <question-form v-if="form" :question="question"></question-form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['questions', 'detail', 'form'],

    data() {
        return {
            opened: 0,
        }
    },

    methods: {
        isOpen(key) {
            return this.opened === key;
        }
    }
}
</script>
