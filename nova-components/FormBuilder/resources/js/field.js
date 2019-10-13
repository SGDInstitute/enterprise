Nova.booting((Vue, router) => {
    Vue.component('index-form-builder', require('./components/IndexField'));
    Vue.component('detail-form-builder', require('./components/DetailField'));
    Vue.component('form-form-builder', require('./components/FormField'));

    Vue.component('questions', require('./components/Questions'));
    Vue.component('question-detail', require('./components/QuestionDetail'));
    Vue.component('question-form', require('./components/QuestionForm'));
    Vue.component('choices', require('./components/Choices'));
    Vue.component('add-many-choices', require('./components/AddManyChoices'));
})
