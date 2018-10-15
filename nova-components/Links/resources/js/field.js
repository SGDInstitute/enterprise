Nova.booting((Vue, router) => {
    Vue.component('index-links', require('./components/IndexField'));
    Vue.component('detail-links', require('./components/DetailField'));
    Vue.component('form-links', require('./components/FormField'));
})
