<?php
require 'UpdateYatterSumShell' . DS . 'Config' . DS . 'Config.php';
class UpdateYatterSumShell extends AppShell
{
    public $uses = array('Yatter', 'YatterSum');

    public function startup()
    {
    }

    public function main()
    {
        $yatterCount = $this->Yatter->find('count', array(
            'conditions' => array(
                'created >=' => date('Y-m-d 00:00:00', mktime(0, 0, 0, date('m'), date('d')-1, date('Y'))),
                'created <=' => date('Y-m-d 23:59:59', mktime(0, 0, 0, date('m'), date('d')-1, date('Y')))
            )
        ));

        $data['YatterSum']['yatter_count']    = $yatterCount;
        $data['YatterSum']['date']            = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')-1, date('Y')));        
        $data['YatterSum']['tomorrow_target'] = floor($yatterCount + $yatterCount * TOMORROW_TARGET_SCALE_FACTOR);
        if ($data['YatterSum']['tomorrow_target'] < TOMORROW_TARGET_BORDERLINE) {
            $data['YatterSum']['tomorrow_target'] = TOMORROW_TARGET_BORDERLINE;
        }

        $this->YatterSum->create();
        if ($this->YatterSum->save($data))  {
            CakeLog::write('console' . DS . Inflector::underscore($this->name), 'yatter_sumsへの保存が完了しました');
        } else {
            CakeLog::write('console' . DS . Inflector::underscore($this->name), 'yatter_sumsへの保存が失敗しました');
        }
    }
}
