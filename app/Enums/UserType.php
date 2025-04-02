<?php
 namespace App\Enums;

 enum UserType: string
 {
     case Common = 'comum';
     case Merchant = 'lojista';

     public static function values(): array
     {
         return array_column(self::cases(), 'value');
     }
 }
