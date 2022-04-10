<?php

declare(strict_types=1);

namespace App\Utils;

class Message
{
    public static function color(string $type, string $message): void
    {
        switch ($type) {
            default:
            case 'info':
                echo "\033[36m$message \033[0m\n";
                
                break;

            case 'error':
                echo "\033[31m$message \033[0m\n";
            
                break;
            
            case 'success':
                echo "\033[32m$message \033[0m\n";
                
                break;
            
            case 'warning':
                echo "\033[33m$message \033[0m\n";
                
                break;     
        }
    }
}
