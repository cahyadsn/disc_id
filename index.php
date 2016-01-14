<?php
/************************************
FILENAME     : index.php
AUTHOR       : CAHYA DSN
CREATED DATE : 2015-01-13
*************************************/
include 'inc/db.php';
//-- query data from database
$sql='SELECT * FROM tbl_personalities ORDER BY no ASC';
$result=$db->query($sql);
$data=array();
while($row=$result->fetch_object()) $data[]=$row;
$terms=json_encode($data);
$show_mark = 0;  //<-- show 1 or hide 0 the marker
$cols      = 4;  //<-- number of columns
$rows      = count($data)/(4*$cols);
?>
<doctype html>
<html>
  <head>
    <title>DISC Personality Test</title>
    <link rel='stylesheet' href='css/disc.css' />
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
      for($i=0;$i<$rows;++$i){
        echo "<tr".($i%2==0?" class='dark'":"").">";
        for($j=0;$j<4;++$j){
          for($n=0;$n<$cols;++$n){
             if($j>0 && $n==0){
               echo "<tr".($i%2==0?" class='dark'":"").">";
             }elseif($j==0){
               echo "<th rowspan='$cols'"
                 .($j==0?" class='first'":"").">"
                 .($i+$n*$rows+1)
                 ."</th>";
             }
            echo "<td".($j==0?" class='first'":"").">
                  {$data[$cols*($i+$n*$rows)+$j]->term}
                  </td>
                  <td".($j==0?" class='first'":"").">
                <input type='radio' 
                       name='m[".($i+$n*$rows)."]' 
                     value='{$data[$cols*($i+$n*$rows)+$j]->most}' 
                     required />" 
               .($show_mark?$data[$cols*($i+$n*$rows)+$j]->most:'')
               ."</td>
                  <td".($j==0?" class='first'":"").">
                  <input type='radio' 
                         name='l[".($i+$n*$rows)."]' 
                         value='{$data[$cols*($i+$n*$rows)+$j]->least}' 
                         required />"
                 .($show_mark?$data[$cols*($i+$n*$rows)+$j]->least:'')
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
