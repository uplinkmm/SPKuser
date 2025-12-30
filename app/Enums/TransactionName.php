<?php

namespace App\Enums;

enum TransactionName: string
{
    use HasLabelTrait;

    case CapitalDeposit = 'capital_deposit';

    case Stake = 'stake';
    case Payout = 'payout';
    case Bonus = 'bonus';
    case JackPot = 'jack_pot';
    case Cancel = 'cancel';
    case Rollback = 'rollback';
    case BuyIn = 'buy_in';
    case BuyOut = 'buy_out';

    case Commission = 'commission';
    case Refund = 'refund';

    case CreditTransfer = 'credit_transfer';
    case DebitTransfer = 'debit_transfer';

    case CreditAdjustment = 'credit_adjustment';
    case DebitAdjustment = 'debit_adjustment';

    case GameMoneyTransfer = 'game_money_transfer';

    case MainMoneyTransfer = 'main_money_transfer';

    public static function isValid(string $action): bool
    {
        return in_array($action, array_column(self::cases(), 'value'), true);
    }

    case Promotion = 'promotion';
    case ReferralPromotion = 'referral_promotion';
    
    case GameLoss = 'game_loss';
    case GAME_BET = 'game_bet';
    case GameWin = 'game_win';
}
