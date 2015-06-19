<?php
	
class FoxyStripeIntegrationsExtension extends Extension {
	
	public function addIntegrations($FoxyData) {

		$config = SiteConfig::current_site_config();

		if(!$config->Integrations()->exists()) { SS_Log::log("No integrations at this time.", SS_Log::WARN); }
		
		foreach ($config->Integrations() as $integration) {
			
			// relay Datafeed to each Integration via curl
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $integration->URL); 
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array("FoxyData" => $FoxyData)); 
			//if($ignore_ssl === TRUE) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // sometimes there are problem with SSL
			$result = curl_exec($ch);
			curl_close($ch);
						
			if($result != "foxy") {
				echo '<p>' . $integration->Name . ' failed</p>';
			}


			SS_Log::log($integration->Name . " responded " . $result, SS_Log::WARN);
			$result = "";
			
		}
			
	}
	
}