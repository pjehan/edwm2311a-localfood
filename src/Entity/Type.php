<?php

namespace App\Entity;

enum Type: string
{
    case PointOfSale = 'POS';
    case Producer = 'PROD';
}
