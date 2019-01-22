<?php
  // Set the key for access to the API server
  $keys = (object)array(
    "access_key" => "input-your-access-key",
    "secret_key" => "input-your-secret-key"
  );

  // Parameters to be provided to API server to generate qr(data)code
  $params = (object)array(
    "apiHost" => "https://payapi.bitcom.com/api/bus/qrcode/create", // API HOST URL
    "appKey" => $keys->access_key, // ACCESS KEY
    "coinId" => "4", // 2(BS), 3(ETH), 4(USDT), 5(BTC), 6(BCH), 7(XRP) // The kind of coins a merchant would like to get.
    "currencyType" => "3", // 1(CNY), 2(USD), 3(KRW) // The type of legal currency for the item price.
    "itemName" => "input-your-item-name", // ITEM NAME
    "orderNum" => "123456789012345", // This is a 15-digit order number that allows the merchant to distinguish an order.
    "price" => "10000", // Item price based on specified legal currency.
    "requestTimeStr" => "2019-01-01 00:00:00" // It's time to order. NOTE: Use the merchant's time zone.
  );

  // Using parameters and signatures, create a query string as shown in the example below.
  $query_string = "appKey={$keys->access_key}&coinId={$params->coinId}&currencyType={$params->currencyType}&itemName={$params->itemName}&orderNum={$params->orderNum}&price={$params->price}&requestTimeStr={$params->requestTimeStr}&";

  $sign_string = $query_string . $keys->secret_key;

  // Capitalize MD5 result values.
  $signature = strtoupper(md5($sign_string));

  $query_string .= "sign={$signature}";

  // Send the generated query string to the API server to receive the qr(data)code back.
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $params->apiHost,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $query_string,
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/x-www-form-urlencoded",
      "cache-control: no-cache"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    echo $response;
  }