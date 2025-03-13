import moment from 'moment'

export default targetDate => ({
  targetTime: moment(targetDate),
  days: '00',
  hours: '00',
  minutes: '00',
  seconds: '00',

  interval: null,

  updateTimeLeft() {
    const now = moment()
    const duration = moment.duration(this.targetTime.diff(now))

    if (duration.asSeconds() <= 0) {
      this.finishTimer()
      return
    }

    this.days = String(Math.floor(duration.asDays())).padStart(2, '0')
    this.hours = String(duration.hours()).padStart(2, '0')
    this.minutes = String(duration.minutes()).padStart(2, '0')
    this.seconds = String(duration.seconds()).padStart(2, '0')
  },

  init() {
    this.updateTimeLeft()

    this.interval = setInterval(() => this.updateTimeLeft(), 1000)
  },

  finishTimer() {
    this.days = '00'
    this.hours = '00'
    this.minutes = '00'
    this.seconds = '00'
    clearInterval(this.interval)
  },
})
