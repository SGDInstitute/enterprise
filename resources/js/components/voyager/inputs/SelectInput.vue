<template>
    <div class="form-group">
        <label>
            <h2>{{ question.question }} <span v-show="question.required">*</span></h2>
            <p v-show="question.description" v-html="question.description"></p>

            <select :id="question.id + '_question'" class="form-control" multiple="multiple" v-if="question.multiple">
                <option v-for="choice in question.choices" :value="choice">{{ choice }}</option>
            </select>
            <select class="form-control" v-model="selected" v-else>
                <option v-for="choice in question.choices" :value="choice">{{ choice }}</option>
            </select>
        </label>
    </div>
</template>

<script>
    export default {
        props: ['question'],
        data() {
            return {
                selected: []
            }
        },
        mounted() {
            if(this.question.multiple) {
                let self = this,
                    $multiple = $('#' + this.question.id + '_question');

                $multiple.selectWoo({
                    tags: true
                });

                $multiple.on('change.selectWoo', function (e) {
                    self.selected = _.map($multiple.selectWoo('data'), 'text');
                });
            }
        },
        watch: {
            selected(value) {
                this.$emit('input', value)
            }
        }
    }
</script>
