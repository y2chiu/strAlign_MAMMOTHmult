PDB files from MAMMOTHmult structual alignment results
=============================================

##Steps

1. Set the CE path
  >In prog/0_param.ini   
  >  
  >[MAMMOTHmult_parameters]  
  >MMULT_DIR = './'  
  >MMULT_PROG = 'mmult'  

2. Prepare the PDB files

3. Run COMMAND
  ```
  php prog/1_runMMULT.php --di example/32_kinase_cav/ --do example/ > todo.sh
  sh todo.sh
  php prog/2_mat2PDB.php -l example/list.32_kinase_cav.txt -m example/list.32_kinase_cav.txt-FINAL.rot --do example/32_kinase_trpdb
  ```

