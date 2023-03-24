import Slug from 'slug';

const Zone = {
	methods: {
		/**
		 * @public
		 * @param action
		 * @param callback
		 */
		
		getProvinceName(typeZone, zoneAddress) {
			if (typeZone && zoneAddress) {
				let type = typeZone.find( i => i.name == 'province').type
				return zoneAddress.find( i => i.type == type).name
			}
		},
		
		getProvinceId(typeZone, zoneAddress, zoneProvinces) {
			if (typeZone && zoneAddress) {
				let type = typeZone.find( i => i.name == 'province').type
				let province = zoneAddress.find( i => i.type == type)
				return zoneProvinces.find( i => Slug(i.province_name, {lower: true}) == province.name_id).u_id
			}
		},
		
		getDistrictId(typeZone, zoneAddress, zoneDistrict) {
			if (typeZone && zoneAddress && zoneDistrict) {
				let type = typeZone.find( i => i.name == 'district').type
				let districtType = zoneAddress.find( i => i.type == type)
				let districtId = zoneDistrict.find( i => Slug(i.district_name, {lower: true}) == districtType.name_id)
				if (districtId) {
					return districtId.u_id
				}
			}
		},
		
		getWardId(typeZone, zoneAddress, zoneWard) {
			if (typeZone && zoneAddress && zoneWard) {
				let type = typeZone.find( i => i.name == 'ward').type
				let ward = zoneAddress.find( i => i.type == type)
				return zoneWard.find( i => Slug(i.ward_name, {lower: true}) == ward.name_id).u_id
			}
		}
		
	}
}

export default Zone
