<?php
/**
 * @package yandex-php-library.
 * @author Supme
 * @copyright Supme 2014
 * @license http://opensource.org/licenses/MIT MIT License	
 *
 *  THE SOFTWARE AND DOCUMENTATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF
 *	ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 *	IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR
 *	PURPOSE.
 *
 *	Please see the license.txt file for more information.
 *
 */

/**
 * @namespace
 */
namespace Yandex\Pdd;

use Guzzle\Service\Client;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Yandex\Common\AbstractServiceClient;
use Yandex\Pdd\Exception\PddRequestException;

/**
 * Class Email
 *
 * @category Yandex
 * @package Pdd
 *
 * @author   Agafonov Alexey <supmea@gmail.com>
 */

class EmailMl extends PddClient
{
    /**
     * @var string
     */
    protected $serviceDomain = 'pddimp.yandex.ru';

    /**
     * Requested version of API
     * @var string
     */
    private $version = 'api2';

    private $domain;

    public function get()
    {
        return parent::sendGet('admin/email/ml/list');
    }

    public function add($maillist)
    {
        return parent::sendPost('admin/email/ml/add', ['maillist'     =>  $maillist]);
    }

    public function del($maillist)
    {
        return parent::sendPost('admin/email/ml/del', ['maillist'     =>  $maillist]);
    }

    public function subscribers($maillist)
    {
        return parent::sendGet('admin/email/ml/subscribers', ['maillist'     =>  $maillist]);
    }

    public function subscribe($maillist, $subscriber, $cansend= 'no')
    {
        return parent::sendPost('admin/email/ml/subscribe', [
            'maillist'          =>  $maillist,
            'subscriber'        =>  $subscriber,
            'can_send_on_behalf'=>  $cansend
        ]);
    }

    public function unsubscribe($maillist, $subscriber)
    {
        return parent::sendPost('admin/email/ml/unsubscribe', [
            'maillist'          =>  $maillist,
            'subscriber'        =>  $subscriber
        ]);
    }

    public function getCanSend($maillist, $subscriber)
    {
        return parent::sendPost('admin/email/ml/get_can_send_on_behalf', [
            'maillist'          =>  $maillist,
            'subscriber'        =>  $subscriber
        ]);
    }

    public function setCanSend($maillist, $subscriber, $cansend= 'no')
    {
        return parent::sendPost('admin/email/ml/set_can_send_on_behalf', [
            'maillist'          =>  $maillist,
            'subscriber'        =>  $subscriber,
            'can_send_on_behalf'=>  $cansend
        ]);
    }

}