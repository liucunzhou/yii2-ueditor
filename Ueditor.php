<?php
/**
 * 
 * @author 	wenyuan 
 * Email 	liucunzhou@163.com
 * qq		1510033691
 *
 */
namespace wenyuan\ueditor;

use Yii;
use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use wenyuan\ueditor\UeditorAsset;

class Ueditor extends InputWidget
{
    public $events = [];
    
    /*
     * Tag
     * @var bool
     */
    public $renderTag=true;
    
    /*
     * Initializes the widget
     */
    public function init() {
    	
    	$this->events = $this->options;
    	\Yii::setAlias('@wenyuan\ueditor\assets', '@vendor/wenyuan/yii2-ueditor/assets');
        if(empty($this->name)){
            $this->name=$this->hasModel() ? Html::getInputName($this->model, $this->attribute): $this->id;
        }
    	
        //register css & js
        $asset = UeditorAsset::register($this->view);
        
        //init options
        parent::init();
    }
    
    /*
     * Renders the widget
     */
    public function run() {
    	
        $this->registerScripts();
        if($this->renderTag===true){
            echo $this->renderTag();
        }
    }
  
    /**
     * render file input tag
     * @return string
     */
    private function renderTag() {
    	$options = [
    		'type'	=> 'text/plain',
    		'name'	=> $this->id,
    		'id'	=> $this->id
		];
    	
        return Html::script('', $options);
    }
    
    /**
     * register script
     */
    private function registerScripts() {
        $jsonOptions = Json::encode($this->events);
        $script = <<<EOF
var um = UE.getEditor('{$this->id}', {$jsonOptions});
EOF;
        $this->view->registerJs($script, View::POS_READY);
    }
}
