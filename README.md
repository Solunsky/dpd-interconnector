# Interconnector - DPD API

Interconnector is a REST-based Web-Service to integrate information systems of DPD customers, which through POST requests allows using DPD services provided. Interconnector allows to use DPD services by transmitting shipment information, requesting package pickups, printing parcel labels, etc.

## Documentation

[**Interconnector (EN) V2.6 | From DPD LV (DPD shipment creation and tracking web services)**](https://www.dpd.com/lv/en/sending-parcels/e-commerce/for-developers/)

[**Interconnector (EN) V2.4 | From DPD EE**](https://www.dpd.com/ee/wp-content/uploads/sites/235/2020/04/Interconnector_dokumentatsioon-1.pdf)

## Installiation

#### Require

- PHP >=5.5

Work at PHP ^7.*

```
composer require solunsky/dpd-interconnector
```

## Full example

```
use Solunsky\Interconnector\Authentication;
use Solunsky\Interconnector\Request\CreateShipment;
use Solunsky\Interconnector\Request\PrintLabel;
use Solunsky\Interconnector\Client;

$auth = new Authentication('username', 'password', 'lv');
$shipmentRequest = new CreateShipment($auth, $params);
$client = new Client(array('verify' => false));

// Response
$shipmentResponse = $client->get($shipmentRequest);
// Output json

// Response Label
$printRequest = new PrintLabel($auth, $shipmentResponse['pl_number']);
$printResponse = $client->get($printRequest, false);
// Output string

header("Content-type:application/pdf");
echo $print;
```

## Authentication (Step 1)


##### Params:

```
string|array $countryCode: 'lv' or 'ee' or 'lt' or array("uk" => "https://integration.dpd.uk/ws-mapper-rest/")
boolean $debug: default false
```
##### Example:

```
use Solunsky\Interconnector\Authentication;

$auth = new Authentication('username', 'password', $countryCode);
```

## Methods (Step 2)

### Shipment creation

This method creates shipment that can contain one or multiple parcels.
The data that is needed for creating shipments will depend on DPD service that is requested.

##### Params:

Read the documentation

```
array $params
```

##### Example:

```
use Solunsky\Interconnector\Request\CreateShipment;

$response = new CreateShipment($auth, $params);
```

### Parcel label creation

This method generates a parcel label. There’s a possibility to configure automatic data submission by
DPD triggered by parcel printing.

##### Params:

Read the documentation

```
string $numbers: parcel number (pl_number)
string $printType: default PDF, other epl, zpl
string $printFormat: default A6, other A4, A5
integer $printSequence: default 1
string $printPosition: default LeftTop
```

##### Example:

```
use Solunsky\Interconnector\Request\PrintLabel;

$print = new PrintLabel($auth, $response['pl_number']);

header("Content-type:application/pdf");
echo $print;
```

### Parcel pickup request

This method provides information for DPD that you need a courier that should pick up your parcels. It
has to be used in cases if there is no pre-agreed regular parcel’ pick-up time.

##### Params:

Read the documentation

```
array $params
```

##### Example:

```
use Solunsky\Interconnector\Request\ParcelPickup;

$response = new ParcelPickup($auth, $params);
```

### Pickup point search

This method provides a list of DPD Pickup points (parcel shops and pickup lockers).

##### Params:

Read the documentation

```
array $params
```

### Parcel pickup request

This method provides information for DPD that you need a courier that should pick up your parcels. It
has to be used in cases if there is no pre-agreed regular parcel’ pick-up time.

##### Params:

Read the documentation

```
array $params
```

##### Example:

```
use Solunsky\Interconnector\Request\ParcelPickup;

$response = new ParcelPickup($auth, $params);
```

### Deleting a parcel

This method deletes a specific parcel. If shipment consists of more than one parcel, whole shipment
will be deleted in case if any parcel from this shipment is deleted.

Note: this function cannot be done in case if data has been transferred to DPD by closing manifest, by using
parcelDataSend_ (SendParcelData) or by automatic data transfer that is configured by DPD.

##### Params:

Read the documentation

```
string $numbers
```

##### Example:

```
use Solunsky\Interconnector\Request\DeleteShipment;

$response = new DeleteShipment($auth, $numbers);
```

### Parcel data submission

This method submits shipment data to DPD. Regularity for this function can be adapted to client
processes, but it should be requested at least 30 minutes before courier arrival. If needed, can be used after
each parcel. It should not be used in case if manifest closure is used or if automatic data transfer is configured
by DPD.

##### Params:

Read the documentation

```
mixed $auth
```

##### Example:

```
use Solunsky\Interconnector\Request\SendParcelData;

$response = new SendParcelData($auth);
```

### Manifest closure

This method submits shipment data for shipments that are created on specific date and returns
document that contains information about all the parcels that has been created by the API user on this date and
that were not included in any other manifest. Regularity for this function can be adapted to client processes, but
it should be requested at least 30 minutes before courier arrival. If needed, can be used after each parcel. It
should not be used in case if parcel data submission method is used or if automatic data transfer is configured
by DPD.

##### Params:

Read the documentation

```
mixed $date: (YYYYMM-DD)
mixed $format: default PDF, other json, zpl, epl
```

##### Example:

```
use Solunsky\Interconnector\Request\PrintManifest;

$response = new PrintManifest($auth, $date, $format);
```

### Collection request

This method allows to order a courier to address of a third party. For example - for DPD client to
organize his customer a free return of goods (paid by DPD client not his customer).

##### Params:

Read the documentation

```
array $params
```

##### Example:

```
use Solunsky\Interconnector\Request\RequestCollection;

$response = new RequestCollection($auth, $params);
```

## Client (Step 3)

### Params:

[Read GuzzleHttp documentation](https://docs.guzzlephp.org/en/stable/quickstart.html#making-a-request)

#### Class Client
```
array $params
```

#### Method Get
```
mixed $request,
boolean $jsonDecode: default true
```

##### Example:

```
use Solunsky\Interconnector\Client;

$client = new Client(array('verify' => false));

$response = $client->get($request);
```

## Create custom request

If you want to create your custom request use this example.

```
namespace Solunsky\Interconnector\Request;

class CustomRequest extends Request
{
    private $params;

    public function __construct($authentication, $params)
    {
        parent::__construct($authentication);

        $this->params = $params;
    }

    public function get()
    {
        $body = array_merge(
            $this->authentication->credentials(),
            $this->params
        );

        $headers = array(
            'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8',
        );

        return $this->build('POST', 'method_uri', $headers, $body);
    }
}

```

##### Use:

```
$customRequest = new CustomRequest($auth, $params);

$response = $client->get($customRequest);
```
