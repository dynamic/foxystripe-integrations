<?php

namespace Dynamic\FoxyStripe\ORM;

use Dynamic\FoxyStripe\Model\FoxyStripeSetting;
use Psr\Log\LoggerInterface;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Core\Extension;

class FoxyStripeIntegrationsExtension extends Extension
{
    /**
     * @param $FoxyData
     * @throws \SilverStripe\ORM\ValidationException
     */
    public function addIntegrations($FoxyData)
    {
        $config = FoxyStripeSetting::current_foxystripe_setting();

        if (!$config->Integrations()->exists()) {
            Injector::inst()->get(LoggerInterface::class)->debug("No integrations at this time.");
        }
        
        foreach ($config->Integrations() as $integration) {
            // relay Datafeed to each Integration via curl
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $integration->URL);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array("FoxyData" => $FoxyData));
            //if($ignore_ssl === TRUE) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            // // sometimes there are problem with SSL
            $result = curl_exec($ch);
            curl_close($ch);
                        
            if ($result != "foxy") {
                echo '<p>' . $integration->Name . ' failed</p>';
            }

            Injector::inst()->get(LoggerInterface::class)->debug($integration->Name . " responded " . $result);
            $result = "";
        }
    }
}
