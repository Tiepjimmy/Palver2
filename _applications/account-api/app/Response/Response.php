<?php

namespace App\Response;

use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Str;

use App\Response\Json\Error;
use App\Response\Json\Message;

/**
 * Class Response
 * @package App\Response
 * @author HuyDien <huydien.it@gmail.com>
 */
class Response
{
    /**
     *
     */
    const TYPE_JSON = 'json';
    /**
     *
     */
    const TYPE_HTML = 'html';

    /**
     * Response constructor.
     * @param ResponseFactory $factory
     */
    public function __construct(ResponseFactory $factory)
    {
        $responseType = $this->_getResponseType();
        $responseInstanceForResponseType = $this->_getInstanceForResponseType($responseType);
        $this->_bindMacros($responseInstanceForResponseType, $factory);
    }

    /**
     * @param $responseType
     * @return array
     * @author HuyDien <huydien.it@gmail.com>
     */
    protected function _getInstanceForResponseType($responseType)
    {
        switch ($responseType) {
            case self::TYPE_JSON:
                return array(Error::class, Message::class);
            case self::TYPE_HTML:
                return array(Error::class, Message::class);
        }
    }

    /**
     * @return string
     * @author HuyDien <huydien.it@gmail.com>
     */
    protected function _getResponseType()
    {
        if (request()->isJson() || request()->wantsJson() || Str::contains(request()->getRequestUri(), '/api')) {
            return self::TYPE_JSON;
        }
        if (request()->has('__responseType') && is_string(request()->get('__responseType'))) {
            return self::TYPE_HTML;
        }
        return self::TYPE_HTML;
    }

    /**
     * @param $responseInstances
     * @param $factory
     * @author HuyDien <huydien.it@gmail.com>
     */
    protected function _bindMacros($responseInstances, $factory)
    {
        foreach ($responseInstances as $responseInstance) {
            (new $responseInstance)->run($factory);
        }
    }
}
