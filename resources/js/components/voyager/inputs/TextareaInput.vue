<template>
    <div class="form-group">
        <textarea :name="question.id" :id="question.id" class="form-control" v-model="text" rows="7"></textarea>
    </div>
</template>

<script>
    export default {
        props: ['question'],
        data() {
            return {
                text: ''
            }
        },
        watch: {
            text(value) {
                this.$emit('input', value)
            }
        }
    }
</script>
