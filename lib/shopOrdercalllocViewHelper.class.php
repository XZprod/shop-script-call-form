<?php

class shopOrdercalllocViewHelper
{
    public static function display()
    {
        $page_action = new shopOrdercalllocBuildForm();
//        $page_action->run(['text' =>'adasdasdasdasd']);
        $page_action->display();
    }
}