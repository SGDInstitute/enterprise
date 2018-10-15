<template>
    <div>
        <button @click="start" class="text-grey"><i class="fa fa-info"></i></button>
        <v-tour name="inviteTour" :steps="steps"></v-tour>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                steps: [
                    {
                        target: '#me',
                        content: "I'm coming, add my information to this ticket."
                    },
                    {
                        target: '#manually',
                        content: 'Fill out attendee information manually.'
                    },
                    {
                        target: '#invite',
                        content: 'Invite attendees to fill out their own information by email.'
                    }
                ]
            }
        },
        methods: {
            start() {
                this.$tours['inviteTour'].start();
            }
        }
    }
</script>