<?php
App::uses('AppModel', 'Model');
class Yatter extends AppModel 
{
    var $name = 'Yatter';

    // point
    const POINT_1 = 1;
    const POINT_2 = 2;
    const POINT_3 = 3;

public static $pointList = array(
self::POINT_1 => '1ポイント',
self::POINT_2 => '2ポイント',
self::POINT_3 => '3ポイント'
);

    public $validate = array(
    );

    public function beforeSave() {
        return true;
    }
}
