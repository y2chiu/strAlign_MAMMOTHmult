PDB files from MAMMOTHmult structual alignment results
=============================================

##Steps

1. Set the CE path
  >In prog/0_param.ini   
  >  
  >[MAMMOTHmult_parameters]  
  >MMULT_DIR = './'  
  >MMULT_PROG = 'mmult_45'  

2. Prepare the PDB files

3. Run COMMAND
  ```
  php prog/1_runMMULT.php --di example/IRAK4/ --do example/IRAK4_out 
  php prog/2_mat2PDB.php -l example/IRAK4_out/list.IRAK4.txt -m example/list.IRAK4.txt-FINAL.rot --do example/IRAK4_trpdb
  ```

