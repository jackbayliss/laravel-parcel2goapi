# Laravel Parcel2GO API

** At the moment you can only quote, not book- as I haven't implemented anything else yet. **

## Why?
* Created for my own personal use, wanted something simple to use for quoting parcels.
* You get around 46 quotes for your one, with all various courier / freight companies- great for customers.


## How do I get/use it?

Composer require the package into your laravel project.
```php
composer require jackbayliss/laravel-parcel2goapi
```

> Note: If you're using Laravel >= 5.5, you can skip the registration of the service provider, as they are registered automatically. So no need to add it into your providers array.

Then in your config folder, go into your app.php and add the below to the providers array.
```php
jackbayliss\Parcel2GoApi\Parcel2GoAPIServiceProvider::class,
```

I would then recommend setting your `client_id`, and `client_secret` which can be found in vendor->jackbayliss->Config->config.php
once these have been set you can then use the API.

If you don't have the above, set up an account [here](https://www.parcel2go.com/login), then create your API credentials by going [here](https://www.parcel2go.com/myaccount/api).

Once you've set your `client_id` and `client_secret` you're ready to use- simply do the below.

```php
$parcel = [array("Value" =>150 ,"Weight" =>2, "Length" =>9, "Width" => 8, "Height" => 1)];
$api = new \jackbayliss\Parcel2GoApi\Parcel2GoAPI();
$api->SetToCountry("GBR")->SetParcels($parcel)->GetQuote();

 ```
 
If you want to add more than one parcel, you can just do the below
 ```php
$parcels = [
array("Value" =>150 ,"Weight" =>2, "Length" =>9, "Width" => 8, "Height" => 1)
array("Value" =>250 ,"Weight" =>1, "Length" =>3, "Width" => 2, "Height" => 3)
];
$api = new \jackbayliss\Parcel2GoApi\Parcel2GoAPI();
$api->SetToCountry("GBR")->SetParcels($parcels)->GetQuote();


  Once you've done the above, you can access the quotes given to you by simply doing 
  ```php
  $api->quotes
  ```
  Or just add it onto the GetQuote method like the below..
  
  ```php
  $api->SetToCountry("GBR")->SetParcels($parcels)->GetQuote()->quotes
  ```

  ## Authors
  * Jack Bayliss - Initial work
  
 ## License
This project is licensed under the MIT License - see the [LICENSE](https://github.com/jackbayliss/laravel-parcel2goapi/blob/master/LICENSE) file for details
  
  
  That's all folks 👍
  
