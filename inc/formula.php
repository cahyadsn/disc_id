<?php
/************************************
FILENAME     : formula.php
AUTHOR       : CAHYA DSN
CREATED DATE : 2023-10-08
UPDATED DATE : 2026-07-28 12:11:34
DEMO SITE    : https://psycho.cahyadsn.com/disc_id
SOURCE CODE  : https://github.com/cahyadsn/disc_id
*************************************/

function getDISCResults($db,$result,$line){
    $line = (int)$line;
    $dVal = (int)($result['D'][$line] ?? 0);
    $iVal = (int)($result['I'][$line] ?? 0);
    $sVal = (int)($result['S'][$line] ?? 0);
    $cVal = (int)($result['C'][$line] ?? 0);

    $sql="
      SELECT
        d.d,i.i,s.s,c.c
      FROM
        (SELECT d FROM tbl_results WHERE line={$line} AND value={$dVal}) d,
        (SELECT i FROM tbl_results WHERE line={$line} AND value={$iVal}) i,
        (SELECT s FROM tbl_results WHERE line={$line} AND value={$sVal}) s,
        (SELECT c FROM tbl_results WHERE line={$line} AND value={$cVal}) c
       ";
    $dbResult=$db->query($sql);
    if (!$dbResult) {
        return (object)['d' => 0.0, 'i' => 0.0, 's' => 0.0, 'c' => 0.0];
    }
    $data=$dbResult->fetch_object();
    $dbResult->free();
    return $data ?: (object)['d' => 0.0, 'i' => 0.0, 's' => 0.0, 'c' => 0.0];
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
    $pattern = (int)$pattern;
    $sql="SELECT * FROM tbl_patterns WHERE id={$pattern}";
    $dbResult=$db->query($sql);
    $data=null;
    if ($dbResult) {
        $data=$dbResult->fetch_object();
        $dbResult->free();
    }
    if (!$data) {
        $data = (object)[
            'id' => 0,
            'pattern' => 'UNKNOWN',
            'behaviour' => '',
            'description' => 'No pattern profile matches these scores.',
            'jobs' => ''
        ];
    }
    return array($disc,$data);
  }