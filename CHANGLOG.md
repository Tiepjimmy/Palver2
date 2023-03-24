### INITAL 
01. ubuntu 20.4
02. php 7.4

### 20220105 - upgrade php version
01. php 7.4 -> php 8.1
02. install cron
03. install vim
04. fix không lưu được mysql sau mỗi lần up hoặc down
```
docker build images/ubuntu20-php81
docker composer up 
```
*Lưu ý :* cần xóa các image cũ để giảm dung lượng docker

### 20220106 - fix missing path in api-gateway
01. file \api_gateway\haproxy\sites-enabled\any.api-gateway.local.conf add missing [/]
02. Update network alias shop1-10.api-gateway.local

### 20220112 - Tối ưu docker 
01. Tối ưu config docker composer

### 20220119 - Đổi network alias
01. Đổi network alias từ \*.lc sang \*. docker