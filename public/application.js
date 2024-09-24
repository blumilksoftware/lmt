function initialize() {
  return {
    meetups: [],
    meetup: null,
    pastMeetups: [],
    active: false,
    selectedSpeakerIndex: 0,
    counters: {
      days: '00',
      hours: '00',
      minutes: '00',
      seconds: '00',
    },
    lightbox: {
      visible: false,
      currentImageIndex: 0,
    },
    start: async function () {
      await this.fetchData()
      this.calculateCounters()
      this.processPastMeetups()
      this.loadUpcomingMeetup()
      setInterval(() => {
        this.calculateCounters()
      }, 1000)
      this.setupKeyboardListeners()
    },
    fetchData: async function () {
      const meetupsResponse = await fetch(
        './assets/meetups.json?timestamp=' + Date.now()
      )
      const meetupsData = await meetupsResponse.json()
      this.meetups = await Promise.all(
        meetupsData.map(async (meetupUrl) => {
          const response = await fetch(meetupUrl + '?timestamp=' + Date.now())
          const meetupData = await response.json()

          const meetupFolder = meetupUrl.substring(
            0,
            meetupUrl.lastIndexOf('/')
          )
          const meetupId = meetupFolder.split('/').pop()
          meetupData.id = meetupId
          meetupData.lineup = meetupData.lineup.map((speaker) => ({
            ...speaker,
            avatarUrl: `${meetupFolder}/images/speakers/${speaker.avatarUrl}`,
          }))
          meetupData.patrons = meetupData.patrons.map((patron) => ({
            ...patron,
            logoUrl: `${meetupFolder}/images/partners/${patron.logoUrl}`,
          }))
          meetupData.partners = meetupData.partners.map((partner) => ({
            ...partner,
            logoUrl: `${meetupFolder}/images/partners/${partner.logoUrl}`,
          }))
          meetupData.sponsors = meetupData.sponsors.map((sponsor) => ({
            ...sponsor,
            logoUrl: `${meetupFolder}/images/partners/${sponsor.logoUrl}`,
          }))

          meetupData.gallery = await this.loadGalleryImages(
            meetupId,
            meetupFolder
          )

          return meetupData
        })
      )

      this.meetups.sort((a, b) => new Date(b.datetime) - new Date(a.datetime))

      const urlParams = new URLSearchParams(window.location.search)
      const meetupId = urlParams.get('meetupId')
      if (meetupId) {
        this.loadSpecificMeetup(meetupId)
      } else {
        this.loadUpcomingMeetup()
      }
    },
    loadUpcomingMeetup: function () {
      const now = moment()
      const endOfDay = moment().endOf('day')

      const upcomingMeetup = this.meetups.find((meetup) => {
        const meetupDate = moment(meetup.datetime)

        return meetupDate.isSameOrAfter(now, 'day')
      })

      if (upcomingMeetup) {
        this.processMeetup(upcomingMeetup)
      }
    },
    loadSpecificMeetup: function (meetupId) {
      const specificMeetup = this.meetups.find(
        (meetup) => meetup.id === meetupId
      )
      if (specificMeetup) {
        this.processMeetup(specificMeetup)
      }
    },
    processMeetup: function (meetup) {
      let time = moment(meetup.datetime).locale('pl')
      meetup.date = time.format('DD MMMM')
      meetup.time = time.format('HH:mm')
      meetup.year = time.format('Y')
      const meetupDate = moment(meetup.datetime)
      const endOfMeetupDay = meetupDate.endOf('day')

      meetup.isPastEndOfDay = moment().isAfter(endOfMeetupDay)

      meetup.agenda = meetup.agenda.map((lecture) => ({
        ...lecture,
        expanded: false,
      }))

      this.meetup = meetup
      this.initializeSpeakers()
    },
    initializeSpeakers: function () {
      if (this.meetup && this.meetup.lineup && this.meetup.lineup.length > 0) {
        this.selectedSpeaker = this.meetup.lineup[0]
        this.selectedSpeakerIndex = 0
      }
    },
    loadGalleryImages: async function (meetupId, meetupFolder) {
      try {
        const galleryResponse = await fetch(
          `./gallery.php?meetupId=${meetupId}`
        )
        if (!galleryResponse.ok) {
          return []
        }
        const galleryData = await galleryResponse.json()
        return galleryData.images.map((image) => ({
          id: image,
          url: `${meetupFolder}/images/gallery/${image}`,
          alt: `Gallery image ${image}`,
        }))
      } catch (error) {
        console.error('Error loading gallery images:', error)
        return []
      }
    },
    processPastMeetups: function () {
      const now = moment()

      this.pastMeetups = this.meetups
        .filter((meetup) => {
          const meetupDate = moment(meetup.datetime)
          return meetupDate.isBefore(now, 'day')
        })
        .map((meetup) => ({
          ...meetup,
          formattedDate: this.formatDate(meetup.datetime),
        }))
    },
    formatDate: function (dateString) {
      const date = new Date(dateString)
      return date
        .toLocaleDateString('en-GB', {
          day: '2-digit',
          month: '2-digit',
          year: '2-digit',
        })
        .replace(/\//g, '/')
    },
    calculateCounters: function () {
      if (this.meetup) {
        const now = moment()
        const diff = moment(this.meetup.datetime).diff(now)
        this.active = diff > 0

        this.counters.days = String(
          Math.floor(moment.duration(diff).asDays())
        ).padStart(2, '0')
        this.counters.hours = String(moment.duration(diff).hours()).padStart(
          2,
          '0'
        )
        this.counters.minutes = String(
          moment.duration(diff).minutes()
        ).padStart(2, '0')
        this.counters.seconds = String(
          moment.duration(diff).seconds()
        ).padStart(2, '0')
      }
    },
    selectPreviousSpeaker: function () {
      if (this.meetup && this.meetup.lineup) {
        this.selectedSpeakerIndex =
          (this.selectedSpeakerIndex - 1 + this.meetup.lineup.length) %
          this.meetup.lineup.length
      }
    },
    selectNextSpeaker: function () {
      if (this.meetup && this.meetup.lineup) {
        this.selectedSpeakerIndex =
          (this.selectedSpeakerIndex + 1) % this.meetup.lineup.length
      }
    },
    openLightbox(imageIndex) {
      this.lightbox.visible = true
      this.lightbox.currentImageIndex = imageIndex
    },
    closeLightbox() {
      this.lightbox.visible = false
    },
    changeImage(direction) {
      if (this.meetup && this.meetup.gallery) {
        const galleryLength = this.meetup.gallery.length
        this.lightbox.currentImageIndex =
          (this.lightbox.currentImageIndex + direction + galleryLength) %
          galleryLength
      }
    },
    setupKeyboardListeners() {
      window.addEventListener('keydown', (e) => {
        if (this.lightbox.visible) {
          switch (e.key) {
            case 'Escape':
              this.closeLightbox()
              break
            case 'ArrowRight':
              this.changeImage(1)
              break
            case 'ArrowLeft':
              this.changeImage(-1)
              break
          }
        }
      })
    },
    getImageAtIndex(columnIndex, rowIndex) {
      return this.meetup.gallery[this.calculateIndex(columnIndex, rowIndex)]
    },
    getImageIndex(columnIndex, rowIndex) {
      return this.calculateIndex(columnIndex, rowIndex)
    },
    calculateIndex(columnIndex, rowIndex) {
      return (columnIndex - 1) * 3 + rowIndex - 1
    },
  }
}
