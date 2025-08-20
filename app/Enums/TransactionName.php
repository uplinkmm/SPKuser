<?php

namespace App\Enums;

enum TransactionName: string
{
    // use HasLabelTrait;

    case CapitalDeposit = 'capital_deposit';

    // case Bet = 'bet';

    // case Stake = 'stake';
    // case Payout = 'payout';
    // case Bonus = 'bonus';
    // case JackPot = 'jack_pot';
    // case Cancel = 'cancel';
    // case Rollback = 'rollback';
    // case BuyIn = 'buy_in';
    // case BuyOut = 'buy_out';

    case bet='bet';
    case tip='tip';
    case rollback='rollback';
    case adjustment='adjustment';
    case settled='settled';
    case jack_pot='jack_pot';
    case cancel='cancel';
    case promo='promo'; 
    case leader_board='leader_board'; 



    case Commission = 'commission';
    case Refund = 'refund';

    case CreditTransfer = 'credit_transfer';
    case DebitTransfer = 'debit_transfer';

    case CreditAdjustment = 'credit_adjustment';
    case DebitAdjustment = 'debit_adjustment';

    case GameMoneyTransfer = 'game_money_transfer';

    case MainMoneyTransfer = 'main_money_transfer';

}
