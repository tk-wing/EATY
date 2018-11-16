<?php

    function e($val){
        if(true){
            echo $val;
        }
    }


    function v($val,$var_name){
        if(true){
            echo '<pre>';
            echo $var_name . ' = ';
            var_dump($val);
            echo '</pre>';
        }
    }

    function h($val){
        return htmlspecialchars($val);
    }

    function result($validations,$valid_name,$item){
      if (isset($validations[$valid_name]) && $validations[$valid_name] == 'blank') {
        return $item.'を入力してください。';
      }
    }

    function select_result($validations,$valid_name,$item){
      if (isset($validations[$valid_name]) && $validations[$valid_name] == 'blank') {
        return $item.'を選択してください。';
      }
    }

?>