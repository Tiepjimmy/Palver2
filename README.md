# Môi trường phát triển tuhav2 
Môi trường dành cho việc phát triển hệ thống tuhav2
#### Môi trường bao gồm  các container sau
##### 01. Nghiệp vụ
01. ui : Base UI
02. account : Account API 
03. om : Order manager API
04. inventory : Inventory API
##### 02. Sử dụng chung
01. api-gateway : HAProxy, thực hiện việc điều hướng theo domain name
01. reserved_proxy : Thực hiện việc điều hướng theo domain name ( không xuất hiện trên production, Staging )
02. mariadb : Mariadb chung của dự án ( rds ). root/root 
03. redis : Cache chung của dự án 
04. s3 : Simple storage service là dự án thực hiện việc lưu ảnh, tài liệu, ...
05. cdn : Giả lập cdn local 
06. sys : System project. Thực hiệc việc login, quản lý phân hệ.
07. migration : Quản lý migration, seed db

#### Các domain sẽ được sử dụng 
01. any.tuhav2.local      : (shop01, shop02).tuhav2.local toàn hộ các site của khách hàng ( base UI )
02. any.api-gateway.local : (shop01, shop02).api-gateway.local Api gateway sử dụng để test api( inventory, om, account)
03. cdn.local             : Giả lập CDN 
04. s3.local              : API sử dụng đển kiểm tra simple storage service
05. tuhav2.local          : System project

#### Thư mục được phân chia như sau 
01. ./_applications : chứa toàn bộ ứng dụng 
02. ./_applications/* : tên các dự án 
03. ./_storages/* : lưu chữa file
04. ./api_gateway/* : lưu thông tin api gateway ( có thể là kongd hoặc haproxy )
05. ./images/* : Custom images được sử dụng trong dự án 
06. ./rds/* : relation database system. cấu hình cho mariadb 
07. ./reserved_proxy/* : Lưu thông tin reserved proxy cho  môi trường local 

## Thực hiện chạy hệ thống 
**Bước 01 : Thực hiên khởi tạo images**
```sh
docker compose up -d 
```
*Lưu ý :*
*1. không chạy trực tiếp trên google drive*
*2. Nếu mạng không ổn định có thể dẫn đến lỗi pull image*

**Bước 02 : Đăng kí api gateway**
N/A

**Bước 03 : Khởi động lại api**
```sh 
docker compose down && docker compose up -d
```

**Bước 04 : Cấu hình truy cập theo domain name**
Thêm các dòng sau vào host file 
window : C:\Windows\System32\drivers\etc\hosts
ubuntu : /etc/hosts
```text
127.0.0.1 api-gateway.local
127.0.0.1 cdn.local
127.0.0.1 s3.local
127.0.0.1 tuhav2.local
127.0.0.1 shop1.tuhav2.local
127.0.0.1 shop2.tuhav2.local
127.0.0.1 shop3.tuhav2.local
127.0.0.1 shop4.tuhav2.local
127.0.0.1 shop5.tuhav2.local
127.0.0.1 shop6.tuhav2.local
127.0.0.1 shop7.tuhav2.local
127.0.0.1 shop8.tuhav2.local
127.0.0.1 shop9.tuhav2.local
127.0.0.1 shop10.tuhav2.local
127.0.0.1 shop1.api-gateway.local
127.0.0.1 shop2.api-gateway.local
127.0.0.1 shop3.api-gateway.local
127.0.0.1 shop4.api-gateway.local
127.0.0.1 shop5.api-gateway.local
127.0.0.1 shop6.api-gateway.local
127.0.0.1 shop7.api-gateway.local
127.0.0.1 shop8.api-gateway.local
127.0.0.1 shop9.api-gateway.local
127.0.0.1 shop10.api-gateway.local
```
