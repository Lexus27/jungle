<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 07.05.2016
 * Time: 15:59
 */
namespace Jungle\Application\Dispatcher\Router {

	use Jungle\Application\Dispatcher\Controller\ProcessInitiatorInterface;
	use Jungle\Application\Dispatcher\RouteInterface;
	use Jungle\Application\Dispatcher\Router\Exception\MatchedException;
	use Jungle\Application\RequestInterface;

	/**
	 * Class Routing
	 * @package Jungle\Application\Dispatcher\Router
	 */
	class Routing implements RoutingInterface , ProcessInitiatorInterface{

		/** @var  RequestInterface */
		protected $request;

		/** @var  RouteInterface */
		protected $route;

		/** @var  array|null */
		protected $params;

		/** @var  array|null|mixed */
		protected $reference;

		/** @var  bool  */
		protected $matching = true;

		/** @var  bool  */
		protected $notFound = false;

		/**
		 * Routing constructor.
		 * @param RequestInterface $request
		 */
		public function __construct(RequestInterface $request){
			$this->request = $request;
		}

		/**
		 * @param RouteInterface $route
		 * @param array|null $params
		 * @param mixed $reference
		 * @param bool $throwException
		 * @return $this
		 * @throws MatchedException
		 */
		public function matched(RouteInterface $route,array $params = null, $reference = null, $throwException = true){
			if($this->matching){
				$this->matching		= false;
				$this->route		= $route;
				$this->params		= $params;
				$this->reference	= $reference;
				if($throwException){
					throw new MatchedException($this);
				}
			}else{
				throw new \LogicException('Routing already matched!');
			}
			return $this;
		}

		/**
		 * @param array|null $params
		 * @param mixed $reference
		 * @param bool $throwException
		 * @return $this
		 * @throws MatchedException
		 */
		public function notFound(array $params = null, $reference = null, $throwException = true){
			if($this->matching){
				$this->matching		= false;
				$this->notFound		= true;
				$this->params		= $params;
				$this->reference	= $reference;
				if($throwException){
					throw new MatchedException($this);
				}
			}else{
				throw new \LogicException('Routing already matched!');
			}
			return $this;
		}

		/**
		 * @return bool
		 */
		public function isNotFound(){
			return $this->notFound;
		}

		/**
		 * @return bool
		 */
		public function isUnknown(){
			return !$this->reference;
		}

		/**
		 * @return RequestInterface
		 */
		public function getRequest(){
			return $this->request;
		}

		/**
		 * @return RouteInterface
		 */
		public function getRoute(){
			return $this->route;
		}

		/**
		 * @return array
		 */
		public function getParams(){
			if(is_array($this->params)){
				return $this->params;
			}else{
				return [];
			}
		}

		/**
		 * @return array|mixed|null
		 */
		public function getReference(){
			return $this->reference;
		}


	}
}

