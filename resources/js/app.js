import Alpine from 'alpinejs'
import address from './address.js'
// import payment from './payment.js'

Alpine.data('address', address)
// Alpine.data('payment', payment)

window.Alpine = Alpine

Alpine.start()
