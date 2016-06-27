<?php

namespace alamid\interfaces;

interface INotificationReader {

	public function pull($param = array());
}