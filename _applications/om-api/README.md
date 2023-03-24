# Tuha Inventory - Cấu trúc
Xây dựng và sử dụng cấu trúc HMVC với Laravel 8.

Ưu điểm: 
- Module hóa: Giảm sự phụ thuộc giữa các thành phần khác nhau của ứng dụng.
- Tính tổ chức: Các thành phần được tổ chức trong một thư mục riêng giúp thực công việc nhẹ nhàng hơn.
- Khả năng tái sử dụng: Theo bản chất của thiết kế, nó dễ dàng sử dụng lại gần như mọi đoạn mã.
- Khả năng mở rộng: Làm cho ứng dụng có thể mở rộng hơn mà vẫn dễ bảo trì.

## Cấu trúc dự án
- Base MVC - Laravel App
    - Module 1 MVC - Small Laravel App
    - Module 2 MVC - Small Laravel App
    - ...
    - Module n MVC - Small Laravel App

## Cấu trúc Module
- ModuleName
    - Console
    - Constants
    - Controllers
    - Jobs
    - Models
        - Entities: Khai báo models
        - Mutator
        - Observers
        - Relations
        - Repositories
            - Contracts: Chứa các interface
            - Eloquent: Chứa các repository
        - Services: Xử lý logic
    - Providers
    - Requests
    - Resources: Chuyển đổi dữ liệu sang json
    - Routes
    - Views

Module giống như một ứng dụng nhỏ, nó vẫn hoạt động mà không cần đầy đủ thành phần.
Chú ý là phải có `ServiceProvider` để khởi tạo module.

## Làm sao để tạo module
1. Tạo module bên trong thư mục `app/Modules`
2. Bên trong thư mục module, tạo các thư mục con theo cấu trúc bên trên (Controllers, Models, Views,...)
3. Tạo file ServiceProvider cho module
4. Kiểm tra module

## Mã lỗi

## Tạo files
- Tạo model
> php artisan make:om-model {name} {--module=} {--table=}
- Tạo repository
> php artisan make:om-repo {name} {--module=}
- Tạo request
> php artisan make:om-request {name} {--module=} {--table=} {--store} {--update}
- Tạo resource
> php artisan make:om-resource {name} {--module=} {--table=}