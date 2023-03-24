import moment from "moment";

const Labels = {
	methods: {
		convertToNotMark(string) {
			return string.normalize("NFKD").replace(/[\u0300-\u036f]/g, "").replace(/[đĐ]/g, 'd');
		},
    selectEndDate(time) {
      if (time) {
        this.disableEndDate = false

        let endDate = moment(this.endDate, 'DD-MM-YYYY').format('YYYY-MM-DD')
        let startDate = moment(time, 'DD-MM-YYYY').format('YYYY-MM-DD')
        let date = new Date(startDate)
        let endDay = new Date(endDate)
        let maxDate = date.setMonth(date.getMonth() + 6)

        if (startDate > endDate || !this.endDate || endDay.getTime() > maxDate) {
          this.endDate = time
        }

        this.pickerDateEnd = {
          disabledDate(date) {
            let day = new Date(startDate)
            let toDay = new Date()

            return date < day.setDate(day.getDate() - 1) || date > toDay.setDate(toDay.getDate()) || date > maxDate
          }
        }
      } else {
        this.disableEndDate = true
        this.endDate = null
      }
    },
    timeFilter() {
      if (this.startDate && this.endDate) {
        let times = [
          this.startDate, this.endDate
        ]
        this.params.time = times
      } else {
        this.params.time = null
      }
    },
    getTimeFilter() {
      let time = this.$route.query.time
      if (time) {
        this.startDate = time[0]
        this.endDate = time[1]
      }
    },
	}
}

export default Labels
