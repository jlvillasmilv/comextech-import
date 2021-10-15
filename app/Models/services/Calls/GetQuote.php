<?php
namespace App\Models\services\Calls;
use App\Models\services\Api\DHLAbstractAPI;

    class GetQuote extends DHLAbstractAPI
    {

        private $fromCountryCode;
        private $fromPostalCode;
        private $fromCity;

        private $toCountryCode;
        private $toPostalCode;
        private $toCity;

        private $shipDate;
        private $timeZone;
        private $dimensionUnit;
        private $weightUnit;
        
        private $declaredValue;
        private $euCountries = [
        "GB","DE","AT","BE","BG","CY","CZ","DK","DE","EE","ES","FI",
        "FR","HR","IE","LV","MT","NL","PO","PT","RO","SE","SL","SK"
        ];
        private $pieces;

        public function __construct()
        {
            parent::__construct();
            // $this->fromCountryCode = config('dhlapiconfig.from_country_code')?: getenv("DHL_FROM_COUNTRYCODE");
            // $this->fromPostalCode =  config('dhlapiconfig.from_post_code')?: getenv("DHL_FROM_POSTCODE");
            $this->timeZone = "+02:00";
            $this->dimensionUnit = 'CM';
            $this->weightUnit = 'KG';
        }

        /**
         * Called from DHLAbstractAPI
         *
         * @return [string] XML string; 
         */
        public function toXML():String
        {
            //dd($this->currency);
            $xml = new \XmlWriter();
            $xml->openMemory();
            $xml->setIndent(TRUE);
            $xml->setIndentString("  ");
            $xml->startDocument('1.0', 'UTF-8');
            $xml->startElement('p:DCTRequest');
            $xml->writeAttribute('xmlns:p', "http://www.dhl.com");
            $xml->writeAttribute('xmlns:p1', "http://www.dhl.com/datatypes");
            $xml->writeAttribute('xmlns:p2', "http://www.dhl.com/DCTRequestdatatypes");
            $xml->writeAttribute('xmlns:xsi', "http://www.w3.org/2001/XMLSchema-instance");
            $xml->writeAttribute('xsi:schemaLocation', "http://www.dhl.com DCT-req.xsd");
            $xml->startElement('GetQuote');
            $xml->startElement('Request');
            $xml->startElement('ServiceHeader');
            $xml->writeElement('MessageTime',  date('c'));
            $xml->writeElement('MessageReference', $this->reference); 
            $xml->writeElement('SiteID', $this->siteid);
            $xml->writeElement('Password', $this->password);
            $xml->endElement();
            $xml->endElement();
            $xml->startElement('From');
            $xml->writeElement('CountryCode', $this->fromCountryCode); 
            $xml->writeElement('Postalcode', $this->fromPostalCode);
            $xml->writeElement('City', $this->fromCity);  
            $xml->endElement();
            $xml->startElement('BkgDetails');
            $xml->writeElement('PaymentCountryCode', $this->fromCountryCode);
            $xml->writeElement('Date', $this->shipDate);
            $xml->writeElement('ReadyTime', 'PT10H21M');
            $xml->writeElement('ReadyTimeGMTOffset', '+01:00');
            $xml->writeElement('DimensionUnit', $this->dimensionUnit);
            $xml->writeElement('WeightUnit', $this->weightUnit);
            $xml->startElement('Pieces');

            foreach($this->pieces as $key => $piece){
                $piece = (object)$piece;
                $xml->startElement("Piece");
                $xml->writeElement('PieceID',$key); 
                $xml->writeElement('Height', $piece->height); 
                $xml->writeElement('Depth', $piece->depth); 
                $xml->writeElement('Width', $piece->width); 
                $xml->writeElement('Weight', $piece->weight); 
                $xml->endElement();
            }
            $xml->endElement();

            $xml->writeElement('PaymentAccountNumber',$this->accountNumber); 
            // if EU none duitable
            if(in_array($this->toCountryCode,$this->euCountries)){
                $xml->writeElement('IsDutiable', 'N');
                $xml->writeElement('NetworkTypeCode', 'AL');
                $xml->endElement();
            }else{
                $xml->writeElement('IsDutiable', 'Y');
                $xml->writeElement('NetworkTypeCode', 'AL');
                $xml->endElement();
            }
            $xml->startElement('To');
            $xml->writeElement('CountryCode',$this->toCountryCode); 
            $xml->writeElement('Postalcode', $this->toPostalCode); 
            $xml->writeElement('City', $this->toCity);
            $xml->endElement();
            $xml->startElement('Dutiable');
            $xml->writeElement('DeclaredCurrency', $this->currency); 
            $xml->writeElement('DeclaredValue', $this->declaredValue); 
            $xml->endElement();
            $xml->endElement();
            $xml->endElement();
            $xml->endDocument();
            return $this->xmlRequest = $xml->outputMemory();
        }

        public function toCountryCode($value = NULL):Self
        {
            if (empty($value)) {
                return $this->toCountryCode;
            }

            $this->toCountryCode = $value;

            return $this;
        }

        public function toPostalCode($value = NULL):Self
        {
            if (empty($value)) {
                return $this->toPostalCode;
            }

            $this->toPostalCode = $value;

            return $this;
        }

        public function toCity($value = NULL): self
        {
            if (empty($value)) {
                return $this->toCity;
            }

            $this->toCity = $value;

            return $this;
        }

        public function fromCountryCode($value = NULL):Self
        {
            if (empty($value)) {
                return $this->fromCountryCode;
            }

            $this->fromCountryCode = $value;

            return $this;
        }

        public function fromPostalCode($value = NULL):Self 
        {
            
            if (empty($value)) {
                return $this->fromPostalCode;
            }

            $this->fromPostalCode = $value;

            return $this;
        }

        public function fromCity($value = NULL): self
        {
            if (empty($value)) {
                return $this->fromCity;
            }

            $this->fromCity = $value;

            return $this;
        }


        public function declaredValue($value = NULL):Self
        {
            if (empty($value)) {
                return $this->declaredValue;
            }

            $this->declaredValue = $value;

            return $this;
        }

        public function shipDate($value = NULL):Self
        {
            if (empty($value)) {
                return $this->shipDate;
            }

            $this->shipDate = $value;

            return $this;
        }

        public function weightUnit($value = NULL):Self
        {
            if (empty($value)) {
                return $this->weightUnit;
            }

            $this->weightUnit = $value;

            return $this;
        }

        public function dimensionUnit($value = NULL):Self
        {
            if (empty($value)) {
                return $this->dimensionUnit;
            }

            $this->dimensionUnit = $value;

            return $this;
        }

        public function setPieces($pieces): void{
          $this->pieces = $pieces;
        }
    }