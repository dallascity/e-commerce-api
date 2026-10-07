# Eymen Navdar API Service

Bu proje, Laravel 11 kullanılarak geliştirilmiş bir e-ticaret API'sidir. Postman adlı klasörün içinde test edebilmeniz için hazır ayarlı kayıt bulunmaktadır.

## 🚀 Kullanılan Teknolojiler

-   **Laravel 11**: PHP framework.
-   **Docker**: Konteyner tabanlı geliştirme ortamı.
-   **PHP**: Backend geliştirme dili.
-   **RESTful API**
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
docker-compose up --build

docker-compose up -d
```

### 2. Storage Link Oluşturma

```bash
php artisan storage:link
```

### 3. Veritabanı Migrasyonu

-   İlk Önce Laravel Containerinin İçine Girin

```bash
docker exec -it laravel_app bash
```

-   Daha Sonra

```bash
php artisan migrate

php artisan migrate:refresh --seed
```

### 4. Localhost

Localhost Adresi:

```bash
http://localhost:8080
```

PhpMyAdmin Adresi (Kullanıcı Adı = User Şifre = 123) :

```bash
http://localhost:8081
```

### 5. Test Hesapları

- **Admin:** `admin@gmail.com` / `123456789`
- **User:** `test@gmail.com` / `123456789`

### 6. Postman & İçe Aktarma

-   POSTMAN Klasörü İçindeki "EymenNavdarCase.postman_collectionv2.json"
-   Postman'de File > Import seçeneğine tıklayın.
-   JSON dosyasını seçerek koleksiyonu yükleyebilirsiniz.
-   POSTMAN'daki {{URL}} Değişkeni http://localhost:8080/api/ 'dir .
-   İlgili Parametreler Body Kısmındadır.
-   Bearer JWT Token Kullanılmıştır.
