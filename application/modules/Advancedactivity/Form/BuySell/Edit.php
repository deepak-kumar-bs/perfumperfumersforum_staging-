  <?php
 
class Advancedactivity_Form_BuySell_Edit extends Advancedactivity_Form_BuySell_Create
{
  public $_error = array();
  protected $_item;

  public function getItem()
  {
    return $this->_item;
  }

  public function setItem(Core_Model_Item_Abstract $item)
  {
    $this->_item = $item;
    return $this;
  }
  
  public function init()
  {
    parent::init();
    $this->setTitle('Edit BuySell')
         ->setDescription('Edit your Advertising item below, then click \"Save Changes\" to save your item.');
   
    $this->addElement('Hidden', 'photo_id', array('value'=>''));

    $populateFiles = array();
    $photo_ids = explode(" ", $this->getItem()->photo_id);
    foreach( array_filter($photo_ids) as $photo_id ) {
      $photo = Engine_Api::_()->getItem('album_photo', $photo_id);
      if ($photo) {
        $populateFiles[] = array(
          'id' => $photo->getIdentity(),
          'src' => $photo->getPhotoUrl(),
        );
      }
    }

    $uploadUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array()) . '?ul=1';
    // $deleteUrl = $this->getView()->url(array('module' => 'album', 'controller' => 'photo', 'action' =>'delete'), 'default');
    $this->addElement('SeaoFancyUpload', 'file', array(
      'url' =>  $uploadUrl,
      'accept' => 'image/*',
      // 'deleteUrl' =>  $deleteUrl,
      'data' => array(
        'populateFiles' => $populateFiles,
        'fileIdsElement' =>  'photo_id',
      ),
    ));

    $this->title->setLabel('What to sell');
    $this->price->setLabel('What is price');
    $this->currency->setLabel('What is currency');
    $this->place->setLabel('Where to sell');
    $this->description->setLabel('Description');

    // Element: execute
    $this->addElement('Button', 'execute', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      
    ));
  }
}