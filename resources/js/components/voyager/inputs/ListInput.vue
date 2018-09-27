<template>
    <div>
        <div :class="type" v-for="choice in choices">
            <label v-if="type === 'radio'">
                <input type="radio" :class="question.id" :value="choice" v-model="selected">
                {{ choice }}
            </label>
            <label v-if="type === 'checkbox'">
                <input type="checkbox" :class="question.id" :value="choice" v-model="chosen">
                {{ choice }}
            </label>
        </div>

        <input v-show="showOtherInput" type="text" class="form-control" v-model="input" :id="question.id">
    </div>
</template>

<script>
    export default {
        props: ['question'],
        data() {
            return {
                selected: '',
                chosen: [],
                input: ''
            }
        },
        computed: {
            type() {
                return (this.question.multiple) ? 'checkbox' : 'radio';
            },
            showOtherInput() {
                return this.question.other === true && (this.selected === this.otherWording || _.indexOf(this.chosen, this.otherWording) !== -1);
            },
            choices() {
                if (this.question.other) {
                    this.question.choices.push(this.otherWording);
                    return this.question.choices;
                }

                return this.question.choices;
            },
            otherWording() {
                if (typeof this.question.other_wording === "undefined" || this.question.other_wording === null) {
                    return 'Other';
                }

                return this.question.other_wording;
            }
        },
        watch: {
            selected(value) {
                this.$emit('input', value)
            },
            chosen(value) {
                this.$emit('input', value)
            },
            /*input(value) {
                if(!_.isEmpty(this.chosen)) {
                    this.chosen.push(value);
                }
                else {
                    this.$emit('input', value)
                }
            },*/
        }
    }
</script>
