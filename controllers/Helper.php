<?php

namespace app\controllers;

use Yii;
use yii\httpclient\Client;

class Helper
{
  function apiService($method, $url, $data)
  {
    $this->_url = Yii::$app->params['DreamFactoryContextURL'];
    $this->_DFHeaderKey = Yii::$app->params['DreamFactoryHeaderKey'];
    $this->_DFHeaderPass = Yii::$app->params['DreamFactoryHeaderPass'];

    $url = $this->_url . $url;

    $client = new Client();

    if ($method == 'GET')
      return $client->createRequest()
        ->setFormat(Client::FORMAT_URLENCODED)
        ->setMethod($method)
        ->setUrl($url)
        ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
        ->send();

    if ($method == 'POST' || $method == 'PUT')
      return $client->createRequest()
      ->setFormat(Client::FORMAT_URLENCODED)
      ->setMethod($method)
      ->setUrl($url)
      ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
      ->setData($data)
      ->send();
    
  }

  function apiServiceCrawler($method, $url, $data)
  {
    $this->_url = Yii::$app->params['DreamFactoryContextURLCrawler'];
    $this->_DFHeaderKey = Yii::$app->params['DreamFactoryHeaderKey'];
    $this->_DFHeaderPass = Yii::$app->params['DreamFactoryHeaderPass'];

    $url = $this->_url . $url;

    $client = new Client();

    if ($method == 'GET')
      return $client->createRequest()
        ->setFormat(Client::FORMAT_URLENCODED)
        ->setMethod($method)
        ->setUrl($url)
        ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
        ->send();

    if ($method == 'POST' || $method == 'PUT')
        return $client->createRequest()
        ->setFormat(Client::FORMAT_URLENCODED)
        ->setMethod($method)
        ->setUrl($url)
        ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
        ->setData($data)
        ->send();
  }

  function apiServiceProcedure($method, $url, $data)
  {
    $this->_url = Yii::$app->params['DreamFactoryContextURLProcedures'];
    $this->_DFHeaderKey = Yii::$app->params['DreamFactoryHeaderKey'];
    $this->_DFHeaderPass = Yii::$app->params['DreamFactoryHeaderPass'];

    $url = $this->_url . $url;

    $client = new Client();

    if ($method == 'POST' || $method == 'PUT')
        return $client->createRequest()
        ->setFormat(Client::FORMAT_URLENCODED)
        ->setMethod($method)
        ->setUrl($url)
        ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
        ->setData($data)
        ->send();

  }
   
}