<?php

/**
 * This is the model class for table "{{cinema_hall}}".
 *
 * The followings are the available columns in table '{{cinema_hall}}':
 * @property string $id
 * @property string $cinema_id
 * @property string $title
 * @property string $status
 * @property Cinema $cinema
 *
 * The followings are the available model relations:
 * @property Movie[] $yiiMovies
 * @property SeancePlace[] $seancePlaces
 * @property Ticket[] $tickets
 */
class CinemaHall extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cinema_hall}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cinema_id, title', 'required'),
			array('cinema_id, title', 'length', 'max'=>10),
			array('status', 'length', 'max'=>8),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cinema_id, title, status', 'safe', 'on'=>'search'),
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
			'btCinema' => array(self::BELONGS_TO, 'Cinema', 'cinema_id'),
			'hmCinemaHallMovie' => array(self::HAS_MANY, 'MmCinemaHallMovie', 'cinema_hall_id'),
			#array(self::MANY_MANY, 'Movie', '{{mm_cinema_hall_movie}}(cinema_hall_id, movie_id)'),
			'hmSeancePlace' => array(self::HAS_MANY, 'SeancePlace', 'cinema_hall_id'),
			'hmTicket' => array(self::HAS_MANY, 'Ticket', 'cinema_hall_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cinema_id' => 'Cinema',
			'title' => 'Title',
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
		$criteria->compare('cinema_id',$this->cinema_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CinemaHall the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
