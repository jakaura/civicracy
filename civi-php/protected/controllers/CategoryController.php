<?php

class CategoryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform the actions
				'actions'=>array('index','view','create','update','admin','delete','contact'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'ranking' => User::model()->getVoteCountInCategoryTotal($id),
			'voteparticipation' => Vote::model()->getVoteParticipation($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Category;

		// propose sane defaults
		$sustainParams = CiviGlobals::getSustainTimeParameters();
		$model->rmax = $sustainParams['R_max'];
		$model->tmax = $sustainParams['T_max'];
		$model->boardsize = CiviGlobals::$defaultBoardSize;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			// If a wholenumber percent number is entered it's getting converted to a 0.xx number
			$_POST['Category'] = $this->decodePercentArray($_POST['Category'], array('boardsize', 'rmax'));
			
			$model->attributes=$_POST['Category'];
			if($this->saveCategoryAndHistory($model))
				$this->redirect(array('view','id'=>$model->id));
			}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	/**
	 * Enables to Send Email from Webserver to either all Users (has to be updated for Users of just one Category
	 * or all members of the board of a specific categories (has to be updated aswell, currently just one board/category possible
	 * 
	 */
	public function actionContact($categoryId, $target)
	 {
	 	 // Formular f�r gew�hlte Benutzergruppe anzeigen!
		  	if(!isset($_POST['ContactEmail']))
		  	{
		   		$email='';
		   		$model=new ContactEmail();
			   	if($target=='all')
			   	{
			    	$users=User::model()->findAll();
			    	foreach($users as $row)
			    	{
			     		$email.=$row->email.',';
			    	}
			    	$model->email_adds=$email;
			    	$this->render('createEmail',array('model' => $model));
			   	}elseif($target=='board')
			   	{
			    	$users=User::model()->getVoteCountInCategoryTotal($categoryId);
			    	foreach($users as $row)
			    	{
			     		$email.=$row['email'].',';
			    	}
			    	$model->email_adds=$email;
			    	$this->render('createEmail',array('model' => $model));
		   		}
		  } else 
		  {
		  		$model=new ContactEmail();
		  		$model->attributes=$_POST['ContactEmail'];
		  		if($model->sendMail())
		  		{
		  			$model->sent=true;
		  			$this->render('createEmail',array('model' => $model));
		  		}
		  }
	 }


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			// If a wholenumber percent number is entered for boardsize it's getting converted to a 0.xx number
			$_POST['Category'] = $this->decodePercentArray($_POST['Category'], array('boardsize', 'rmax'));

			$model->attributes=$_POST['Category'];
			if($this->saveCategoryAndHistory($model))
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		// we only allow deletion via POST request
		if(Yii::app()->request->isPostRequest)
		{
			$category = $this->loadModel($id);

			// mark category as deleted
			$category->active = 0;
			if(!$this->saveCategoryAndHistory($category))
				return;

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400, Yii::t('app', 'http.400'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, Yii::t('app', 'http.404'));
		return $model;
	}

	/**
	 * Save a Category model while keeping history in CategoryHistory.
	 */
	private function saveCategoryAndHistory($model)
	{
		$historyModel = new CategoryHistory;
		$historyModel->attributes = $model->attributes;

		// copy safe attributes separately
		$historyModel->active = $model->active;

		return $this->saveModelAndHistory($model, $historyModel, 'category_id');
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
