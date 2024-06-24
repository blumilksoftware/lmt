function initialize() {
    return {
        meetups: [],
        meetup: null,
        active: false,
        selectedSpeaker: null,
        counters: {
            days: "00",
            hours: "00",
            minutes: "00",
            seconds: "00",
        },
        start: async function () {
            await this.fetchData()
            this.calculateCounters()
            setInterval(() => {
                this.calculateCounters()
            }, 1000)
        },
        fetchData: async function () {
            const meetupsResponse = await fetch("./assets/meetups.json?timestamp=" + Date.now())
            const meetupsData = await meetupsResponse.json()
            this.meetups = meetupsData

            const meetupResponse = await fetch(meetupsData[0] + "?timestamp=" + Date.now())
            const meetupData = await meetupResponse.json()

            let time = moment(meetupData.datetime).locale("pl")
            meetupData["date"] = time.format("DD MMMM")
            meetupData["time"] = time.format("HH:mm")
            meetupData["year"] = time.format("Y")
            meetupData["agenda"] = meetupData["agenda"].map(lecture => {
                lecture["expanded"] = false
                return lecture
            })

            this.selectedSpeaker = meetupData.lineup[0] ?? null
            this.meetup = meetupData
        },
        calculateCounters: function () {
            if (this.meetup) {
                const now = moment()
                const diff = moment(this.meetup.datetime).diff(now)
                this.active = diff > 0

                this.counters.days = String(Math.floor(moment.duration(diff).asDays())).padStart(2, "0")
                this.counters.hours = String(moment.duration(diff).hours()).padStart(2, "0")
                this.counters.minutes = String(moment.duration(diff).minutes()).padStart(2, "0")
                this.counters.seconds = String(moment.duration(diff).seconds()).padStart(2, "0")
            }
        },
        selectPreviousSpeaker: function () {
            const currentIndex = this.meetup.lineup.findIndex((speaker) => speaker === this.selectedSpeaker);
            const previousIndex = (currentIndex - 1 + this.meetup.lineup.length) % this.meetup.lineup.length;
            this.selectedSpeaker = this.meetup.lineup[previousIndex];
          },
          selectNextSpeaker: function () {
            const currentIndex = this.meetup.lineup.findIndex((speaker) => speaker === this.selectedSpeaker);
            const nextIndex = (currentIndex + 1) % this.meetup.lineup.length;
            this.selectedSpeaker = this.meetup.lineup[nextIndex];
          },
    }
}
