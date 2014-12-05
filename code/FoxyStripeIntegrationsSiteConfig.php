<?php
	
class FoxyStripeIntegrationsSiteConfig extends DataExtension {
	
	private static $has_many = array(
		'Integrations' => 'FoxyStripeIntegrationsObject'
	);
	
	public function updateCMSFields(FieldList $fields) {
		
		$fields->addFieldsToTab('Root.Integrations', array(
			HeaderField::create('IntegrationsHeader', 'FoxyStripe Integrations', 3),
			LiteralField::create('IntegrationsDescip', '<p>Relay your FoxyCart Datafeed to additional URLs for processing. This allows your Datafeed to be used by additional applications, such as <a href="http://foxytools.com/orderdesk/" target="_blank">OrderDesk</a></p>'),
			GridField::create('Integrations', 'Integrations', $this->owner->Integrations(), GridFieldConfig_RelationEditor::create()
				->removeComponentsByType('GridFieldAddExistingAutocompleter'))
		));
		
	}
	
}