<?php

namespace JobMetric\Sms;

use JobMetric\PackageCore\Exceptions\AssetFolderNotFoundException;
use JobMetric\PackageCore\Exceptions\MigrationFolderNotFoundException;
use JobMetric\PackageCore\Exceptions\RegisterClassTypeNotFoundException;
use JobMetric\PackageCore\Exceptions\ViewFolderNotFoundException;
use JobMetric\PackageCore\PackageCore;
use JobMetric\PackageCore\PackageCoreServiceProvider;

class SmsServiceProvider extends PackageCoreServiceProvider
{
    /**
     * @param PackageCore $package
     *
     * @return void
     * @throws MigrationFolderNotFoundException
     * @throws RegisterClassTypeNotFoundException
     * @throws AssetFolderNotFoundException
     * @throws ViewFolderNotFoundException
     */
    public function configuration(PackageCore $package): void
    {
        $package->name('laravel-sms')
            ->hasConfig()
            ->hasAsset()
            ->hasMigration()
            ->hasTranslation()
            ->hasRoute()
            ->hasView()
            ->registerClass('Sms', Sms::class);
    }
}
