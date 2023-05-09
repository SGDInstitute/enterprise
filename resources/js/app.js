import Alpine from 'alpinejs'
import mask from '@alpinejs/mask'
import FormsAlpinePlugin from '../../vendor/filament/forms/dist/module.esm'
import NotificationsAlpinePlugin from '../../vendor/filament/notifications/dist/module.esm'
import address from './address.js'

Alpine.plugin(mask)
Alpine.plugin(FormsAlpinePlugin)
Alpine.plugin(NotificationsAlpinePlugin)

Alpine.data('address', address)

window.Alpine = Alpine

Alpine.start()
