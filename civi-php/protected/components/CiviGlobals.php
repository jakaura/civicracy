<?php 

/**
 * Global variables that do not change between different deployments.
 */
class CiviGlobals {
	public static $buttonClass = array('class' => 'btn btn-primary btn-civi'); // CSS class for buttons
	public static $buttonClassWarning = array('class' => 'btn btn-primary btn-civi btn-warning'); // CSS class for buttons with warning
	public static $infoboxClass = array('class' => 'alert alert-error'); // CSS class for form error infoboxes

	public static $defaultBoardSize = 10; // proposal if you create a new Category

	// for now, store config parameters for voting here...
	public static function getSustainTimeParameters()
	{
		return array(
			'R_max' => (0.30), // (empirical) maximum representation, from experience (in fraction of total users)
			'T_max' => (14), // representation should be stable for this interval (in days)
		);
	}

	/**
	 * Includes the requested JS file into a view.
	 */
	public static function requireJs($fileName)
	{
		$clientScript=Yii::app()->clientScript;

		// this would publish from protected/js to assets, but it does that every time
/*
		$assetManager=Yii::app()->assetManager;

		// JS files in protected/js
		$folderJs=YiiBase::getPathOfAlias('application.js');

		// publish script
		$urlContainerScript=$assetManager->publish($folderJs . DIRECTORY_SEPARATOR . $fileName);
*/

		$urlContainerScript = Yii::app()->request->baseUrl . '/js/' . $fileName;

		// register jQuery
		$clientScript->registerCoreScript('jquery');

		// register container script
		$clientScript->registerScriptFile($urlContainerScript, CClientScript::POS_HEAD);
	}
}
