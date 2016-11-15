<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\BaseUrl;
class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout','Detallesproducto'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
       $query = 'women shoes zara';
          $url = $this->url($query);
          $resp = simplexml_load_file($url);
          $search = $resp->searchResult;
        return $this->render('index', ['result_front_index'=>$search]);
    }

    public function actionProductos($nombre){
          $url = $this->url($nombre,60);
          $resp = simplexml_load_file($url);
          $search = $resp->searchResult;
        return $this->render('productos', ['result_front_index'=>$search]);
    }

    public function traductor($text){
      $text = urlencode($text);
        $req =     BaseUrl::to('https://www.googleapis.com/language/translate/v2?key=AIzaSyB5XiG95da_gMv8qaFOvIzH-uvUITm4CgM&q='.$text.'&source=en&target=es');
      $ch = curl_init();
      // Disable SSL verification
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      // Will return the response, if false it print the response
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // Set the url
      curl_setopt($ch, CURLOPT_URL,$req);
      // Execute
      $result=curl_exec($ch);
      // Closing
      curl_close($ch);

      $encode =   json_decode($result, true);
      return $encode['data']['translations'][0]['translatedText'];
    }


    public function actionDetallesproducto($id){
      $product = $this->productDetails($id);
       $resp = simplexml_load_file($product);
       return $this->render("detallesproducto",['item'=>$resp->Item]);
    }
    public function productDetails($ItemID){

      $SafeItemID = urlencode($ItemID); // Make the ItemID URL-friendly

      $endpoint = 'http://open.api.ebay.com/shopping';  // URL to call
      $responseEncoding = 'NV';                         // Type of response we want back - need to enable JSON extension

      // Construct the call 
      $apicall = "$endpoint?callname=GetSingleItem&version=517&siteid=0"
               . "&appid=comprael-5c2f-469a-b9ad-c155d852646a"
               . "&ItemID=$SafeItemID"
           //    . "&responseencoding=$responseEncoding"
               . "&IncludeSelector=Description,ItemSpecifics";
              // parse_str(file_get_contents($apicall), $resp); 
               return $apicall;
    }

    public function url($query,$cantidad = 30){

      $endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
        $version = '1.0.0';  // API version supported by your application
       $appid = 'comprael-5c2f-469a-b9ad-c155d852646a';  // Replace with your own AppID
        $globalid = 'EBAY-US';  // Global ID of the eBay site you want to search (e.g., EBAY-DE)
         // You may want to supply your own query
           $safequery = urlencode($query);  // Make the query URL-friendly

        $filterarray = array( 
          array(
            'name'=>'Condition',
            'value'=>'New',
            ),
          array(
              'name'=>'HideDuplicateItems',
              "value"=>"true", 
            ),
         array(
           "name"=>'MaxPrice', 
           "value"=>"199", 
           "paramName"=>"Currency", 
           "paramValue"=>"USD"
         ), array(
         "name"=>"FreeShippingOnly", 
           "value"=>"true", 
           "paramName"=>"", 
           "paramValue"=>""
         ), array(
           "name"=>"ListingType", 
           "value"=>array("AuctionWithBIN", "FixedPrice", "StoreInventory"), 
           "paramName"=>"", 
           "paramValue"=>""
         ),

 );

    $urlfilter = $this->buildURLArray($filterarray);
    //     $url =$url. "http://svcs.ebay.com/services/search/FindingService/v1";
    // $url = $url. "?OPERATION-NAME=findItemsByKeywords";
    // $url = $url.  "&SERVICE-VERSION=1.0.0";
    // $url = $url.  "&SECURITY-APPNAME=comprael-5c2f-469a-b9ad-c155d852646a";
    // $url = $url.  "&GLOBAL-ID=EBAY-US";
    // $url = $url.  "&descriptionSearch=true";
    // $url = $url.  "&HideDuplicateItems=true";
    // $url = $url.  "&callback=_cb_findItemsByKeywords";
    // $url = $url.  "&REST-PAYLOAD";
    // $url = $url.  "&keywords=shoes";
    // $url = $url.  "&paginationInput.entriesPerPage=9";
    // $url = $url.  $urlfilter;
$apicall = "$endpoint?";
$apicall .= "OPERATION-NAME=findItemsByKeywords";
$apicall .= "&SERVICE-VERSION=$version";
$apicall .= "&SECURITY-APPNAME=$appid";
$apicall .= "&GLOBAL-ID=$globalid";
$apicall .= "&keywords=$safequery";
$apicall .= "&paginationInput.entriesPerPage=$cantidad";
$apicall .= "$urlfilter";

    return $apicall;
    }


public function buildURLArray ($filterarray) {
           $i = '0';  // Initialize the item filter index to 0

  // Iterate through each filter in the array
  foreach($filterarray as $itemfilter) {
    // Iterate through each key in the filter
    foreach ($itemfilter as $key =>$value) {
      if(is_array($value)) {
        foreach($value as $j => $content) { // Index the key for each value
          $urlfilter .= "&itemFilter($i).$key($j)=$content";
        }
      }
      else {
        if($value != "") {
          $urlfilter .= "&itemFilter($i).$key=$value";
        }
      }
    }
    $i++;
  }
  return "$urlfilter";
}

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout($id)
    {

      ddump($id);
        return $this->render('about');
    }
}
