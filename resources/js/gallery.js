export default length => ({
  length: length,
  current: 0,
  active: false,

  next() {
    this.current++

    if (this.current >= length) {
      this.current = 0
    }
  },
  previous() {
    this.current--

    if (this.current < 0) {
      this.current = length - 1
    }
  },

  select(image) {
    this.current = image
    this.active = true
  },

  exit() {
    this.current = null
    this.active = false
  },

  init() {
    window.addEventListener('keydown',  (e) => {
      if (this.active) {
        switch (e.key) {
        case 'Escape':
          this.exit()
          break
        case 'ArrowRight':
          this.next()
          break
        case 'ArrowLeft':
          this.previous()
          break
        }
      }
    })
  },
})
