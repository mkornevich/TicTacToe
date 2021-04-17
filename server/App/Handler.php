<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.04.2021
 * Time: 22:24
 */

namespace App;


use App\Entities\Client;

abstract class Handler
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string[]
     */
    protected $errors = [];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function execute($options)
    {
        $this->validate($options);
        if (count($this->errors) == 0) {
            $this->handle($options);
        } else {
            $this->showErrorMessage($options);
        }
    }

    protected abstract function handle($options);

    protected function validate($options)
    {
    }

    protected function ifError($cond, $message) {
        if ($cond) {
            $this->errors[] = $message;
        }
    }

    private function showErrorMessage($options)
    {
        $this->client->send('messageScreen.setMessage', [
            'message' => $this->buildErrorMessage(),
        ]);
        $this->client->send('screensController.showScreen', [
            'screenName' => 'messageScreen',
            'hidePrev' => false
        ]);
    }

    private function buildErrorMessage() {
        $html = '<ol>';
        foreach ($this->errors as $error) {
            $html .= '<li>' . $error . '</li>';
        }
        $html .= '</ol>';
        return $html;
    }
}