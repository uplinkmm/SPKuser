<?php

namespace App\Observers;

use App\Models\AgentWallet;
use App\Models\Betting;

class BettingObserver
{
    /**
     * Handle the Betting "created" event.
     */
    public function created(Betting $betting): void
    {
        //
        $betting->load(['customer.agent.agent_commissions' => function ($query) use ($betting) {
            $query->where('game_id', $betting->game_id);
        }]);
        $agent = $betting->customer->agent?? null;
        if ($agent && $agent->agent_commissions->isNotEmpty()) {
            $agentCommission = $agent->agent_commissions->first();
            if ($agentCommission) {
                $amount = ($agentCommission->commission_amount / 100) * $betting->total_amount;
                AgentWallet::create([
                    'date_time' => now(),
                    'amount' => $amount,
                    'walletable_id' => $betting->id,
                    'agent_id'=>$agent->id,
                    'walletable_type' => 'betting',
                    'action' => 'in',
                ]);
            }
        }
    }

    /**
     * Handle the Betting "updated" event.
     */
    public function updated(Betting $betting): void
    {
        //
    }

    /**
     * Handle the Betting "deleted" event.
     */
    public function deleted(Betting $betting): void
    {
        //
    }

    /**
     * Handle the Betting "restored" event.
     */
    public function restored(Betting $betting): void
    {
        //
    }

    /**
     * Handle the Betting "force deleted" event.
     */
    public function forceDeleted(Betting $betting): void
    {
        //
    }
}
