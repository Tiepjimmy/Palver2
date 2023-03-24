import moment from "moment";

const Labels = {
  methods: {
    getLabel({value, items}) {
      let label = '' //'Chưa cập nhật'
      if(!value) {
        return label
      }

      const item = items.find(i => i.value == value)
      if (item != null) {
        return item.label
      }

      return label
    },

    nullDataStyle (value = '') {
      if (value == null || value == '') {
        return true;
      }
      return false
    },

    checkNull(data = '') {
      if(data == null || data == '') {
        return '' //'Chưa cập nhật'
      }
      return data
    },

    formatTime(time) {
      return time ? moment(time).format("DD/MM/YYYY HH:mm") : '' //'Chưa cập nhật'
    },

    formatBirthDate(time) {
      if (!time) {
        return 'chưa cập nhật'
      }
      return moment(time).format("DD/MM/YYYY")
    },
      formatBirthDateAndAge(time) {
      if (!time) {
        return 'Chưa cập nhật'
      }
      let age = new Date().getFullYear() - new Date(moment(time).format("YYYY")).getFullYear()
      return moment(time).format("DD/MM/YYYY") + ' - ' + age + ' tuổi'
    },

    getNameGender(gender) {
      let name
      switch (gender) {
        case 1:
          name = 'Nam'
          break
        case 2:
          name = 'Nữ'
          break
        default:
          name = 'Khác'
          break
      }

      return name
    },
  }
}

export default Labels
