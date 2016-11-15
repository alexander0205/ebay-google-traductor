/*price range*/
var htmlProduct =    '<div class="col-sm-4"> <div class="product-image-wrapper"> <div class="single-products"> <div class="productinfo text-center">'+
                                        '<img src="{img}" alt="" />'+
                                        '<h2>RD{price}</h2>'+
                                        '<p>{tittle}</p>'+
                                        '<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Comprar</a>'+
                                    '</div>'+
                                    '<div class="product-overlay">'+
                                        '<div class="overlay-content">'+
                                            '<h2>RD{price}</h2>'+
                                            '<p>{tittle}</p>'+
                                            '<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Comprar</a>'+
                                       ' </div>'+
                                    '</div>'+
                                   '<img src="images/home/sale.png" class="new" alt="" />'+
                                '</div>'+
                               '<div class="choose">'+
                                    '<ul class="nav nav-pills nav-justified">'+
                                        '<li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>'+
                                        '<li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>'+
                                    '</ul>'+
                                '</div>'+
                            '</div>'+
                        '</div> ';
function _cb_findItemsByKeywords(root) {
  console.log(root.PictureURL);
 /* var items = root.findItemsByKeywordsResponse[0].searchResult[0].item || [];
  var html = [];
  for (var i = 0; i < items.length; ++i) {
    var item     = items[i];
    var title    = item.title;
    var pic      = item.galleryURL;
    console.log(pic);

    var id = item.itemId;
    var pic = 'http://thumbs3.ebaystatic.com/d/l400/pict/'+id+'.jpg'
    console.log(pic);
    var viewitem = item.viewItemURL;    
    var price = item.sellingStatus[0].currentPrice[0].__value__;
    price = parseFloat(price) * parseFloat(44.50);
    if (null != title && null != viewitem) {
      var string =htmlProduct;
        string = string.replace('{price}',price);
         string = string.replace('{tittle}',title);
          string = string.replace('{price}',price);
         string = string.replace('{tittle}',title);
          string = string.replace('{img}',pic);
      html.push(string);

    }
  }
 */
  //document.getElementById("panel-principal").innerHTML = html.join("");
}  // End _cb_findItemsByKeywords() function

// Create a JavaScript array of the item filters you want to use in your request
var filterarray = [
  {
   "name":"MaxPrice", 
   "value":"199", 
   "paramName":"Currency", 
   "paramValue":"USD"
 },
  {"name":"FreeShippingOnly", 
   "value":"true", 
   "paramName":"", 
   "paramValue":""
 },
  {"name":"ListingType", 
   "value":["AuctionWithBIN", "FixedPrice", "StoreInventory"], 
   "paramName":"", 
   "paramValue":""},
  ];


// Define global variable for the URL filter
var urlfilter = "";

// Generates an indexed URL snippet from the array of item filters
 // End buildURLArray() function

// Execute the function to build the URL filter

// Construct the request
// Replace MyAppID with your Production AppID
var url = "http://open.api.ebay.com/shopping?&";
    url += "callname=GetSingleItem";
    url += "&version=515";
    url += "&siteid=0";
    url += "&appid=comprael-5c2f-469a-b9ad-c155d852646a";
    url += "&ItemID=171722366182";
    url += "&responseencoding=JSON";
   // url += "&IncludeSelector=Description,ItemSpecifics";
    url += urlfilter;


// Submit the request 
s=document.createElement('script'); // create script element
s.src= url;
console.log(url);
document.body.appendChild(s);

// Display the request as a clickable link for testing
document.write("<a href=\"" + url + "\">" + url + "</a>");


