<template>
    <section class="welcome">
        <div class="container">
            <h1>{{ survey.name }}</h1>
            <p class="large-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A atque dicta dolor earum excepturi explicabo
                harum ipsa labore libero, maiores maxime modi nam nostrum praesentium quasi sequi sint suscipit
                veritatis.</p>
            <a href="#question-0" class="btn flat-btn flat-btn-mint btn-lg smooth">Lets Do This!</a>
        </div>
    </section>
</template>

<script>
    export default {
        props: ['survey']
    }
</script>

<style>
    .welcome {
        height: 100vh;
        display: flex;
        align-items: center;
    }
    .large-text {
        font-size: 16px;
    }
</style>