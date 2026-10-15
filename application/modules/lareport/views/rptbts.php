<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
@font-face {
    font-family: 'arial'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/arial.ttf');?>'); /*URL to font*/
}
body {font-family: 'arial';font-size: 10pt}
@page { margin-left:3cm; margin-right:3cm; margin-top:3cm;margin-bottom:2cm;size:8.27in 11.69in;}
</style>
</head>
<body>
<?php
if(isset($result)){
foreach($result as $row){ 
$pasunitname = '';
	  $pasunitsqm = 0;
	  foreach($vunit as $rowunit){ 
	  		$pasunitname .= $rowunit->unit_name. '&'; 
			$pasunitsqm =$rowunit->unit_sqm+$pasunitsqm; 
	  }
	  $vunitname = trim($pasunitname, "&");
	  $vunitsqm =$pasunitsqm;
?>
<table width="753" border="0">
  <tr>
    <td align="center"><p align="center"><strong><u>PERJANJIAN SEWA MENYEWA</u></strong></p></td>
  </tr>
  <tr>
    <td align="center"><b>No.<?php echo $nolah;?></b></td>
  </tr>
   <tr>
    <td align="center">&nbsp;</td>
  </tr>
  </table>
  <br />
     <table width="753" border="0">
  <tr>
    <td width="33" valign="top"><b>1</b></td>
    <td width="710" valign="top" align="justify"><strong><?php echo $row->region_namereport;?></strong>,  suatu perseroan yang didirikan dan tunduk pada hukum Negara Republik Indonesia, berdomisili di <?php echo $row->branch_namerpt;?> (selanjutnya disebut &quot;<strong>Pemilik</strong>&quot;); dan</td>
  </tr>
  <tr>
    <td valign="top"><b>2</b></td>
    <td valign="top" align="justify"><strong><?php echo $row->rekanan_name;?></strong>,  suatu perseroan yang didirikan dan tunduk pada hukum Negara Republik Indonesia,  berdomisili di <?php echo $row->rekanan_address;?>. (selanjutnya  disebut &quot;<strong>Penyewa</strong>&quot;),</td>
    </tr>
  <tr>
    <td colspan="2" valign="top" align="justify">(Pemilik dan Penyewa secara  bersama-sama selanjutnya disebut &quot;<strong>Para  Pihak</strong>&quot; dan salah satu dari Para Pihak selanjutnya disebut juga &quot;<strong>Pihak</strong>&quot;)</td>
    </tr>
  <tr>
    <td height="36" colspan="2" align="center" valign="middle"><p align="center"><strong>Mengingat:</strong></p></td>
    </tr>
  <tr>
    <td valign="top">A.</td>
    <td valign="top" align="justify">Bahwa,  Pemilik adalah pemilik gedung <?php echo $row->branch_namerpt;?>.. , <?php echo $row->branch_address;?>. (selanjutnya disebut &quot;<strong>Carrefour</strong>&quot;);</td>
  </tr>
  <tr>
    <td valign="top">B.</td>
    <td valign="top" align="justify">Bahwa,  Penyewa adalah perseroan yang bergerak dalam bidang telekomunikasi yang  memerlukan lokasi untuk memasang/menempatkan pemancar jaringan dan/atau  peralatan telekomunikasi <em>outdoor</em>; dan</td>
  </tr>
  <tr>
    <td valign="top">C.</td>
    <td valign="top" align="justify">Bahwa,  sehubungan dengan butir B. di atas, Penyewa bermaksud untuk menyewa lokasi di  Carrefour dari Pemilik.</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" align="justify">OLEH KARENANYA, berdasarkan hal-hal  tersebut di atas, Para Pihak setuju untuk membuat Perjanjian Sewa Menyewa ini  (selanjutnya disebut &quot;<strong>Perjanjian</strong>&quot;),  dengan ketentuan dan syarat-syarat sebagaimana diatur di bawah ini:</td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top"><p align="center"><strong>Pasal 1</strong></p></td>
    </tr>
  <tr>
    <td colspan="2" align="center" valign="top"><p align="center"><strong>KESEPAKATAN SEWA MENYEWA</strong></p></td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">1.1</td>
    <td valign="top" align="justify">Pemilik dengan ini setuju untuk menyewakan Lokasi Sewa (sebagaimana dimaksud dalam  Pasal 2 Perjanjian ini) kepada Penyewa dan Penyewa dengan ini setuju untuk  menyewa Lokasi Sewa dari Pemilik.</td>
  </tr>
  <tr>
    <td valign="top">1.2</td>
    <td valign="top" align="justify">Selanjutnya, Penyewa diberikan ijin untuk, sepanjang berdasarkan petunjuk dan dalam pengawasan  dari Pemilik, memasang/menempatkan jaringan atau kabel data untuk menghubungkan peralatan telekomunikasi yang akan dioperasikannya.</td>
  </tr>
  <tr>
    <td valign="top">1.3</td>
    <td valign="top" align="justify">Peralatan  telekomunikasi yang akan dioperasikan oleh penyewa adalah milik operator …….  (&ldquo;operator&rdquo;).</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" align="center"><strong>Pasal 2</strong></td>
    </tr>
  <tr>
    <td colspan="2" align="center" valign="top"><strong>KETENTUAN POKOK SEWA MENYEWA</strong></td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" align="justify">Pemilik dan Penyewa dengan ini setuju bahwa penyewaan lokasi di Carrefour yang dilakukan, tunduk pada  ketentuan-ketentuan berikut ini:</td>
    </tr>
  <tr>
    <td valign="top">2.1</td>
    <td valign="top"><strong>Lokasi</strong></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top"><p>Lokasi sewa terletak di bangunan Carrefour dengan ketentuan sebagai berikut:</p></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top" align="justify"><ul>
      <li>atap  gedung (<em>rooftop</em>) Carrefour dengan luas <?php echo $vunitsqm;?> m2  (<?php echo number_to_wordsnorp($vunitsqm);?> meter persegi)  per operator untuk memasang/menempatkan peralatan telekomunikasi selular GSM  milik Penyewa yang digunakan sebagai stasiun penerima dan pemancar selular.</li>
    </ul></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top" align="justify">sebagaimana dijelaskan lebih rinci dalam <i>layout</i> Lokasi Sewa  terlampir dalam <strong>Lampiran A</strong> Perjanjian ini atau lokasi lain yang ditentukan oleh Pemilik (selanjutnya  disebut &ldquo;<strong>Lokasi Sewa</strong>&rdquo;).</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top"><p><u>Sarana Pendukung</u>:</p></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top" align="justify">Penyewa harus memiliki semua ijin yang diperlukan dan mematuhi semua ketentuan yang berlaku untuk mendirikan dan/atau memasang dan/atau mengoperasikan peralatan telekomunikasi yang dipergunakan, dalam hal jaringan dan/atau peralatan telekomunikasi yang dipasang meliputi menara telekomunikasi, Penyewa harus melengkapi persyaratan antara lain sebagai berikut (sebagaimana relevan):</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  </table>
 <table width="753" border="0">
  <tr>
    <td width="38" valign="top">(a)</td>
    <td colspan="2" valign="top">Sarana  pendukung:</td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td width="19" valign="top">(i)</td>
    <td width="682" valign="top"><em>grounding</em>;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(ii)</td>
    <td valign="top">penangkal  petir; dan</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(iii)</td>
    <td valign="top">pagar  pengaman.</td>
  </tr>
  <tr>
    <td valign="top">(b)</td>
    <td colspan="2" valign="top">Identitas  hukum:</td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(i)</td>
    <td valign="top">nama  pemilik menara;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(ii)</td>
    <td valign="top">lokasi  dan koordinat menara;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(iii)</td>
    <td valign="top">tinggi  menara;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(iv)</td>
    <td valign="top">tahun  pembuatan/pemasangan menara;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(v)</td>
    <td valign="top">penyedia  jasa konstruksi; dan</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(vi)</td>
    <td valign="top">beban  maksimum menara.</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>

  <tr>
    <td valign="top">2.2</td>
    <td colspan="2" valign="top"><strong>Masa Sewa</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(a)</td>
    <td valign="top" align="justify">Masa/periode  sewa menyewa Lokasi Sewa adalah <?php echo $row->agreement_term;?>( <?php echo number_to_wordsnorp($row->agreement_term);?>) bulan sejak tanggal <?php echo $new_date = date('d F Y', strtotime($row->loo_sdate));?> sampai dengan <?php echo $new_date = date('d F Y', strtotime($row->loo_edate));?>.<br />(selanjutnya  disebut &ldquo;<strong>Masa Sewa</strong>&rdquo;).</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(b)</td>
    <td valign="top" align="justify">Kecuali  diakhiri sebelumnya menurut Pasal 7.3 atau Pasal 10.3 Perjanjian ini, 3 (tiga)  bulan sebelum berakhirnya Masa Sewa, Penyewa akan memberitahukan kepada Pemilik  mengenai akan berakhirnya Masa Sewa. Para Pihak, dengan kesepakatan bersama  secara tertulis, dapat memperpanjang Masa Sewa.</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(c)</td>
    <td valign="top" align="justify">Dalam hal  berakhirnya Masa Sewa dan tidak terdapat perpanjangan Masa Sewa atau  pengakhiran Masa Sewa lebih awal, maka Penyewa wajib, dengan biayanya sendiri,  membongkar peralatan telekomunikasi miliknya dan memindahkan keluar Lokasi Sewa  dalam jangka waktu 1 (satu) hari kalender. Apabila setelah jangka waktu 1  (satu) hari tersebut, Penyewa tidak membongkar atau memindahkan peralatan  telekomunikasi tersebut, maka Pemilik mempunyai pilihan, namun bukan kewajiban,  untuk membongkar peralatan tersebut dengan biaya Penyewa dan Penyewa harus  segera membayar biaya tersebut tanpa ada sanggahan apapun.</td>
  </tr>
  <tr>
    <td valign="top">2.3</td>
    <td colspan="2" valign="top"><strong>Penggunaan Lokasi Sewa</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top" align="justify">Lokasi Sewa dipergunakan  hanya untuk menempatkan, memelihara dan mengoperasikan peralatan telekomunikasi  milik Penyewa terkait dengan keperluan operasional stasiun penerima dan  pemancar sinyal selular sesuai dengan spesifikasi yang disetujui terlebih  dahulu secara tertulis oleh Pemilik dan mematuhi semua ketentuan yang berlaku  (selanjutnya disebut &quot;<strong>Tujuan Sewa</strong>&quot;).</td>
   </tr>
  <tr>
    <td valign="top">2.4</td>
    <td colspan="2" valign="top"><strong>Harga Sewa dan Cara Pembayaran</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(a)</td>
    <td valign="top" align="justify"><p>Harga  Sewa Lokasi selama Masa Sewa adalah sebesar Rp. <?php echo number_format($rtotbts,0);?>,- (<?php echo number_to_wordsnorp($rtotbts);?> Rupiah) per tahun termasuk Pajak  Penghasilan (&ldquo;<strong>PPh</strong>&rdquo;) namun tidak termasuk Pajak Pertambahan Nilai (&ldquo;<strong>PPN</strong>&rdquo;)  dan pengeluaran listrik selama Masa Sewa (selanjutnya disebut &ldquo;<strong>Harga Sewa</strong>&rdquo;).</p>
    <p>Total Biaya Sewa yang  harus dibayarkan selama <?php echo $row->agreement_term;?>( <?php echo number_to_wordsnorp($row->agreement_term);?>) bulan <?php if ($row->agreement_dayterm>0){ echo $row->agreement_dayterm." hari";}?> jangka waktu sewa menyewa adalah sebesar <strong>Rp. <?php echo number_format($rtotbts1,0);?>,- (<?php echo number_to_wordsnorp($rtotbts1);?> Rupiah)</strong> termasuk Pajak Penghasilan (&ldquo;<strong>PPh</strong>&rdquo;)  namun tidak termasuk Pajak Pertambahan Nilai (&ldquo;<strong>PPN</strong>&rdquo;) dan pengeluaran listrik selama Masa Sewa.</p></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(b)</td>
    <td valign="top"><p>Cara  pembayaran Harga Sewa adalah sebagai berikut:</p></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top" align="justify">Para pihak setuju bahwa  penyewa akan membayar sejumlah uang sewa untuk jangka waktu sewa pada sebesar <strong>Rp. <?php echo number_format($rtotbts1,0);?>,- ( <?php echo number_to_wordsnorp($rtotbts1);?> Rupiah)</strong><strong> </strong>yang akan dibayarkan di muka, sesuai  dengan ketentuan dalam lampiran B, Jadwal Pembayaran.</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top" align="justify"><p>Pembayaran Harga Sewa  harus dilakukan dalam waktu 14 (empat belas) hari kalender setelah tanggal <em>invoice</em> yang diterbitkan Pemilik.  Apabila dalam waktu 14 (empat belas) hari kalender dimaksud, Penyewa belum  melakukan pembayaran Harga Sewa, maka Pemilik berhak untuk: (i) mengakhiri  Perjanjian ini tanpa kompensasi apapun kepada Penyewa; dan/atau (ii) mengenakan  denda kepada Penyewa sebesar 0,1% dari total <em>invoice </em>untuk setiap hari keterlambatan.<br />
      Penyewa akan melakukan  pemotongan Pajak PPh setiap pembayaran harga Sewa dan berkewajiban menyampaikan  bukti potong PPh asli kepada Pemilik paling lambat 1 (satu) bulan setelah  tanggal pembayaran terkait. Kegagalan atas kewajiban tersebut akan  diperhitungkan sebagai tunggakan Penyewa dan Pemilik berhak mengenakan denda  keterlambatan kepada Penyewa.<br />
    Pembayaran harus  disampaikan oleh Penyewa melalui transfer ke akun bank berikut:</p></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><p>PT. TRANS RETAIL INDONESIA<br />
    PEMBAYARAN DILAKUKAN KE NO  VIRTUAL ACCOUNT …...<br />
    BANK MEGA CABANG  TENDEAN<br />
    <br />
    Bukti pembayaran wajib  dikirim melalui fax yang ditujukan kepada:<br />
    </p>
    <p>PT. TRANS RETAIL INDONESIA  – Divisi Shopping Mall<br />
Carrefour Lebak Bulus 3rd  Floor, Jl. Lebak Bulus Raya No. 8 Jakarta 12310<br />
Fax No. 27585899</p>
    <p>&nbsp; </p></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top" align="justify">Penyewa sepakat bahwa pembayaran di muka tidak dapat dikembalikan dalam hal terjadi pemutusan awal  terhadap Perjanjian ini yang disebabkan karena kegagalan pembayaran oleh Penyewa.</td>
  </tr>
  <tr>
    <td valign="top">2.5</td>
    <td colspan="2" valign="top"><strong>Fasilitas Listrik</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top" align="justify">Beban harga atas fasilitas  listrik ditanggung oleh Penyewa pada tarif dan menurut persyaratan yang  dibebankan oleh Perusahaan Listrik Negara (PLN) dari waktu ke waktu kepada  konsumen dengan kategori penggunaan yang sama dengan Penyewa, yang menggunakan  jumlah listrik yang sama seperti Penyewa atau harga lain yang dapat dibayarkan  oleh Pemilik berdasarkan pemakaian tercatat dalam meteran listrik setiap bulan  ditambah 10% (sepuluh persen) dari tagihan untuk biaya administrasi. Biaya  tersebut akan dikenakan PPN dan pajak-pajak terkait lainnya.</td>
   </tr>
  <tr>
    <td valign="top">2.6</td>
    <td colspan="2" valign="top"><strong>Eksklusivitas</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top" align="justify">Tidak ada ketentuan dalam  Perjanjian ini yang dapat diartikan bahwa pemilik memberikan hak eksklusivitas  atau hak prioritas kepada Penyewa sebagai satu-satunya pihak yang diberikan hak  penuh untuk bekerja sama dengan operator atau pihak lain yang berhubungan  dengan pemasangan peralatan telekomunikasi baik <em>indoor</em> dan <em>outdoor coverage</em> termasuk <em>rooftop </em>(sebagaimana  relevan). Dalam hal Pemilik bermaksud menambah operator atau penyewa lain, maka  Pemilik tanpa persetujuan dari Penyewa, berhak untuk menerima dan/atau bekerja  sama dengan operator terkait untuk memasang/menempatkan jaringan atau kabel  data peralatan telekomunikasi yang akan dioperasikan di Carrefour.</td>
   </tr>
  <tr>
    <td valign="top">2.7</td>
    <td colspan="2" valign="top"><strong>Gangguan Telekomunikasi</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top" align="justify">Dalam hal Pemilik dan/atau penyewa dan/atau pengguna gedung lainnya mengalami gangguan koneksi dan/atau interkoneksi dan/atau komunikasi yang disebabkan karena pemasangan/penempatan peralatan dan/atau peralatan telekomunikasi yang  dikembangkan dan/atau diletakkan oleh Penyewa di Lokasi Sewa, maka Penyewa harus segera memperbaiki sistem sampai koneksi dan/atau interkoneksi dan/atau komunikasi Pemilik atau penyewa atau pengguna gedung tidak terganggu.</td>
   </tr>
  <tr>
    <td valign="top">2.8</td>
    <td colspan="2" valign="top"><strong>Renovasi</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top" align="justify">Dalam  hal Pemilik bermaksud untuk melakukan renovasi Carrefour atau kegiatan lain  yang mengharuskan dilakukannya pemindahan peralatan telekomunikasi milik  Penyewa, Penyewa bersedia untuk memindahkan Lokasi Sewa ke lokasi lain dalam  Carrefour dengan luas minimal sama dan biaya bongkar maupun pasang peralatan  telekomunikasi ditanggung oleh Penyewa.</td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" valign="top" align="center"><b>Pasal 3</b></td>
   </tr>
  <tr>
    <td colspan="3" align="center" valign="top"><strong>TANGGUNG JAWAB</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">3.1</td>
    <td colspan="2" valign="top" align="justify">Baik  Pemilik maupun pegawai dan/atau wakilnya tidak bertanggung jawab kepada Penyewa  atau kepada setiap pihak lainnya, atas setiap kehilangan, kerugian atau  kerusakan yang diderita oleh pihak ketiga dan/atau Penyewa atau pihak lain yang  bertindak untuk dan atas nama Penyewa atau kontraktor atau rekanan Penyewa atau  kepada pihak lain di dalam Carrefour atau Lokasi Sewa yang timbul sehubungan  dengan penggunaan Lokasi Sewa oleh Penyewa. </td>
   </tr>
  <tr>
    <td valign="top">3.2</td>
    <td colspan="2" valign="top" align="justify">Penyewa  harus bertanggung jawab sepenuhnya dan membebaskan, membela dan melindungi  Pemilik dan wakilnya dari dan terhadap seluruh gugatan, permintaan, tindakan,  tuntutan, perkara hukum, perintah, putusan pengadilan, biaya, kerugian dan  pengeluaran (termasuk imbalan pengacara dan biaya pengadilan) (selanjutnya disebut  &ldquo;<strong>Kerugian</strong>&rdquo;), termasuk Kerugian yang  diderita atau dialami oleh Pemilik atau wakilnya sehubungan dengan  ketidaklengkapan perijinan atau persetujuan yang wajib diperoleh Penyewa  dan/atau kontraktor dan/atau mitra kerjanya untuk melakukan kegiatannya dan/atau  kehilangan nyawa atau cedera pada seseorang dan/atau kerusakan pada suatu  barang milik Carrefour atau Lokasi Sewa atau milik pihak ketiga atau bagian  daripadanya yang timbul dari atau akibat pengoperasian dan/atau penggunaan  peralatan telekomunikasi oleh Penyewa, pihak yang bertindak untuk dan atas nama  Penyewa atau kontraktor atau rekanan Penyewa atau yang disebabkan oleh  perbuatan, kecerobohan, kelalaian atau tindakan Penyewa atau pihak yang  bertindak untuk dan atas nama Penyewa atau kontraktor atau rekanan Penyewa.</td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" valign="top" align="center"><strong>Pasal 4</strong></td>
   </tr>
  <tr>
    <td colspan="3" align="center" valign="top"><strong>PERNYATAAN DAN JAMINAN</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">4.1</td>
    <td colspan="2" valign="top"><strong>Pernyataan dan Jaminan Pemilik</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top"><p>Pemilik menyatakan dan  menjamin Penyewa bahwa:</p></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(a)</td>
    <td valign="top" align="justify">Pemilik  mempunyai kecakapan hukum penuh dan kewenangan untuk menandatangani dan  melaksanakan hak dan kewajibannya berdasarkan Perjanjian ini dan  penandatanganan Perjanjian ini adalah sah, mengikat dan dapat dilaksanakan  serta tidak akan melanggar perjanjian lain dimana Pemilik adalah merupakan  salah satu pihak atau dimana ia terikat;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(b)</td>
    <td valign="top" align="justify">Pemilik  akan, dengan pemberitahuan tertulis terlebih dahulu, mengijinkan karyawan  Penyewa atau pihak yang bertindak untuk dan atas nama Penyewa untuk memasuki  Lokasi Sewa dalam waktu dan jam kerja, atau waktu-waktu lainnya yang disetujui  Pemilik, dalam rangka melakukan konstruksi, instalasi, perawatan,  pengoperasian, perbaikan atau <em>upgrade</em> peralatan telekomunikasi milik Penyewa yang berada di dalam Lokasi Sewa menurut  ketentuan yang ditetapkan oleh Pemilik; dan</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(c)</td>
    <td valign="top" align="justify">Lokasi  Sewa dan Carrefour tidak dalam keadaan sengketa dengan pihak manapun juga.</td>
  </tr>
  <tr>
    <td valign="top">4.2</td>
    <td colspan="2" valign="top"><p><strong>Pernyataan  dan Jaminan Penyewa</strong></p></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top"><p>Penyewa menyatakan dan  menjamin Pemilik bahwa:</p></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(a)</td>
    <td valign="top" align="justify">Penyewa adalah pemilik atau penyewa yang sah atas semua peralatan telekomunikasi yang akan dipasang di Carrefour;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(b)</td>
    <td valign="top" align="justify">Penyewa telah memperoleh semua perijinan dan/atau persetujuan yang diperlukan untuk  melakukan kegiatan usahanya di bidang telekomunikasi atau penyedia menara serta memasang/menempatkan dan menyewakan jaringan dan/atau peralatan telekomunikasi  menurut Perjanjian ini;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(c)</td>
    <td valign="top" align="justify">Penyewa mempunyai kecakapan hukum penuh dan kewenangan untuk menandatangani dan melaksanakan hak dan kewajibannya berdasarkan Perjanjian ini dan penandatanganan Perjanjian ini adalah sah, mengikat dan dapat dilaksanakan serta tidak akan melanggar perjanjian lain dimana Penyewa adalah merupakan salah satu pihak atau dimana ia terikat;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(d)</td>
    <td valign="top">Penyewa hanya akan menggunakan Lokasi Sewa untuk Tujuan Sewa;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(e)</td>
    <td valign="top" align="justify">dengan pemberitahuan yang wajar dari Pemilik, Penyewa akan mengijinkan Pemilik atau wakilnya untuk masuk ke dalam Lokasi Sewa untuk melakukan pemeliharaan dan/atau perbaikan dan/atau pekerjaan lainnya yang menurut Pemilik, secara wajar,  diperlukan;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(f)</td>
    <td valign="top" align="justify">Penyewa akan bertanggung jawab terhadap setiap terjadinya cedera atau kerusakan atau kerugian atau tuntutan akibat jatuh/ambruknya jaringan dan/atau peralatan  telekomunikasi milik Penyewa dan/atau kontraktornya;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(g)</td>
    <td valign="top" align="justify">Penyewa akan menanggung biaya instalasi yang terjadi akibat pemasangan perangkat oleh Penyewa maupun kontraktornya;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(h)</td>
    <td valign="top" align="justify">Penyewa akan bertanggung jawab untuk memperbaiki setiap kerusakan yang terjadi akibat  pemasangan perangkat telekomunikasi;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(i)</td>
    <td valign="top" align="justify">Penyewa akan bertanggung jawab untuk menyelesaikan setiap masalah yang timbul sebagai dampak dari pemasangan dan/atau pengoperasian instalasi perangkat telekomunikasi Lokasi Sewa;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(j)</td>
    <td valign="top" align="justify">Penyewa tidak terlibat dalam suatu perkara yang dapat menghalangi pelaksanaan oleh Penyewa atas transaksi yang dimaksud dalam Perjanjian ini;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(k)</td>
    <td valign="top" align="justify">Penyewa akan membayar biaya pemakaian listrik sesuai dengan pemakaian sebagaimana tertera pada meteran Kwh sebagaimana dimaksud dalam Pasal 2.5 Perjanjian ini;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(l)</td>
    <td valign="top" align="justify">Penyewa akan menanggung sendiri biaya instalasi yang terjadi akibat pemasangan  perangkat dan/atau peralatan telekomunikasi, baik yang dilakukannya sendiri,  operator dan/atau kontraktornya;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(m)</td>
    <td valign="top" align="justify">Penyewa akan bertanggung jawab dan memperbaiki segala kerusakan yang terjadi akibat pemasangan perangkat dan/atau peralatan telekomunikasi; dan</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">(n)</td>
    <td valign="top" align="justify">Penyewa akan menyelesaikan setiap masalah yang timbul sehubungan dengan atau dampak dari instalasi perangkat dan/atau peralatan telekomunikasi.</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="top"><strong>Pasal 5</strong></td>
   </tr>
  <tr>
    <td colspan="3" valign="top" align="center"><strong>ASURANSI</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">5.1</td>
    <td colspan="2" valign="top" align="justify">Penyewa,  selama masa instalasi Base Transceiver Station (BTS) harus menutup dan menjaga  keberlakuan asuransi atas &ldquo;segala resiko konstruksi&rdquo; (Construction All Risks) untuk menutup risiko sebagaimana dimaksud pada Pasal 3 dan seluruh kewajiban  Penyewa untuk kepentingan Pemilik dan risiko lainnya sesuai dengan rekomendasi risiko dari perusahaan asuransi yang mempunyai reputasi baik di Jakarta.</td>
   </tr>
  <tr>
    <td valign="top">5.2</td>
    <td colspan="2" valign="top" align="justify">Penyewa  harus menutup, pada setiap saat selama Masa Sewa, dan menjaga keberlakuannya  untuk kepentingan Penyewa, suatu polis asuransi yang meliputi tanggung jawab  publik yang menyeluruh dalam jumlah sebagaimana dari waktu ke waktu ditetapkan,  sesuai dengan rekomendasi risiko dari perusahaan asuransi yang mempunyai reputasi  baik di Jakarta, sehubungan dengan setiap kejadian guna menutup risiko  sebagaimana dimaksud pada Pasal 3 dan seluruh kewajiban Penyewa untuk  kepentingan Pemilik dan risiko lainnya sesuai dengan rekomendasi risiko dari  perusahaan asuransi yang mempunyai reputasi baik di Jakarta atau yang  sewajarnya disyaratkan oleh Pemilik.</td>
   </tr>
  <tr>
    <td valign="top">5.3</td>
    <td colspan="2" valign="top" align="justify">Penyewa  pada setiap saat selama Masa Sewa, juga harus menutup dan menjaga keberlakuan  asuransi atas &ldquo;segala risiko&rdquo; (<em>all risk</em>),  yang meliputi barang milik Penyewa yang dapat diterima oleh Pemilik.</td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="top"><strong>Pasal 6</strong></td>
   </tr>
  <tr>
    <td colspan="3" valign="top" align="center"><strong>PEMBERITAHUAN</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">6.1</td>
    <td colspan="2" valign="top" align="justify">Suatu  pemberitahuan, ijin, persetujuan atau komunikasi lainnya (selanjutnya disebut &ldquo;<strong>Pemberitahuan</strong>&rdquo;) berdasarkan Perjanjian  ini harus dibuat secara tertulis, ditandatangani oleh atau atas nama pihak yang  berwenang memberikannya, ditujukan kepada pihak yang berwenang kepada siapa  Pemberitahuan tersebut akan ditujukan dan diberikan, dikirimkan melalui  faksimili, jasa pengiriman, pos tercatat atau dikirimkan langsung secara  pribadi kepada alamat pihak tersebut.</td>
   </tr>
  <tr>
    <td valign="top">6.2</td>
    <td colspan="2" valign="top" align="justify">Suatu Pemberitahuan yang dikirimkan melalui faksimili dianggap telah diterima pada  hari kerja berikutnya setelah hari pengiriman, suatu Pemberitahuan yang dikirimkan melalui jasa pengiriman atau pos tercatat dianggap telah diterima  pada hari kalender ke-3 (tiga) setelah hari pengiriman, dan Pemberitahuan yang dikirimkan langsung secara pribadi dianggap telah diterima pada saat penerimaan.</td>
   </tr>
  <tr>
    <td valign="top">6.3</td>
    <td colspan="2" valign="top" align="justify">Untuk  tujuan Pasal 6 ini, alamat dari suatu Pihak adalah sebagaimana tersebut di  bawah ini atau alamat lain yang dari waktu ke waktu, dengan pemberitahuan  tertulis sebelumnya, diberitahukan oleh Pihak yang bersangkutan:</td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top"><p><u><br />
      Untuk Pemilik</u>:<br />
      <?php echo $row->region_namereport;?><br />
      <?php echo $row->branch_namerpt;?><br />
      <?php echo $row->branch_address;?><br />
      No. Telepon&nbsp;&nbsp;&nbsp;:<?php echo $row->region_telp;?><br />
      No. Faksimili&nbsp;:<?php echo $row->region_fax;?><br />
    U.p.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</p></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top"><p><u><br />
      Untuk Penyewa</u>:<br />
      PT. <?php echo $row->rekanan_name;?><br />
      <?php echo $row->rekanan_address;?><br />
      No. Telepon   :<?php echo $row->rekanan_telp;?><br />
      No. Faksimili&nbsp;:<br />
      Hp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<br />
      U.p.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $row->rekananshipping_contactname;?><br />
    Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $row->rekanan_email;?></p></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" valign="top" align="center"><strong>Pasal 7</strong></td>
   </tr>
  <tr>
    <td colspan="3" align="center" valign="top"><strong>KEJADIAN WANPRESTASI</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">7.1</td>
    <td colspan="2" valign="top" align="justify">Kelalaian untuk melaksanakan kewajiban-kewajiban sebagaimana diatur dalam Perjanjian ini  termasuk namun tidak terbatas pada pernyataan dan jaminan oleh salah satu Pihak merupakan pelanggaran Perjanjian ini (selanjutnya disebut &ldquo;<b>Wanprestasi</b>&rdquo;).</td>
   </tr>
  <tr>
    <td valign="top">7.2</td>
    <td colspan="2" valign="top" align="justify">Dalam hal  terjadi kejadian sebagaimana diatur dalam Pasal 7.1 di atas, Pihak yang  dirugikan memberikan pemberitahuan wanprestasi dan ketentuan Perjanjian yang  dilanggar, dan meminta Pihak yang melakukan wanprestasi untuk memperbaiki  Wanprestasi dalam jangka waktu sebagaimana diatur dalam Pasal 7.3 Perjanjian  ini.</td>
   </tr>
  <tr>
    <td valign="top">7.3</td>
    <td colspan="2" valign="top" align="justify">Kecuali  disepakati sebaliknya, Pihak yang melakukan Wanprestasi harus memperbaiki  Wanprestasi dalam jangka waktu 14 (empat belas) hari kalender sejak tanggal  pemberitahuan Wanprestasi dari Pihak yang dirugikan. Apabila dalam jangka waktu  14 (empat belas) hari kalender tersebut, Pihak yang Wanprestasi tidak dapat  memperbaiki Wanprestasinya, maka Pihak yang dirugikan berhak meminta ganti  kerugian dan/atau mengakhiri Perjanjian ini.</td>
   </tr>
  <tr>
    <td valign="top">7.4</td>
    <td colspan="2" valign="top" align="justify">Dalam hal  Pemilik mengakhiri Perjanjian berdasarkan Pasal 7.3, maka setiap pembayaran  yang telah diterima oleh Pemilik menjadi hak Pemilik dan Penyewa setuju untuk  tidak menuntut kembali pembayaran untuk Masa Sewa yang belum digunakan dan  karenanya Penyewa dengan ini melepaskan haknya untuk menuntut pembayaran  kembali tersebut.</td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="top"><p align="center"><strong>Pasal 8</strong></p></td>
   </tr>
  <tr>
    <td colspan="3" align="center" valign="top"><strong>HUKUM YANG BERLAKU</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">8.1</td>
    <td colspan="2" valign="top">Perjanjian ini diatur dan tafsirkan menurut hukum  Negara Republik Indoensia.</td>
   </tr>
  <tr>
    <td valign="top">8.2</td>
    <td colspan="2" valign="top" align="justify">Untuk  tujuan pelaksanaan Perjanjian dan segala konsekuensinya, Para Pihak memilih  domisili hukum di Kantor Panitera Pengadilan Negeri Jakarta Selatan.</td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="top"><strong>Pasal 9</strong></td>
   </tr>
  <tr>
    <td colspan="3" valign="top" align="center"><strong>PENYELESAIAN  SENGKETA</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">9.1</td>
    <td colspan="2" valign="top" align="justify">Setiap  sengketa yang timbul dari atau berkenaan dengan Perjanjian ini, termasuk namun  tidak terbatas pada keberadaan, keabsahan, pengakhiran atau hak maupun  kewajiban masing-masing Pihak yang tidak dapat diselesaikan secara musyawarah  untuk mufakat dalam jangka waktu 15 (lima belas) hari kalender oleh Para Pihak,  akan diselesaikan melalui Badan Arbitrase Nasional Indonesia (&ldquo;<strong>BANI</strong>&rdquo;).</td>
   </tr>
  <tr>
    <td valign="top">9.2</td>
    <td colspan="2" valign="top"><p>Proses  arbitrase dilaksanakan di Jakarta, dalam bahasa Indonesia.</p></td>
   </tr>
  <tr>
    <td valign="top">9.3</td>
    <td colspan="2" valign="top" align="justify">Ketentuan  penyelesaian sengketa menurut peraturan BANI sebagaimana dimaksud dalam Pasal  9.1 di atas tanpa mengesampingkan ketentuan Undang-Undang No.30 Tahun 1999  mengenai Arbitrase dan Penyelesaian Sengketa Alternatif.</td>
   </tr>
  <tr>
    <td valign="top">9.4</td>
    <td colspan="2" valign="top" align="justify">Tidak ada Pihak yang berhak untuk memulai atau  melakukan suatu tindakan di setiap pengadilan atas segala hal dalam sengketa  sampai hal tersebut telah disampaikan dan telah diputuskan berdasarkan  ketentuan Perjanjian ini, kecuali untuk pelaksanaan putusan badan arbitrase.</td>
   </tr>
  <tr>
    <td valign="top">9.5</td>
    <td colspan="2" valign="top" align="justify">Para Pihak setuju untuk mengesampingkan berlakunya  ketentuan Pasal 650.2 RV (<em>Reglement op de  Burgerlijke Rechts vordering</em>), sehingga penunjukan badan arbitrase tidak  berakhir dalam waktu 6 (enam) bulan sejak tanggal penunjukannya. Mandat badan  arbitrase yang dibentuk kembali berdasarkan ketentuan Pasal 9.5 ini tetap  berlaku sampai suatu putusan final telah diterbitkan oleh badan arbitrase.</td>
   </tr>
  <tr>
    <td valign="top">9.6</td>
    <td colspan="2" valign="top" align="justify">Putusan badan arbitrase adalah final, tidak dapat disbanding dan mengikat Para Pihak dan berlaku penuh terhadap Para Pihak.</td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="top"><strong>Pasal 10</strong></td>
   </tr>
  <tr>
    <td colspan="3" align="center" valign="top"><strong>KEADAAN KAHAR</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">10.1</td>
    <td colspan="2" valign="top" align="justify">Tidak ada  Pihak yang harus bertanggung jawab terhadap kegagalan untuk melaksanakan  kewajibannya berdasarkan Perjanjian ini karena sebab di luar kontrol Pihak yang  bersangkutan yang secara langsung berdampak kepada kemampuan Pihak terkait  untuk melaksanakan kewajibannya berdasarkan Perjanjian ini, termasuk namun  tidak terbatas pada bencana alam, bencana maritim, perang (baik yang dinyatakan  maupun tidak), pemogokan, kerusuhan, revolusi, kebakaran, ledakan dan sabotase  (selanjutnya disebut &ldquo;<strong>Keadaan Kahar</strong>&rdquo;).  yang secara langsung berdampak kepada kemampuan Pihak terkait untuk melaksanakan  kewajibannya berdasarkan Perjanjian ini</td>
   </tr>
  <tr>
    <td valign="top">10.2</td>
    <td colspan="2" valign="top" align="justify">Pihak  yang terkena Keadaan Kahar harus melakukan usaha sebaik-baiknya untuk  mengurangi Keadaan Kahar dan memberikan Pemberitahuan kepada Pihak lainnya  dalam waktu paling lama 3 (tiga) hari kalender sejak terjadinya Keadaan Kahar.</td>
   </tr>
  <tr>
    <td valign="top">10.3</td>
    <td colspan="2" valign="top" align="justify">Apabila  Keadaan Kahar berlangsung terus menerus selama 1 (satu) bulan, maka Para Pihak,  dengan kesepakatan bersama secara tertulis, dapat mengakhiri Perjanjian ini.</td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="top"><strong>Pasal 11</strong></td>
   </tr>
  <tr>
    <td colspan="3" valign="top" align="center"><strong>KESELURUHAN  PERJANJIAN</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" valign="top" align="justify">Perjanjian ini merupakan keseluruhan  kesepatan di antara Para Pihak dan mengesampingkan seluruh negosiasi,  kesepakatan dan komitmen sebelumnya, baik yang dibuat secara resmi maupun  tidak, lisan maupun tertulis, berkenaan dengan transaksi sebagaimana diatur  dalam Perjanjian ini.</td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" valign="top" align="center"><strong>Pasal 12</strong></td>
   </tr>
  <tr>
    <td colspan="3" align="center" valign="top"><strong>PENGALIHAN</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">12.1</td>
    <td colspan="2" valign="top" align="justify">Perjanjian  ini mengikat dan dipakai untuk kemanfaatan Para Pihak dan masing-masing penerus  dan penerima pengalihan yang diijinkan.</td>
   </tr>
  <tr>
    <td valign="top">12.2</td>
    <td colspan="2" valign="top" align="justify">Kecuali  disepakati sebaliknya, setiap Pihak hanya dapat mengalihkan hak dan kewajibannya  berdasarkan Perjanjian ini kepada afiliasi dan/atau grup usahanya.</td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" valign="top" align="center"><strong>Pasal 13</strong></td>
   </tr>
  <tr>
    <td colspan="3" valign="top" align="center"><strong>PERUBAHAN  PERJANJIAN</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" valign="top" align="justify">Perjanjian ini tidak dapat  diperbaiki, diubah atau dimodifikasi dengan segala cara kecuali dibuat dalam  bentuk tertulis yang ditandatangani oleh pihak yang berwenang dari  masing-masing Pihak.</td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="top"><strong>Pasal 14</strong></td>
   </tr>
  <tr>
    <td colspan="3" valign="top" align="center"><strong>PENGAKHIRAN</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">14.1</td>
    <td colspan="2" valign="top" align="justify">Perjanjian  ini berlaku efektif sejak tanggal ditandatanganinya Perjanjian dan berakhir  pada akhir Masa Sewa, kecuali diakhiri sebelumnya sebagaimana diatur dalam  Pasal 7.3 atau Pasal 10.3 Perjanjian ini.</td>
   </tr>
  <tr>
    <td valign="top">14.2</td>
    <td colspan="2" valign="top" align="justify">Untuk  kepentingan pengakhiran Perjanjian ini, Para Pihak sepakat untuk  mengesampingkan ketentuan Pasal 1266 alinea ke-2 (dua) dari Kitab Undang-Undang  Hukum Perdata, sepanjang diperlukannya putusan pengadilan pengakhiran suatu  perjanjian.</td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="top" ><strong>Pasal 15</strong></td>
   </tr>
  <tr>
    <td colspan="3" align="center" valign="top"><strong>KETENTUAN-KETENTUAN LAIN</strong></td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">15.1</td>
    <td colspan="2" valign="top" align="justify">Judul  dan/atau sub-judul dalam Perjanjian ini dibuat hanya untuk kenyamanan referensi  saja, dan tidak dapat mempengaruhi konstruksi dan penafsiran Perjanjian ini.</td>
   </tr>
  <tr>
    <td valign="top">15.2</td>
    <td colspan="2" valign="top" align="justify">Apabila  satu atau lebih kententuan dalam Perjanjian ini menjadi tidak berlaku, tidak  sah dan tidak dapat dilaksanakan berdasarkan ketentuan hukum Negara Republik  Indonesia, ketentuan-ketentuan lain dalam Perjanjian ini tetap berlaku, sah dan  dapat dilaksanakan.</td>
   </tr>
  <tr>
    <td valign="top">15.3</td>
    <td colspan="2" valign="top" align="justify">Dalam  hal terjadi peristiwa sebagaimana diatur dalam Pasal 15.2 di atas, Para Pihak  setuju untuk mengganti ketentuan yang tidak berlaku, tidak sah dan tidak dapat  dilaksanakan tersebut.    </td>
   </tr>
  <tr>
    <td valign="top">15.4</td>
    <td colspan="2" valign="top" align="justify">Para  Pihak sepakat bahwa Perjanjian ini, pelaksanaannya dan ketentuan-ketentuan di  dalamnya bersifat rahasia (&ldquo;<strong>Informasi  Rahasia</strong>&rdquo;), dan karenanya bersedia untuk menjaga kerahasiaan tersebut dengan  usaha terbaiknya. Ketentuan ini tidak berlaku terhadap Informasi Rahasia yang  telah menjadi domain umum dan/atau diminta untuk dibuka berdasarkan perintah  pengadilan. Ketentuan ini akan berlaku selama Perjanjian berlaku efektif dan  setiap saat setelahnya.</td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" valign="top" align="justify">DEMIKIAN, pihak yang berwenang dari  masing-masing Pihak menandatangani Perjanjian ini dalam 2 (dua) rangkap asli,  yang masing-masing mempunyai kekuatan hukum yang sama, pada tanggal sebagaimana  tersebut pada awal Perjanjian ini.</td>
   </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  </table>

<table width="753" border="0">
  <tr>
    <td width="355"><p>Untuk dan atas nama,<strong></strong></p></td>
    <td width="37">&nbsp;</td>
    <td width="140">&nbsp;</td>
    <td width="203"><p>Untuk dan atas nama,<strong></strong></p></td>
  </tr>
  <tr>
    <td>PT ......</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>PT....</td>
  </tr>
  <tr>
    <td height="95" nowrap="nowrap">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td><u><b><?php echo $rkomisaris['penanggung_jawab'];?></b></u></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><u><strong><?php echo $rkomisaris['penyewa'];?></strong></u></td>
  </tr>
  <tr>
    <td><?php echo $rkomisaris['jabatan_pemilik'];?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo $rkomisaris['jabatan_penyewa'];?></td>
  </tr>
</table>
<?php }}?> 
</body>
</html>