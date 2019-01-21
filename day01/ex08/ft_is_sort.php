<?php

function    ft_is_sort($arr)
{
    $res = $arr;
    sort($res);
    if ($res !== $arr)
        return (0);
    return (1);
} 

?>