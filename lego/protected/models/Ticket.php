<?php

/**
 * This is the model class for table "{{ticket}}".
 *
 * The followings are the available columns in table '{{ticket}}':
 * @property string $id
 * @property string $hash
 * @property string $cinema_id
 * @property string $cinema_hall_id
 * @property string $movie_id
 * @property string $seance_id
 * @property string $seance_place_id
 * @property string $cinema_title
 * @property string $cinema_hall_title
 * @property string $movie_title
 * @property string $seance_date
 * @property string $seance_place
 * @property string $date
 *
 * The followings are the available model relations:
 * @property CinemaHall $cinemaHall
 * @property Cinema $cinema
 * @property Movie $movie
 * @property Seance $seance
 * @property SeancePlace $seancePlace
 */
class Ticket extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ticket}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hash, cinema_title, cinema_hall_title, movie_title, seance_date, seance_place', 'required'),
			array('hash', 'length', 'max'=>128),
			array('cinema_id, cinema_hall_id, movie_id, seance_id, seance_place_id', 'length', 'max'=>10),
			array('cinema_title, cinema_hall_title, movie_title, seance_place', 'length', 'max'=>255),
			array('date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hash, cinema_id, cinema_hall_id, movie_id, seance_id, seance_place_id, cinema_title, cinema_hall_title, movie_title, seance_date, seance_place', 'safe', 'on'=>'search'),
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
			'btCinema' => array(self::BELONGS_TO, 'Cinema', 'cinema_id'),
			'btMovie' => array(self::BELONGS_TO, 'Movie', 'movie_id'),
			'btSeance' => array(self::BELONGS_TO, 'Seance', 'seance_id'),
			'btSeancePlace' => array(self::BELONGS_TO, 'SeancePlace', 'seance_place_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hash' => 'Hash',
			'cinema_id' => 'Cinema',
			'cinema_hall_id' => 'Cinema Hall',
			'movie_id' => 'Movie',
			'seance_id' => 'Seance',
			'seance_place_id' => 'Seance Place',
			'cinema_title' => 'Cinema Title',
			'cinema_hall_title' => 'Cinema Hall Title',
			'movie_title' => 'Movie Title',
			'seance_date' => 'Seance Date',
			'seance_place' => 'Seance Place',
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
		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('cinema_id',$this->cinema_id,true);
		$criteria->compare('cinema_hall_id',$this->cinema_hall_id,true);
		$criteria->compare('movie_id',$this->movie_id,true);
		$criteria->compare('seance_id',$this->seance_id,true);
		$criteria->compare('seance_place_id',$this->seance_place_id,true);
		$criteria->compare('cinema_title',$this->cinema_title,true);
		$criteria->compare('cinema_hall_title',$this->cinema_hall_title,true);
		$criteria->compare('movie_title',$this->movie_title,true);
		$criteria->compare('seance_date',$this->seance_date,true);
		$criteria->compare('seance_place',$this->seance_place,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ticket the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
