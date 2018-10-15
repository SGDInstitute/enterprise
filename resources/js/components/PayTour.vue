<template>
    <div>
        <button @click="start" class="text-grey"><i class="fa fa-info"></i></button>
        <v-tour name="payTour" :steps="steps"></v-tour>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                steps: [
                    {
                        target: '#pay',
                        content: `Discover <strong>Vue Tour</strong>!`
                    },
                    {
                        target: '#invoice',
                        content: 'An awesome plugin made with Vue.js!'
                    }
                ]
            }
        },
        methods: {
            start() {
                this.$tours['payTour'].start();
            }
        }
    }
</script>