<?php

interface IPermission {

	public function validate($params = array());
	public function nextChain(IPermission $newChain);
}
