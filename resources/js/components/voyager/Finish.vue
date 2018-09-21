<template>
    <section :id="id"  class="finish">
        <div class="container">
            <h1>Thank You!</h1>
            <p class="large-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A atque dicta dolor earum excepturi explicabo
                harum ipsa labore libero, maiores maxime modi nam nostrum praesentium quasi sequi sint suscipit
                veritatis.</p>
            <button type="button" class="btn flat-btn flat-btn-mint btn-lg smooth" @click.prevent="save" :disabled="form.busy">Save Answers!</button>
        </div>
    </section>
</template>

<script>
    export default {
        props: ['survey'],
        computed: {
            id() {
                return 'question-' + this.survey.form.length;
            }
        }
    }
</script>

<style>
    .finish {
        height: 100vh;
        display: flex;
        align-items: center;
    }
    .large-text {
        font-size: 16px;
    }
</style>