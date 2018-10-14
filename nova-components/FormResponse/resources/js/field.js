Nova.booting((Vue, router) => {
    Vue.component('index-form-response', require('./components/IndexField'));
    Vue.component('detail-form-response', require('./components/DetailField'));
    Vue.component('form-form-response', require('./components/FormField'));

    Vue.component('answers', require('./components/Answers'));
    Vue.component('answer-detail', require('./components/AnswerDetail'));
    Vue.component('answer-form', require('./components/AnswerForm'));
})
