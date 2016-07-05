<?php

Yii::import('gii.generators.crud.CrudGenerator');

class BootstrapGenerator extends CrudGenerator
{
	public $codeModel = 'application.extensions.giiplus.bootstrap.BootstrapCode';
}
