<?php

namespace Blacktrue\Reader;

use Blacktrue\Exceptions\CfdiReaderException;
use DOMDocument;
use DOMXpath;

/**
 * Class Cfdi
 * @package Blacktrue\Reader\Xml
 */
class Cfdi{

	const NAMESPACE_CFDI = 'http://www.sat.gob.mx/cfd/3';
	const NAMESPACE_IMPLOCAL = 'http://www.sat.gob.mx/implocal';
	const TAG_EMISOR = 'Emisor';
	const TAG_DOMICILIO_EMISOR = 'DomicilioFiscal';
	const TAG_RECEPTOR = 'Receptor';
	const TAG_DOMICILIO_RECEPTOR = 'Domicilio';
	const TAG_TRASLADO = 'Traslado';
	const TAG_RETENCION = 'Retencion';
	const TAG_CONCEPTO = 'Concepto';
	const TAG_RETENCION_LOCAL = 'RetencionesLocales';
	const TAG_TRASLADO_LOCAL = 'TrasladosLocales';

    /**
     * @var $xml
     */
	protected $xml;

    /**
     * @var
     */
	protected $dom;

    /**
     * @var
     */
	protected $xmlString;

    /**
     * @var string
     */
	protected static $prefix = '//@';

    /**
     * @param string $xml
     * @return $this
     */
	public function setXml(string $xml)
	{
		$this->xmlString = $xml;
		$this->dom = new DOMDocument;
		$this->dom->loadXML($xml); 
		$this->xml = new DOMXpath($this->dom);
        return $this;
	}

	/**
	 * @param null $key
	 * @return array|mixed
	 */
	public function getEmisor($key=null)
	{
		$emisor = [];
		$dataEmisor = $this->dom->getElementsByTagNameNS(self::NAMESPACE_CFDI,self::TAG_EMISOR)->item(0);
		if (!is_null($dataEmisor) && $dataEmisor->hasAttributes()) {
		  foreach ($dataEmisor->attributes as $attr) {
		   $emisor[(string)$attr->nodeName] = (string)$attr->nodeValue;
		  }
		}
		$dataDomicilioEmisor = $this->dom->getElementsByTagNameNS(self::NAMESPACE_CFDI,self::TAG_DOMICILIO_EMISOR)->item(0);
		if (!is_null($dataDomicilioEmisor) && $dataDomicilioEmisor->hasAttributes()) {
		  foreach ($dataDomicilioEmisor->attributes as $attr) {
		   $emisor[(string)$attr->nodeName] = (string)$attr->nodeValue;
		  }
		}

		if(!is_null($key) && isset($emisor[$key])){
			return $emisor[$key];
		}

		return $emisor;
	}

	/**
	 * @param null $key
	 * @return array|mixed
	 */
	public function getReceptor($key=null)
	{
		$receptor = [];
		$dataReceptor = $this->dom->getElementsByTagNameNS(self::NAMESPACE_CFDI,self::TAG_RECEPTOR)->item(0);
		if (!is_null($dataReceptor) && $dataReceptor->hasAttributes()) {
		  foreach ($dataReceptor->attributes as $attr) {
		   $receptor[(string)$attr->nodeName] = (string)$attr->nodeValue;
		  }
		}
		$dataDomiciliorReceptor = $this->dom->getElementsByTagNameNS(self::NAMESPACE_CFDI,self::TAG_DOMICILIO_RECEPTOR)->item(0);
		if (!is_null($dataDomiciliorReceptor) && $dataDomiciliorReceptor->hasAttributes()) {
		  foreach ($dataDomiciliorReceptor->attributes as $attr) {
		   $receptor[(string)$attr->nodeName] = (string)$attr->nodeValue;
		  }
		}

		if(!is_null($key) && isset($receptor[$key])){
			return $receptor[$key];
		}

		return $receptor;
	}

	/**
	 * @return array
	 */
	public function getConceptos() : array
	{
		$conceptos = [];
		$dataConceptos = $this->dom->getElementsByTagNameNS(self::NAMESPACE_CFDI,self::TAG_CONCEPTO);
		foreach($dataConceptos as $data){
			if (!is_null($data) && $data->hasAttributes()) {
			  foreach ($data->attributes as $attr) {
			   	$temp[(string)$attr->nodeName] = (string)$attr->nodeValue;
			  }
			  $conceptos[] = $temp;
			}
		}

		return $conceptos;
	}

	/**
	 * @return array
	 */
	public function getTraslados() : array
	{
		$traslados = [];
		$dataTraslados = $this->dom->getElementsByTagNameNS(self::NAMESPACE_CFDI,self::TAG_TRASLADO);
		foreach($dataTraslados as $data){
			if (!is_null($data) && $data->hasAttributes()) {
			  foreach ($data->attributes as $attr) {
			   	$temp[(string)$attr->nodeName] = (string)$attr->nodeValue;
			  }
			  $traslados[] = $temp;
			}
		}

		return $traslados;
	}

	/**
	 * @return array
	 */
	public function getRetenciones() : array
	{
		$retenciones = [];
		$dataRetenciones = $this->dom->getElementsByTagNameNS(self::NAMESPACE_CFDI,self::TAG_RETENCION);
		foreach($dataRetenciones as $data){
			if (!is_null($data) && $data->hasAttributes()) {
			  foreach ($data->attributes as $attr) {
			   	$temp[(string)$attr->nodeName] = (string)$attr->nodeValue;
			  }
			  $retenciones[] = $temp;
			}
		}

		return $retenciones;
	}

	/**
	 * @return array
	 */
	public function getTrasladosLocal() : array
	{
		$trasladoslocal = [];
		$dataTrasladosLocal = $this->dom->getElementsByTagNameNS(self::NAMESPACE_IMPLOCAL,self::TAG_TRASLADO_LOCAL);
		foreach($dataTrasladosLocal as $data){
			if (!is_null($data) && $data->hasAttributes()) {
			  foreach ($data->attributes as $attr) {
			   	$temp[(string)$attr->nodeName] = (string)$attr->nodeValue;
			  }
			  $trasladoslocal[] = $temp;
			}
		}

		return $trasladoslocal;
	}

	/**
	 * @return array
	 */
	public function getRetencionesLocal() : array
	{
		$retencionesLocal = [];
		$dataRetencionesLocal = $this->dom->getElementsByTagNameNS(self::NAMESPACE_IMPLOCAL,self::TAG_RETENCION_LOCAL);
		foreach($dataRetencionesLocal as $data){
			if (!is_null($data) && $data->hasAttributes()) {
			  foreach ($data->attributes as $attr) {
			   	$temp[(string)$attr->nodeName] = (string)$attr->nodeValue;
			  }
			  $retencionesLocal[] = $temp;
			}
		}

		return $retencionesLocal;
	}

    /**
     * @param $key
     * @return array
     * @throws CfdiReaderException
     */
	public function __get($key)
	{
		$nodelist = $this->xml->query(self::$prefix.$key);
		$tmpnode = $nodelist->item(0);

		if(is_null($tmpnode)){
			throw new CfdiReaderException("El nodo {$key} no fue encontrado en el XML");
		}

		$param = trim($tmpnode->nodeValue);

		return $param;
	}

    /**
     * @param $method
     * @param $params
     * @throws CfdiReaderException
     */
	public function __call($method,$params)
	{
		if(!method_exists($this,$method)){
			throw new CfdiReaderException("El metodo {$method} no esta disponible");
		}
	}

	/**
	 * @return mixed
	 */
	public function __toString()
	{
		return $this->xmlString;
	}
}