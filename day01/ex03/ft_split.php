<?php
function    ft_split($line)
{
    return (explode(' ', preg_replace('/ +/', ' ', trim($line))));
}
?>