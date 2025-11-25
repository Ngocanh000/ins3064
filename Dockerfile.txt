# Dùng image PHP tích hợp Apache
FROM php:8.2-apache

# Copy toàn bộ code vào thư mục Apache
COPY midterm/ /var/www/html/

# Cấp quyền nếu cần
RUN chown -R www-data:www-data /var/www/html

# Expose port
EXPOSE 80

# CMD mặc định của image php:apache sẽ chạy Apache
