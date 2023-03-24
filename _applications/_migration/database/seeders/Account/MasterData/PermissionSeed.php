<?php

namespace Database\Seeders\Account\MasterData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use AccountSdkDb\Modules\Master\Models\SubSystem;
use AccountSdkDb\Modules\Master\Models\Feature;
use AccountSdkDb\Modules\Master\Models\Permission;
use AccountSdkDb\Modules\User\Models\PermissionPermissionGroup;

class PermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $listSystem = [
                1 => [
                    'name' => 'Account',
                    'cd' => 'account',
                    'chuc_nang' => [
                        1 => [
                            'name' => 'Sản phẩm',
                            'cd' => 'san-pham',
                            'permission' => [
                                1 => [
                                    'Xem sản phẩm',
                                    'no',
                                    'san-pham',
                                    'Xem danh sách tất sản phẩm'
                                ],
                                2 => [
                                    'Tạo sản phẩm',
                                    'yes',
                                    'tao-san-pham',
                                    'Tạo sản phẩm mới'
                                ],
                                3 => [
                                    'Sửa sản phẩm',
                                    'yes',
                                    'sua-san-pham',
                                    'Sửa thông tin trong sản phẩm'
                                ],
                                4 => [
                                    'Xuất file sản phẩm',
                                    'no',
                                    'xuat-file-san-pham',
                                    'Xuất file danh sách sản phẩm dưới dạng file excel'
                                ],
                                5 => [
                                    'Nhập file sản phẩm',
                                    'no',
                                    'nhap-file-san-pham',
                                    'Nhập file template sản phẩm dưới dạng file excel'
                                ]
                            ]
                        ],
                        2 => [
                            'name' => 'Loại sản phẩm',
                            'cd' => 'loai-san-pham',
                            'permission' => [
                                6 => [
                                    'Xem loại sản phẩm',
                                    'no',
                                    'danh-muc',
                                    'Xem danh sách loại sản phẩm'
                                ],
                                7 => [
                                    'Tạo loại sản phẩm',
                                    'yes',
                                    'tao-danh-muc',
                                    'Thêm mới loại sản phẩm'
                                ],
                                8 => [
                                    'Sửa loại sản phẩm',
                                    'yes',
                                    'sua-danh-muc',
                                    'Sửa thông tin trong loại sản phẩm'
                                ]
                            ]
                        ],
                        3 => [
                            'name' => 'Nhà cung cấp',
                            'cd' => 'nha-cung-cap',
                            'permission' => [
                                9 => [
                                    'Xem nhà cung cấp',
                                    'no',
                                    'nha-cung-cap',
                                    'Xem danh sách nhà cung cấp'
                                ],
                                10 => [
                                    'Tạo nhà cung cấp',
                                    'yes',
                                    'tao-nha-cung-cap',
                                    'Thêm mới nhà cung cấp'
                                ],
                                11 => [
                                    'Sửa nhà cung cấp',
                                    'yes',
                                    'sua-nha-cung-cap',
                                    'Sửa thông tin trong nhà cung cấp'
                                ]
                            ]
                        ],
                        4 => [
                            'name' => 'User',
                            'cd' => 'user',
                            'permission' => [
                                12 => [
                                    'Xem danh sách user',
                                    'no',
                                    'user',
                                    'Xem danh sách user có trong tổ chức'
                                ],
                                13 => [
                                    'Thêm user',
                                    'no',
                                    'them-user',
                                    'Thêm mới user'
                                ],
                                14 => [
                                    'Sửa user',
                                    'no',
                                    'sua-user',
                                    'Sửa thông tin trong user'
                                ]
                            ]
                        ],
                        5 => [
                            'name' => 'Cơ cấu tổ chức',
                            'cd' => 'co-cau-to-chuc',
                            'permission' => [
                                15 => [
                                    'Xem danh sách cơ cấu tổ chức',
                                    'no',
                                    'to-chuc',
                                    'Xem danh sách cơ cấu tổ chức có trong hệ thống'
                                ],
                                16 => [
                                    'Thêm cơ cấu tổ chức',
                                    'yes',
                                    'them-to-chuc',
                                    'Thêm mới cơ cấu tổ chức'
                                ],
                                17 => [
                                    'Sửa cơ cấu tổ chức',
                                    'yes',
                                    'sua-to-chuc',
                                    'Sửa thông tin trong cơ cấu tổ chức'
                                ]
                            ]
                        ],
                        6 => [
                            'name' => 'Chức danh',
                            'cd' => 'chuc-danh',
                            'permission' => [
                                18 => [
                                    'Xem danh sách chức danh',
                                    'no',
                                    'chuc-danh',
                                    'Xem danh sách chức danh'
                                ],
                                19 => [
                                    'Thêm chức danh',
                                    'yes',
                                    'them-chuc-danh',
                                    'Thêm mới chức danh ứng với từng tổ chức'
                                ],
                                20 => [
                                    'Sửa chức danh',
                                    'yes',
                                    'sua-chuc-danh',
                                    'Sửa thông tin trong chức danh'
                                ]
                            ]
                        ],
                        7 => [
                            'name' => 'Kho',
                            'cd' => 'kho',
                            'permission' => [
                                21 => [
                                    'Xem danh sách kho',
                                    'no',
                                    'kho',
                                    'Xem danh sách kho'
                                ],
                                22 => [
                                    'Thêm kho',
                                    'yes',
                                    'them-kho',
                                    'Thêm mới kho'
                                ],
                                23 => [
                                    'Sửa kho',
                                    'yes',
                                    'sua-kho',
                                    'Sửa thông tin trong kho'
                                ]
                            ]
                        ],
                        8 => [
                            'name' => 'Quyền',
                            'cd' => 'quyen',
                            'permission' => [
                                24 => [
                                    'Xem danh sách quyền',
                                    'no',
                                    'quyen',
                                    'Xem danh sách nhóm quyền'
                                ],
                                25 => [
                                    'Thêm quyền',
                                    'yes',
                                    'them-quyen',
                                    'Thêm mới nhóm quyền ứng với từng tổ chức'
                                ],
                                26 => [
                                    'Sửa quyền',
                                    'yes',
                                    'sua-quyen',
                                    'Sửa thông tin trong nhóm quyền'
                                ]
                            ]
                        ]
                    ]
                ],
                2 => [
                    'name' => 'OM',
                    'cd' => 'om',
                    'chuc_nang' => [
                        9 => [
                            'name' => 'Đơn hàng',
                            'cd' => 'don-hang',
                            'permission' => [
                                27 => [
                                    'Xem đơn hàng',
                                    'no',
                                    'don-hang',
                                    null
                                ],
                                28 => [
                                    'Tạo đơn hàng',
                                    'no',
                                    'tao-don-hang',
                                    null
                                ],
                                29 => [
                                    'Sửa đơn hàng',
                                    'no',
                                    'sua-don-hang',
                                    null
                                ],
                                30 => [
                                    'Chuyển trạng thái đơn hàng',
                                    'no',
                                    'trang-thai-don-hang',
                                    null
                                ],
                                31 => [
                                    'Xuất file đơn hàng',
                                    'no',
                                    'xuat-file-don-hang',
                                    null
                                ],
                                32 => [
                                    'Thanh toán đơn hàng',
                                    'no',
                                    'thanh-toan-don-hang',
                                    null
                                ],
                                33 => [
                                    'Xuất hóa đơn điện tử',
                                    'no',
                                    'xuat-hoa-don-dien-tu',
                                    null
                                ]
                            ]
                        ],
                        10 => [
                            'name' => 'Đối soát vận chuyển',
                            'cd' => 'doi-soat-van-chuyen',
                            'permission' => [
                                34 => [
                                    'Xem phiếu đối soát',
                                    'no',
                                    'doi-soat',
                                    null
                                ],
                                35 => [
                                    'Tạo phiếu đối soát',
                                    'no',
                                    'tao-phieu-doi-soat',
                                    null
                                ],
                                36 => [
                                    'Sửa phiếu đối soát',
                                    'no',
                                    'sua-phieu-doi-soat',
                                    null
                                ],
                                37 => [
                                    'Xác nhận đối soát',
                                    'no',
                                    'xac-nhan-doi-soat',
                                    null
                                ],
                                38 => [
                                    'Hủy phiếu đối soát',
                                    'no',
                                    'huy-phieu-doi-soat',
                                    null
                                ],
                                39 => [
                                    'Thanh toán đối soát',
                                    'no',
                                    'thanh-toan-doi-soat',
                                    null
                                ]
                            ]
                        ],
                        11 => [
                            'name' => 'Khuyến mại',
                            'cd' => 'khuyen-mai',
                            'permission' => [
                                40 => [
                                    'Xem chương trình khuyến mại',
                                    'no',
                                    'khuyen-mai',
                                    null
                                ],
                                41 => [
                                    'Thêm chương trình khuyến mại',
                                    'yes',
                                    'them-khuyen-mai',
                                    null
                                ],
                                42 => [
                                    'Sửa chương trình khuyến mại',
                                    'yes',
                                    'sua-khuyen-mai',
                                    null
                                ]
                            ]
                        ]
                    ]
                ],
                3 => [
                    'name' => 'Reporting',
                    'cd' => 'reporting',
                    'chuc_nang' => [
                        12 => [
                            'name' => 'Báo cáo',
                            'cd' => 'bao-cao',
                            'permission' => [
                                43 => [
                                    'Xem báo cáo tổng',
                                    'no',
                                    'bao-cao-tong',
                                    null
                                ],
                                44 => [
                                    'Xem báo cáo doanh thu',
                                    'no',
                                    'bao-bao-doanh-thu',
                                    null
                                ],
                                45 => [
                                    'Xem báo cáo marketing',
                                    'no',
                                    'bao-cao-marketing',
                                    null
                                ],
                                46 => [
                                    'Xem báo cáo tồn kho',
                                    'no',
                                    'bao-cao-ton-kho',
                                    null
                                ]
                            ]
                        ]
                    ]
                ],
                4 => [
                    'name' => 'Palion',
                    'cd' => 'palion',
                    'chuc_nang' => [
                        13 => [
                            'name' => 'Đăng nhập',
                            'cd' => 'dang-nhap',
                            'permission' => [
                                47 => [
                                    'Đăng nhập',
                                    'no',
                                    'dang-nhap',
                                    null
                                ]
                            ]
                        ],
                        14 => [
                            'name' => 'Khách hàng',
                            'cd' => 'khach-hang',
                            'permission' => [
                                48 => [
                                    'Xem danh sách khách hàng',
                                    'no',
                                    'khach-hang',
                                    null
                                ],
                                49 => [
                                    'Sửa danh sách khách hàng',
                                    'no',
                                    'sua-khach-hang',
                                    null
                                ],
                                50 => [
                                    'Xuất file danh sách khách hàng',
                                    'no',
                                    'xuat-file-khach-hang',
                                    null
                                ]
                            ]
                        ]
                    ]
                ],
                5 => [
                    'name' => 'Palnet',
                    'cd' => 'palnet',
                    'chuc_nang' => [
                        15 => [
                            'name' => 'Quản lý chủ đề',
                            'cd' => 'quan-ly-chu-de',
                            'permission' => [
                                51 => [
                                    'Tạo mới',
                                    'no',
                                    'tao-moi-chu-de',
                                    null
                                ],
                                52 => [
                                    'Sửa chủ đề',
                                    'no',
                                    'sua-chu-de',
                                    null
                                ],
                                53 => [
                                    'Xóa chủ đề',
                                    'no',
                                    'sua-chu-de',
                                    null
                                ],
                                54 => [
                                    'Đổi tên chủ đề',
                                    'no',
                                    'doi-ten-chu-de',
                                    null
                                ],
                                55 => [
                                    'Áp dụng chủ đề',
                                    'no',
                                    'ap-dung-chu-de',
                                    null
                                ],
                                56 => [
                                    'Xem trước (Preview)',
                                    'no',
                                    'xem-truoc',
                                    null
                                ]
                            ]
                        ]
                    ]
                ],
            ];

            foreach ($listSystem as $keySystem => $system) {
                $crudSubSystem = SubSystem::updateOrCreate([
                    'id' => $keySystem
                ], [
                    'subsystem_name' => $system['name'],
                    'subsystem_cd' => $system['cd']
                ]);
                foreach ($system['chuc_nang'] as $keyFeature => $feature ) {
                    $crudFeature = Feature::updateOrCreate([
                        'id' => $keyFeature
                    ], [
                        'subsystem_id' => $crudSubSystem->id,
                        'feature_name' => $feature['name'],
                        'feature_cd' => $feature['cd']
                    ]);
                    foreach ( $feature['permission'] as $keyPermission => $permission ) {
                        Permission::updateOrCreate([
                            'id' => $keyPermission,
                        ],[
                            'feature_id' => $crudFeature->id,
                            'permission_name' => $permission[0],
                            'private' => $permission[1],
                            'permission_cd' => $permission[2],
                            'tooltip' => $permission[3]
                        ]);
                    }
                }
            }

            $listPermissionPermissionGroup = [
                [
                    'permission_id' => 1,
                    'permission_group_id' => 1
                ],
                [
                    'permission_id' => 2,
                    'permission_group_id' => 1
                ],
                [
                    'permission_id' => 3,
                    'permission_group_id' => 1
                ],
                [
                    'permission_id' => 4,
                    'permission_group_id' => 1
                ],
                [
                    'permission_id' => 5,
                    'permission_group_id' => 1
                ],
                [
                    'permission_id' => 6,
                    'permission_group_id' => 1
                ],
                [
                    'permission_id' => 7,
                    'permission_group_id' => 1
                ],
                [
                    'permission_id' => 8,
                    'permission_group_id' => 1
                ],
                [
                    'permission_id' => 9,
                    'permission_group_id' => 2
                ],
                [
                    'permission_id' => 10,
                    'permission_group_id' => 2
                ],
                [
                    'permission_id' => 11,
                    'permission_group_id' => 2
                ],
                [
                    'permission_id' => 12,
                    'permission_group_id' => 3
                ],
                [
                    'permission_id' => 13,
                    'permission_group_id' => 3
                ],
                [
                    'permission_id' => 14,
                    'permission_group_id' => 3
                ],
                [
                    'permission_id' => 15,
                    'permission_group_id' => 4
                ],
                [
                    'permission_id' => 16,
                    'permission_group_id' => 4
                ],
                [
                    'permission_id' => 17,
                    'permission_group_id' => 4
                ],
                [
                    'permission_id' => 18,
                    'permission_group_id' => 5
                ],
                [
                    'permission_id' => 19,
                    'permission_group_id' => 5
                ],
                [
                    'permission_id' => 20,
                    'permission_group_id' => 5
                ],
                [
                    'permission_id' => 21,
                    'permission_group_id' => 6
                ],
                [
                    'permission_id' => 22,
                    'permission_group_id' => 6
                ],
                [
                    'permission_id' => 23,
                    'permission_group_id' => 6
                ],
                [
                    'permission_id' => 24,
                    'permission_group_id' => 7
                ],
                [
                    'permission_id' => 25,
                    'permission_group_id' => 7
                ],
                [
                    'permission_id' => 26,
                    'permission_group_id' => 7
                ],
                [
                    'permission_id' => 27,
                    'permission_group_id' => 8
                ],
                [
                    'permission_id' => 28,
                    'permission_group_id' => 8
                ],
                [
                    'permission_id' => 29,
                    'permission_group_id' => 8
                ],
                [
                    'permission_id' => 30,
                    'permission_group_id' => 8
                ],
                [
                    'permission_id' => 31,
                    'permission_group_id' => 8
                ],
                [
                    'permission_id' => 32,
                    'permission_group_id' => 8
                ],
                [
                    'permission_id' => 33,
                    'permission_group_id' => 8
                ],
                [
                    'permission_id' => 34,
                    'permission_group_id' => 9
                ],
                [
                    'permission_id' => 35,
                    'permission_group_id' => 9
                ],
                [
                    'permission_id' => 36,
                    'permission_group_id' => 9
                ],
                [
                    'permission_id' => 37,
                    'permission_group_id' => 9
                ],
                [
                    'permission_id' => 38,
                    'permission_group_id' => 9
                ],
                [
                    'permission_id' => 39,
                    'permission_group_id' => 9
                ],
                [
                    'permission_id' => 40,
                    'permission_group_id' => 10
                ],
                [
                    'permission_id' => 41,
                    'permission_group_id' => 10
                ],
                [
                    'permission_id' => 42,
                    'permission_group_id' => 10
                ],
                [
                    'permission_id' => 43,
                    'permission_group_id' => 9
                ],
                [
                    'permission_id' => 44,
                    'permission_group_id' => 9
                ],
                [
                    'permission_id' => 45,
                    'permission_group_id' => 9
                ],
                [
                    'permission_id' => 46,
                    'permission_group_id' => 9
                ],
                [
                    'permission_id' => 47,
                    'permission_group_id' => 3
                ],
                [
                    'permission_id' => 48,
                    'permission_group_id' => 11
                ],
                [
                    'permission_id' => 49,
                    'permission_group_id' => 11
                ],
                [
                    'permission_id' => 50,
                    'permission_group_id' => 11
                ],
                [
                    'permission_id' => 51,
                    'permission_group_id' => 12
                ],
                [
                    'permission_id' => 52,
                    'permission_group_id' => 12
                ],
                [
                    'permission_id' => 53,
                    'permission_group_id' => 12
                ],
                [
                    'permission_id' => 54,
                    'permission_group_id' => 12
                ],
                [
                    'permission_id' => 55,
                    'permission_group_id' => 12
                ],
                [
                    'permission_id' => 56,
                    'permission_group_id' => 12
                ],
            ];

            for ($storeId = 1; $storeId <= 10; $storeId++) {
                foreach ($listPermissionPermissionGroup as $permissionPermissionGroup) {
                    PermissionPermissionGroup::updateOrCreate(array(
                        'permission_id' => $permissionPermissionGroup['permission_id'],
                        'permission_group_id' => $permissionPermissionGroup['permission_group_id'] + ($storeId - 1) * 12
                    ));
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }
}
