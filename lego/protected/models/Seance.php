<?php

/**
 * This is the model class for table "{{seance}}".
 *
 * The followings are the available columns in table '{{seance}}':
 * @property string $id
 * @property string $movie_id
 * @property string $price
 * @property string $date
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Movie $movie
 * @property SeancePlace[] $seancePlaces
 * @property Ticket[] $tickets
 */
class Seance extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{seance}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date', 'required'),
			array('movie_id', 'length', 'max'=>10),
			array('price', 'length', 'max'=>6),
			array('status', 'length', 'max'=>8),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, movie_id, price, date, status', 'safe', 'on'=>'search'),
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
			'hmMovie' => array(self::HAS_MANY, 'MmCinemaHallMovie', 'seance_id'),
			# array(self::BELONGS_TO, 'Movie', 'movie_id'),
			'hmSeancePlace' => array(self::HAS_MANY, 'SeancePlace', 'seance_id'),
			'hmTicket' => array(self::HAS_MANY, 'Ticket', 'seance_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'movie_id' => 'Movie',
			'price' => 'Price',
			'date' => 'Date',
			'status' => 'Status',
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
		$criteria->compare('movie_id',$this->movie_id,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Seance the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
