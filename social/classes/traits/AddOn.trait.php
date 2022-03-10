<?php

namespace SocialTrait;

trait AddOn {
	private $additional_data;

	protected function invoke() {
		$args = func_get_args();
		$args_num = func_num_args();
		$endarg_num = $args_num - 1;
		$endarg = $args[$endarg_num];

		unset($args[$endarg_num]);

		$args = implode(', ', $args);

		$this->additional_data = \miuan\Plugins::invoke($args, $endarg);
		return $this->additional_data;
	}
}