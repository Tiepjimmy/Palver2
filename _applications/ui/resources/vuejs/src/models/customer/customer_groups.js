import Model from '@/core/model';

/**
 * This class describes customer groups.
 *
 * @class      CustomerGroups (name)
 */
class CustomerGroups extends Model {
    /**
     * Constructs a new instance.
     *
     * @param      {<type>}  data    The data
     */
    constructor(data) {
        super();

        this.id = null;
        this.store_id = null;
        this.name = null;
        this.created_by = null;
        this.updated_by = null;
        this.created_at = null;
        this.updated_at = null;
        this.deleted_at = null;

        this.bind(data);
    }

    typeOfNumber() {
        return ['id', 'store_id', 'created_by', 'updated_by'];
    }

    apiGroup() {
        return 'om_customer_groups';
    }
}

export default CustomerGroups;
