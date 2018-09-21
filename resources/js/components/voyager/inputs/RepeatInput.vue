<template>
    <div>
        <button class="btn btn-primary mb-4" @click.prevent="add">Add {{ question.name }}</button>

        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default" v-for="(repeat, index) in repeated">
                <div class="panel-heading" role="tab" :id="'heading' + index">

                    <a role="button" class="pull-right" @click.prevent="remove(index)">Remove {{ question.name }}</a>

                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" :href="'#collapse' + index"
                           aria-expanded="true" aria-controls="'#collapse' + index">
                            {{ question.name }} #{{ index + 1 }}
                        </a>
                    </h4>
                </div>
                <div :id="'collapse' + index" :class="(question.required && index == 0) ? 'panel-collapse collapse in' : 'panel-collapse collapse'" role="tabpanel"
                     :aria-labelledby="'heading' + index">
                    <div class="panel-body">
                        <div class="form-group" v-for="q in question.form" :id="q.id">
                            <!--:class="{'has-error': form.errors.has(q.id)}"-->
                            <label><h3 class="control-label">{{ q.question }} <span v-show="q.required">*</span></h3></label>
                            <p v-show="q.description" v-html="q.description"></p>

                            <component :is="q.type + '-input'" :question="question"
                                       v-model="repeated[index][q.id]"></component>
                            <!--v-model="form[q.id]"-->
                            <!--<span class="help-block" v-show="form.errors.has(q.id)">-->
                            <!--{{ form.errors.get(q.id) }}-->
                            <!--</span>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ListInput from '../inputs/ListInput.vue';
    import SectionInput from '../inputs/SectionInput.vue';
    import RepeatInput from '../inputs/RepeatInput.vue';
    import OpinionScaleInput from '../inputs/OpinionScaleInput.vue';
    import TextareaInput from '../inputs/TextareaInput.vue';
    import TextInput from '../inputs/TextInput.vue';
    import SelectInput from '../inputs/SelectInput.vue';

    export default {
        props: ['question'],
        data() {
            return {
                repeated: [],
                init: {},
            }
        },
        created() {
            for (let i = 0, len = this.question.form.length; i < len; i++) {
                let id = this.question.form[i].id;
                this.init[id] = '';
            }

            if(this.question.required) this.add();
        },
        methods: {
            add() {
                this.repeated.push(Object.assign({}, this.init));
            },
            remove(index) {
                this.repeated.splice(this.repeated.indexOf(index), 1)
            }
        },
        watch: {
            repeated(value) {
                this.$emit('input', value)
            }
        },
        components: {
            ListInput,
            SectionInput,
            RepeatInput,
            OpinionScaleInput,
            TextareaInput,
            TextInput,
            SelectInput
        }
    }
</script>
