export default initial => ({
  expanded: initial ?? false,

  toggle() {
    this.expanded = !this.expanded
  },

  reset() {
    this.expanded = initial
  },
})
