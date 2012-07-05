<?php
Class PagesController extends AppController
{
    public $name = 'Pages';
    public $uses = array('Yatter', 'YatterSum');

    public function beforeFileter()
    {
        parent::beforeFilter();
    }

    /**
     * トップページ
     *
     * @access public
     */
    public function index()
    {
        $yatters = $this->Yatter->find('all', array(
            'limit' => 10,
            'order' => array('id' => 'DESC')
        ));
        $todayYatterCount = $this->Yatter->find('count', array(
            'conditions' => array(
                'created >=' => date('Y-m-d 00:00:00'),
                'created <=' => date('Y-m-d 23:59:59')
            )
        ));
        $yatterSum = $this->YatterSum->findByDate(YESTERDAY_DATE);

        $this->set(compact('yatters', 'todayYatterCount', 'yatterSum'));
        $this->set('title_for_layout', TITLE);
        $this->set('title_for_page', TITLE);
    }
}
