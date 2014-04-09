<?php

/**
 * This is the model class for table "members".
 *
 * The followings are the available columns in table 'members':
 * @property string $characterID
 * @property string $character
 * @property string $startDateTime
 * @property string $baseID
 * @property string $base
 * @property string $title
 * @property string $logonDateTime
 * @property string $logoffDateTime
 * @property string $locationID
 * @property string $location
 * @property string $shipTypeID
 * @property string $shipType
 * @property string $roles
 * @property string $grantableRoles
 */
class Members extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Members the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'members';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('characterID, character, startDateTime, baseID, base, title, logonDateTime, logoffDateTime, locationID, location, shipTypeID, shipType, roles, grantableRoles', 'required'),
			array('characterID, baseID, locationID, shipTypeID, roles, grantableRoles', 'length', 'max'=>10),
			array('character, base, title, location, shipType', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('characterID, character, startDateTime, baseID, base, title, logonDateTime, logoffDateTime, locationID, location, shipTypeID, shipType, roles, grantableRoles', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'characterID' => 'Character',
			'character' => 'Character',
			'startDateTime' => 'Start Date Time',
			'baseID' => 'Base',
			'base' => 'Base',
			'title' => 'Title',
			'logonDateTime' => 'Logon Date Time',
			'logoffDateTime' => 'Logoff Date Time',
			'locationID' => 'Location',
			'location' => 'Location',
			'shipTypeID' => 'Ship Type',
			'shipType' => 'Ship Type',
			'roles' => 'Roles',
			'grantableRoles' => 'Grantable Roles',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('characterID',$this->characterID,true);
		$criteria->compare('character',$this->character,true);
		$criteria->compare('startDateTime',$this->startDateTime,true);
		$criteria->compare('baseID',$this->baseID,true);
		$criteria->compare('base',$this->base,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('logonDateTime',$this->logonDateTime,true);
		$criteria->compare('logoffDateTime',$this->logoffDateTime,true);
		$criteria->compare('locationID',$this->locationID,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('shipTypeID',$this->shipTypeID,true);
		$criteria->compare('shipType',$this->shipType,true);
		$criteria->compare('roles',$this->roles,true);
		$criteria->compare('grantableRoles',$this->grantableRoles,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}