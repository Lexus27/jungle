<?php
/**
 * Created by PhpStorm.
 * Project: MobileCasino
 * Date: 12.03.2015
 * Time: 0:03
 */
namespace Jungle\Util\Smart\Keyword;

use Jungle\Util\TransientInterface;

/**
 * Class Keyword
 * @package Jungle\Util\Smart\Keyword
 *
 * Инстанциируется через метод instanceFromArray
 *
 */
abstract class Keyword implements TransientInterface , \Serializable{

	use \Jungle\Util\PropContainer\PropContainerOptionTrait{
		setOption as protected _setOption;
	}

	/**
	 * @var Pool
	 */
	protected $pool;

	/**
	 * @var string
	 */
	protected $identifier;

	/**
	 * @var bool
	 */
	protected $dirty;

	/**
	 * @var bool
	 *
	 */
	protected $dummy;

	/**
	 * Final for not extending
	 */
	final public function __construct(){
		$this->setDirty(false);
	}

	/**
	 * Constructor and Restorator
	 */
	protected function onConstruct(){
		$this->setDirty(false);
	}

	/**
	 * @return string
	 */
	public function getIdentifier(){
		return $this->identifier;
	}

	/**
	 * @param Keyword $with
	 * @return bool
	 */
	public function compareIdentifiersWith($with){
		return $this->getPool()->compareIdentifiers($this->getIdentifier(),$with instanceof Keyword?$with->getIdentifier() :$with);
	}

	/**
	 * @param string $identifier
	 */
	public function setIdentifier($identifier){
		if($identifier instanceof Keyword){
			$identifier = $identifier->getIdentifier();
		}
		if(!is_string($identifier) && !is_numeric($identifier)){
			throw new \InvalidArgumentException('Identifier must be string or numeric');
		}
		if($this->identifier!==$identifier){
			$this->setDirty(true);
			$this->identifier = $identifier;
		}
	}

	/**
	 * @param $mgrAlias
	 * @param $identifier
	 * @return Keyword
	 */
	public function getRelated($mgrAlias, $identifier){
		$manager = $this->getPool();
		if(!$manager){

		}
		$context = $manager->getManager();
		if(!$context){

		}
		$relatedManager = $context->getPool($mgrAlias);
		if(!$relatedManager){

		}
		return $relatedManager->get($identifier);

	}

	/**
	 * @param $mgrAlias
	 * @param $identifier
	 * @return bool
	 */
	public function hasRelated($mgrAlias, $identifier){
		$manager = $this->getPool();
		if(!$manager){

		}
		$context = $manager->getManager();
		if(!$context){

		}
		$relatedManager = $context->getPool($mgrAlias);
		if(!$relatedManager){

		}
		return $relatedManager->has($identifier);
	}

	/**
	 * @param $mgrAlias
	 * @param $optionKey
	 * @param null $default
	 * @return Keyword|null
	 */
	public function getRelatedByOption($mgrAlias, $optionKey, $default = null){
		$option = $this->getOption($optionKey,false);
		if($option!==false){
			return $this->getRelated($mgrAlias,$option);
		}else{
			return $default;
		}
	}

	/**
	 * @return bool
	 */
	final public function isDirty(){
		return $this->dirty===true;
	}

	/**
	 * @param bool $state
	 * @return $this|void
	 */
	final public function setDirty($state = true){
		if($this->dirty!==$state){
			$this->dirty = $state===true;
			if(!$this->isDummy() && $this->dirty && ($manager = $this->getPool())){
				$manager->setDirty(true);
			}
		}
	}

	/**
	 * @return bool
	 */
	final public function isDummy(){
		return $this->dummy===true;
	}

	/**
	 * @param bool $dummy
	 */
	final public function setDummy($dummy = true){
		if($this->dummy!==$dummy){
			$oldDummy = $this->dummy;
			$this->dummy = $dummy===true;
			if($this->dummy===false && $oldDummy===true && $this->isDirty() && ($manager = $this->getPool())){
				$manager->setDirty(true);
			}
		}
	}

	/**
	 * @param Pool $pool
	 */
	final public function setPool(Pool $pool = null){
		$this->pool = $pool;
	}

	/**
	 * @return Pool
	 */
	public function getPool(){
		return $this->pool;
	}

	/**
	 * Clearing and saving
	 */
	public function __destruct(){
		if(!$this->isDummy() && $this->isDirty()){
			$manager = $this->getPool();
			if($manager){
				$store = $manager->getStorage();
				if($store){
					$store->save($this);
					$this->setDirty(false);
				}
			}
		}
	}

	/**
	 * @return string
	 */
	public function __toString(){
		return (string)$this->getIdentifier();
	}

	/**
	 * @param $key
	 * @param $value
	 */
	public function setOption($key,$value){
		if($this->getOption($key)!==$value){
			$this->_setOption($key,$value);
			$this->setDirty(true);
		}
	}



	/** transport representation this object properties to simple array
	 * @return array
	 */
	public function toArray(){
		return [
			'identifier' => $this->getIdentifier(),
			'options' => $this->_srv_options
		];
	}

	/** set object representation from array generated by method toArray()
	 * @param array $data
	 */
	public function fromArray(array $data){
		$this->setIdentifier($data['identifier']);
		if(is_array($data['options'])){
			foreach($data['options'] as $key => $opt){
				$this->setOption($key,$opt);
			}
		}
	}

	/** Pack this object to array data and class identifier this inheritor
	 * @param Keyword $instance
	 * @return array
	 */
	public static function instanceToData(Keyword $instance){
		return array_merge([
			'class' => get_class($instance)
		],$instance->toArray());
	}

	/** Restore packed state
	 * @param array $data
	 * @return Keyword
	 */
	public static function instanceFromData(array $data){
		if(isset($data['class'])){

			/** @var Keyword $class */
			/** @var Keyword $instance */
			$class = $data['class'];

			if(!is_a($class, __CLASS__, true)){
				throw new \LogicException(
					'Keyword::fromPacked Class "' . $class . '" must be instance of ' . __CLASS__ . ''
				);
			}

			if(!class_exists($class, true)){
				throw new \LogicException('Keyword::fromPacked Class "' . $class . '" not found');
			}
			$instance = new $class();
			$instance->fromArray($data);
			$instance->onConstruct();
			return $instance;

		}else{
			throw new \LogicException('fromPacked data not have class name representation');
		}
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * String representation of object
	 * @link http://php.net/manual/en/serializable.serialize.php
	 * @return string the string representation of the object or null
	 */
	public function serialize(){
		return serialize($this->toArray());
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Constructs the object
	 * @link http://php.net/manual/en/serializable.unserialize.php
	 * @param string $serialized <p>
	 * The string representation of the object.
	 * </p>
	 * @return void
	 */
	public function unserialize($serialized){
		$data = unserialize($serialized);
		$this->fromArray($data);
		$this->onConstruct();
	}

	/**
	 * @param array $state
	 * @return Keyword
	 */
	public static function __setState(array $state){
		return self::instanceFromData($state);
	}

}