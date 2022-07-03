<?php
/**
 *
 * @About:
 * @File:        BaseController.php
 * @Date:        6/24/20
 * @Version:     1.0
 * @Developer:   José Daniel Quijano (jose.quijano55@gmail.com)
 *
 **/

	namespace App\Controllers;

	use Psr\Container\ContainerInterface;

	class BaseController
	{
		protected $container;

		/**
		 * BaseController constructor.
		 * @param ContainerInterface $c
		 */

		public function __construct(ContainerInterface $c)
		{
			$this->container = $c;
		}

	}