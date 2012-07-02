<?php
class BridgesController extends AppController 
{
    public $uses       = array('User', 'Yatter', 'YatterSum');
    public $components = array('RequestHandler');

    public function beforeFilter()
    {
        parent::beforeFilter();
    }

   /**
    * ヤッター!登録(Ajax)
    *
    * @access public
    */
    public function addYatter()
    {
// TODO Ajax判定(もしくはURL直叩き)を入れてエラー処理を通したい
//        if (!$this->RequestHandler->isAjax()) {
//            $this->log('Ajax以外のアクセスがありました。', 'warn');
//            $this->redirect('/error');
//        }

        if ($this->request->is('post')) {
            $this->Yatter->create();
            $data = array('Yatter' => array(
                'point' => Yatter::POINT_1
            ));

            if (!$this->Yatter->save($data)) {
                $this->set('errorMsg', '失敗!');
            } else {
                $this->set('successMsg', '成功!');
            }
        }
    }

    /**
     * ヤッター取得
     *
     * @access public
     */
    public function selectYatter()
    {
        if (!$this->RequestHandler->isAjax()) {
            $this->log('Ajax以外のアクセスがありました。', 'warn');
            $this->redirect('/');
        }
        if ($this->request->is('post')) {
            $this->Yatter->recursive = 0;
            $yatters = $this->Yatter->find('all', array(
                'limit' => AJAX_SELECT_LIMIT,
                'conditions' => array(
                    'created >=' => $this->request->data['nowTime']
//'created >=' => '2012-06-30 20:00:00'
                )
            ));
            $totalCount = count($yatters);
            $this->set(compact('yatters', 'totalCount'));
        }
    }
}
