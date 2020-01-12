Nova.booting((Vue, router, store) => {
  Vue.component('index-bulletin-links', require('./components/IndexField'))
  Vue.component('detail-bulletin-links', require('./components/DetailField'))
  Vue.component('form-bulletin-links', require('./components/FormField'))
})
