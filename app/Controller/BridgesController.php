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
    * ヤッター登録
    *
    * @access public
    */
    public function addYatter()
    {
        if ($this->request->is('post')) {
            $this->Yatter->create();
            $data = array('Yatter' => array(
                'point' => Yatter::POINT_1,
                'comment' => $this->request->data['comment']
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
                )
            ));
            $totalCount = count($yatters);
            $this->set(compact('yatters', 'totalCount'));
        }
    }
}
