<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnTimestampToDatetime extends Migration
{
    private $tables = [
        'acc_m_attribute_type',
        'acc_m_districts',
        'acc_m_features',
        'acc_m_permissions',
        'acc_m_provinces',
        'acc_m_subsystems',
        'acc_m_volume_units',
        'acc_m_wards',
        'acc_m_warehouse_types',
        'acc_t_assign_permission_group',
        'acc_t_assigns',
        'acc_t_attribute_float',
        'acc_t_attribute_groups',
        'acc_t_attribute_int',
        'acc_t_attribute_varchar',
        'acc_t_combos',
        'acc_t_job_titles',
        'acc_t_password_histories',
        'acc_t_permission_groups',
        'acc_t_permission_permission_group',
        'acc_t_product_attributes',
        'acc_t_product_catalog_attribute_group',
        'acc_t_product_catalogs',
        'acc_t_product_entities',
        'acc_t_product_entity_attribute_float',
        'acc_t_product_entity_attribute_int',
        'acc_t_product_entity_attribute_varchar',
        'acc_t_product_entity_prices',
        'acc_t_product_gallery',
        'acc_t_product_provider',
        'acc_t_products',
        'acc_t_provider_groups',
        'acc_t_provider_provider_group',
        'acc_t_providers',
        'acc_t_retail_combos',
        'acc_t_retail_product_entities',
        'acc_t_retail_product_entity_prices',
        'acc_t_retail_product_gallery',
        'acc_t_retail_products',
        'acc_t_store_permission_group',
        'acc_t_store_product_catalog',
        'acc_t_store_provider',
        'acc_t_stores',
        'acc_t_system_settings',
        'acc_t_user_tokens',
        'acc_t_users',
        'acc_t_warehouse_store',
        'acc_t_warehouses',

    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->datetime('created_at')->comment('Ngày thêm bản ghi')->change();
                $table->datetime('updated_at')->nullable()->comment('Ngày sửa bản ghi')->change();
                $table->datetime('deleted_at')->nullable()->comment('Ngày xóa bản ghi')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $tableName) {
            \DB::statement("ALTER TABLE `".$tableName."` CHANGE `created_at` `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP");
            \DB::statement("ALTER TABLE `".$tableName."` CHANGE `updated_at` `updated_at` TIMESTAMP NULL");
            \DB::statement("ALTER TABLE `".$tableName."` CHANGE `deleted_at` `deleted_at` TIMESTAMP NULL");
        }
    }
}
