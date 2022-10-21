<?php

function getPrice($price)
{
    return replace_number(number_format($price)) . ' تومان';
}
