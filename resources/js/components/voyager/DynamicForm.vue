<template>
    <div>
        <form method="post" class="form" @submit.prevent="save">
            <section class="section">
                <div class="container">
                    <h1>{{ form.name }}</h1>
                    <p class="large-text">{{ form.description }}</p>
                    <a :href="'#' + form.form[0].id" class="btn flat-btn flat-btn-mint btn-lg smooth">Lets Do
                        This!</a>
                </div>
            </section>
            <section>
                <div v-for="(question, index) in form.form" :id="question.id"
                         :class="{ section: question.type === 'section', question: question.type !== 'section'}">
                    <div class="container" v-if="question.id != 'submit'">
                        <div class="form-group" :class="{'has-error': form.errors.has(question.id)}">
                            <div v-if="question.type !== 'select'"><label :for="question.id"><h2>{{ question.question }} <span v-show="question.required">*</span></h2></label>
                            <p v-show="question.description" v-html="question.description"></p></div>

                            <component :is="question.type + '-input'" :question="question"
                                       v-model="form[question.id]"></component>

                            <span class="help-block" v-show="form.errors.has(question.id)">
                                {{ form.errors.get(question.id) }}
                            </span>
                            <a :href="nextId(index)" class="btn flat-btn flat-btn-mint smooth"
                               v-if="nextIsSection(index) || question.type === 'section'">Next!</a>
                        </div>
                    </div>
                </div>
            </section>
            <section :id="finishId" class="section">
                <div class="container">
                    <h1>All Done!</h1>
                    <p class="large-text">Don't forget to save your hard work by clicking the button below.</p>
                    <div class="alert alert-danger" v-show="form.errors.hasErrors()">
                        Whoops! Looks like you missed some required fields! Please, scroll up and respond to them.
                        <ul>
                            <li v-for="(error, key) in form.errors.all()"><a :href="'#' + key">{{ error[0] }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <button type="submit" class="btn flat-btn flat-btn-mint btn-lg" :disabled="form.busy">
                            {{ buttonText }}
                        </button>
                    </div>
                </div>
            </section>
        </form>
        <nav class="navbar navbar-default navbar-fixed-bottom">
            <div class="progress">
                <div class="progress-bar scroll-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                     aria-valuemax="100"
                     style="width: 0">
                    <span class="sr-only scroll-label">0% Complete</span>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
    import Welcome from './Welcome.vue';
    import ListInput from './inputs/ListInput.vue';
    import SectionInput from './inputs/SectionInput.vue';
    import RepeatInput from './inputs/RepeatInput.vue';
    import OpinionScaleInput from './inputs/OpinionScaleInput.vue';
    import TextareaInput from './inputs/TextareaInput.vue';
    import TextInput from './inputs/TextInput.vue';
    import SelectInput from './inputs/SelectInput.vue';
    import Finish from './Finish.vue';

    export default {
        props: ['form'],
        data() {
            return {
                form: new SparkForm({})
            }
        },
        beforeMount() {
            for (var i = 0, len = this.form.form.length; i < len; i++) {
                var id = this.form.form[i].id;
                this.form[id] = '';
            }

            this.form['email'] = this.getParameterByName('email');
        },
        methods: {
            save() {
                Spark.post('/forms/' + this.form.id + '/responses', this.form)
                    .then(response => {
                        if (response.success == true) {
                            location.href = response.url;
                        }
                    })
            },
            nextIsSection(index) {
                return typeof this.form.form[index + 1] !== 'undefined' &&
                    this.form.form[index + 1].type === 'section';
            },
            nextId(index) {
                if (typeof this.form.form[index + 1] !== 'undefined') {
                    return '#' + this.form.form[index + 1].id;
                }
            },
            getParameterByName(name, url) {
                if (!url) {
                    url = window.location.href;
                }
                name = name.replace(/[\[\]]/g, "\\$&");
                var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                    results = regex.exec(url);
                if (!results) return null;
                if (!results[2]) return '';
                return decodeURIComponent(results[2].replace(/\+/g, " "));
            }
        },
        computed: {
            finishId() {
                return 'question-' + this.form.form.length;
            },
            buttonText() {
                return this.form.button_text !== null ? this.form.button_text : 'Save Answers'
            }
        },
        components: {
            Welcome,
            ListInput,
            SectionInput,
            RepeatInput,
            OpinionScaleInput,
            TextareaInput,
            TextInput,
            SelectInput,
            Finish
        }
    }
</script>

<style>
    .form {
        margin-top: -70px;
    }

    .section {
        height: 100vh;
        display: flex;
        align-items: center;
    }

    .question {
        padding: 50px 0;
    }

    .large-text {
        font-size: 16px;
    }

    .help-block {
        clear: both;
    }

    .navbar.navbar-default.navbar-fixed-bottom {
        min-height: 0;
    }

    .progress {
        margin-bottom: 0;
        border-radius: 0;
    }
</style>
