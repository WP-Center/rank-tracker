<?php

namespace WPRankTracker;

use DI\Container;
use DI\ContainerBuilder;
use WPRankTracker\Helpers\DatabaseHelper;
use WPRankTracker\Helpers\IconHelper;
use WPRankTracker\Helpers\LicenseHelper;
use WPRankTracker\Helpers\OptionsHelper as OptionsHelper;
use WPRankTracker\Helpers\PageHelper;
use WPRankTracker\Helpers\ResponseHelper;
use WPRankTracker\Helpers\UserTimeZoneHelper;
use WPRankTracker\Helpers\UserTypeHelper;
use WPRankTracker\Helpers\KeywordHelper;
use WPRankTracker\Modules\Admin\AssetsController;
use WPRankTracker\Modules\Admin\LicenseActivationController;
use WPRankTracker\Modules\Admin\LicenseRemoveController;
use WPRankTracker\Modules\Admin\MenuController;
use WPRankTracker\Modules\Admin\NotificationController;
use WPRankTracker\Modules\Admin\UserTimeZoneController;
use WPRankTracker\Modules\Admin\UserTypeController;
use WPRankTracker\Modules\Api\ApiController;
use WPRankTracker\Modules\Cron\DailyRequestCronController;
use WPRankTracker\Modules\Keywords\AddKeywordsController;
use WPRankTracker\Modules\Keywords\KeywordDatabaseController;
use WPRankTracker\Modules\Keywords\DeleteKeywordsController;
use WPRankTracker\Modules\Keywords\GetKeywordsController;
use WPRankTracker\Modules\License\LicenseExpiredController;
use WPRankTracker\Modules\Ranks\RankController;
use WPRankTracker\Modules\Ranks\RankDatabaseController;
use WPRankTracker\Modules\System\Activation;
use WPRankTracker\Modules\System\Deactivation;
use WPRankTracker\Modules\Transient\ApiLimitTransient;
use WPRankTracker\Modules\Transient\LicenseTransient;
use WPRankTracker\Modules\Transient\TransientCheckController;

class Plugin
{
    /**
     * @var Container
     */
    protected Container $container;

    /**
     * @var Plugin
     */
    protected static $instance;

    /**
     * This method allows us to call classes.
     */
    public function __construct()
    {
        $builder = new ContainerBuilder();
        $container = $builder->build();

        $classes = [
            'Activation' => Activation::class,
            'Deactivation' => Deactivation::class,
            'UserTypeController' => UserTypeController::class,
            'MenuController' => MenuController::class,
            'LicenseHelper' => LicenseHelper::class,
            'UserTypeHelper' => UserTypeHelper::class,
            'OptionsHelper' => OptionsHelper::class,
            'KeywordHelper' => KeywordHelper::class,
            'PageHelper' => PageHelper::class,
            'AssetsController' => AssetsController::class,
            'AddKeywordsController' => AddKeywordsController::class,
            'DatabaseHelper' => DatabaseHelper::class,
            'KeywordDatabaseController' => KeywordDatabaseController::class,
            'RankDatabaseController' => RankDatabaseController::class,
            'IconHelper' => IconHelper::class,
            'GetKeywordsController' => GetKeywordsController::class,
            'DeleteKeywordsController' => DeleteKeywordsController::class,
            'ResponseHelper' => ResponseHelper::class,
            'LicenseActivation' => LicenseActivationController::class,
            'RankController' => RankController::class,
            'ApiController' => ApiController::class,
            'LicenseExpiredController' => LicenseExpiredController::class,
            'LicenseTransient' => LicenseTransient::class,
            'ApiLimitTransient' => ApiLimitTransient::class,
            'TransientCheckController' => TransientCheckController::class,
            'DailyRequestCronController' => DailyRequestCronController::class,
            'LicenseRemoveController' => LicenseRemoveController::class,
            'UserTimeZoneController' => UserTimeZoneController::class,
            'UserTimeZoneHelper' => UserTimeZoneHelper::class,
            'NotificationController' => NotificationController::class,
        ];

        foreach ($classes as $alias => $abstract) {
            $container->set($alias, new $abstract());
        }

        $this->container = $container;
    }

    public static function getInstance(): Plugin
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function getContainer(): Container
    {
        return $this->container;
    }
}
