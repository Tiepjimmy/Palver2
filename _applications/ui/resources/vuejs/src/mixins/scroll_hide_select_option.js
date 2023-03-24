import $ from "jquery";

const scrollHideSelectModal = {
  methods: {
    scrollHideSelectModal(modalName) {
       $('#' + modalName).scroll(function () {
        if ($('.is-focus').length > 0) {
          $('.is-focus').click()
        }
        if ($('.has-time').css('display') != 'none') {
          $('.has-time').css('display', 'none')
        }
      })
    }
  }
}

export default scrollHideSelectModal
