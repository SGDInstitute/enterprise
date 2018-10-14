<template>
    <div>
        <div v-for="(question) in form">
            <p class="leading-normal">
                <strong class="mr-2">{{ question.question }}:</strong>
                <span v-if="question.type === 'repeat'">
                    <div v-for="answer in realLookup(question.id)" class="ml-4">
                        <div v-for="q in question.form">
                            <p class="leading-normal">
                                <strong class="mr-2">{{ q.question }}:</strong>
                                <span>{{ lookupAnswer(q.id, answer) }}</span>
                            </p>
                        </div>
                    </div>
                </span>
                <span v-else>{{ lookupAnswer(question.id, answers) }}</span>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['value', 'type', 'form'],

        data() {
            return {
                answers: this.value,
            }
        },

        methods: {
            lookupAnswer(id, answers) {
                let answer = answers[id];
                if (typeof answer === 'object') {
                    return _.values(answer).join(', ');
                }
                if (typeof answer === 'array') {
                    return answer.join(', ');
                }
                return answer;
            },
            realLookup(id) {
                return this.answers[id];
            }
        }
    }
</script>
