<template>
    <v-card class="mx-auto" outlined>
        <v-card-title class="blue-grey lighten-5 text-center font-weight-bold"> Xem trước mẫu in </v-card-title>
        <v-divider class="mt-0"></v-divider>
        <v-card-text id="print-content" v-html="preview"></v-card-text>
    </v-card>
</template>

<script type="text/javascript">
import $ from 'jquery';

export default {
    name: 'Create',

    props: {
        template: String,
    },

    data: () => ({}),

    computed: {

        /**
         * { function_description }
         *
         * @return     {Object}  { description_of_the_return_value }
         */
        nomalItems() {
            return {
                __LOGO_CUA_HANG__:
                    '<img src="/assets/standard/images/tuha_logo.png?v=03122021" style="max-width: 200px" />',
                __SDT_DOANH_NGHIEP__: '0987666444',
                __EMAIL_DOANH_NGHIEP__: 'email@example.com',
                __DIA_CHI_DOANH_NGHIEP__: '143 Nguyễn Tuân, Thanh Xuân, HN, VN',
                __TEN_CUA_HANG__: 'QLBH',
                __TEN_BAN_IN__: 'Sản phẩm 01',
                __STT_BAN_IN__: 'No. 01',
                __MA_DH__: '4193531',
                __MA_VACH__:
                    '<div style="text-align: center; padding-top: 10px"><img src="assets/lib/php-barcode-master/barcode.php?text=99354583"><br /> <center>99354583</center></div>',
                __MA_VACH_QR__:
                    '<div style="text-align: center; padding-top: 10px"><img src="generate-qr.php?text=99354583"><br /> <center>99354583</center></div>',
                __MA_VACH_QR_MEDIDOC__:
                    '<div style="text-align: center; padding-top: 10px"><img src="generate-qr.php?text=99354583"></div>',
                __MA_VACH_DH__:
                    '<div style="text-align: center; padding-top: 10px"><img src="assets/lib/php-barcode-master/barcode.php?text=S384893.4193531"><br /> <center>S384893.4193531</center></div>',
                __MA_VACH_DH_QR__:
                    '<div style="text-align: center; padding-top: 10px"><img src="generate-qr.php?text=S384893.4193531"><br /> <center>S384893.4193531</center></div>',
                __MA_VACH_VAN_DON__:
                    '<div style="text-align: center; padding-top: 10px"><img src="assets/lib/php-barcode-master/barcode.php?text=S384893.4193531"><br /> <center>S384893.4193531</center></div>',
                __MA_VACH_VAN_DON_QR__:
                    '<div style="text-align: center; padding-top: 10px"><img src="generate-qr.php?text=S384893.4193531"><br /> <center>S384893.4193531</center></div>',
                __MA_VACH_DH_SIZE_LARGE__:
                    '<div style="text-align: center; padding-top: 10px"><img src="assets/lib/php-barcode-master/barcode.php?text=S384893.4193531&size=80"><br /> <center>S384893.4193531</center></div>',
                __MA_VACH_DH_SIZE_LARGE_QR__:
                    '<div style="text-align: center; padding-top: 10px"><img src="generate-qr.php?text=S384893.4193531&size=5"><br /> <center>S384893.4193531</center></div>',
                __MA_VACH_VAN_DON_SIZE_LARGE__:
                    '<div style="text-align: center; padding-top: 10px"><img src="assets/lib/php-barcode-master/barcode.php?text=S384893.4193531&size=80"><br /> <center>S384893.4193531</center></div>',
                __MA_VACH_VAN_DON_SIZE_LARGE_QR__:
                    '<div style="text-align: center; padding-top: 10px"><img src="generate-qr.php?text=S384893.4193531&size=5"><br /> <center>S384893.4193531</center></div>',
                __MA_VAN_DON__: 'SH3456789',
                __SORT_CODE__: '00-00-00/28',
                __NGAY_TAO__: '22/02/2022',
                __NGAY_HIEN_TAI__: '22/02/2022 00:00:00',
                __TONG_TIEN__: '850,000',
                __GHI_CHU_CHUNG__: 'Đơn hàng sử dụng vận chuyển GHTK',
                __GHI_CHU_GIAO_HANG__: 'Giao hàng trong giờ hành chính',
                __NGUOI_TAO_DON__: 'Khoa Nguyen',
                __NGUOI_CHOT_DON__: 'Khoa Nguyen',
                __THANH_TIEN__: '820,000',
                __THANH_TIEN_NOT_SHIPPING__: '820,000',
                __GIAM_GIA__: '20,000',
                __PHI_VAN_CHUYEN__: '20,000',
                __PHU_THU__: '30,000',
                __KIEM_TRA_HANG__: 'Không cho xem hàng',
                __DON_VI_VC__: 'Giao hàng nhanh',
                __DANH_SACH_SP_1__: '1 Áo phông nam size S, 1 Áo cô gái size s, m, l',
                __TEN_NGUOI_GUI__: 'Trịnh Anh Tuấn',
                __PHUONG_XA_NGUOI_GUI__: 'Phường Giảng Võ',
                __QUAN_HUYEN_NGUOI_GUI__: 'Quận Ba Đình',
                __TINH_THANH_NGUOI_GUI__: 'TP. Hà Nội',
                __SDT_NGUOI_GUI__: '0988.888.888',
                __DIA_CHI_NGUOI_GUI__: '222 Giảng Võ',
                __TEN_NGUOI_NHAN__: 'Phạm Hồng Thảo',
                __TINH_THANH_NGUOI_NHAN__: 'TP. Hà Nội',
                __SDT_NGUOI_NHAN__: '0987.888.888',
                __DIA_CHI_NGUOI_NHAN__: '143 Nguyễn Tuân, Thanh Xuân, HN',
                __QUAN_HUYEN_NGUOI_NHAN__: 'Ba Đình',
            };
        },

        /**
         * { function_description }
         *
         * @return     {Array}  { description_of_the_return_value }
         */
        intervalItems() {
            return [
                {
                    __STT_SP__: 1,
                    __MA_SP__: 'MSP_1',
                    __TEN_SP__: 'Tông đơ cắt tóc HT (Loại mới)',
                    __MAU_SAC_SP__: 'Xanh',
                    __SIZE_SP__: 42,
                    __TRONG_LUONG_SP__: 500,
                    __GIA_BAN_SP__: '200,000',
                    __SL_SP__: 2,
                    __DV_SP__: 'Kg',
                    __TONG_TIEN_SP__: '400,000',
                },
                {
                    __STT_SP__: 2,
                    __MA_SP__: 'MSP_2',
                    __TEN_SP__: 'Sữa tắm loại mới',
                    __MAU_SAC_SP__: 'Vàng',
                    __SIZE_SP__: 43,
                    __TRONG_LUONG_SP__: 1000,
                    __GIA_BAN_SP__: '400,000',
                    __SL_SP__: 3,
                    __DV_SP__: 'Thỏi',
                    __TONG_TIEN_SP__: '1,200,000',
                },
            ];
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        preview() {
            return this.replaceTemplate(this.template);
        },
    },
    methods: {
        /**
         * { function_description }
         *
         * @param      {<type>}  template  The template
         * @return     {<type>}  { description_of_the_return_value }
         */
        replaceTemplate(template) {
            if (!template) {
                return;
            }

            let i, j, keyword;
            for (let key in this.nomalItems) {
                template = this.replaceAll(template, '{' + key + '}', this.nomalItems[key]);
            }

            let tempDoc = $('<div/>').html(template);
            let tableWrapper = this.findTableWrapper(tempDoc);
            var replaceInterval = '';

            if (tableWrapper) {
                let trStart = this.findStartLoop(tempDoc, tableWrapper);
                let intervalHtml = this.findHtmlLoopItem(tableWrapper, trStart)

                for (let item of this.intervalItems) {
                    var temp = intervalHtml;
                    for (var key in item) {
                        temp = this.replaceAll(temp, '{' + key + '}', item[key]);
                    }

                    replaceInterval += temp;
                }

                tableWrapper.find('tbody').append(replaceInterval);
                template = tempDoc.html();
            }

            return template;
        },

        /**
         * Finds a table wrapper.
         *
         * @param      {<type>}  tempDoc  The temporary document
         * @return     {<type>}  { description_of_the_return_value }
         */
        findTableWrapper(tempDoc) {
            let tableWrapper = null;

            _.forEach(this.intervalItems, function (item) {
                _.forEach(item, function (value, key) {
                    let tbl = tempDoc
                        .find(":contains('" + key + "')")
                        .last()
                        .closest('table');

                    if (tbl.length && !tableWrapper) {
                        tableWrapper = tbl;
                    }

                    return !tableWrapper;
                });
            });

            return tableWrapper;
        },

        /**
         * Finds a start loop.
         *
         * @param      {<type>}  tempDoc       The temporary document
         * @param      {<type>}  tableWrapper  The table wrapper
         * @return     {<type>}  { description_of_the_return_value }
         */
        findStartLoop(tempDoc, tableWrapper) {
            let trStart = false;

            _.forEach(this.intervalItems, function (item) {
                _.forEach(item, function (value, key) {
                    tempDoc
                        .find(":contains('" + key + "')")
                        .filter(function () {
                            return (
                                $(this)
                                    .clone()
                                    .children()
                                    .remove()
                                    .end()
                                    .filter(":contains('" + key + "')").length > 0
                            );
                        })
                        .each(function () {
                            var trIndex = tableWrapper.find('tbody tr').index($(this).closest('tr'));
                            if (trIndex != -1) {
                                if (trStart === false || trStart == -1 || trStart > trIndex) {
                                    trStart = trIndex;
                                }
                            }
                        });
                });
            });

            return trStart;
        },

        /**
         * Finds a html loop item.
         *
         * @param      {<type>}  tableWrapper  The table wrapper
         * @return     {string}  { description_of_the_return_value }
         */
        findHtmlLoopItem(tableWrapper, trStart) {
            let intervalHtml = '';
            tableWrapper.find('tbody tr').each(function () {
                if (tableWrapper.find('tbody tr').index($(this)) == trStart) {
                    intervalHtml += $('<div/>').append($(this)).html();
                }
            });

            return intervalHtml;
        },

        /**
         * { function_description }
         *
         * @param      {string}    str      The string
         * @param      {<type>}    find     The find
         * @param      {Function}  replace  The replace
         * @return     {string}    { description_of_the_return_value }
         */
        replaceAll: function (str, find, replace) {
            return str.replace(new RegExp(find, 'g'), replace);
        },
    },
};
</script>
