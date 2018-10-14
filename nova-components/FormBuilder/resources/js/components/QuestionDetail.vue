<template>
    <div>
        <p class="leading-normal"><strong>ID:</strong> {{ question.id }}</p>
        <div v-if="question.type === 'repeat'">
            <p class="leading-normal"><strong>Question:</strong> {{ question.name }}</p>
            <p class="leading-normal"><strong>Button:</strong> {{ question.question }}</p>
        </div>
        <p v-else class="leading-normal"><strong>Question:</strong> {{ question.question }}</p>

        <p v-if="question.description" class="leading-normal"><strong>Description:</strong> {{ question.description }}</p>
        <p class="leading-normal"><strong>Type:</strong> {{ question.type }}</p>
        <p class="leading-normal"><strong>Rules:</strong> {{ question.rules }}</p>
        <div>
            <p v-if="question.choices" class="leading-normal"><strong>Choices:</strong></p>
            <ul>
                <li v-for="choice in question.choices" class="leading-normal">{{ choice }}</li>
            </ul>
        </div>
        <p v-if="question.multiple" class="leading-normal"><strong>Multiple Choice:</strong> {{ question.multiple }}</p>

        <p v-if="question.max_value" class="leading-normal"><strong>Max Value:</strong> {{ question.max_value }}</p>
        <p v-if="question.negative_label" class="leading-normal"><strong>Negative Label:</strong> {{ question.negative_label }}</p>
        <p v-if="question.positive_label" class="leading-normal"><strong>Positive Label:</strong> {{ question.positive_label }}</p>
        <p v-if="question.start_at_one" class="leading-normal"><strong>Start at One:</strong> {{ question.start_at_one }}</p>

        <p v-if="question.other" class="leading-normal"><strong>Other:</strong> {{ question.other }}, <strong>Wording:</strong> {{ question.other_wording}}</p>
        <div v-if="question.form">
            <p class="mb-4 leading-normal"><strong>Form:</strong></p>
            <questions v-model="question.form" detail="true"></questions>
        </div>
    </div>
</template>

<script>
export default {
    props: ['question'],
}
</script>
