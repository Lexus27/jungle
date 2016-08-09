<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 14.06.2016
 * Time: 2:47
 */
namespace Jungle\Data\Record\ModelMetadata {

	use Jungle\Data\Record\Model;

	/**
	 * Class Strategy
	 * @package Jungle\Data\Record
	 *
	 * introspection
	 *
	 */
	abstract class Strategy{


		public function getColumnNames(Model $model){

		}

		public function getColumnDefaults(Model $model){

		}

		public function getNullableColumns(Model $model){

		}

	}
}
