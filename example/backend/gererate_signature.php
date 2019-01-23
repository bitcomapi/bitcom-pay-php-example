<?php
  // Set the key for access to the API server
  $keys = array(
    "access_key" => "input-your-access-key",
    "secret_key" => "input-your-secret-key"
  );

  // Parameters to be provided to API server to generate qr(base64)code
  $params = array(
    "appKey" => $_POST['appKey'], // ACCESS KEY
    "coinId" => $_POST['coinId'], // 2(BS), 3(ETH), 4(USDT), 5(BTC), 6(BCH), 7(XRP) // The kind of coins a merchant would like to get.
    "currencyType" => $_POST['currencyType'], // 1(CNY), 2(USD), 3(KRW) // The type of legal currency for the item price.
    "itemName" => $_POST['itemName'], // ITEM NAME
    "orderNum" => $_POST['orderNum'], // This is a 15-digit order number that allows the merchant to distinguish an order.
    "price" => $_POST['price'], // Item price based on specified legal currency.
    "requestTimeStr" => $_POST['requestTimeStr'] // It's time to order. NOTE: Use the merchant's time zone.
  );

  // Add only when value is not null
  if ($_POST['customParams'] != NULL) {
    $params['customParams'] = $_POST['customParams'];
  }

  // Sort object key names alphabetically.
  ksort($params);

  $query_string = '';

  foreach ($params as $key => $value) {
    $query_string .= $key . "=" . $value . "&";
  }

  $sign_string = $query_string . $keys['secret_key'];

  // Capitalize MD5 result values.
  $signature = strtoupper(md5($sign_string));

  echo $signature;