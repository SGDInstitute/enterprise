<template>
    <div>
        <button class="btn btn-primary mb-4" @click.prevent="add">Add {{ question.name }}</button>

        <!--<div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">-->
            <!--<div class="card" v-for="(repeat, index) in repeated">-->
                <!--<div class="card-header" role="tab" :id="'heading' + index">-->

                    <!--<a role="button" class="pull-right" @click.prevent="remove(index)">Remove {{ question.name }}</a>-->

                    <!--<h4 class="mb-0">-->
                        <!--<a role="button" data-toggle="collapse" data-parent="#accordion" :href="'#collapse' + index"-->
                           <!--aria-expanded="true" aria-controls="'#collapse' + index">-->
                            <!--{{ question.name }} #{{ index + 1 }}-->
                        <!--</a>-->
                    <!--</h4>-->
                <!--</div>-->
                <!--<div :id="'collapse' + index" :class="(question.required && index == 0) ? 'collapse show' : 'collapse'" role="tabpanel"-->
                     <!--:aria-labelledby="'heading' + index">-->
                    <!--<div class="card-body">-->
                        <!--<div class="form-group" v-for="q in question.form" :id="q.id">-->
                            <!--<label><h3 class="control-label">{{ q.question }} <span v-show="q.required">*</span></h3></label>-->
                            <!--<p v-show="q.description" v-html="q.description"></p>-->

                            <!--<component :is="q.type + '-input'" :question="question"-->
                                       <!--v-model="repeated[index][q.id]"></component>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->

        <div class="accordion" id="accordion">
            <div class="card" v-for="(repeat, index) in repeated">
                <div class="card-header flex justify-between" :id="'heading' + index">
                    <button class="btn btn-link" type="button" data-toggle="collapse" :data-target="'#collapse' + index" aria-expanded="true" :aria-controls="'collapse' + index">
                        {{ question.name }} #{{ index + 1 }}
                    </button>
                    <a role="button" class="btn btn-link" @click.prevent="remove(index)">Remove {{ question.name }}</a>
                </div>

                <div :id="'collapse' + index" class="collapse show" :aria-labelledby="'heading' + index" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group" v-for="q in question.form" :id="q.id">
                            <label class="control-label">{{ q.question }} <span v-show="q.required">*</span></label>
                            <p v-show="q.description" v-html="q.description"></p>

                            <component :is="q.type + '-input'" :question="q" v-model="repeated[index][q.id]"></component>
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
