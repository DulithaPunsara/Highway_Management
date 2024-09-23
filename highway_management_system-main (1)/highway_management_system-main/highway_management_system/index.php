<?php

require 'theam/head.php';

require 'exit/link_list.php';
session_write_close();
require 'entrance/link_list.php';
session_write_close();
require_once 'Accident/accident.php';
session_write_close();
require 'service_area/vehicle_service.php';
session_write_close();
require_once 'age/age.php';
session_write_close();
require 'home/se1.php';






require 'theam/footer.php';