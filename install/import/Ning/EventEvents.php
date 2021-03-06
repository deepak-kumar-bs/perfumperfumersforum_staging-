<?php

class Install_Import_Ning_EventEvents extends Install_Import_Ning_Abstract
{
  protected $_fromFile = 'ning-events-local.json';

  protected $_fromFileAlternate = 'ning-events.json';

  protected $_toTable = 'engine4_event_events';

  protected $_resourceType = 'event';

  protected $_priority = 700;

  protected function  _translateRow(array $data, $key = null)
  {
    $userIdentity = $this->getUserMap($data['contributorName']);
    $eventIdentity = $key + 1;
    $this->setEventMap($data['id'], $eventIdentity);

    $newData = array();

    $newData['event_id'] = $eventIdentity;
    $newData['title'] = $data['title'] ? $data['title'] : 'Untitled';
    $newData['description'] = $data['description'] . "\n" . @$data['contactInfo'] . "\n" . @$data['website'];
    $newData['user_id'] = $userIdentity;
    $newData['parent_type'] = 'user';
    $newData['parent_id'] = $userIdentity;
    $newData['search'] = 1;
    $newData['creation_date'] = $this->_translateTime($data['createdDate']);
    $newData['modified_date'] = $this->_translateTime($data['updatedDate']);
    $newData['starttime'] = $this->_translateTime($data['startDate']);
    $newData['endtime'] = $this->_translateTime($data['endDate']);
    $newData['host'] = (string) ( @$data['organizedBy'] == $data['contributorName'] ? '' : @$data['organizedBy'] );
    $newData['location'] = join(' ', array_filter(array(@$data['location'], @$data['street'], @$data['city'])));
    $newData['view_count'] = 0;
    $newData['member_count'] = !empty($data['members']) ? count($data['members']) : 0;

    // privacy
    $this->_insertPrivacy($this->_resourceType, $newData['event_id'], 'view');
    $this->_insertPrivacy($this->_resourceType, $newData['event_id'], 'comment');

    // search
    $this->_insertSearch($this->_resourceType, $newData['event_id'], array(
      'title' => $newData['title'],
      'description' => $newData['description']
    ));

    // photo
    if( !empty($data['photoUrl']) ) {
      $info = parse_url($data['photoUrl']);
      $file = $this->getFromPath() . '/' . $info['path'];

      $file_id = $this->_translatePhoto($file, array(
        'parent_type' => $this->_resourceType,
        'parent_id' => $eventIdentity,
        'user_id' => $userIdentity,
      ));

      if( $file_id ) {
        $newData['photo_id'] = $file_id;
      }
    }

    return $newData;
  }
}
