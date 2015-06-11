<?
    $DIR_PROG = dirname(realpath(__FILE__));
    include($DIR_PROG.'/libcom.php');
    ini_set('memory_limit', '2048M');

    $opt= getOption('l:x:', array('di:','do:','cmd'));
    foreach(array('di','do') as $k)
    {
        if(!isset($opt[$k]))
            die(sprintf("\n !! %s --di DIR_INPUT_PDB --do DIR_OUT_MATRIX\n\n", $argv[0]));
    }

    $DEF_PARAM = parse_ini_file(sprintf('%s/0_param.ini', $DIR_PROG));

    $DIR_IN  = createPath($opt['di']);
    $DIR_OUT = createPath($opt['do']);
    $SHOW_CMD = (isset($opt['x']) || isset($opt['cmd'])) ? true : false;
    
    $FN_LIST = sprintf('%s/list.%s.txt', $DIR_OUT, basename($DIR_IN));

    $cmd = array();
    $cmd[] = sprintf("find %s -type f > %s;\n", $DIR_IN, $FN_LIST);
    $cmd[] = sprintf("sed -i '1i MAMMOTH' %s;\n", $FN_LIST);
   
    $mm_dir = getRealPath($DEF_PARAM['MMULT_DIR']);
    $cmd[] = sprintf("cd %s;\n", $DIR_OUT);
    $cmd[] = sprintf('echo "# start MAMMOTHmult alignment";'."\n");
    $cmd[] = sprintf("%s/%s %s -rot -n %d;\n", $mm_dir, $DEF_PARAM['MMULT_PROG'], $FN_LIST, $DEF_PARAM['N_STR']);

    $cmd[] = sprintf('echo "# finish MAMMOTHmult alignment";'."\n");
    $cmd[] = sprintf("cd -;\n");

    if($SHOW_CMD)
    {
        echo join('',$cmd);
    }
    else
    {
        $fout = '.run.script';
        file_put_contents($fout,$cmd);
        //system("sh $fout"); // it cant show all raw outputs
        passthru("sh $fout"); 
    }

    exit;

?>
