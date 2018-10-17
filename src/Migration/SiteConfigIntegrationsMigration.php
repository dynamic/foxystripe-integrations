<?php

namespace Dynamic\FoxyStripe\ORM;

use Dynamic\FoxyStripe\Model\FoxyStripeIntegrationsObject;
use Dynamic\FoxyStripe\Model\FoxyStripeSetting;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

/**
 * Class SiteConfigMigration
 *
 * Apply this DataExtension to SiteConfig and hit Save. Data will be migrated to FoxyStripeSetting
 * via the onAfterWrite() function.
 *
 * @package Dynamic\FoxyStripe\ORM
 */
class SiteConfigIntegrationsMigration extends DataExtension
{
    /**
     * @var array
     */
    private static $has_many = array(
        'Integrations' => FoxyStripeIntegrationsObject::class
    );

    /**
     *
     */
    public function onAfterWrite()
    {
        parent::onAfterWrite();

        $config = FoxyStripeSetting::current_foxystripe_setting();

        foreach ($this->owner->Integrations() as $integration) {
            $integration->FoxyStripeSettingID = $config->ID;
            $integration->write();
        }
    }
}
