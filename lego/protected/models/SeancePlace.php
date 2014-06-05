<?php

/**
 * This is the model class for table "{{seance_place}}".
 *
 * The followings are the available columns in table '{{seance_place}}':
 * @property string $id
 * @property string $cinema_hall_id
 * @property string $seance_id
 * @property string $place
 *
 * The followings are the available model relations:
 * @property CinemaHall $cinemaHall
 * @property Seance $seance
 * @property Ticket[] $tickets
 */
class SeancePlace extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{seance_place}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cinema_hall_id, seance_id, place', 'required'),
			array('cinema_hall_id, seance_id', 'length', 'max'=>10),
			array('place', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cinema_hall_id, seance_id, place, status', 'safe', 'on'=>'search'),
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
			'btCinemaHall' => array(self::BELONGS_TO, 'CinemaHall', 'cinema_hall_id'),
			'btSeance' => array(self::BELONGS_TO, 'Seance', 'seance_id'),
			'hmTicket' => array(self::HAS_MANY, 'Ticket', 'seance_place_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cinema_hall_id' => 'Cinema Hall',
			'seance_id' => 'Seance',
			'place' => 'Place',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('cinema_hall_id',$this->cinema_hall_id,true);
		$criteria->compare('seance_id',$this->seance_id,true);
		$criteria->compare('place',$this->place,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeancePlace the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
