<?php

return [
    "DN" => [
        "name" => "Doanh nghiệp",
        "constants" => [
            "{__LOGO_CUA_HANG__}" => [
                "name" => "Logo doanh nghiệp",
                "content" =>
                    '<img src="/assets/standard/images/tuha_logo.png" style="max-width: 200px" />',
                "name_db" => "image_url",
            ],
            "{__SDT_DOANH_NGHIEP__}" => [
                "name" => "SĐT Doanh nghiệp",
                "content" => "0987666444",
                "name_db" => "phone_dn",
            ],
            "{__EMAIL_DOANH_NGHIEP__}" => [
                "name" => "Email Doanh nghiệp ",
                "content" => "pal@tuha.vn",
                "name_db" => "email_dn",
            ],
            "{__DIA_CHI_DOANH_NGHIEP__}" => [
                "name" => "Địa chỉ Doanh nghiệp ",
                "content" => "143 Nguyễn Tuân, Thanh Xuân, HN, VN",
                "name_db" => "address_dn",
            ],
            "{__TEN_CUA_HANG__}" => [
                "name" => "Tên cửu hàng",
                "content" => "Pal Shop",
                "name_db" => "name_dn",
            ],
            "{__MA_CONG_TY__}" => [
                "name" => "Mã công ty",
                "content" => "0312808882",
                "name_db" => "code_dn",
            ],
        ],
    ],

    "DH" => [
        "name" => "Đơn hàng",
        "constants" => [
            "{__TEN_BAN_IN__}" => [
                "name" => "Tên bản in",
                "content" => "Sản phẩm 01",
                "name_db" => "ten_ban_in",
            ],
            "{__STT_BAN_IN__}" => [
                "name" => "STT bản in",
                "content" => "No. 01",
                "name_db" => "stt_ban_in",
            ],
            "{__MA_DH__}" => [
                "name" => "Mã đơn hàng",
                "content" => "4193531",
                "name_db" => "id",
            ],
            "{__MA_VACH_DH__}" => [
                "name" => "Mã vạch đơn hàng",
                "content" =>
                    '<div style="text-align: center; padding-top: 10px"><img src="assets/lib/php-barcode-master/barcode.php?text=4193531"><br /> <center>4193531</center></div>',
                "name_db" => "bar_code",
            ],
            "{__MA_VACH_DH_QR__}" => [
                "name" => "Mã vạch đơn hàng QR Code",
                "content" =>
                    '<div style="text-align: center; padding-top: 10px"><img src="generate-qr.php?text=4193531"><br /> <center>4193531</center></div>',
                "name_db" => "bar_code_qr",
            ],
            "{__MA_VACH_VAN_DON__}" => [
                "name" => "Mã vạch vận đơn",
                "content" => "SG263-00-00-02",
                "name_db" => "postal_bar_code",
            ],
            "{__MA_VACH_VAN_DON_QR__}" => [
                "name" => "Mã vạch vận đơn QR Code",
                "content" =>
                    '<div style="text-align: center; padding-top: 10px"><img src="generate-qr.php?text=S384893.4193531"><br /> <center>S384893.4193531</center></div>',
                "name_db" => "postal_bar_code_qr",
            ],
            "{__MA_VACH_VAN_DON_SUB__}" => [
                "name" => "Mã vạch vận đơn rút gọn",
                "content" =>
                    '<div style="text-align: center; padding-top: 10px"><img src="assets/lib/php-barcode-master/barcode.php?text=4193531"><br /> <center>4193531</center></div>',
                "name_db" => "postal_bar_code_sub",
            ],
            "{__MA_VACH_VAN_DON_SUB_QR__}" => [
                "name" => "Mã vạch vận đơn rút gọn QR Code",
                "content" =>
                    '<div style="text-align: center; padding-top: 10px"><img src="generate-qr.php?text=4193531"><br /> <center>4193531</center></div>',
                "name_db" => "postal_bar_code_sub_qr",
            ],
            "{__MA_VACH_DH_SIZE_LARGE__}" => [
                "name" => "Mã vạch đơn hàng lớn",
                "content" =>
                    '<div style="text-align: center; padding-top: 10px"><img src="assets/lib/php-barcode-master/barcode.php?text=S384893.4193531&size=80"><br /> <center>S384893.4193531</center></div>',
                "name_db" => "bar_code_large",
            ],
            "{__MA_VACH_DH_SIZE_LARGE_QR__}" => [
                "name" => "Mã vạch đơn hàng lớn QR Code",
                "content" =>
                    '<div style="text-align: center; padding-top: 10px"><img src="generate-qr.php?text=S384893.4193531&size=5"><br /> <center>S384893.4193531</center></div>',
                "name_db" => "bar_code_large_qr",
            ],
            "{__MA_VACH_VAN_DON_SIZE_LARGE__}" => [
                "name" => "Mã vạch vận đơn lớn",
                "content" =>
                    '<div style="text-align: center; padding-top: 10px"><img src="assets/lib/php-barcode-master/barcode.php?text=S384893.4193531&size=80"><br /> <center>S384893.4193531</center></div>',
                "name_db" => "postal_bar_code_large",
            ],
            "{__MA_VACH_VAN_DON_SIZE_LARGE_QR__}" => [
                "name" => "Mã vạch vận đơn lớn QR Code",
                "content" =>
                    '<div style="text-align: center; padding-top: 10px"><img src="generate-qr.php?text=S384893.4193531&size=5"><br /> <center>S384893.4193531</center></div>',
                "name_db" => "postal_bar_code_large_qr",
            ],
            "{__MA_VAN_DON__}" => [
                "name" => "Mã vận đơn",
                "content" => "SH3456789",
                "name_db" => "postal_code",
            ],
            "{__SORT_CODE__}" => [
                "name" => "Sort Code",
                "content" => "00-00-00/28",
                "name_db" => "sort_code",
            ],
            "{__NGAY_TAO__}" => [
                "name" => "Ngày tạo",
                "content" => date("d/m/Y"),
                "name_db" => "created_at",
            ],
            "{__NGAY_HIEN_TAI__}" => [
                "name" => "Ngày hiện tại",
                "content" => date("d/m/Y 00:00:00"),
                "name_db" => "current_date",
            ],
            "{__TONG_TIEN__}" => [
                "name" => "Tổng tiền (còn lại - thu người nhận)",
                "content" => "850,000",
                "name_db" => "total_price",
            ],
            "{__GHI_CHU_CHUNG__}" => [
                "name" => "Ghi chú chung",
                "content" => "Đơn hàng sử dụng vận chuyển GHTK",
                "name_db" => "note1",
            ],
            "{__GHI_CHU_GIAO_HANG__}" => [
                "name" => "Ghi chú giao hàng",
                "content" => "Giao hàng trong giờ hành chính",
                "name_db" => "shipping_note",
            ],
            "{__NGUOI_TAO_DON__}" => [
                "name" => "Người tạo đơn",
                "content" => "Khoa Nguyen",
                "name_db" => "user_created",
            ],
            "{__NGUOI_CHOT_DON__}" => [
                "name" => "Người chốt đơn",
                "content" => "Khoa Nguyen",
                "name_db" => "user_confirmed",
            ],
            "{__THANH_TIEN__}" => [
                "name" => "Thành tiền (chưa bao gồm phụ phí)",
                "content" => "820,000",
                "name_db" => "price",
            ],
            "{__THANH_TIEN_NOT_SHIPPING__}" => [
                "name" => "Tổng tiền (không bao gồm phí ship)",
                "content" => "820,000",
                "name_db" => "price_not_shipping",
            ],
            "{__GIAM_GIA__}" => [
                "name" => "Giảm giá",
                "content" => "20,000",
                "name_db" => "discount_price",
            ],
            "{__PHI_VAN_CHUYEN__}" => [
                "name" => "Phí vận chuyển",
                "content" => "20,000",
                "name_db" => "shipping_price",
            ],
            "{__PHU_THU__}" => [
                "name" => "Phụ thu",
                "content" => "30,000",
                "name_db" => "other_price",
            ],
            "{__KIEM_TRA_HANG__}" => [
                "name" => "Kiểm tra hàng",
                "content" => "Không cho xem hàng",
                "name_db" => "note_code",
            ],
            "{__DON_VI_VC__}" => [
                "name" => "Đơn vị vận chuyển",
                "content" => "Giao hàng nhanh",
                "name_db" => "don_vi_van_chuyen",
            ],
            "{__DELIVERY_TIME__}" => [
                "name" => "Thời gian giao hàng",
                "content" => "delivery_time",
                "name_db" => "delivery_time",
            ],
            "{__TRA_TRUOC__}" => [
                "name" => "Trả trước",
                "content" => "120,000",
                "name_db" => "prepaid",
            ],
            "{__CON_NO__}" => [
                "name" => "Còn nợ",
                "content" => "730,000",
                "name_db" => "prepaid_remain",
            ],
        ],
    ],

    "SP" => [
        "name" => "Sản phẩm",
        "constants" => [
            "{__DANH_SACH_SP_1__}" => [
                "name" => "Danh sách sản phẩm 1",
                "content" =>
                    "1 Áo phông nam size S, 1 Áo cô gái size s, m, l",
                "name_db" => "dssp1",
            ],
            "{__STT_SP__}" => [
                "name" => "STT",
                "is_interval" => 1,
                "data" => [1, 2],
                "name_db" => "stt",
            ],
            "{__MA_SP__}" => [
                "name" => "Mã sản phẩm",
                "is_interval" => 1,
                "data" => ["MSP_1", "MSP_2"],
                "name_db" => "code",
            ],
            "{__TEN_SP__}" => [
                "name" => "Tên sản phẩm",
                "content" => "Tông đơ cắt tóc HT (Loại mới)",
                "is_interval" => 1,
                "data" => [
                    "Tông đơ cắt tóc HT (Loại mới)",
                    "Sữa tắm loại mới",
                ],
                "name_db" => "product_name",
            ],
            "{__MAU_SAC_SP__}" => [
                "name" => "Màu sắc sản phẩm",
                "content" => "Xanh da trời",
                "is_interval" => 1,
                "data" => ["Xanh", "Vàng"],
                "name_db" => "color",
            ],
            "{__SIZE_SP__}" => [
                "name" => "Kích cỡ sản phẩm",
                "content" => "42",
                "is_interval" => 1,
                "data" => [42, 43],
                "name_db" => "size",
            ],
            "{__TRONG_LUONG_SP__}" => [
                "name" => "Trọng lượng sản phẩm",
                "content" => "500",
                "is_interval" => 1,
                "data" => [500, 1000],
                "name_db" => "weight",
            ],
            "{__GIA_BAN_SP__}" => [
                "name" => "Giá bán sản phẩm",
                "is_interval" => 1,
                "data" => ["200,000", "400,000"],
                "name_db" => "product_price",
            ],
            "{__SL_SP__}" => [
                "name" => "Số lượng sản phẩm",
                "is_interval" => 1,
                "data" => [2, 3],
                "name_db" => "qty",
            ],
            "{__DV_SP__}" => [
                "name" => "Đơn vị sản phẩm",
                "is_interval" => 1,
                "data" => ["Kg", "Thỏi"],
                "name_db" => "units_name",
            ],
            "{__TONG_TIEN_SP__}" => [
                "name" => "Tổng tiền sản phẩm",
                "is_interval" => 1,
                "data" => ["400,000", "1,200,000"],
                "name_db" => "total",
            ],
        ],
    ],

    "NGNN" => [
        "name" => "Người gửi, người nhận",
        "constants" => [
            "{__DANH_SACH_SP_1__}" => [
                "name" => "Danh sách sản phẩm 1",
                "content" =>
                    "1 Áo phông nam size S, 1 Áo cô gái size s, m, l",
                "name_db" => "dssp1",
            ],
            "{__DANH_SACH_SP_2__}" => [
                "name" => "Danh sách sản phẩm 2",
                "content" => "3YK, 1V.cher",
                "name_db" => "dssp2",
            ],
            "{__STT_SP__}" => [
                "name" => "STT",
                "is_interval" => 1,
                "data" => [1, 2],
                "name_db" => "stt",
            ],
            "{__MA_SP__}" => [
                "name" => "Mã sản phẩm",
                "is_interval" => 1,
                "data" => ["MSP_1", "MSP_2"],
                "name_db" => "product_code",
            ],
            "{__TEN_SP__}" => [
                "name" => "Tên sản phẩm",
                "content" => "Tông đơ cắt tóc HT (Loại mới)",
                "is_interval" => 1,
                "data" => [
                    "Tông đơ cắt tóc HT (Loại mới)",
                    "Sữa tắm loại mới",
                ],
                "name_db" => "product_name",
            ],
        ],
    ]
];
