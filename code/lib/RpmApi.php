<?php 
class RpmApi {

    var $Url;
    var $Key;

    function __construct($ApiUrl, $ApiKey) {
        $this->Url = $ApiUrl;
        $this->Key = $ApiKey;
    }

    public function send($endpoint, $data = array())
    {
        $params = $this->_prepareParams($data);
        $rawResponse = $this->_sendRequest($endpoint, $params);
        return $this->_decodeResponse($rawResponse);
    }

    private function _prepareParams($data) {
        $data['Key'] = $this->Key;
        $data = json_encode($data);
        $headers = join(
            "\r\n",
            array(
                "Content-type: application/x-www-form-urlencoded",
                "Content-Length: " . strlen($data)
            )
        );
        $params = array(
            'http' => array(
                'method' => 'POST',
                'header' => $headers,
                'content' => $data
            )
        );
        return $params;
    }

    private function _sendRequest($endpoint, $params)
    {
        $url = $this->Url . 'Api2.svc/' . $endpoint;
        $context = stream_context_create($params);
        $fp = fopen($url, 'rb', false, $context);
        if (!$fp) {
            throw new Exception("Problem with $url");
        }
        $response = @stream_get_contents($fp);
        if ($response === false) {
            throw new Exception("Problem reading data from $url");
        }
        return $response;
    }

    private function _decodeResponse($raw)
    {
        echo '<pre>';
        $decoded = json_decode($raw, true);
        if (isset($decoded["Result"])) {
            $decoded = $decoded["Result"];
        }
        return $decoded;
    }
}
