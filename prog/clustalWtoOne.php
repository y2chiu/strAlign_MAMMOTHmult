<?

    $f = file($argv[1]);
    array_splice($f,0,2);

    $o = array();
    foreach($f as $l)
    {
        $l2 = trim($l);
        if(empty($l2) || $l[0] == ' ')
            continue;
        else
        {
            list($k, $s) = preg_split('/\s+/', $l2);
            
            if(!isset($o[$k]))
                $o[$k]  = $s;
            else
                $o[$k] .= $s;
        }
    }

    foreach($o as $k=>$s)
    {
        $kin = explode('_',$k);
        $kin = array_shift($kin);
        printf("%s\t%s\n", $kin, $s);
    }
?>
