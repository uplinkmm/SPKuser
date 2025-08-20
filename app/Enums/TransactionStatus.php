<?php

namespace App\Enums;

enum TransactionStatus: int
{
    case Pending = 100;
    case Settle = 101;
    case Void = 102;
    case NotSet = 0;
    // case bet='bet';
    // case tip='tip';
    // case rollback='rollback';
    // case adjustment='adjustment';
    // case settled='settled';
    // case jack_pot='jack_pot';
    // case cancel='cancel';
    // case promo='promo'; 
    // case leader_board='leader_board'; 
}
