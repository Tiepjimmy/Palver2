<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'Trường :attribute được phép nằm trong khoảng :min đến :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'Trường :attribute phải là số và độ dài từ :min-:max ký tự.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'Trường xác nhận :attribute không đúng.',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',

    'digits_between' => 'Trường :attribute phải là số và độ dài từ :min-:max ký tự.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'Trường :attribute phải nhập đúng định dạng.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'exists' => 'Trường :attribute nhập giá trị sai.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'Trường :attribute nhập giá trị sai.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'Trường :attribute phải là số.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute must not be greater than :max.',
        'file' => 'The :attribute must not be greater than :max kilobytes.',
        'string' => 'The :attribute must not be greater than :max characters.',
        'array' => 'The :attribute must not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'Trường :attribute không đúng định dạng.',
    'required' => 'Trường :attribute bắt buộc nhập.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'Trường :attribute phải ở dạng chuỗi.',
    'timezone' => 'The :attribute must be a valid timezone.',
    'unique' => 'Giá trị :attribute đã được sử dụng.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute must be a valid URL.',
    'uuid' => 'The :attribute must be a valid UUID.',
    'is_username' => 'The :attribute must be without spaces.',
    'is_phone_number' => 'Trường :attribute phải nhập đúng định dạng.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'to_chuc.*' => [
            'required' => 'Vui lòng chọn tổ chức.',
            'numeric' => 'Vui lòng chọn đúng tổ chức.',
        ],
        'chuc_danh.*' => [
            'required' => 'Vui lòng chọn chức danh.',
            'numeric' => 'Vui lòng chọn đúng chức danh.',
        ],
        'ten_chuc_danh.*' => [
            'required' => 'Vui lòng chọn chức danh.',
        ],
        'nhom_chuc_danh.*' => [
            'required' => 'Vui lòng chọn nhóm chức danh.',
            'string' => 'Vui lòng chọn đúng nhóm chức danh.',
        ],
        'store.*' => [
            'required' => 'Vui lòng chọn tổ chức.',
            'numeric' => 'Vui lòng chọn đúng tổ chức.',
        ],
        'job_title.*' => [
            'required' => 'Vui lòng chọn chức danh.',
            'numeric' => 'Vui lòng chọn đúng chức danh.',
        ],
        'job_title_group.*' => [
            'required' => 'Vui lòng chọn nhóm chức danh.',
            'string' => 'Vui lòng chọn đúng nhóm chức danh.',
        ],
        'phan_he.*' => [
            'required' => 'Vui lòng chọn phân hệ.',
            'numeric' => 'Vui lòng chọn đúng phân hệ.',
        ],
        'danh_sach_thuoc_tinh.*.ma_thuoc_tinh' => [
            'required' => 'Vui lòng nhập mã thuộc tính.',
        ],
        'product_attribute_list.*.attribute_cd' => [
            'required' => 'Vui lòng nhập mã thuộc tính.',
            'unique' => 'Mã thuộc tính đã tồn tại.',
        ],
        'danh_sach_thuoc_tinh.*.ten_thuoc_tinh' => [
            'required' => 'Vui lòng nhập tên thuộc tính.',
        ],
        'product_attribute_list.*.attribute_display_name' => [
            'required' => 'Vui lòng nhập tên thuộc tính.',
            'unique' => 'Tên thuộc tính đã tồn tại.',
        ],
        'danh_sach_thuoc_tinh.*.loai_thuoc_tinh' => [
            'required' => 'Vui lòng chọn loại thuộc tính.',
        ],
        'product_attribute_list.*.attribute_type_id' => [
            'required' => 'Vui lòng chọn loại thuộc tính.',
        ],
        'danh_sach_thuoc_tinh.*.mac_dinh' => [
            'required' => 'Vui lòng chọn mặc định.',
        ],
        'danh_sach_thuoc_tinh.*.bat_buoc' => [
            'required' => 'Vui lòng chọn bắt buộc.',
        ],
        'danh_sach_thuoc_tinh.*.gia_tri' => [
            'required' => 'Vui lòng nhập các giá trị thuộc tính.',
        ],
        'product_attribute_list.*.value' => [
            'required' => 'Vui lòng nhập các giá trị thuộc tính.',
        ],
        'danh_sach_thuoc_tinh.*.gia_tri.*' => [
            'required' => 'Vui lòng nhập giá trị thuộc tính.',
        ],
        'product_attribute_list.*.value.*' => [
            'required' => 'Vui lòng nhập giá trị thuộc tính.',
        ],
        'gia_tri.*' => [
            'required' => 'Vui lòng nhập giá trị thuộc tính.',
        ],
        'value.*' => [
            'required' => 'Vui lòng nhập giá trị thuộc tính.',
        ],
        'password' => [
            'min' => 'Vui lòng nhập mật khẩu từ 6-20 ký tự.',
            'max' => 'Vui lòng nhập mật khẩu từ 6-20 ký tự.',
        ],
        'attribute_group_cd' => [
            'unique' => 'Mã nhóm thuộc tính đã tồn tại.',
        ],
        'attribute_group_name' => [
            'unique' => 'Tên nhóm thuộc tính đã tồn tại.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'product_catalog_id' => 'Loại sản phẩm',
        'volume_unit_id' => 'Loại khối lượng',
        'product_cd' => 'Mã sản phẩm',
        'product_name' => 'Tên sản phẩm',
        'product_display_name' => 'Tên hiển thị',
        'quantity' => 'Khối lượng',
        'description' => 'Mô tả',
        'product_avatar' => 'Ảnh đại diện',
        'is_sales' => 'Cho phép kinh doanh',
        'is_enable_tax' => 'Áp dụng thuế',
        'tax_percent' => 'Giá trị áp dụng',
        'product_type' => 'Loại sản phẩm',
        'sku' => 'Mã SKU',
        'unit' => 'Đơn vị tính',
        'minimum_inventory' => 'Tồn kho tói thiểu',
        'providers' => 'Nhà cung cấp',
        'old_wholesale_prices' => 'Giá bán buôn',
        'old_cost_prices' => 'Giá vốn',
        'old_prices' => 'Giá bán lẻ',
        'tax_percent' => 'Áp dụng thuế',
        'prices.*' => 'Giá bán',
        'cost_prices.*' => 'Giá vốn',
        'product_entity_cd.*' => 'Mã sản phẩm',
        'sku_entity.*' => 'Mã SKU',
        'minimum_inventory_entity.*' => 'Tồn kho tối thiểu',
        'related_product_quantity.*' => 'Số lượng',
        'related_product_prices.*' => 'Giá bán lẻ',
        'store_id' => 'Tổ chức',
        'province_id' => 'thành phố/tỉnh',
        'district_id' => 'quận/huyện',
        'ward_id' => 'phường/Xã',
        'parent_id' => '',
        'store_name' => 'tên tổ chức',
        'store_cd' => 'mã tổ chức',
        'product_catalog_cd' => 'mã loại sản phẩm',
        'product_catalog_name' => 'tên loại sản phẩm',
        'product_cd_prefix' => 'mã loại sản phẩm',
        'note' => 'ghi chú',
        'warehouse_type_id' => 'loại kho',
        'warehouse_name' => 'tên kho',
        'warehouse_cd' => 'mã kho',
        'id_loai_kho' => 'loại kho',
        'id_to_chuc' => 'tổ chức',
        'province_id' => 'tỉnh thành phố',
        'district_id' => 'quận huyện',
        'commune_id' => 'phường xã',
        'ten_kho' => 'tên kho',
        'noi_dung' => 'nội dung',
        'address' => 'địa chỉ',
        'hotline' => 'sdt hotline',
        'id_danh_muc_san_pham' => 'danh mục sản phẩm',
        'id_don_vi_khoi_luong' => 'đơn vị khối lượng',
        'ten_san_pham' => 'tên sản phẩm',
        'ma_san_pham' => 'mã sản phẩm',
        'khoi_luong' => 'khối lượng',
        'don_vi_tinh' => 'đơn vị tính',
        'mo_ta' => 'mô tả',
        'gia_ban' => 'giá bán',
        'gia_ban_buon' => 'giá bán buôn',
        'gia_von' => 'giá vốn',
        'cho_phep_kinh_doanh' => 'cho phép kinh doanh',
        'ap_dung_thue' => 'áp dụng thuế',
        'loai_san_pham' => 'loại sản phẩm',
        'ten_thuoc_tinh' => 'tên thuộc tính',
        'gia_tri_thuoc_tinh' => 'giá trị thuộc tính',
        'anh_san_pham' => 'ảnh sản phẩm',
        'ten_danh_muc' => 'tên danh mục',
        'ghi_chu' => 'ghi chú',
        'id_danh_muc_cha' => 'danh mục cha',
        'active_status' => 'trạng thái',
        'nhom_chuc_danh' => 'nhóm chức danh',
        'parent_id' => 'đơn vị trực thuộc',
        'store_name' => 'tên tổ chức',
        'id_nhom_ncc' => 'nhóm nhà cung cấp',
        'ma_nhom' => 'mã nhóm',
        'ten_nhom' => 'tên nhóm',
        'ten' => 'tên',
        'username' => 'tên đăng nhập',
        'sdt' => 'số điện thoại',
        'nhom_quyen' => 'nhóm quyền',
        'password' => 'mật khẩu',
        'password_confirmation' => 'xác nhận mật khẩu',
        'ma_to_chuc' => 'mã tổ chức',
        'ten_chuc_danh' => 'tên chức danh',
        'ten_ncc' => 'tên nhà cung cấp',
        'ma_ncc' => 'mã nhà cung cấp',
        'ma_danh_muc' => 'mã danh mục',
        'ten_nhom_quyen' => 'tên nhóm quyền',
        'id_quyen' => 'quyền',
        'new_password' =>'mật khẩu mới',
        'old_password' =>'mật hiện tại',
        'ma_thuoc_tinh' => 'mã thuộc tính',
        'loai_thuoc_tinh' => 'loại thuộc tính',
        'mac_dinh' => 'mặc định',
        'bat_buoc' => 'bắt buộc',
        'gia_tri' => 'giá trị',
        'full_name' => 'tên người dùng',
        'phone' => 'số điện thoại',
        'store' => 'tổ chức',
        'job_title' => 'chức danh',
        'job_title_name' => 'tên chức danh',
        'job_title_type' => 'nhóm chức danh',
        'job_title_group' => 'nhóm chức danh',
        'permission_group' => 'nhóm quyền',
        'attribute_group_id' => 'id nhóm thuộc tính',
        'attribute_group_cd' => 'mã nhóm thuộc tính',
        'attribute_group_name' => 'tên nhóm thuộc tính',
        'product_catalog_id' => 'loại sản phẩm',
        'attribute_cd' => 'mã thuộc tính',
        'attribute_display_name' => 'tên thuộc tính',
        'attribute_type_id' => 'loại thuộc tính',
        'provider_name' => 'tên nhà cung cấp',
        'provider_cd' => 'mã nhà cung cấp',
        'provider_group_id' => 'nhóm nhà cung cấp',
        'store_id' => 'tổ chức',
        'ward_id' => 'phường/xã',
        'group_name' => 'tên nhóm nhà cung cấp',
        'group_cd' => 'mã nhóm nhà cung cấp',
    ],

    'sanpham' => [
        'unique' => 'Mã sản phẩm đã tồn tại.'
    ],

    'nhomquyen' => [
        'unique' => 'Tên nhóm quyền đã tồn tại.'
    ]
];
