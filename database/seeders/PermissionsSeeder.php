<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run(){

        Permission::all()->each(function (Permission $permission){
            $permission->delete();
        });

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //region clients
        Permission::create([
            'name' => 'view-client-overview',
            'slug' => 'مشاهده تب جزییات مشتریان',
        ]);

        Permission::create([
            'name' => 'deactivate-client',
            'slug' => 'فعال/غیرفعال کردن مشتری',
        ]);

        Permission::create([
            'name' => 'delete-client',
            'slug' => 'حذف مشتری',
        ]);
        Permission::create([
            'name' => 'view-client-subscriptions',
            'slug' => 'مشاهده اشتراک مشتریان',
        ]);
        Permission::create([
            'name' => 'view-client-financial',
            'slug' => 'مشاهده تب مالی مشتریان',
        ]);

        //endregion

        //region agents
        Permission::create([
            'name' => 'create-agent',
            'slug' => 'افزودن نماینده',
        ]);
        Permission::create([
            'name' => 'edit-agent',
            'slug' => 'ویرایش نماینده',
        ]);
        Permission::create([
            'name' => 'delete-agent',
            'slug' => 'حذف نماینده',
        ]);
        Permission::create([
            'name' => 'view-agent-table',
            'slug' => 'مشاهده لیست نمایندگان',
        ]);
        Permission::create([
            'name' => 'view-agent-overview',
            'slug' => 'مشاهده تب جزییات نمایندگان',
        ]);
        Permission::create([
            'name' => 'view-agent-clients',
            'slug' => 'مشاهده تب مشتریان نمایندگان',
        ]);
        Permission::create([
            'name' => 'view-agent-financial',
            'slug' => 'مشاهده تب مالی نمایندگان',
        ]);
        Permission::create([
            'name' => 'view-agent-plans',
            'slug' => 'مشاهده تب طرح های نمایندگان',
        ]);
        Permission::create([
            'name' => 'view-agent-security',
            'slug' => 'مشاهده تب امنیت نمایندگان',
        ]);
        Permission::create([
            'name' => 'deactivate-agent',
            'slug' => 'فعال/غیرفعال کردن نماینده',
        ]);
        Permission::create([
            'name' => 'view-agent-references',
            'slug' => 'مشاهده زیر مجموعه نماینده',
        ]);
        Permission::create([
            'name' => 'submit-ticket-for-users',
            'slug' => 'ثبت تیکت برای نماینده',
        ]);
        Permission::create([
            'name' => 'view-agent-tickets',
            'slug' => 'مشاهده تیکت های نماینده',
        ]);
        //endregion

        //region discounts
        Permission::create([
            'name' => 'modify-discount',
            'slug' => 'تعریف تخفیف',
        ]);
        Permission::create([
            'name' => 'delete-discount',
            'slug' => 'حذف تخفیف',
        ]);
        Permission::create([
            'name' => 'view-discount-table',
            'slug' => 'مشاهده لیست تخفیف ها',
        ]);
        //endregion

        //region plans
        Permission::create([
            'name' => 'modify-plan',
            'slug' => 'تعریف طرح',
        ]);
        Permission::create([
            'name' => 'delete-plan',
            'slug' => 'حذف طرح',
        ]);
        Permission::create([
            'name' => 'view-plans-table',
            'slug' => 'مشاهده طرح ها',
        ]);
        Permission::create([
            'name' => 'buy-plan',
            'slug' => 'خرید طرح',
        ]);
        //endregion

        //region domain
        //region discounts
        Permission::create([
            'name' => 'modify-domain',
            'slug' => 'تعریف دامنه',
        ]);
        Permission::create([
            'name' => 'delete-domain',
            'slug' => 'حذف دامنه',
        ]);
        Permission::create([
            'name' => 'view-domain-table',
            'slug' => 'مشاهده لیست دامنه ها',
        ]);
        //endregion
        //endregion

        //region layer
        Permission::create([
            'name' => 'modify-layer',
            'slug' => 'تعریف لایه',
        ]);
        Permission::create([
            'name' => 'delete-layer',
            'slug' => 'حذف لایه',
        ]);
        Permission::create([
            'name' => 'view-layer-table',
            'slug' => 'مشاهده لایه ها',
        ]);
        Permission::create([
            'name' => 'view-layer',
            'slug' => 'مشاهده لایه',
        ]);
        Permission::create([
            'name' => 'change-server-layer',
            'slug' => 'تغییر لایه سرور',
        ]);
        Permission::create([
            'name' => 'change-client-layer',
            'slug' => 'مشاهده لایه مشتری',
        ]);
        //endregion

        //region servers
        Permission::create([
            'name' => 'modify-server',
            'slug' => 'تعریف سرور',
        ]);
        Permission::create([
            'name' => 'delete-server',
            'slug' => 'حذف سرور',
        ]);
        Permission::create([
            'name' => 'view-server-table',
            'slug' => 'مشاهده لیست سرور ها',
        ]);
        Permission::create([
            'name' => 'view-server',
            'slug' => 'مشاهده جزییات سرور',
        ]);
        //endregion


        //region Tickets
        Permission::create([
            'name' => 'submit-ticket-for-user',
            'slug' => 'ثبت تیکت برای کاربران',
        ]);
        Permission::create([
            'name' => 'toggle-ticket-status',
            'slug' => 'تغییر وضعیت تیکت',
        ]);
        //endregion

        //region Financial
        //Invoices
        Permission::create([
            'name' => 'reverse-invoice',
            'slug' => 'برگشت فاکتور',
        ]);

        Permission::create([
            'name' => 'view-invoice',
            'slug' => 'مشاهده فاکتور',
        ]);

        Permission::create([
            'name' => 'view-invoice-table',
            'slug' => 'مشاهده لیست فاکتورها',
        ]);
        //endregion

        //Payment
        Permission::create([
            'name' => 'view-payment-table',
            'slug' => 'مشاهده جدول پرداختی ها',
        ]);



        Permission::create([
            'name' => 'view-user-log',
            'slug' => 'مشاهده لاگ های کاربران',
        ]);


        Permission::create([
            'name' => 'view-transaction-table',
            'slug' => 'مشاهده تراکنش ها',
        ]);

    }



}
