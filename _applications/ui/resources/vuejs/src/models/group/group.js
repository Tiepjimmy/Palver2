import Model from '@/core/model'

class Group extends Model {
  account_type
  address
  code
  name
  description
  request_time
  shared_time
  user_created
  email
  phone
  active
  status
  expired_date

  apiGroup() {
    return 'group'
  }

  typeOfNumber() {
    return []
  }

}
export default Group
