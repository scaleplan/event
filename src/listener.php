<?php

if (!empty($_REQUEST['event'])) {
    \Scaleplan\Event\dispatch($_REQUEST['event']);
}
