<?php

use function Scaleplan\Event\dispatch;

if (!empty($_REQUEST['event'])) {
    dispatch($_REQUEST['event'], $_REQUEST['data'] ?? []);
}