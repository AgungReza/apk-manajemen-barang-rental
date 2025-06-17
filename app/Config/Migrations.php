<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Migrations extends BaseConfig
{
    public bool $enabled = true;

    public string $table = 'migrations';

    public string $type = 'timestamp'; 

    public string $timestampFormat = 'Y-m-d-His_';
}
