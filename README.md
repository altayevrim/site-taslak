# Kişisel Site Taslağı
Hazır site hazırlamak için güvenli bir Framework üstüne kurulmuş hoş bir site taslağı.  
  
## Ayarlar
Ayar dosyası **config/** dizininde, *sample.ini* dosyasının *rimtay.ini* ile değiştirlmesi ve değişikliklerin yapılması yeterli olacaktır.  
  
  
## İletişim Formu
İletişim formu çalışıyor ve ajax destekliyor. Öncelikle yapılması gereken **assets/js/rimtay.js** dosyasını dahil etmek.  

### Özellikleri
- Telefon numarası kontrolü,
- Gerçek E-Posta kontrolü (alanadı kontrolü yapıyor)
- Max boyut min boyut kontrolü vs.

Ayrıca tasarımınıza bir form dahil edip aşağıdaki işlemleri yapmanız gerekli.  
1- Formunuza aşağıdaki onsubmit değerini ekleyin.
```
onsubmit="event.preventDefault(); contactSend();"
```
2 - name, email, phone, message **id** lerine sahip input'ları sayfanıza eklemek.  
3 - Form gönderilince sistem verileri POST edecek ve sistem gerekli kontrolleri yaptıktan sonra formu gönderecek.  
  
## Tasarım
Tasarımınızı **views/index.html** olarak yerleştirin.

## Haklar
İstenildiği gibi kullanılabilir MIT lisansına sahiptir.