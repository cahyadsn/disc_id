<?php
/************************************
FILENAME     : index.php
AUTHOR       : CAHYA DSN
CREATED DATE : 2016-01-13
UPDATED DATE : 2023-08-24
DEMO SITE    : https://psycho.cahyadsn.com/disc_id
SOURCE CODE  : https://github.com/cahyadsn/disc_id
*************************************/
include 'inc/db.php';
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
$show_mark = 0;  //<-- show 1 or hide 0 the marker
$cols      = 3;  //<-- number of columns
$rows      = count($x)/$cols;
shuffle($x);
$data=array();
foreach($x as $dt){
  shuffle($dt);
  foreach($dt as $d){
    $data[]=$d;
  }
}
?>
<doctype html>
<html>
  <head>
    <title>DISC Personality Test</title>
    <meta http-equiv="expires" content="<?php echo date('r');?>" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="no-cache" />
    <link rel='stylesheet' href='css/disc.css?<?php echo md5(date('r'));?>' />
  </head>
  <body>
    <header><h1>:: DISC Personality Test</h1></header>
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
    <table>
      <thead>
        <tr>
        <?php for($i=0;$i<$cols;++$i):?>
          <th>No</th>
          <th>Gambaran Diri</th>
          <th>P</th>
          <th>K</th>
        <?php endfor;?>
        </tr>
      </thead>
      <tbody>
      <?php
      for($i=0;$i<$rows;$i++){
        echo "<tr".($i%2==0?" class='dark'":"").">";
        for($j=0;$j<4;++$j){
          for($n=0;$n<$cols;$n++){
             if($j>0 && $n==0){
               echo "<tr".($i%2==0?" class='dark'":"").">";
             }elseif($j==0){
               echo "<th rowspan='4'"
                 .($j==0?" class='first'":"").">"
                 .($i+$n*$rows+1)
                 ."</th>";
             }
	    $no=$n*$rows+$i*4+$j+($cols*$rows*$n);
            echo "<td".($j==0?" class='first'":"").">
                  {$data[$no]->term}
                  </td>
                  <td".($j==0?" class='first'":"").">
                <input type='radio' 
                       name='m[".($i+$n*$rows)."]' 
                     value='{$data[$no]->most}' 
                     required />" 
               .($show_mark?$data[$no]->most:'')
               ."</td>
                  <td".($j==0?" class='first'":"").">
                  <input type='radio' 
                         name='l[".($i+$n*$rows)."]' 
                         value='{$data[$no]->least}' 
                         required />"
                 .($show_mark?$data[$no]->least:'')
                 ."</td>";
            }
          echo "</tr>";
        }
      }
      ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan='<?php echo $cols*4;?>'>
            <input type='submit' value='proses' class='btn'/>
           </th>
         </tr>
      </tfoot>
    </table>
    </form>
  </div>
  <footer>copyright &copy; 2016<?php echo (date('Y')>2016?date('Y'):'');?> by <a href='mailto:cahyadsn@gmail.com'>cahya dsn</a></footer>
  </body>
</html>
