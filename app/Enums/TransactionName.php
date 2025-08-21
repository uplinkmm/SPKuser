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

    case BET='BET';
    case TIP='TIP';
    case ROLLBACK='ROLLBACK';
    case ADJUSTMENT='ADJUSTMENT';
    case SETTLED='SETTLED';
    case JACKPOT='JACKPOT';
    case CANCEL='CANCEL';
    case PROMO='PROMO'; 
    case LEADERBOARD='LEADERBOARD'; 



    case Commission = 'commission';
    case Refund = 'refund';

    case CreditTransfer = 'credit_transfer';
    case DebitTransfer = 'debit_transfer';

    case CreditAdjustment = 'credit_adjustment';
    case DebitAdjustment = 'debit_adjustment';

    case GameMoneyTransfer = 'game_money_transfer';

    case MainMoneyTransfer = 'main_money_transfer';

}
