<?php
namespace Admin\Controller;

class IndexController extends CommonController {
    public function index()
    {
        $this->display();
    }

    public function top()
    {
    	$this->display();
    }
    public function menu()
    {
        $this->assign('menus',$this->user['menus']);
    	$this->display();
    }
    public function main()
    {
    	$this->display();
    }
}