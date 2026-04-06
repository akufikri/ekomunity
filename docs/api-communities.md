# API Communities

Base URL: `/api`
Auth: `Bearer {token}` (semua endpoint perlu Sanctum token)

---

## 1. GET `/api/communities/{id}`
Papar maklumat komuniti.

**Response:**
```json
{
    "id": 1,
    "nama_pertubuhan": "Taman Melati RA",
    "email": "taman.melati@gmail.com",
    "no_pendaftaran": "PPM-001-14-25012022",
    "poskod": "88000",
    "nama_wakil": "Ahmad Rizky",
    "email_wakil": "rizky@gmail.com",
    "no_telefon_wakil": "60123456789",
    "no_telefon_pejabat": "60123678342",
    "daerah": "Penampang",
    "negeri": "Sabah",
    "no_fax": null,
    "laman_web": "tamanmelati.com",
    "yuran": null,
    "alamat": "Jalan Pintas Penampang, Kobusak",
    "slogan": "Komuniti Sejahtera, Hidup Bahagia",
    "mengenai": "Persatuan Penduduk Taman Melati...",
    "pautan": "https://ekomuniti.my/tamanmelati",
    "gambar_persatuan": null,
    "banner": null
}
```

---

## 2. PUT `/api/communities/{id}`
Update maklumat komuniti. Hanya boleh dilakukan oleh owner komuniti.

**Request:** `multipart/form-data`

| Field | Type | Keterangan |
|-------|------|------------|
| `nama_pertubuhan` | string | Nama komuniti |
| `email` | string | Email wakil |
| `no_pendaftaran` | string | No. pendaftaran |
| `poskod` | string | Poskod |
| `negeri` | integer | ID negeri |
| `daerah` | integer | ID daerah/bandar |
| `no_telefon_pejabat` | string | No. telefon pejabat |
| `no_fax` | string | No. fax |
| `no_telefon` | string | No. telefon wakil |
| `laman_web` | string | URL laman web |
| `kostum_nama_pautan` | string | Custom link profil |
| `yuran` | numeric | Yuran keahlian |
| `slogan` | string | Slogan komuniti |
| `mengenai` | string | Penerangan komuniti |
| `alamat` | string | Alamat |
| `gambar_persatuan` | file | Logo komuniti |
| `banner` | file | Gambar banner |
| `toyyibpay_category_code` | string | ToyyibPay category code |
| `toyyibpay_secret_key` | string | ToyyibPay secret key |

**Response:**
```json
{
    "message": "Maklumat komuniti berjaya dikemaskini"
}
```

---

## 3. GET `/api/communities/{id}/members`
Senarai ahli komuniti dengan search dan pagination.

**Query Params:**

| Param | Type | Keterangan |
|-------|------|------------|
| `search` | string | Carian nama / email / telefon / IC |
| `page` | integer | Nombor halaman (default: 1) |

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "name": "Ahmad Rizky",
            "initials": "AR",
            "email": "rizky@gmail.com",
            "phone": "60123456789",
            "ic": "880101145521",
            "role": "member",
            "bumiputera": "Bumiputera",
            "invoice": "PAID",
            "jawatan": "Pengerusi",
            "status": "Aktif"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 5,
        "total": 128
    }
}
```

**Nilai yang mungkin:**
- `role`: `admin` / `member`
- `invoice`: `PAID` / `UNPAID` / `EXPIRED`
- `status`: `Aktif` / `Tidak Aktif`

---

## 4. PUT `/api/communities/{id}/members/{member_id}`
Update data ahli. Hanya boleh dilakukan oleh owner komuniti.

**Request:** `application/json`

```json
{
    "name": "Ahmad Rizky",
    "ic": "880101145521",
    "phone": "60123456789",
    "email": "rizky@gmail.com",
    "bumiputera": "Bumiputera",
    "invoice": "PAID",
    "jawatan": "Pengerusi",
    "status": "Aktif"
}
```

**Response:**
```json
{
    "message": "Maklumat ahli berjaya dikemaskini"
}
```

---

## 5. POST `/api/communities/{id}/invite`
Hantar jemputan kepada ahli baharu melalui emel.

**Request:** `application/json`

```json
{
    "email": "ahmadnoorasyrul@gmail.com"
}
```

**Response:**
```json
{
    "message": "Jemputan berjaya dihantar"
}
```

---

## Error Responses

| Code | Keterangan |
|------|------------|
| `401` | Tidak log masuk |
| `403` | Tidak dibenarkan (bukan owner) |
| `404` | Data tidak ditemukan |
| `422` | Validation gagal / data konflik |
