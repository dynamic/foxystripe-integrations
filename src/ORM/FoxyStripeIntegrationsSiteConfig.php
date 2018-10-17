<?php

namespace Dynamic\FoxyStripe\ORM;

use Dynamic\FoxyStripe\Model\FoxyStripeIntegrationsObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\ORM\DataExtension;

class FoxyStripeIntegrationsSiteConfig extends DataExtension
{
    /**
     * @var array
     */
    private static $has_many = array(
        'Integrations' => FoxyStripeIntegrationsObject::class
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        
        $fields->addFieldsToTab('Root.Integrations', array(
            HeaderField::create('IntegrationsHeader', 'FoxyStripe Integrations', 3),
            LiteralField::create(
                'IntegrationsDescip',
                '<p>Relay your FoxyCart Datafeed to additional URLs for processing. This allows your Datafeed to be 
                    used by additional applications, such as 
                    <a href="http://foxytools.com/orderdesk/" target="_blank">OrderDesk</a></p>'
            ),
            GridField::create(
                'Integrations',
                'Integrations',
                $this->owner->Integrations(),
                GridFieldConfig_RelationEditor::create()
                    ->removeComponentsByType(GridFieldAddExistingAutocompleter::class)
            )
        ));
    }
}
