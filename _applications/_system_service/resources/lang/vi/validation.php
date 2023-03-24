<?php

return [
    'email' => 'Giá trị :attribute chưa phù hợp.',
    'max' => [
        'string' => 'Trường :attribute không được nhiều hơn :max kí tự.',
    ],
    'min' => [
        'string' => 'Trường :attribute không được ít hơn :min kí tự.',
    ],
    'not_regex' => 'Trường :attribute nhập đúng định dạng.',
    'numeric' => 'Trường :attribute bắt buộc là số',
    'between' => [
        'numeric' => 'Trường :attribute phải là số.',
        'string' => 'Trường :attribute phải có :min - :max ký tự',
    ],
    'digits_between' => 'Trường :attribute phải là số và độ dài từ :min-:max ký tự.',
    'regex' => 'Trường :attribute không đúng định dạng.',
    'required' => 'Vui lòng nhập :attribute.',
    'is_username' => 'Trường :attribute không được chứa khoảng trắng.',
    'is_phone_number' => 'Trường :attribute nhập đúng định dạng.',
    'string' => 'Trường :attribute phải là một chuỗi kí tự.',
    'in' => 'Chọn :attribute sai loại giá trị.',
    'required_if' => 'Trường :attribute bắt buộc nhập.',
    'same' => 'Trường :attribute và :other phải trùng nhau.',
    'password_format' => 'Trường mật khẩu bắt buộc phải có ít nhất : 1 kí tự đặc biệt, 1 chữ hoa, 1 chữ thường.',
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
            'required' => 'Vui lòng nhập đầy đủ các tổ chức.',
            'numeric' => 'Vui lòng nhập đúng định dạng các tổ chức.',
        ],
        'chuc_danh.*' => [
            'required' => 'Vui lòng nhập đầy đủ các chức danh.',
            'numeric' => 'Vui lòng nhập đúng định dạng các chức danh.',
        ],
        'ten_chuc_danh.*' => [
            'required' => 'Vui lòng nhập đầy đủ các tên chức danh.',
            'string' => 'Vui lòng nhập đúng định dạng các tên chức danh.',
        ],
        'nhom_chuc_danh.*' => [
            'required' => 'Vui lòng nhập đầy đủ các nhóm chức danh.',
            'string' => 'Vui lòng nhập đúng định dạng các nhóm chức danh.',
        ],
        'to-chuc.*' => [
            'required' => 'Vui lòng nhập đầy đủ các tổ chức.',
            'numeric' => 'Vui lòng nhập đúng định dạng các tổ chức.',
        ],
        'nhom-ncc.*' => [
            'required' => 'Vui lòng nhập đầy đủ các nhóm nhà cung cấp.',
            'numeric' => 'Vui lòng nhập đúng định dạng các nhóm nhà cung cấp.',
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
        'sdt' => 'số điện thoại',
        'username' => 'tên đăng nhập',
        'password' => 'mật khẩu',
        'ten_to_chuc' => 'tên tổ chức',
        'ten' => 'họ tên',
        'to_chuc' => 'tổ chức',
        'id_to_chuc' => 'tổ chức',
        'ten_nhom_quyen' => 'tên nhóm quyền',
        'id_quyen' => 'quyền',
        'id_phan_he' => 'phân hệ',
        'trang_thai' => 'trạng thái',
        'id_loai_kho' => 'loại kho',
        'id_tinh_thanh_pho' => 'tỉnh thành phố',
        'id_quan_huyen' => 'quận/huyện',
        'id_phuong_xa' => 'phường/xã',
        'ten_kho' => 'tên kho',
        'hotline' => 'SĐT hotline',
        'dia_chi' => 'địa chỉ chi tiết',
        'noi_dung' => 'nội dung',
        'avatar' => 'ảnh đại diện',
        'quyen' => 'quyền',
        'nhom_quyen' => 'nhóm quyền',
        'email' => 'email',
        'ten_danh_muc' => 'tên danh mục',
        'ghi_chu' => 'ghi chú',
        'ten_chuc_danh' => 'tên chức danh',
        'chuc_danh' => 'chức danh',
        'nhom_chuc_danh' => 'nhóm chức danh',
        'id_truc_thuoc' => 'đơn vị trực thuộc',
        'ten_san_pham' => 'tên sản phẩm',
        'ma_san_pham' => 'mã sản phẩm',
        'anh_dai_dien' => 'Ảnh đại diện',
        'ten-ncc' => 'nhà cung cấp',
        'ma-so-thue' => 'nhà cung cấp',
        'id-tinh-thanh-pho' => 'tỉnh/thành phố',
        'id-quan-huyen' => 'quận/huyện',
        'id-phuong-xa' => 'phường/xã',
        'dia-chi' => 'địa chỉ',
        'to-chuc' => 'tổ chức',
        'nhom-ncc' => 'nhóm nhà cung cấp',
        'mo-ta' => 'mô tả',
        'fileImport' => 'file nhập',
        'khoi_luong' => 'khối lượng',
        'password_confirmation' => 'xác nhận mật khẩu'
    ],

];
