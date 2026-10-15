<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="800" border="0">
  <tr>
    <td align="center"><img src="<?php echo base_url('assets/img/transmart.jpg');?>" width="268" height="91" /></td>
  </tr>
</table>
<p>&nbsp;</p>
 <?php if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?>  
<table width="800" border="0">
  <tr>
    <td width="34">No</td>
    <td width="356">:<?php echo $row->loo_id;?></td>
    <td width="195">&nbsp;</td>
    <td width="197"><?php echo $new_date = date('d F Y', strtotime($row->loo_date));?></td>
  </tr>
</table>
<table width="800" border="0">
  <tr>
    <td width="499"><b><?php echo $row->rekanancontact_name;?></b></td>
    <td width="291"><?php echo $row->branch_name;?></td>
  </tr>
  <tr>
    <td><?php echo $row->rekananshipping_name;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Di Tempat</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Telp.  <?php echo $row->rekanan_telp;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Email :</td>
    <td><?php echo $row->rekanan_email;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><b>PERIHAL: Surat Penawaran Untuk "<?php echo $row->rekananshipping_name;?>" di <?php echo $row->branch_name;?></b></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Dengan Hormat,</td>
  </tr>
  <tr>
    <td colspan="2">Bersama ini kami sampaikan Surat Penawaran untuk <?php echo $row->rekananshipping_name;?> dengan ketentuan dan syarat-syarat sebagaimana tersebut dibawah ini. </td>
  </tr>
  <tr>
    <td colspan="2"><strong>- Ruang Sewa (sebagaimana terlampir):</strong></td>
  </tr>
</table>
<table width="800" border="0">
  <tr>
    <td width="25">a.</td>
    <td width="150">Lantai</td>
    <td width="611">:<?php echo $row->lantai_name;?></td>
  </tr>
  <tr>
    <td>b.</td>
    <td>Nomor Unit</td>
    <td>:<?php echo $row->unit_name;?></td>
  </tr>
  <tr>
    <td>c.</td>
    <td>Luas </td>
    <td>:<?php echo $row->unit_sqm;?> M2</td>
  </tr>
</table>
<table width="800" border="0">
  <tr>
    <td width="178"><strong>- Periode Masa Sewa</strong></td>
    <td width="612"> :<?php echo $row->loo_term;?> Bulan</td>
  </tr>
</table>
<table width="800" border="0">
  <tr>
    <td width="25">a.</td>
    <td width="150">Mulai pada tanggal</td>
    <td width="611">:<?php echo $new_date = date('d F Y', strtotime($row->loo_sdate));?></td>
  </tr>
  <tr>
    <td>b.</td>
    <td>Berakhir pada tanggal</td>
    <td>:<?php echo $new_date = date('d F Y', strtotime($row->loo_edate));?></td>
  </tr>
</table>
<table width="800" border="0">
  <tr>
    <td><strong>TERM &amp; CONDITION</strong></td>
  </tr>
</table>
<table width="800" border="0">
  <tr>
    <td width="29"><strong>1</strong></td>
    <td width="271"><strong>Harga Sewa</strong></td>
    <td width="11">:</td>
    <td width="471">Rp. <?php echo number_format($row->loodetil_baserent,0);?>/ m2 / Bulan tidak termasuk PPn</td>
  </tr>
  <tr>
    <td><strong>2</strong></td>
    <td><strong>Biaya Pelayanan (Service Charge)</strong></td>
    <td>:</td>
    <td>Rp. / m2 / Bulan tidak termasuk PPn</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>:</td>
    <td><div align="justify">(Dibayarkan setiap 3 ( tiga ) bulan dimuka  dan pembayaran biaya pelayanan pertama kali harus dimulai sejak tanggal mulai sewa. Biaya Pelayanan akan ditinjau ulang setiap periode.)</div></td>
  </tr>
  <tr>
    <td><strong>3</strong></td>
    <td><strong>Promotion Levy</strong></td>
    <td>:</td>
    <td>Rp. / m2 / Bulan tidak termasuk PPn</td>
  </tr>
  <tr>
    <td><strong>4</strong></td>
    <td><strong>Cara Pembayaran</strong></td>
    <td>:</td>
    <td><div align="justify">DP 20% dibayarkan dalam 2 kali angsuran setelah Surat Kesepakatan (Letter of Intent) telah ditandatangani <br />
    Installment 80% dibayarkan dalam 30 kali angsuran  bulanan di muka</div></td>
  </tr>
  <tr>
    <td><strong>5</strong></td>
    <td><strong>Jaminan Sewa</strong></td>
    <td>:</td>
    <td>bulan Harga Sewa dan Service Charge </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>:</td>
    <td><div align="justify">Jaminan sewa  tersebut  dapat  dikembalikan  secara utuh,  tanpa
      bunga  pada  masa   berakhirnya  masa  sewa  mengacu  kepada 
      dipatuhinya  segala ketentuan dan syarat-syarat PERJANJIAN dari
      Penyewa,  tetapi  tidak  akan dikembalikan bila terjadi pemutusan
    awal yang disebabkan oleh wanprestasi pembayaran PENYEWA.</div></td>
  </tr>
  <tr>
    <td><strong>6</strong></td>
    <td><strong>Listrik</strong></td>
    <td>:</td>
    <td>Berdasarkan pemakaian bulanan ditambah administrasi 10% dan Ppn 10% </td>
  </tr>
  <tr>
    <td><strong>7</strong></td>
    <td><strong>Air </strong></td>
    <td>:</td>
    <td>Berdasarkan pemakaian bulanan ditambah administrasi 10% dan Ppn 10%   (Tidak Tersedia)</td>
  </tr>
  <tr>
    <td><strong>8</strong></td>
    <td><strong>Gas</strong></td>
    <td>:</td>
    <td>Berdasarkan pemakaian bulanan ditambah administrasi 10% dan Ppn 10%   (Tidak Tersedia)</td>
  </tr>
  <tr>
    <td><strong>9</strong></td>
    <td><strong>Telepon</strong></td>
    <td>:</td>
    <td><div align="justify">Pihak Pemilik akan menyediakan minimal 1 (satu) line telepon untuk setiap ruang usaha dengan biaya deposit sebesar Rp. 3.500.000,- (Tiga Juta Lima Ratus Ribu Rupiah) (Refundable) per line dengan biaya penyambungan sebesar Rp. 1.000.000,- (Satu Juta Rupiah)</div></td>
  </tr>
  <tr>
    <td><strong>10</strong></td>
    <td colspan="3"><strong>Masa berlaku Surat Penawaran :</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">Penawaran ini berlaku 1 minggu sejak surat diterbitkan dan semua penawaran berdasarkan dari first come first serve basis.</td>
  </tr>
  <tr>
    <td><strong>11</strong></td>
    <td colspan="3"><strong>Ketentuan Khusus :</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">Layout sewaktu-waktu dapat berubah sesuai dengan commercial plan.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">Terima kasih  atas  perhatiannya  dan  bila Bapak setuju,  harap ditanda tangani  pada kolom yang disediakan  dan  di  email kembali ke kami dengan alamat sbb:   setyawati_setyawati@transretail.co.id  atau tanti_triandini@transretail.co.id atau Ihya_Nasution@transretail.co.id. Jika ada pertanyaan lebih lanjut dapat menghubungi Tanti Triandini 081808093931 /Ihya Nasution 081223023016</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">Setelah surat penawaran ini disepakati oleh para pihak, akan ditingkatkan menjadi surat kesepakatan paling lambat 7 hari untuk ditandatangani kembali oleh para pihak</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="800" border="0">
  <tr>
    <td width="325">Hormat kami,</td>
    <td width="65">&nbsp;</td>
    <td width="195">&nbsp;</td>
    <td width="197">Menyetujui penawaran tsb</td>
  </tr>
  <tr>
    <td><strong>PT TRANS RETAIL INDONESIA</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><b><?php echo $row->rekananshipping_name;?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong><u>Tanti Triandini </u></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
  </tr>
  <tr>
    <td>Senior Leasing Manager</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="800" border="0">
  <tr>
    <td><table cellspacing="0" cellpadding="0">
    
      <tr>
        <td colspan="7"><strong>PT Trans Retail Indonesia - SHOPPING MALL </strong></td>
        <td width="18"></td>
        <td width="38"></td>
        <td width="41"></td>
        <td width="136"></td>
      </tr>
      <tr>
        <td colspan="11">Head    Office : Carrefour Lebak Bulus, 3rd Floor, Jl. Lebak Bulus Raya No. 8,    Jakarta 12310</td>
      </tr>
      <tr>
        <td colspan="8">Telp    : 021 (2758.5800 ext. 55614)  Fax. :    021 (2758.5899)</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="10">PIC.    Tanti Triandini (081808093931) atau Ihya Nasution (081223023016)</td>
        <td></td>
      </tr>
      <tr>
        <td colspan="11">Email    : tanti_triandini@transretail.co.id atau Ihya_Nasution@transretail.co.id</td>
      </tr>
    </table></td>
  </tr>

</table>
<?php }}?> 
</body>
</html>