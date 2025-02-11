export default length => ({
  length: length,
  current: 0,

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
})
