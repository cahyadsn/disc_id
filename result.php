<?php
/************************************
FILENAME     : result.php
AUTHOR       : CAHYA DSN
CREATED DATE : 2016-01-13
UPDATED DATE : 2023-08-25
DEMO SITE    : https://psycho.cahyadsn.com/disc_id
SOURCE CODE  : https://github.com/cahyadsn/disc_id
*************************************/
?>
<doctype html>
<html>
  <head>
    <title>DISC Personality Test</title>
    <link rel='stylesheet' href='css/disc.css' />
  </head>
  <body>
  <header><h1>:: DISC Personality Result</h1></header>
<?php
if(isset($_POST['m']) && isset($_POST['l'])){
  include 'inc/db.php';
  $most=array_count_values($_POST['m']);
  $least=array_count_values($_POST['l']);
  $result=array();
  $aspect=array('D','I','S','C','N');
  foreach($aspect as $a){
    $result[$a][1]=isset($most[$a])?$most[$a]:0;
    $result[$a][2]=isset($least[$a])?$least[$a]:0;
    $result[$a][3]=($a!='N'?$result[$a][1]-$result[$a][2]:0);
  }
  function getDISCResults($db,$result,$line){
    $sql="
      SELECT
        d.d,i.i,s.s,c.c
      FROM
        (SELECT d FROM tbl_results WHERE line={$line} AND value={$result['D'][$line]}) d,
        (SELECT i FROM tbl_results WHERE line={$line} AND value={$result['I'][$line]}) i,
        (SELECT s FROM tbl_results WHERE line={$line} AND value={$result['S'][$line]}) s,
        (SELECT c FROM tbl_results WHERE line={$line} AND value={$result['C'][$line]}) c
       ";
    $result=$db->query($sql);
    $data=$result->fetch_object();
    $result->free();
    return $data;
  }

  function getPattern($db,$result,$line){
    $disc=getDISCResults($db,$result,$line);
    $D=$disc->d;
    $I=$disc->i;
    $S=$disc->s;
    $C=$disc->c;
    if($D<=0 && $I<=0 && $S<=0 && $C>0) $pattern=1;
    elseif($D>0 && $I<=0 && $S<=0 && $C<=0) $pattern=2;
    elseif($D>0 && $I<=0 && $S<=0 && $C>0 && $C>=$D) $pattern=3;
    elseif($D>0 && $I>0 && $S<=0 && $C<=0 && $I>=$D) $pattern=4;
    elseif($D>0 && $I>0 && $S<=0 && $C>0 && $I>=$D && $D>=$C) $pattern=5;
    elseif($D>0 && $I>0 && $S>0 && $C<=0 && $I>=$D && $D>=$S) $pattern=6;
    elseif($D>0 && $I>0 && $S>0 && $C<=0 && $I>=$S && $S>=$D) $pattern=7;
    elseif($D>0 && $I<=0 && $S>0 && $C>0 && $S>=$D && $D>=$C) $pattern=8;
    elseif($D>0 && $I>0 && $S<=0 && $C<=0 && $D>=$I) $pattern=9;
    elseif($D>0 && $I>0 && $S>0 && $C<=0 && $D>=$I && $I>=$S) $pattern=10;
    elseif($D>0 && $I<=0 && $S>0 && $C<=0 && $D>=$S) $pattern=11;
    elseif($D<=0 && $I>0 && $S>0 && $C>0 && $C>=$I && $I>=$S) $pattern=12;
    elseif($D<=0 && $I>0 && $S>0 && $C>0 && $C>=$S && $S>=$I) $pattern=13;
    elseif($D<=0 && $I>0 && $S>0 && $C>0 && $I>=$S && $I>=$C) $pattern=14;
    elseif($D<=0 && $I<=0 && $S>0 && $C<=0) $pattern=15;
    elseif($D<=0 && $I<=0 && $S>0 && $C>0 && $C>=$S) $pattern=16;
    elseif($D<=0 && $I<=0 && $S>0 && $C>0 && $S>=$C) $pattern=17;
    elseif($D>0 && $I<=0 && $S<=0 && $C>0 && $D>=$C) $pattern=18;
    elseif($D>0 && $I>0 && $S<=0 && $C>0 && $D>=$I && $I>=$C) $pattern=19;
    elseif($D>0 && $I>0 && $S>0 && $C<=0 && $D>=$S && $S>=$I) $pattern=20;
    elseif($D>0 && $I<=0 && $S>0 && $C>0 && $D>=$S && $S>=$C) $pattern=21;
    elseif($D>0 && $I>0 && $S<=0 && $C>0 && $D>=$C && $C>=$I) $pattern=22;
    elseif($D>0 && $I<=0 && $S>0 && $C>0 && $D>=$C && $C>=$S) $pattern=23;
    elseif($D<=0 && $I>0 && $S<=0 && $C<=0) $pattern=24;
    elseif($D<=0 && $I>0 && $S>0 && $C<=0 && $I>=$S) $pattern=25;
    elseif($D<=0 && $I>0 && $S<=0 && $C>0 && $I>=$C) $pattern=26;
    elseif($D>0 && $I>0 && $S<=0 && $C>0 && $I>=$C && $C>=$D) $pattern=27;
    elseif($D<=0 && $I>0 && $S>0 && $C>0 && $I>=$C && $C>=$S) $pattern=28;
    elseif($D>0 && $I<=0 && $S>0 && $C<=0 && $S>=$D) $pattern=29;
    elseif($D<=0 && $I>0 && $S>0 && $C<=0 && $S>=$I) $pattern=30;
    elseif($D>0 && $I>0 && $S>0 && $C<=0 && $S>=$D && $D>=$I) $pattern=31;
    elseif($D>0 && $I>0 && $S>0 && $C<=0 && $S>=$I && $I>=$D) $pattern=32;
    elseif($D<=0 && $I>0 && $S>0 && $C>0 && $S>=$I && $I>=$C) $pattern=33;
    elseif($D>0 && $I<=0 && $S>0 && $C>0 && $S>=$C && $C>=$D) $pattern=34;
    elseif($D<=0 && $I>0 && $S>0 && $C>0 && $S>=$C && $C>=$I) $pattern=35;
    elseif($D<=0 && $I>0 && $S<=0 && $C>0 && $C>=$I) $pattern=36;
    elseif($D>0 && $I>0 && $S<=0 && $C>0 && $C>=$D && $D>=$I) $pattern=37;
    elseif($D>0 && $I<=0 && $S>0 && $C>0 && $C>=$D && $D>=$S) $pattern=38;
    elseif($D>0 && $I>0 && $S<=0 && $C>0 && $C>=$I && $I>=$D) $pattern=39;
    elseif($D>0 && $I<=0 && $S>0 && $C>0 && $C>=$S && $S>=$D) $pattern=40;
    else $pattern=0;
    $sql="SELECT * FROM tbl_patterns WHERE id={$pattern}";
    $result=$db->query($sql);
    $data=$result->fetch_object();
    $result->free();
    return array($disc,$data);
  }
  $line1=getPattern($db,$result,1);
  $line2=getPattern($db,$result,2);
  $line3=getPattern($db,$result,3);
?>
    <div id='container'>
      <script src="js/raphael.min.js"></script>
      <script src="js/jquery.min.js"></script>
      <script src="js/morris.min.js"></script>
      <script>
      $(function(){
        Morris.Line({
          element: 'graph',
          data: [
            <?php
            echo "
            { y: 'D', a: {$line1[0]->d}, b:{$line2[0]->d}, c:{$line3[0]->d}},
            { y: 'I', a: {$line1[0]->i},  b:{$line2[0]->i}, c:{$line3[0]->i}},
            { y: 'S', a: {$line1[0]->s},  b:{$line2[0]->s}, c:{$line3[0]->s}},
            { y: 'C', a: {$line1[0]->c},  b:{$line2[0]->c}, c:{$line3[0]->c}},
            ";
            ?>
          ],
          xkey: 'y',
          ykeys: ['a', 'b','c'],
          parseTime:false,
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
    <div>
      <h1>RESULT</h1>
      <div>
        <h2>Gambaran Karakter</h2>
        <b>Kepribadian di muka umum</b><br />
        <?php
        echo "<h3>{$line1[1]->pattern}</h3>";
        echo "<ul><li>".implode('</li><li>',explode(',',$line1[1]->behaviour))."</li></ul>";
        ?>
        <b>Kepribadian saat mendapat tekanan</b><br />
        <?php
        echo "<h3>{$line2[1]->pattern}</h3>";
        echo "<ul><li>".implode('</li><li>',explode(',',$line2[1]->behaviour))."</li></ul>";
        ?>
        <b>Kepribadian asli yang tersembunyi</b><br />
        <?php
        echo "<h3>{$line3[1]->pattern}</h3>";
        echo "<ul><li>".implode('</li><li>',explode(',',$line3[1]->behaviour))."</li></ul>";
        ?>
        <h2>Deskripsi Kepribadian</h2>
        <?php
        echo "<p>{$line3[1]->description}</p>";
        ?>
        <h2>Job Match</h2>
        <?php
        echo "<ul><li>".implode('</li><li>',explode(',',$line3[1]->jobs))."</li></ul>";
        ?>
      </div>
    </div>
<?php
}
?>
  <footer>copyright &copy; 2016<?php echo (date('Y')>2016?'-'.date('Y'):'');?> by <a href='mailto:cahyadsn@gmail.com'>cahya dsn</a></footer>
  </body>
</html>