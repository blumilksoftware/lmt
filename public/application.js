function initialize() {
  return {
    meetups: [],
    meetup: null,
    pastMeetups: [],
    active: false,
    selectedSpeaker: null,
    counters: {
      days: '00',
      hours: '00',
      minutes: '00',
      seconds: '00',
    },
    start: async function () {
      await this.fetchData()
      this.calculateCounters()
      this.processPastMeetups()
      setInterval(() => {
        this.calculateCounters()
      }, 1000)
    },
    fetchData: async function () {
      const meetupsResponse = await fetch('./assets/meetups.json?timestamp=' + Date.now())
      const meetupsData = await meetupsResponse.json()
      this.meetups = await Promise.all(
        meetupsData.map(async (meetupUrl) => {
          const response = await fetch(meetupUrl + '?timestamp=' + Date.now())
          const meetupData = await response.json()

          const meetupFolder = meetupUrl.substring(0, meetupUrl.lastIndexOf('/'))
          const meetupId = meetupFolder.split('/').pop()
          meetupData.id = meetupId // Assign the ID to the meetup
          meetupData.lineup = meetupData.lineup.map((speaker) => ({
            ...speaker,
            avatarUrl: `${meetupFolder}/images/speakers/${speaker.avatarUrl}`,
          }))
          meetupData.sponsors = meetupData.sponsors.map((sponsor) => ({
            ...sponsor,
            logoUrl: `${meetupFolder}/images/partners/${sponsor.logoUrl}`,
          }))
          meetupData.partners = meetupData.partners.map((partner) => ({
            ...partner,
            logoUrl: `${meetupFolder}/images/partners/${partner.logoUrl}`,
          }))

          meetupData.gallery = await this.loadGalleryImages(meetupId, meetupFolder)

          return meetupData
        })
      )

      this.meetups.sort((a, b) => new Date(b.datetime) - new Date(a.datetime))

      const upcomingMeetup = this.meetups.find((meetup) => new Date(meetup.datetime) > new Date())

      if (upcomingMeetup) {
        let time = moment(upcomingMeetup.datetime).locale('pl')
        upcomingMeetup['date'] = time.format('DD MMMM')
        upcomingMeetup['time'] = time.format('HH:mm')
        upcomingMeetup['year'] = time.format('Y')
        upcomingMeetup['agenda'] = upcomingMeetup['agenda'].map((lecture) => {
          lecture['expanded'] = false
          return lecture
        })

        this.selectedSpeaker = upcomingMeetup.lineup[0] ?? null
        this.meetup = upcomingMeetup
      }

      const urlParams = new URLSearchParams(window.location.search)
      const meetupId = urlParams.get('meetupId')
      if (meetupId) {
        this.loadSpecificMeetup(meetupId)
      }
    },
    loadSpecificMeetup: function (meetupId) {
      const specificMeetup = this.meetups.find((meetup) => meetup.id === meetupId)
      if (specificMeetup) {
        this.meetup = specificMeetup
      } else {
        console.error('Meetup not found')
      }
    },
    loadGalleryImages: async function (meetupId, meetupFolder) {
      try {
        const galleryResponse = await fetch(`./gallery.php?meetupId=${meetupId}`)
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
      const now = new Date()
      this.pastMeetups = this.meetups
        .filter((meetup) => new Date(meetup.datetime) < now)
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

        this.counters.days = String(Math.floor(moment.duration(diff).asDays())).padStart(2, '0')
        this.counters.hours = String(moment.duration(diff).hours()).padStart(2, '0')
        this.counters.minutes = String(moment.duration(diff).minutes()).padStart(2, '0')
        this.counters.seconds = String(moment.duration(diff).seconds()).padStart(2, '0')
      }
    },
    selectPreviousSpeaker: function () {
      const currentIndex = this.meetup.lineup.findIndex((speaker) => speaker === this.selectedSpeaker)
      const previousIndex = (currentIndex - 1 + this.meetup.lineup.length) % this.meetup.lineup.length
      this.selectedSpeaker = this.meetup.lineup[previousIndex]
    },
    selectNextSpeaker: function () {
      const currentIndex = this.meetup.lineup.findIndex((speaker) => speaker === this.selectedSpeaker)
      const nextIndex = (currentIndex + 1) % this.meetup.lineup.length
      this.selectedSpeaker = this.meetup.lineup[nextIndex]
    },
  }
}
