<?php
use yii\helpers\VarDumper;
/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
defined('DS') or define('DS',DIRECTORY_SEPARATOR);
function priceCalculate($libra,$price){
    $priceForDolar= 193.50 + ($price * 44.50);
    return ($priceForDolar * $libra);
 }
/**
 * This is the shortcut to Yii::app()
 * @return CApplication
 */
function app()
{
    return Yii::app();
}

function getDatesDay($from , $to,$date)
{

    while ($from == $to) {
        $stop_date = date('Y-m-d', strtotime($stop_date . ' + 1 day'));
        ddump($stop_date);
    }
}

function mirange($val1 , $val2){
   $array = array();
   for($val =$val1; $val <=$val2; $val++){
       $array[$val] = $val;
   }
   return $array;
}

function formatCurrency($price,$currency){
   $NumberFormatter= new CNumberFormatter('en-US');
  $val =  $NumberFormatter->formatCurrency(strval(ceil($price)),$currency);
  return substr($val,0,-3);

}
/**
 * This is the shortcut to Yii::app()->clientScript
 * @return CClientScript
 */
function cs()
{
    // You could also call the client script instance via Yii::app()->clientScript
    // But this is faster
    return Yii::app()->getClientScript();
}

/**
 * @return CCache
 */
function cache($force=true){
    return Yii::app()->cache?Yii::app()->cache:new CDummyCache();
}
 
/**
 * This is the shortcut to Yii::app()->user.
 * @return CWebUser
 */
function user() 
{
    return Yii::app()->getUser();
}

/**
 * Check user access to dtermined resources
 */
function access(){
	$pars = func_get_args();
	return call_user_func_array(array(user(), 'checkAccess'), $pars);
}


/**
 * This is the shortcut to Yii::app()->createUrl()
 */
function url($route,$params=array(),$ampersand='&')
{
    return Yii::app()->createUrl($route,$params,$ampersand);
}

function nurl($url){
    return CHtml::normalizeUrl($url);
}
 
/**
 * This is the shortcut to CHtml::encode
 */
function h($text)
{
    return htmlspecialchars($text,ENT_QUOTES,Yii::app()->charset);
}
 
/**
 * This is the shortcut to CHtml::link()
 */
function l($text, $url = '#', $htmlOptions = array()) 
{
    return CHtml::link($text, $url, $htmlOptions);
}
 
/**
 * This is the shortcut to Yii::t() with default category = 'stay'
 */
function t($message, $category = 'stay', $params = array(), $source = null, $language = null) 
{
    return Yii::t($category, $message, $params, $source, $language);
}
 
/**
 * This is the shortcut to Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function bu($url=null) 
{
	static $baseUrl;
    if ($baseUrl===null)
        $baseUrl=Yii::app()->getRequest()->getBaseUrl();
    return $url===null ? $baseUrl : $baseUrl.'/'.ltrim($url,'/');
}

/**
	 * Retrieves the named application module.
	 * The module has to be declared in {@link modules}. A new instance will be created
	 * when calling this method with the given ID for the first time.
	 * @param string $id application module ID (case-sensitive)
	 * @return CModule the module instance, null if the module is disabled or does not exist.
	 */
function mod($id=null){
	return Yii::app()->getModule($id);
}
 
/**
 * Returns the named application parameter.
 * This is the shortcut to Yii::app()->params[$name].
 */
function param($name)
{
    return Yii::app()->params[$name];
}

/**
 * Return the representation of the data
 * @param mixed $target
 */
function dump($target, $depth=10, $colors=true)
{
  return VarDumper::dump($target, $depth, $colors) ;
}

function gdump($target, $depth=10, $colors=true)
{
    ob_start();
    VarDumper::dump($target, $depth, $colors) ;
    return ob_get_clean();
}

/**
 * Return the representation of the data
 * @param mixed $target
 */
function ddump($target, $depth=10, $colors=true)
{
  die(VarDumper::dump($target, $depth, $colors)) ;
}

function getTimeFromDate($date){
    if (is_numeric($date)) return $date;

    if (false !== ($time = CDateTimeParser::parse($date, 'yyyy-M-dd') )){
        return $time;
    }else if (false !== ($time = CDateTimeParser::parse($date, Yii::app()->params['dateFormat']) )){
        return $time;
    }
    return false;
}

function yeardiff($time1, $time2=null){
    if ($time2===null)$time2 = time();
    list($Y,$m,$d) = array( date('Y', $time1), date('m', $time1),date('d', $time1) );
    return( date("md", $time2) < $m.$d ? date("Y", $time2)-$Y-1 : date("Y", $time2)-$Y );
}

function dateBetween($date,$dateFrom,$dateTo){
     $dateFrom =    strtotime($dateFrom);
     $dateTo =      strtotime( $dateTo );
     $date =        strtotime($date);

    if(($date >= $dateFrom)&& ($date <= $dateTo)){
        return true;
    }else{
        return false;
    }

}

function dateToDbFormat($date){
    return date('Y-m-d', CDateTimeParser::parse($date, Yii::app()->params['dateFormat'])) ;
}

function dateFromDbFormat($date){
    return Yii::app()->dateFormatter->format(Yii::app()->params['dateFormat'], strtotime($date));
}

function mediaTabSwitch($true, $false){
    if (Yii::app()->params['media']['showMediaTab']){
        return $true;
    }else{
        return $false;
    }
}

function showMediaTab(){
    return Yii::app()->params['media']['showMediaTab'];
}


function setDataColors($data){
    $colors = array('#00ff70', '#00e867', '#0bb6ff', '#0662ff', '#eeff00', '#ffb516', '#ff5903');


    asort($data);

    $keys = array_keys($data);
    $values = array_values($data);

    $colorMap = array();
    $colorMap[$keys[0]] = $colors[0];

    $colorMap[end($keys)] = end($colors);

    unset($keys[count($keys)-1]);
    unset($keys[0]);

    unset($colors[count($colors)-1]);
    unset($colors[0]);


    $emptyColor = '#FFFFFF';
    while(count($keys)){
        $keys = array_values($keys);
        $colors = array_values($colors);

        $colorMap[$keys[0]] = count($colors)?$colors[0]:$emptyColor;

        unset($keys[0]);
        if (count($colors)) unset($colors[0]);

        $keys = array_values($keys);
        $colors = array_values($colors);

        if (count($keys)){
            $colorMap[$keys[count($keys)-1]] = count($colors)?$colors[count($colors)-1]:$emptyColor;
            unset($keys[count($keys)-1]);
            if (count($colors)) unset($colors[count($colors)-1]);
        }
    }

    return $colorMap;
}