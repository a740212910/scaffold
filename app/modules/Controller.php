<?php
/**
 * 脚手架
 *
 * PHP version 7
 *
 * @category  PHP
 * @package   Yii2
 * @author    Hongbin Chen <hongbin.chen@aliyun.com>
 * @copyright 2006-2018 YiiPlus Ltd
 * @license   https://github.com/yiiplus/scaffold/licence.txt BSD Licence
 * @link      http://www.yiiplus.com
 */

namespace app\modules;

use Yii;
use yii\web\Response;

/**
 * BaseController
 *
 * @category  PHP
 * @package   Yii2
 * @author    Hongbin Chen <hongbin.chen@aliyun.com>
 * @copyright 2006-2018 YiiPlus Ltd
 * @license   https://github.com/yiiplus/scaffold/licence.txt BSD Licence
 * @link      http://www.yiiplus.com
 */
abstract class Controller extends \yii\rest\Controller
{
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'list',
    ];

    /**
     * 行为
     *
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator'], $behaviors['rateLimiter']);

        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json'       => Response::FORMAT_JSON,
                'application/javascript' => Response::FORMAT_JSONP,
            ]
        ];

        $behaviors['tokenValidate'] = [
            'class' => 'app\filters\auth\JwtAuth',
            'except' => $this->debug ? ['*'] : []
        ];

        $behaviors['timestampValidate'] = [
            'class' => 'app\filters\auth\TimestampAuth',
            'except' => $this->debug ? ['*'] : []
        ];

        $behaviors['authValidate'] = [
            'class' => 'app\filters\auth\AccessTokenAuth',
            'except'  => $this->debug ? ['*'] : []
        ];

        $behaviors['rateLimiter'] = [
            'class' => 'app\filters\auth\RateLimiterAuth',
            'enableRateLimitHeaders' => true,
            'except'  => $this->debug ? ['*'] : []
        ];

        return $behaviors;
    }

    /**
     * 当在开发环境下使用GET方式传入的`__debug__`参数为1时，debug属性为true
     * 此时大部分behaviors将不会执行 e.g:
     * ```php
     *  $behaviors['authValidate'] = [
     *      'class' => 'app\extensions\auth\AccessTokenAuth',
     *      'except'  => $this->debug ? ['*'] : [] //except属性对debug进行支持
     *  ];
     * ```
     *
     * @return bool
     */
    public function getDebug()
    {
        return YII_DEBUG && Yii::$app->request->get('__debug__') == 1;
    }

    /**
     * 动词定义
     *
     * @return array
     */
    protected function verbs()
    {
        return [
            'index'  => ['GET'],
            'view'   => ['GET'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }
}
