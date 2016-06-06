
<?php
class TestController extends ControllerBase
{

  public function indexAction()
  {
    $model = $this->_createModel();
    $model->show();
  }
  public function checkAction()
  {
    $model = $this->_createModel();
    $post = $this->_getPost();
    $model->check($post);
  }

  private function _createModel()
  {
    return $this->createModel('TestModel');
  }
  private function _getPost()
  {
    $request = new Request();
    return $request->getPost();
  }
}
