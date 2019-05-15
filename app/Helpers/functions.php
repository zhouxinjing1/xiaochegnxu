<?php

/**
 *  拼接七牛云上传的图片
 */
function spellUrl($filename)
{
    return 'http://'. env('QI_DOMAIN') . '/' . $filename;
}