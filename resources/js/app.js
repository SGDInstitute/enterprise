import Alpine from 'alpinejs'
import mask from '@alpinejs/mask'
import address from './address.js'
// import payment from './payment.js'

Alpine.plugin(mask)

Alpine.data('address', address)
// Alpine.data('payment', payment)

window.Alpine = Alpine

Alpine.start()
