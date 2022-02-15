<?php
namespace App\Models\services\Calls;
use App\Models\services\Api\DHLAbstractAPI;

    class GetTracking extends DHLAbstractAPI
    {
        private $declaredValue;
      
        private $lang_code;

        private $tracking_number;
    
        /**
         * Called from DHLAbstractAPI
         *
         * @return [string] XML string; 
         */
        public function toXML():String
        {
            $xml = new \XmlWriter();
            $xml->openMemory();
            $xml->setIndent(TRUE);
            $xml->setIndentString("  ");
            $xml->startDocument('1.0', 'UTF-8');
            $xml->startElement('req:KnownTrackingRequest');
            $xml->writeAttribute('xmlns:req', "http://www.dhl.com");
            $xml->writeAttribute('xmlns:xsi', "http://www.w3.org/2001/XMLSchema-instance");
            $xml->writeAttribute('xsi:schemaLocation', "http://www.dhl.com TrackingRequestKnown.xsd");
            $xml->writeAttribute('schemaVersion', "1.0");
            $xml->startElement('Request');
            $xml->startElement('ServiceHeader');
            $xml->writeElement('MessageTime',  date('c'));
            $xml->writeElement('MessageReference', $this->reference); 
            $xml->writeElement('SiteID', $this->siteid);
            $xml->writeElement('Password', $this->password);
            $xml->endElement();
            $xml->endElement();

            $xml->writeElement('LanguageCode',  "es");
            $xml->writeElement('AWBNumber',  $this->tracking_number);
            $xml->writeElement('LevelOfDetails', 'ALL_CHECK_POINTS');

            $xml->endElement();

            return $this->xmlRequest = $xml->outputMemory();
        }

        public function setTrackingNumber($tracking_number): void
        {
            $this->tracking_number = $tracking_number;
        }

        public function setLanguageCode($lang_code): void{
          $this->lang_code = $lang_code;
        }
    }

