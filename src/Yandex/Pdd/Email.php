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
class Email extends PddClient
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

    //ToDo pages list
    public function getList()
    {
        return parent::sendGet('admin/email/list');

    }

    public function add($login, $password)
    {
        return parent::sendPost('admin/email/add', ['login'     =>  $login, 'password'  =>  $password]);
    }

    public function details($login)
    {
        return parent::sendGet('admin/email/details', ['login' => $login]);

    }

    /**
     * @param $params | array
     * [
     *  'login'     =>  $people['login'],
     *  'password' => $people['password'],
     *  'iname' => $people['iname'],
     *  'fname' => $people['fname'],
     *  'enabled' => 'yes',
     *  'sex' => $people['sex']
     * ]
     * @return array|bool|float|int|string
     * @throws PddRequestException
     */
    public function edit($params)
    {
        return parent::sendPost('admin/email/edit', $params);
    }

    public function delete($login)
    {
        return parent::sendPost('admin/email/del', ['login' => $login]);
    }

    public function counters($login)
    {
        return parent::sendGet('admin/email/counters', ['login' => $login]);

    }
} 