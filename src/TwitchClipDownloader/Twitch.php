<?php

namespace TwitchClipDownloader;

use TwitchClipDownloader\Exceptions\Clip\Clip;
use TwitchClipDownloader\Exceptions\Clip\Save;
use TwitchClipDownloader\Exceptions\Curl\Curl as CurlException;
use TwitchClipDownloader\Exceptions\Curl\ParseResponse;
use TwitchClipDownloader\Exceptions\Curl\Response;

class Twitch {

    private string $urlEndpoint = "";
    private string $clientId = "";
    private string $sha256Hash = "";

    private string $id = "";
    private string $url = "";

    public function __construct ($clientId, $sha256Hash = '6e465bb8446e2391644cf079851c0cb1b96928435a240f07ed4b240f0acc6f1b') {
        $this->urlEndpoint = 'https://gql.twitch.tv/gql';
        $this->clientId = $clientId;
        $this->sha256Hash = $sha256Hash;
    }

    public function download ($id) {

        $this->setId($id);

        $postFields = [
            [
                "operationName" => "ClipsDownloadButton",
                "variables" => [
                    "slug" => $this->getId(),
                ],
                "extensions" => [
                    "persistedQuery" => [
                        "version" => 1,
                        "sha256Hash" => $this->getSha256Hash(),
                    ]
                ],
            ]
        ];

        $postFieldsString = json_encode($postFields);

        $options = [
            CURLOPT_URL => $this->getUrlEndpoint(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postFieldsString,
            // CURLOPT_ENCODING => "",
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            // CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => [
                "Client-Id: ".$this->getClientId(),
            ],
            // CURLOPT_PROXY => $proxy['ip'],
            // CURLOPT_PROXYPORT => $proxy['puerto'],
            // CURLOPT_PROXYUSERPWD => $proxy['login'],
            // CURLOPT_PROXYTYPE => 'HTTP',
            // CURLOPT_HTTPPROXYTUNNEL => 1,
            // CURLOPT_TIMEOUT => 60,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, $options);

        $responseJSON = curl_exec($curl);
        $curlError = curl_error($curl);

        if($curlError) {
            throw new CurlException;
        }

        $response = json_decode($responseJSON);

        if(isset($response->error) || isset($response->errors)) {
            throw new Response($response->message);
        }

        $responseData = $response[0];

        if(isset($responseData->errors)) {
            throw new Response;
        }

        try {
            $url = $responseData->data->clip->videoQualities[0]->sourceURL;
        } catch (\Exception $e) {
            throw new ParseResponse;
        }

        if(!isset($url) || $url == '') {
            throw new ParseResponse;
        }

        $this->setUrl($url);

        return $this;
    }

    public function save ($directory = '') {

        if($this->getUrl() == '') {
            throw new Clip('URL don\'t specified');
        }

        $filename = $this->getId().'.mp4';
        $finalDirectory = ($directory != '') ? realpath($directory).'/'.$filename : $filename;

        try {
            $filePutContents = file_put_contents($finalDirectory, file_get_contents($this->getUrl()));
        } catch(\Exception $e) {
            throw new Save;
        }

        if(!$filePutContents) {
            throw new Save;
        }
    }

    /**
     * @return string
     */
    public function getUrlEndpoint(): string
    {
        return $this->urlEndpoint;
    }

    /**
     * @param string $urlEndpoint
     */
    public function setUrlEndpoint(string $urlEndpoint): void
    {
        $this->urlEndpoint = $urlEndpoint;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     */
    public function setClientId(string $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string
     */
    public function getSha256Hash(): string
    {
        return $this->sha256Hash;
    }

    /**
     * @param string $sha256Hash
     */
    public function setSha256Hash(string $sha256Hash): void
    {
        $this->sha256Hash = $sha256Hash;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}