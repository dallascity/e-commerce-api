# Eymen Navdar Case API

Bu proje, Laravel kullanılarak geliştirilmiş bir e-ticaret API'sidir. Kullanıcı yönetimi, ürün işlemleri, sepet yönetimi ve sipariş yönetimi gibi temel özellikleri içermektedir. Projede JWT tabanlı kimlik doğrulama ve Rate Limiting gibi modern güvenlik ve performans yöntemleri uygulanmıştır.

## 🚀 Kullanılan Teknolojiler

-   **Laravel 11**: PHP framework.
-   **Docker**: Konteyner tabanlı geliştirme ortamı.
-   **PHP**: Backend geliştirme dili.
-   **RESTful API**: API tasarımında kullanılan mimari.
-   **JWT (JSON Web Token)**: Kimlik doğrulama yöntemi.
-   **Rate Limiting**: Dakikada maksimum 10 istek sınırı.

---

## 📋 Özellikler

### Authentication (Kimlik Doğrulama)

-   Kullanıcı kaydı.
-   Kullanıcı girişi.
-   JWT tabanlı kimlik doğrulama.
-   Çıkış yapma işlemi.

### Ürün Yönetimi

-   Ürünlerin listelenmesi.
-   Yeni ürün ekleme (Admin yetkisi gerektirir).
-   Mevcut ürünü güncelleme (Admin yetkisi gerektirir).
-   Ürün silme işlemi (Admin yetkisi gerektirir).

### Sepet Yönetimi

-   Ürünlerin sepete eklenmesi.
-   Sepetteki ürünlerin güncellenmesi.
-   Sepetteki ürünlerin kaldırılması.

### Sipariş Yönetimi

-   Sepet içeriğini siparişe dönüştürme.
-   Kullanıcının geçmiş siparişlerini listeleme.
-   Belirli bir siparişi görüntüleme.

### Rate Limiting

-   Her kullanıcı dakikada en fazla 10 API isteği yapabilir.

---

## 🔧 Kurulum

Aşağıdaki adımları izleyerek projeyi kurabilir ve çalıştırabilirsiniz.

### 1. Docker ile Projeyi Başlatma

Projenin Docker konteynerini başlatmak için:

```bash
docker-compose up -d
```

### 2. Storage Link Oluşturma

```bash
php artisan storage:link
```

### 3. Veritabanı Migrasyonu

```bash
php artisan migrate

php artisan migrate:refresh --seed
```
