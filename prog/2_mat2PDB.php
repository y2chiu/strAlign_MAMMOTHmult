<?
    $DIR_PROG = dirname(realpath(__FILE__));
    include($DIR_PROG.'/libcom.php');
    ini_set('memory_limit', '2048M');

    $opt= getOption('l:m:', array('di:','do:','dm:'));
    foreach(array('l','m','do') as $k)
    {
        if(!isset($opt[$k]))
            die(sprintf("\n !! %s -l LIST_PDB -m FN_OUT_MATRIX --do DIR_OUT_PDB\n\n", $argv[0]));
    }

    $DEF_PARAM = parse_ini_file(sprintf('%s/0_param.ini', $DIR_PROG));

    $FN_LIST = getRealPath($opt['l']);
    $FN_MAT  = getRealPath($opt['m']);
    $DIR_OUT = createPath($opt['do']);


    include('transPDB.php');

    $lst = file($FN_LIST, FILE_IGNORE_NEW_LINES);
    array_shift($lst);

    $mat = file($FN_MAT, FILE_IGNORE_NEW_LINES);
    $TR_MAT = array();
    for($i=count($lst)-1;$i>=0;$i--)
    {
        $p = $lst[$i];
        $m = array_pop($mat);
        $m = preg_split('/\s+/', trim($m));

        $TR_MAT[$i] = array($p, $m);
    }

    printf("# start to translate PDB files\n");

    for($i=0,$n=count($TR_MAT);$i<$n;$i++)
    {
        list($p, $m) = $TR_MAT[$i];

        $u = $t = array();
        $u = array_slice($m, 1, 9);
        $c = array_slice($m,10, 3);
        $t = array_slice($m,13, 3);

        foreach($c as $k => $v)
            $t[$k] = 0-$c[$k]+$t[$k];

        $trmat = array_merge($u, $t);
        $trmat = array_map('trim', $trmat);
        $trmat = array_map('doubleval', $trmat);

        $fn_in  = $p;
        $fn_out = sprintf('%s/%s', $DIR_OUT, basename($p));
        
        printf("# [%2d/%2d] %s\n", $i+1, $n, basename($p));

        trans_structure($fn_in, $fn_out, $trmat);
    }

    printf("\n# done\n");

    exit;
?>
