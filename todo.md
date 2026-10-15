## TODO:

# Mengganti mekanisme cancel Invoice

1. Ubah SP jurnal cancel invoice, data lama jangan dihapus, cukup di reverse pakai (jurnal_id + 'R').
2. Ganti semua referensi schedulepayment_id yang terhubung ke jurnal beberapa file IPRO berikut ini :
 `model_dashboard.php` => line 654
 `invoice_id`
