import $ from "jquery";

const showColorPickerJquery = {
	methods: {
		showColorPickerJquery(event) {
			let target = $(event.target).parents('.add-color').find('.vue-swatches__container')
			if (target.css('display') == 'block') {
				target.css('display', 'none')
			} else {
				target.css('display', 'block')
			}
			$('.vue-swatches__container').on('click', function () {
				$(this).css('display', 'none')
			})
			$('html').click(function (e) {
				if (!$('.add-color').is(e.target) && $('.add-color').has(e.target).length === 0) {
					$('.vue-swatches__container').css('display', 'none')
				}
			});
		}
	}
}

export default showColorPickerJquery
