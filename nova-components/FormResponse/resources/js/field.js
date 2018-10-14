Nova.booting((Vue, router) => {
    Vue.component('index-form-response', require('./components/IndexField'));
    Vue.component('detail-form-response', require('./components/DetailField'));
    Vue.component('form-form-response', require('./components/FormField'));

    Vue.component('questions', require('./components/Questions'));
    Vue.component('question-detail', require('./components/QuestionDetail'));
    Vue.component('question-form', require('./components/QuestionForm'));
})
