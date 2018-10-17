<?php

namespace Dynamic\FoxyStripe\Model;

use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\ORM\DataObject;

class FoxyStripeIntegrationsObject extends DataObject
{
    /**
     * @var array
     */
    private static $db = array(
        'Name' => 'Varchar(150)',
        'URL' => 'Varchar(255)'
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'FoxyStripeSetting' => FoxyStripeSetting::class,
        'SiteConfig' => SiteConfig::class,
    );

    /**
     * @var string
     */
    private static $singular_name = 'Integration';

    /**
     * @var string
     */
    private static $plural_name = 'Integrations';

    /**
     * @var string
     */
    private static $table_name = 'FoxyStripeIntegrationsObject';

    /**
     * @var array
     */
    private static $summary_fields = array(
        'Name',
        'URL'
    );

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'SiteConfigID',
            'FoxyStripeSettingID',
        ]);

        $this->extend('updateCMSFields', $fields);
        return $fields;
    }
}
