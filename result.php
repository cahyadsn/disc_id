<?php
/*
BISMILLAAHIRRAHMAANIRRAHIIM - In the Name of Allah, Most Gracious, Most Merciful
================================================================================
FILENAME     : result.php
DESC         :
AUTHOR       : CAHYA DSN
CREATED DATE : 2016-01-13
UPDATED DATE : 2025-03-18 14:21
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
?>
<doctype html>
<html>
  <head>
    <title>DISC Personality Test</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='css/disc.css' />
  </head>
  <body>
  <header><h1>:: DISC Personality Result</h1></header>
<?php
if(isset($_POST['m']) && isset($_POST['l'])){
  include 'inc/db.php';
  include 'inc/formula.php';
  $most=array_count_values($_POST['m']);
  $least=array_count_values($_POST['l']);
  $result=array();
  $aspect=array('D','I','S','C','N');
  foreach($aspect as $a){
    $result[$a][1]=isset($most[$a])?$most[$a]:0;
    $result[$a][2]=isset($least[$a])?$least[$a]:0;
    $result[$a][3]=($a!='N'?$result[$a][1]-$result[$a][2]:0);
  }
  $line1=getPattern($db,$result,1);
  $line2=getPattern($db,$result,2);
  $line3=getPattern($db,$result,3);
?>
    <div id='container'>
      <script src="js/disc-chart.js"></script>
      <script>
      document.addEventListener('DOMContentLoaded', function() {
        drawDiscChart('graph', [
          <?php
          echo "
          { y: 'D', a: {$line1[0]->d}, b:{$line2[0]->d}, c:{$line3[0]->d}},
          { y: 'I', a: {$line1[0]->i},  b:{$line2[0]->i}, c:{$line3[0]->i}},
          { y: 'S', a: {$line1[0]->s},  b:{$line2[0]->s}, c:{$line3[0]->s}},
          { y: 'C', a: {$line1[0]->c},  b:{$line2[0]->c}, c:{$line3[0]->c}},
          ";
          ?>
        ], {
          ykeys: ['a', 'b','c'],
          labels: ['MOST Mask Public Self', 'LEAST Core Private Self','CHANGE Mirror Perceived Self'],
          ymax: 8,
          ymin: -8
        });
      });
      </script>
      <table>
        <caption>TALLY BOX</caption>
        <tr>
          <th>Graph I<br/>Most</th>
          <th>Graph II<br />Least</th>
          <th>Graph III<br />Change</th>
          <th>Result Graph</th>
        </tr>
    <?php
    $i=0;
    foreach($aspect as $a){
      echo "<tr>
              <td class='badge' data-badge='{$a}'>{$result[$a][1]}</td>
              <td class='badge' data-badge='{$a}'>{$result[$a][2]}</td>
              <td class='badge' data-badge='{$a}'>{$result[$a][3]}</td>"
              .(++$i==1?"<td id='graph' rowspan='5' width='400'></td>":"")
           ."</tr>";
      }
    ?>
      </table>
    </div>

    <div class="result-section">
      <div class="result-card">
        <h2>Gambaran Karakter</h2>
        
        <h3>Kepribadian di muka umum</h3>
        <?php
        echo "<h4>{$line1[1]->pattern}</h4>";
        echo "<ul><li>" . implode('</li><li>', explode(',', $line1[1]->behaviour)) . "</li></ul>";
        ?>
        
        <h3>Kepribadian saat mendapat tekanan</h3>
        <?php
        echo "<h4>{$line2[1]->pattern}</h4>";
        echo "<ul><li>" . implode('</li><li>', explode(',', $line2[1]->behaviour)) . "</li></ul>";
        ?>
        
        <h3>Kepribadian asli yang tersembunyi</h3>
        <?php
        echo "<h4>{$line3[1]->pattern}</h4>";
        echo "<ul><li>" . implode('</li><li>', explode(',', $line3[1]->behaviour)) . "</li></ul>";
        ?>
      </div>
      
      <div class="result-card">
        <h2>Analisis & Rekomendasi</h2>
        
        <h3>Deskripsi Kepribadian</h3>
        <?php
        echo "<p>{$line3[1]->description}</p>";
        ?>
        
        <h3>Kesesuaian Profesi (Job Match)</h3>
        <?php
        echo "<ul><li>" . implode('</li><li>', explode(',', $line3[1]->jobs)) . "</li></ul>";
        ?>
      </div>
    </div>
<?php
}
?>
  <footer>copyright &copy; 2016<?php echo (date('Y')>2016?'-'.date('Y'):'');?> by <a href='mailto:cahyadsn@gmail.com'>cahya dsn</a></footer>
  </body>
</html>
