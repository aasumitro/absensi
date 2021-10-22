# Penggunaan

---

- [Configuration](#section-1)
- [QrCode Generator](#section-2)
- [QrCode Scanner](#section-3)

Cara penggunaan Desktop Platform Client pada Platform OkSetda Absensi (e-Attendance Management System Platform). 

### Daftar isi
1. [Konfigurasi](#section-1)
2. [QrCode Generator](#section-2)
3. [QrCode Scanner](#section-3)

<a name="section-1"></a>
## Konfigurasi
> {info} Anda dapat mengunduh aplikasi desktop melalui tautan berikut ini: 
<u>[**Desktop Client Release Bundle [v1.x]**](https://github.com/Biro-Adpim/oksteda-absensi-distributions/releases)</u>,

Pada saat pertama kali menjalankan aplikasi *desktop client* ini, Anda akan 
disambut oleh sebuah popup atau modal dan Anda diminta untuk mengisi ataupun
memilih sesuai form yang diminta, modal atau popup dapat dilihat pada gambar dibawah ini:
###
![image](https://raw.githubusercontent.com/Biro-Adpim/oksteda-absensi-distributions/main/assets/desktop/setting.png)
###
Pada modal dialog terdapat beberapa form yang harus disi diantaranya adalah:
1. Device Mode 

    Pada `DEVICE MODE` tersedia 2 buah pilihan yaitu `GENERATOR` dan `SCANNER`
    untuk lebih jelasnya silahkan baca penjelasan pada bagian
    [QrCode Generator](#section-2) dan [QrCode Scanner](#section-3)

2. Unique ID

    Setiap kali admin membuat perangkat baru maka sistem akan otomatis membuatkan
    sebuah kode unik secara acak yang mana kode ini merupakan salah satu data kredensial
    yang diperlukan agar client atau aplikasi desktop platform dapat terhubung dengan API dari
    OkSetda Absensi `Server Platfrom`.

3. Secret Key

    Selain `Unique ID` dibutuhkan data kredensial lain yakni sebuah kode rahasia agar Oksetda Absensi 
    `Server Platform` dapat mengetahui apakah perangkat ini benar-benar memiliki otoritas untuk melakukan
    beberapa aksi kedepannya.

4. API URL

    Application Programming Interface Uniform Resource Locator merupakan alamat dari OkSetda Absensi
    `Server Platform` agar  2 perangkat lunak ini dapat berkomunikasi tentu sang client sebagai penerima data
    perlu mengetahui alamat dari si penyedia data
    
> {info} Data kredensial tersebut (**Unique ID**, **Secret Key** dan **API URL**) akan disediakan oleh admin.


<a name="section-2"></a>
## QrCode Generator

Device Mode `GENERATOR`, merupakan mode dimana perangkat lunak menyediakan sebuah QrCode berisikan 
kode rahasia berupa sesi yang dapat di scan melalui OkSetda Absensi `Plafrom Mobile Client`
baik itu Android maupun iOS dan diperuntukan untuk melakukan absensi datang-pulang. 
Pratinjau dapat dilihat pada gambar dibawah ini:
###
![image](https://raw.githubusercontent.com/Biro-Adpim/oksteda-absensi-distributions/main/assets/desktop/generator.png)

<a name="section-3"></a>
## QrCode Scanner

Device Mode `SCANNER`, merupakan mode dimana perangkat lunak mengakses kamera yang dapat
membaca QrCode yang dibuat oleh pengguna pada OkSetda Absensi `Plafrom Mobile Client`
baik itu Android maupun iOS dan diperuntukan untuk melakukan absensi datang-pulang.
Pratinjau dapat dilihat pada gambar dibawah ini:
###
![image](https://raw.githubusercontent.com/Biro-Adpim/oksteda-absensi-distributions/main/assets/desktop/scanner.png)

