<?php

/**
 * This is the model class for table "{{mm_cinema_hall_movie}}".
 *
 * The followings are the available columns in table '{{mm_cinema_hall_movie}}':
 * @property string $cinema_hall_id
 * @property string $movie_id
 */
class MmCinemaHallMovie extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mm_cinema_hall_movie}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cinema_hall_id, movie_id, seance_id', 'required'),
			array('seance_id','unique'),
			array('cinema_hall_id, movie_id, seance_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cinema_hall_id, movie_id, seance_id', 'safe', 'on'=>'search'),

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
			'btSeance' => array(self::BELONGS_TO, 'Seance', 'seance_id'),
			'btCinemaHall' => array(self::BELONGS_TO, 'CinemaHall', 'cinema_hall_id'),
			'btMovie' => array(self::BELONGS_TO, 'Movie', 'movie_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cinema_hall_id' => 'Cinema Hall',
			'movie_id' => 'Movie',
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

		$criteria->compare('cinema_hall_id',$this->cinema_hall_id,true);
		$criteria->compare('movie_id',$this->movie_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MmCinemaHallMovie the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
