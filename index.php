<?php
/*
BISMILLAAHIRRAHMAANIRRAHIIM - In the Name of Allah, Most Gracious, Most Merciful
================================================================================
FILENAME     : index.php
DESC         :
AUTHOR       : CAHYA DSN
CREATED DATE : 2016-01-13
UPDATED DATE : 2026-07-28 12:11:34
DEMO SITE    : https://psycho.cahyadsn.com/disc_id
SOURCE CODE  : https://github.com/cahyadsn/disc_id
================================================================================
MIT License

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

copyright (c) 2024 by cahya dsn; cahyadsn@gmail.com
================================================================================
*/
include 'inc/config.php';
//-- query data from database
$sql='SELECT * FROM tbl_personalities ORDER BY no ASC';
$result=$db->query($sql);
$x=array();
$no=0;
while($row=$result->fetch_object()){
  if($no!=$row->no){
    $no=$row->no;
    $x[$no]=array();
  }
  $x[$no][]=$row;
}
$data=array();
foreach($x as $dt){
  foreach($dt as $d){
    $data[]=$d;
  }
}
?>
<doctype html>
<html>
  <head>
    <title>DISC Personality Test v<?php echo $version;?></title>
    <meta http-equiv="expires" content="<?php echo date('r');?>" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="no-cache" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='css/disc.css?<?php echo md5(date('r'));?>' />
  </head>
  <body>
    <header><h1>DISC Personality Test v<?php echo $version;?></h1></header>
    <div id='container'>
    <div class='info-box'>
      <b>INSTRUKSI</b> : Setiap nomor di bawah ini memuat 4 (empat) kalimat. Tugas anda adalah : <br />
      <ol>
        <li>Beri tanda/cek pada kolom di bawah huruf  [P] di samping kalimat yang PALING menggambarkan diri anda</li>
        <li>Beri tanda/cek pada kolom di bawah huruf  [K] di samping kalimat yang PALING TIDAK menggambarkan diri anda</li>
      </ol>
      <br />
      <b>PERHATIKAN</b> : Setiap nomor hanya ada 1 (satu) tanda/cek di bawah masing-masing kolom P dan K.<br />
    </div>
    <form method='post' action='result.php'>
      <div class='question-grid'>
      <?php
      for($q = 0; $q < 24; $q++) {
        $qClass = (($q + 1) % 2 != 0) ? "q-odd" : "q-even";
        ?>
        <div class="question-card <?php echo $qClass; ?>">
          <div class="question-header">No. <?php echo ($q + 1); ?></div>
          <div class="question-body">
            <div class="question-row header-row">
              <div class="col-term">Gambaran Diri</div>
              <div class="col-radio">P</div>
              <div class="col-radio">K</div>
            </div>
            <?php
            for($j = 0; $j < 4; $j++) {
              $no = $q * 4 + $j;
              ?>
              <div class="question-row term-row">
                <div class="col-term"><?php echo htmlspecialchars($data[$no]->term); ?></div>
                <div class="col-radio">
                  <input type="radio" name="m[<?php echo $q; ?>]" value="<?php echo htmlspecialchars($data[$no]->most); ?>" required />
                </div>
                <div class="col-radio">
                  <input type="radio" name="l[<?php echo $q; ?>]" value="<?php echo htmlspecialchars($data[$no]->least); ?>" required />
                </div>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
        <?php
      }
      ?>
      </div>
      <div class="submit-container">
        <input type='submit' value='proses' class='btn'/>
      </div>
    </form>
  </div>
  <footer>copyright &copy; 2016<?php echo (date('Y')>2016?'-'.date('Y'):'');?> by <a href='mailto:cahyadsn@gmail.com'>cahya dsn</a></footer>
  </body>
</html>