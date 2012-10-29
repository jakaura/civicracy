<?php

$this->breadcrumbs=array(
    Yii::t('app', 'menu.vote') => array('/vote'),
    Yii::t('app', 'menu.viewCategoryVote', array('{category}' => $category)),
);

$this->menu=array(
	array('label' => Yii::t('app', 'menu.vote.again'), 'url'=>array('update', 'id' => $id)),
);

?>
		<div class="hero-unit">
			<div class="hero-left">
				<div class="hero-title">
					<h1>Civicracy</h1>
					<p>Demokratisch Entscheidungsträger finden</p>
				</div>
				<div class="hero-logo">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/civicracy.png" alt="Kreise" />
				</div>
			</div>
			<div class="hero-right hero-title-right">
				<h2>HTL Rennweg</h2>
				<h3>Schülerrat</h3>
				<div class="hero-description">
					<p>Der Schülerrat wird per Civicracy demokratisch gewählt und ist ein Organ zur Unterstützung des Schulsprechers.</p>
				</div>
			</div>
			<div class="container"></div>
		</div>
		<div class="main-content">
<h4><?php echo Yii::t('app', 'vote.path'); ?></h4>
<p><?php echo Category::model()->getAttributeLabel('name'); ?>: <strong><?php echo $category; ?></strong><br/>
<?php echo Vote::model()->getAttributeLabel('reason'); ?>: <strong><?php echo $reason; ?></strong></p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vote-path-grid',
	'dataProvider'=>$votePath,
	'columns'=>array(
		array(
			'header' => User::model()->getAttributeLabel('realname'),
			'value' => '$data->realname',
		),
		array(
			'header' => Vote::model()->getAttributeLabel('reason'),
			'value' => '$data->reason',
		),
	),
)); ?>
		</div>