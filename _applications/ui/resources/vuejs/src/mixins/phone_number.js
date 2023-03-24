const PhoneNumber = {
	methods: {
		changeMobileNumberStatus({item, entityStatus }) {
			if (! item.hasOwnProperty(entityStatus)) {
				item[entityStatus] = null
			}
			item[entityStatus] = !item[entityStatus]
		},
		
		checkShowMobile({ item, entity, entityStatus}) {
			if (! item.hasOwnProperty(entityStatus)) {
				item[entityStatus] = true
			}
			
			if (! item[entity]) {
				return 'Chưa cập nhật'
			}
			
			if (item[entity] && item[entityStatus]) {
				return item[entity].replace(/(\d)(.*)(\d{4})/, '******$3');
			}
			
			if (item[entity] && !item[entityStatus]) {
				return item[entity]
			}
			
		}
	}
}

export default PhoneNumber
