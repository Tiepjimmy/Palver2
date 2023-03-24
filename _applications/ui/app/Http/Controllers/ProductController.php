<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductExport;
use App\Exports\ProductImport;
use App\Http\Controllers\ProxyController;

class ProductController extends ProxyController
{
    /**
     * exportTemplateSingle
     *
     * @return void
     */
    public function exportTemplateSingle() {
        $file = public_path('exel/Tuha_v2_Template sản phẩm đơn.xls');

        return response()->download($file, 'Tuha_v2_Template sản phẩm đơn.xls');
    }

    /**
     * exportTemplateCombo
     *
     * @return void
     */
    public function exportTemplateCombo() {
        $file = public_path('exel/Tuha_v2_Template sản phẩm combo.xls');

        return response()->download($file, 'Tuha_v2_Template sản phẩm combo.xls');
    }

    /**
     * exportTemplateSingleBranch
     *
     * @return void
     */
    public function exportTemplateSingleBranch() {
        $file = public_path('exel/Tuha_v2_Template sản phẩm đơn chi nhánh.xls');

        return response()->download($file, 'Tuha_v2_Template sản phẩm đơn chi nhánh.xls');
    }

    /**
     * exportTemplateComboBranch
     *
     * @return void
     */
    public function exportTemplateComboBranch() {
        $file = public_path('exel/Tuha_v2_Template sản phẩm combo chi nhánh.xls');

        return response()->download($file, 'Tuha_v2_Template sản phẩm combo chi nhánh.xls');
    }
    
    /**
     * import
     *
     * @param  mixed $request
     * @return void 
     */
    public function import(Request $request) {
        $validator = \Validator::make($request->all(), [
            'fileImport' => 'required|mimes:xls|max:3072',
            'type' => 'required|in:combo,single'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $array = Excel::toArray(new ProductImport, request()->file('fileImport'));

        if ( $request->type == 'single' ) {
            $getSettingList = $this->postParam('account/v1/import/product-single' , $array[0]);
        } else {
            $getSettingList = $this->postParam('account/v1/import/product-combo' , $array[0]);
        }

        return response()->json($getSettingList);
    }

    /**
     * export
     *
     * @return void
     */
    public function export(Request $request) {
        $getData = $this->get($request , 'account/v1/san-pham');
        $getJson = json_decode($getData->getContent(), true);
        $data = $getJson['data']['items'];

        return Excel::download(new ProductExport($data), 'san-pham.xlsx'); 
    }
}
