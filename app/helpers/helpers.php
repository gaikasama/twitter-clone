<?php


function mergeArraysById($arr1, $arr2){
    // Create pointer for loop
    $pointer1= 0;
    $pointer2 = 0;

    // Get array lengths
    $arrLength1 = count($arr1);
    $arrLength2 = count($arr2);

    $newArr = [];

    // Merge three arrays
    while(($pointer1 < $arrLength1) && ($pointer2 < $arrLength2 ))
    {
        if($arr1[$pointer1]['id'] > $arr2[$pointer2]['id'])
        {
            array_push($newArr, $arr1[$pointer1]);
            $pointer1 += 1;
        }
        else
        {
            array_push($newArr, $arr2[$pointer2]);
            $pointer2 += 1;
        }
    }

    //  After above step 1 array has 
    //  exhausted. 
    while($pointer1 < $arrLength1){
        array_push($newArr, $arr1[$pointer1]);
        $pointer1 += 1;
    }

    while($pointer2 < $arrLength2 ){
        array_push($newArr, $arr2[$pointer2]);
        $pointer2 += 1;
    }

    return $newArr;
}

function splitString($str){
    // split a string into array by spaces
    // if word starts with # put it into span tag
    // concant array into new str

    $newStr = '';
    $strArr = explode(" ",$str);
    foreach($strArr as $word){
        if($word[0] === "#"){
            $word = "<span class='color--blue pointer--cursor' onclick='searchHashtag(event)'>".$word."</span>";
        }elseif($word[0] === "@"){
            $test = explode("@", $word);
            $word = "<a href='".URLROOT."/tweets/profile/".$test[1]."' class='color--blue pointer--cursor' >".$word."</a>";
        }
        $newStr = $newStr." ".$word;
    }

    return $newStr;
}