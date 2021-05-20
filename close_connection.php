<?php
function close_connection($link)
{
    mysqli_close($link);
}
//print 'close connection';