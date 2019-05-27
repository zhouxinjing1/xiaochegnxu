<?php

/**
 *  拼接七牛云上传的图片
 */
function spellUrl($filename)
{
    return 'http://'. env('QI_DOMAIN') . '/' . $filename;
}

/**
 * 城市
 * @param $data
 * @param $index
 * @param $mark
 * @return mixed
 */
function spellCity($data ,$index, $mark)
{
    return explode($mark,$data)[$index];
}