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
                        content: 'Pay with a credit card or by check.'
                    },
                    {
                        target: '#invoice',
                        content: 'Or create an invoice to pay within 60 days.'
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