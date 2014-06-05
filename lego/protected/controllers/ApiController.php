<?php

class ApiController extends Controller
{

	/**
	 * private
	 */

	/**
	 * find free places on the seance
	 */
	private function findFreePlaces($seanceId, $places)
	{
		$seanceId = $seanceId;
		$seancePlaces = $places;
		$data = array();

		if((int)$seanceId && $seancePlaces)
		{



			$connection = Yii::app()->db;
			$sql = "select count(seance_place.id) as cnt, cinema_hall.places as places
					from {{cinema_hall}} as cinema_hall
					left join {{seance_place}} as seance_place on seance_place.cinema_hall_id = cinema_hall.id
					left join (select id from {{seance}} where id = ".(int)$seanceId.") as seance on seance_place.seance_id = seance.id
					";
			$queryData = $connection->createCommand($sql)->queryRow();

			$aAllPlaces = array();
			for($i=1; $i<=$queryData['places']; $i++)
			{
				$aAllPlaces[] = $i;
			}

			if($queryData['cnt'] > 0)
			{
				$aBusyPlaces = array();
				for($i=1; $i<=$queryData['cnt']; $i++)
				{
					$aBusyPlaces[] = $i;
				}
				$data = array_diff($aAllPlaces, $aBusyPlaces);
			}
			else
				$data = $aAllPlaces;

		}

		return $data;
	}

	/**
	 * public
	 */

	/**
	 *  cinema
	 */
	public function actionCinema()
	{
		$cinemaTitle = Yii::app()->request->getQuery('title');
		$cinemaHall = Yii::app()->request->getQuery('hall');
		$data = array();

		if(!$cinemaHall && !$cinemaTitle)
		{
			$model = Cinema::model()->findAll(array('condition' => 't.status = "ACTIVE"'));
			foreach($model as $k=>$vProp)
			{
				$data[$k]['id'] = $vProp->id;
				$data[$k]['title'] = $vProp->title;
			}
		}
		elseif($cinemaTitle && !$cinemaHall)
		{
			$model = Movie::model()->with(array(
											   'hmCinemaHallMovie.btCinemaHall' => array('alias' => 'cinemaHall', 'condition' => 'cinemaHall.status = "ACTIVE"'),
											   'hmCinemaHallMovie.btCinemaHall.btCinema' => array('alias' => 'cinema', 'condition'=>'cinema.title = :title AND cinema.status = "ACTIVE" ', 'params'=>array(':title'=>$cinemaTitle)),
											   'hmCinemaHallMovie.btSeance' => array('alias' => 'seance', 'condition' => 'seance.status = "ACTIVE"  AND seance.date >= :date', 'params'=>array(':date'=>date('Y-m-d H:i:s'))),
										  ))->findAll();

			foreach($model as $k=>$vProp)
			{
				$data[$k]['movie']['id'] = $vProp->id;
				$data[$k]['movie']['title'] = $vProp->title;

				foreach($vProp->hmCinemaHallMovie as $i=>$vCinemaHallMovie)
				{

					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['id'] = $vCinemaHallMovie->btCinemaHall->id;
					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['title'] = $vCinemaHallMovie->btCinemaHall->title;
					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['places'] = $vCinemaHallMovie->btCinemaHall->places;

					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['seance'][$vCinemaHallMovie->btSeance->id]['id'] = $vCinemaHallMovie->btSeance->id;
					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['seance'][$vCinemaHallMovie->btSeance->id]['date'] = $vCinemaHallMovie->btSeance->date;
					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['seance'][$vCinemaHallMovie->btSeance->id]['price'] = $vCinemaHallMovie->btSeance->price;
				}

			}

		}
		elseif($cinemaTitle && $cinemaHall)
		{
			$model = Movie::model()->with(array(
											   'hmCinemaHallMovie.btCinemaHall' => array('alias' => 'cinemaHall', 'condition' => 'cinemaHall.title = :title_hall', 'params'=>array(':title_hall'=>$cinemaHall)),
											   'hmCinemaHallMovie.btCinemaHall.btCinema' => array('alias' => 'cinema', 'condition'=>'cinema.title = :title AND cinema.status = "ACTIVE"', 'params'=>array(':title'=>$cinemaTitle)),
											   'hmCinemaHallMovie.btSeance' => array('alias' => 'seance', 'condition' => 'seance.status = "ACTIVE" AND seance.date >= :date', 'params'=>array(':date'=>date('Y-m-d H:i:s'))),
										  ))->findAll();

			foreach($model as $k=>$vProp)
			{
				$data[$k]['movie']['id'] = $vProp->id;
				$data[$k]['movie']['title'] = $vProp->title;

				foreach($vProp->hmCinemaHallMovie as $i=>$vCinemaHallMovie)
				{

					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['id'] = $vCinemaHallMovie->btCinemaHall->id;
					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['title'] = $vCinemaHallMovie->btCinemaHall->title;
					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['places'] = $vCinemaHallMovie->btCinemaHall->places;

					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['seance'][$vCinemaHallMovie->btSeance->id]['id'] = $vCinemaHallMovie->btSeance->id;
					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['seance'][$vCinemaHallMovie->btSeance->id]['date'] = $vCinemaHallMovie->btSeance->date;
					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['seance'][$vCinemaHallMovie->btSeance->id]['price'] = $vCinemaHallMovie->btSeance->price;
				}

			}

		}

		if($data)
			echo CJSON::encode(array(
										'success',
										$data
								   ));

		else
			echo CJSON::encode(array(
										'error',
										'no records found'
								   ));


		Yii::app()->end();

	}

	/**
	 * movie
	 */
	public function actionMovie()
	{

		$movieTitle = Yii::app()->request->getQuery('title');
		$data = array();

		if($movieTitle)
		{
			$model = Movie::model()->with(array(
											   'hmCinemaHallMovie.btCinemaHall' => array('alias' => 'cinemaHall', 'condition' => 'cinemaHall.status = "ACTIVE"'),
											   'hmCinemaHallMovie.btCinemaHall.btCinema' => array('alias' => 'cinema', 'condition'=>'cinema.status = "ACTIVE" '),
											   'hmCinemaHallMovie.btSeance' => array('alias' => 'seance', 'condition' => 'seance.status = "ACTIVE"  AND seance.date >= :date', 'params'=>array(':date'=>date('Y-m-d H:i:s'))),
										  ))->findAll(array('condition'=>'t.title = :title AND t.status = "ACTIVE" ', 'params'=>array(':title'=>$movieTitle)));

			foreach($model as $k=>$vProp)
			{
				$data[$k]['movie']['id'] = $vProp->id;
				$data[$k]['movie']['title'] = $vProp->title;

				foreach($vProp->hmCinemaHallMovie as $i=>$vCinemaHallMovie)
				{
					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['id_cinema'] = $vCinemaHallMovie->btCinemaHall->btCinema->id;
					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['title_cinema'] = $vCinemaHallMovie->btCinemaHall->btCinema->title;

					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['id'] = $vCinemaHallMovie->btCinemaHall->id;
					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['title'] = $vCinemaHallMovie->btCinemaHall->title;
					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['places'] = $vCinemaHallMovie->btCinemaHall->places;

					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['seance'][$vCinemaHallMovie->btSeance->id]['id'] = $vCinemaHallMovie->btSeance->id;
					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['seance'][$vCinemaHallMovie->btSeance->id]['date'] = $vCinemaHallMovie->btSeance->date;
					$data[$k]['hall'][$vCinemaHallMovie->btCinemaHall->id]['seance'][$vCinemaHallMovie->btSeance->id]['price'] = $vCinemaHallMovie->btSeance->price;
				}

			}
		}

		if($data)
			echo CJSON::encode(array(
										'success',
										$data
								   ));

		else
			echo CJSON::encode(array(
										'error',
										'no records found'
								   ));


		Yii::app()->end();


	}

	/**
	 * seance
	 */
	public function actionSeance()
	{

		$seanceId = Yii::app()->request->getQuery('id');
		$seancePlaces = Yii::app()->request->getQuery('places');

		$data = $this->findFreePlaces($seanceId, $seancePlaces);

		if($data)
			echo CJSON::encode(array(
										'success',
										$data
								   ));

		else
			echo CJSON::encode(array(
										'error',
										'no records found'
								   ));


		Yii::app()->end();


	}

	/**
	 * ticket
	 */
	public function actionTicket()
	{

		$action = Yii::app()->request->getPost('action');
		$places = Yii::app()->request->getPost('places');
		$seanceId = Yii::app()->request->getPost('seance');
		$orderHash = Yii::app()->request->getPost('hash');

		# buying
		if($action == 'buy' && $places && (int)$seanceId)
		{
			#find free places
			$freePlaces = $this->findFreePlaces($seanceId, $places);

			#compare its with income places
			$aPlaces = explode(',', $places);
			$aCheck = array_intersect($aPlaces, $freePlaces);
			if(count($aCheck) == count($aPlaces))
			{
				#find all info for the tickets
				$movieModel = Movie::model()->with(array(
												   'hmCinemaHallMovie.btCinemaHall' => array('alias' => 'cinemaHall', 'condition' => 'cinemaHall.status = "ACTIVE"'),
												   'hmCinemaHallMovie.btCinemaHall.btCinema' => array('alias' => 'cinema', 'condition'=>'cinema.status = "ACTIVE" '),
												   'hmCinemaHallMovie.btSeance' => array('alias' => 'seance', 'condition' => 'seance.id = :id ', 'params'=>array(':id'=>(int)$seanceId)),
											  ))->find(array('condition'=>'t.status = "ACTIVE" '));

				$transaction = Yii::app()->db->beginTransaction();

				try
				{
					# book places and  make tickets
					$aTickets = array();
					foreach($aPlaces as $vPlace)
					{
						$model = new SeancePlace();
						$model->cinema_hall_id = $movieModel->hmCinemaHallMovie[0]->btCinemaHall->id;
						$model->seance_id = (int)$seanceId;
						$model->place = $vPlace;
						$model->save();

						$ticket = new Ticket();
						$ticket->hash = hash('sha256',($movieModel->hmCinemaHallMovie[0]->btCinemaHall->title.$movieModel->title.$vPlace.microtime().'JHfJ674ND15g'));
						$ticket->cinema_id = $movieModel->hmCinemaHallMovie[0]->btCinemaHall->btCinema->id;
						$ticket->cinema_hall_id = $movieModel->hmCinemaHallMovie[0]->btCinemaHall->id;
						$ticket->movie_id = $movieModel->id;
						$ticket->seance_id = $movieModel->hmCinemaHallMovie[0]->btSeance->id;
						$ticket->seance_place_id = $model->id;
						$ticket->cinema_title = $movieModel->hmCinemaHallMovie[0]->btCinemaHall->btCinema->title;
						$ticket->cinema_hall_title = $movieModel->hmCinemaHallMovie[0]->btCinemaHall->title;
						$ticket->movie_title = $movieModel->title;
						$ticket->seance_date = $movieModel->hmCinemaHallMovie[0]->btSeance->date;
						$ticket->seance_place = $vPlace;
						$ticket->date = date('Y-m-d H:i:s');
						$ticket->save();
						$aTickets[] = $ticket->id;

					}

					# make order
					$order = new Order();
					$orderHash = hash('sha256',($movieModel->hmCinemaHallMovie->btCinemaHall->title.$movieModel->title.serialize($aTickets).microtime().'JHfJ674ND15g'));
					$order->hash = $orderHash;
					$order->tickets = serialize($aTickets);
					$order->date = date('Y-m-d H:i:s');
					$order->seance_date = $movieModel->hmCinemaHallMovie[0]->btSeance->date;
					$order->save();

					$transaction->commit();
					echo CJSON::encode(array(
												'success',
												$orderHash
										   ));
				}
				catch(Exception $e)
				{
					Yii::log('Unable to save order: '.$e->getMessage(), CLogger::LEVEL_ERROR);
					$transaction->rollback();
					echo CJSON::encode(array(
												'error',
												'error has occurred'
										   ));

				}

			}
			else
				echo CJSON::encode(array(
										'error',
										'wrong parameters'
								   ));


		}
		# cancellation
		elseif($action == 'cancel' && $orderHash)
		{
			#find order by hash and check and rollback
			$order = Order::model()->findByAttributes(array('hash'=>$orderHash));
			if(!$order)
			{
				echo CJSON::encode(array(
											'error',
											'no records found'
									   ));
				Yii::app()->end();
			}
			if((strtotime($order->seance_date) - time()) < 3600)
			{
				echo CJSON::encode(array(
											'error',
											'too late to cancel'
									   ));
				Yii::app()->end();
			}
			$aTickets = unserialize($order->tickets);


				$transaction = Yii::app()->db->beginTransaction();

				try
				{
					# delete tickets and places
					foreach($aTickets as $vTicket)
					{
						$ticket = Ticket::model()->findByPk($vTicket);
						$model = SeancePlace::model()->findByPk($ticket->seance_place_id);
						$model->delete();
						$ticket->delete();
					}

					# delete order
					$order->delete();

					$transaction->commit();
					echo CJSON::encode(array(
												'success',
												'order has been canceled'
										   ));
				}
				catch(Exception $e)
				{
					Yii::log('Unable to delete order: '.$e->getMessage(), CLogger::LEVEL_ERROR);
					$transaction->rollback();
					echo CJSON::encode(array(
												'error',
												'error has occurred'
										   ));

				}



		}
		else
			echo CJSON::encode(array(
									'error',
									'wrong parameters'
							   ));
		Yii::app()->end();


	}



}