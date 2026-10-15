<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
    <title>Untitled Document</title>
     <style>
        @font-face {
            font-family: 'arial'; /*a name to be used later*/
            src: url('<?php echo base_url('assets/css/loo/arial.ttf');?>'); /*URL to font*/
        }
        body {font-family: 'arial';font-size: 14pt}
        @page { margin-left:4cm; margin-right:3cm; margin-top:3cm;margin-bottom:3cm;size:8.27in 11.69in;}

        tab1 { padding-right: 222em; }        
     </style>
  </head>
  <body>

<?php 
if(isset($result)){
  foreach($result as $row){ ?>  

<htmlpagefooter name="myfooter">
<div style="border-top: 0px solid #000000; font-size: 6pt; text-align: center; padding-top: 3mm; ">
  <?php echo $la_id; ?>  
</div>
</htmlpagefooter>
<sethtmlpagefooter name="myfooter" value="on" />

    <table width="753" border="0">
      <tbody>
        <tr>
          <td width="626" align="center" style="font-size: 12pt"><b>EKSIBIT A</b><p>&nbsp; </p></td>
        </tr>
        <tr>
          <td width="626" align="center"><b>SYARAT-SYARAT SEWA</b></td>
        </tr>
        <tr>
          <td width="626" align="center"><b>PERJANJIAN SEWA MENYEWA</b></td>
        </tr>
      </tbody>
    </table>
    <span> &nbsp;</span> 
    <table width="753" border="0">
      <tbody>
        <tr>
          <td align="justify">
        Syarat-Syarat Sewa yang diatur disini merupakan bagian dari Perjanjian Sewa Menyewa.
        <br><br>
        Pemilik dan Penyewa dengan ini setuju untuk mengikatkan diri pada syarat-syarat dan
        ketentuan ketentuan dalam Syarat-Syarat Sewa ini (termasuk seluruh Peraturan beserta
        Skedulnya yang termuat dalam buku ini) yang merupakan bagian yang tidak terpisahkan
        dari Perjanjian Sewa Menyewa.
        <br><br>
        Penyewa dengan ini menyatakan dan menjamin kepada Pemilik bahwa Penyewa telah
        membaca dan memahami seluruh syarat dan ketentuan yang termuat dalam Syarat-
        Syarat Sewa ini.
        <br><br>
        KARENANYA dan untuk menandakan kesepakatan mereka dalam mengikatkan diri
        pada Syarat-Syarat Sewa ini, Pemilik dan Penyewa masing masing telah
        menandatangani, membubuhkan cap dan melangsungkan Syarat-Syarat Sewa.
        </tr>
        
      </tbody>
    </table>

    <span> &nbsp;</span>
	  <table width="753" border="0">
      <tbody>
        <tr>
          <td width="420">Pemilik,</td>
          <td width="135">Saksi Pemilik</td>
          <td width="184">: ________________</td>
        </tr>
        <tr><td><b><?php echo 'PT '.strtoupper($row->region_name);?></b></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
  </table>    
    <p>&nbsp;  </p>
    <table width="753" border="0">
      <tbody>
        <tr>
          <td width="202">Nama Penandatangan</td>
          <td width="214">: 
            <?php echo ucwords(strtolower($row->penanggung_jawab));?>
          </td>
          <td width="135" align="left">Nama Saksi</td>
          <td width="184">: ________________</td>    
        </tr>
        <tr>
          <td>Jabatan</td>
          <td>:
            <?php echo ucwords(strtolower($row->jabatan_pemilik));            
            ?>  </td>
          <td align="left">Jabatan</td>    
          <td>: ________________</td>      
        </tr>
        <tr>
          <td>Tanggal</td>
          <td>: ________________</td>
          <td align="left">Tanggal</td>
          <td>: ________________</td>
        </tr>
      </tbody>
    </table> 
    <span> &nbsp;</span>
    <table width="753" border="0">
      <tbody>
        <tr>
          <td width="420">Penyewa,</td>
          <td width="135" align="left">Saksi Penyewa</td>
          <td width="184">: ________________</td>
        </tr>
        <tr>
          <td><b><?php echo strtoupper($row->rekanan_namereport);?></b></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>    
    <p>&nbsp;  </p>
    <table width="753" border="0">
      <tbody>
        <tr>
          <td width="202">Nama Penandatangan</td>
          <td width="214">: <?php echo ucwords(strtolower($row->penyewa));?></td>
          <td width="135">Nama Saksi</td>
          <td width="184">: ________________</td>
        </tr>
        <tr>
          <td>Jabatan</td>
          <td>: <?php echo ucwords(strtolower($row->jabatan_penyewa));?></td>
          <td>Jabatan</td>
          <td>: ________________</td>
        </tr>
        <tr>
          <td>Tanggal</td>
          <td>: ________________</td>
          <td>Tanggal</td>
          <td>: ________________</td>
        </tr>
      </tbody>
    </table>   
    <span> &nbsp;</span> 
    <?php if (trim($row->penyewa2)<>""){?>
    <table width="753" border="0">
      <tbody>
        <tr>
          <td width="420">Penyewa,</td>
          <td width="135" align="left">&nbsp;</td>
          <td width="184">&nbsp;</td>
        </tr>
        <tr>
          <td><b><?php echo strtoupper($row->rekanan_name);?></b></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>
    <p>&nbsp;  </p>
    <table width="753" border="0">
      <tbody>        
          <tr>
            <td width="202">Nama Penandatangan</td>
            <td width="214">: <?php echo ucwords(strtolower($row->penyewa2));?></td>
            <td width="135">&nbsp;</td>
            <td width="184">&nbsp;</td>
          </tr>
          <tr>
            <td>Jabatan</td>
            <td>: <?php echo ucwords(strtolower($row->jabatan_penyewa2));?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Tanggal</td>
            <td>: ________________</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
      </tbody>
    </table>        
  <?php }}}?> 
  </body>
</html>
