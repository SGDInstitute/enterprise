<template>
    <div>
        <p><strong>ID:</strong> {{ question.id }}</p>
        <div v-if="question.type === 'repeat'">
            <p><strong>Question:</strong> {{ question.name }}</p>
            <p><strong>Button:</strong> {{ question.question }}</p>
        </div>
        <p v-else><strong>Question:</strong> {{ question.question }}</p>

        <p v-if="question.description"><strong>Description:</strong> {{ question.description }}</p>
        <p><strong>Type:</strong> {{ question.type }}</p>
        <p><strong>Rules:</strong> {{ question.rules }}</p>
        <div>
            <p v-if="question.choices"><strong>Choices:</strong></p>
            <ul>
                <li v-for="choice in question.choices">{{ choice }}</li>
            </ul>
        </div>
        <p v-if="question.multiple"><strong>Multiple Choice:</strong> {{ question.multiple }}</p>
        <p v-if="question.other"><strong>Other:</strong> {{ question.other }}, <strong>Wording:</strong> {{ question.other_wording}}</p>
        <div v-if="question.form">
            <p class="mb-4"><strong>Form:</strong></p>
            <questions :questions="question.form" detail="true"></questions>
        </div>
    </div>
</template>

<script>
export default {
    props: ['question'],
}
</script>
