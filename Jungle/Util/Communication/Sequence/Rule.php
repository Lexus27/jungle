<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 02.10.2016
 * Time: 19:26
 */
namespace Jungle\Util\Communication\Sequence {

	use Jungle\Util\Communication\Sequence\Exception\RuleMessage;

	/**
	 * Class Rule
	 * @package Jungle\Util\Communication\Sequence
	 */
	class Rule implements RuleInterface{

		/** @var   */
		protected $config = [];

		/**
		 * Rule constructor.
		 * @param array $config
		 */
		public function __construct(array $config){
			$this->config = array_replace([
				'check'     => [],
				'negate'   => false,
				'message'   => null,
			],$config);
		}

		/**
		 * @param ProcessInterface $process
		 * @param ProcessSequenceInterface $processSequence
		 * @return RuleMessage|null
		 */
		public function check(ProcessInterface $process, ProcessSequenceInterface $processSequence){

			/**
			 * @var array $check
			 * @var bool $negate
			 * @var string $message
			 */
			extract($this->config);

			$code = $process->getCode();
			if(!is_array($check))$check = [$check];
			if($negate){
				if(!in_array($code,$check, true)){
					return new RuleMessage($message);
				}
			}else{

				if(in_array($code,$check, true)){
					return new RuleMessage($message);
				}
			}
			return null;
		}

		/**
		 * @param ProcessInterface $process
		 * @param ProcessSequenceInterface $processSequence
		 * @return void
		 */
		public function onNotMessages(ProcessInterface $process, ProcessSequenceInterface $processSequence){
			// TODO: Implement onNotMessages() method.
		}
	}
}
