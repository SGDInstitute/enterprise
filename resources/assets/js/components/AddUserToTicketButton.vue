<template>
    <a href="#" @click.prevent="submit">
        Add my information
    </a>
</template>

<script>
    export default {
        props: ['ticket', 'user'],
        data() {
            return {
                form: new SparkForm({
                    'user_id': this.user
                })
            }
        },
        methods: {
            submit() {
                Spark.patch('/tickets/' + this.ticket, this.form)
                    .then(response => {
                        location.reload();
                    })
            }
        }
    }
</script>