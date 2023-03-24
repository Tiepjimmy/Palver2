import Model from '@/core/model';
import ApiService from '@/core/api.service';

/**
 * PrintedForm constructor
 */
class PrintedForm extends Model {
  constructor(data) {
    super();

    this.id = null;
    this.store_id = null;
    this.title = null;
    this.type = null;
    this.content = null;
    this.is_default = null;
    this.is_active = null;
    this.created_by = null;
    this.updated_by = null;
    this.created_at = null;
    this.updated_at = null;
    this.deleted_at = null;

    this.bind(data);
  }

  typeOfNumber() {
    return ['id', 'store_id', 'type', 'is_default', 'is_active', 'created_by', 'updated_by'];
  }

  /**
   * { function_description }
   *
   * @return     {string}  { description_of_the_return_value }
   */
  apiGroup() {
    return 'printed-forms';
  }

  /**
   * Fetches a short code.
   *
   * @return     {Promise}  The short code.
   */
  async fetchShortCode() {
    return await ApiService.getAsync(this.URL('shortcode'));
  }


  /**
   * Fetches a short code.
   *
   * @return     {Promise}  The short code.
   */
  async fethSystemForms() {
    return await ApiService.getAsync(this.URL('system-forms'));
  }
}

export default PrintedForm;
