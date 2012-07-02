<?php
App::uses('AppModel', 'Model');
class YatterSum extends AppModel {

    var $name = 'YatterSum';

    public $validate = array(
    );

    public function beforeSave() {
        return true;
    }
}
