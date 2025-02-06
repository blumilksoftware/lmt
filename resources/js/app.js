import Alpine from 'alpinejs'
import timer from './timer.js'
import carousel from './carousel.js'
import disclosure from './disclosure.js'
import gallery from './gallery.js'

window.Alpine = Alpine

document.addEventListener('alpine:init', () => {
  Alpine.data('timer', timer)
  Alpine.data('carousel', carousel)
  Alpine.data('disclosure', disclosure)
  Alpine.data('gallery', gallery)
})

Alpine.start()
