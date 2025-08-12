<?php
namespace App\Services\Gsc;

use App\Models\Wager;
use App\Models\SeamlessTransaction;
use App\Enums\SlotWebhookResponseCode;
use App\Services\Slot\SlotWebhookService;
use App\Http\Requests\Gsc\GscWebhookRequest;
use App\Services\Gsc\Dto\GscRequestTransaction;

class GscWebhookValidator
{

    protected ?SeamlessTransaction $existingTransaction;

    // TODO: imp: chang with actual wager
    protected ?Wager $existingWager;

    protected float $totalTransactionAmount = 0;

    protected float $before_balance;

    protected float $after_balance;

    protected array $response;

    /**
     * @var RequestTransaction[]
     */
    protected $requestTransactions;

    protected function __construct(protected GscWebhookRequest $request)
    {
    }

    public function validate()
    {
        if (!$this->isValidSignature()) {
            return $this->response(SlotWebhookResponseCode::InvalidSign);
        }

        if (!$this->request->getMember()) {
            return $this->response(SlotWebhookResponseCode::MemberNotExists);
        }
        foreach ($this->request->getTransactions() as $transaction) {
            $transaction['game_type']=$this->request->getGameCode();
            $transaction['product_code']=$this->request->getProductID();
            $requestTransaction = GscRequestTransaction::from($transaction);
            $this->requestTransactions[] = $requestTransaction;

            if ($requestTransaction->id && !$this->isNewTransaction($requestTransaction)) {
                return $this->response(SlotWebhookResponseCode::DuplicateTransaction);
            }
            if (!in_array($this->request->getMethodName(), ['withdraw', 'deposit']) && $this->isNewWager($requestTransaction)) {
                return $this->response(SlotWebhookResponseCode::BetNotExist);
            }
            $this->totalTransactionAmount += $requestTransaction->amount;
        }

        if (!$this->hasEnoughBalance()) {
            return $this->response(SlotWebhookResponseCode::MemberInsufficientBalance);
        }

        return $this;
    }

    protected function isValidSignature()
    {
        $method = $this->request->getMethodName();
        $operatorCode = $this->request->getOperatorCode();
        $requestTime = $this->request->getRequestTime();
        $secretKey = $this->getSecretKey();
        $signature = md5( $operatorCode.$requestTime.$method.$secretKey);
        return $this->request->getSign() == $signature;
    }

    protected function isNewWager(GscRequestTransaction $transaction)
    {
        return !$this->getExistingWager($transaction);
    }

    public function getExistingWager(GscRequestTransaction $transaction)
    {
        if (!isset($this->existingWager)) {
            $this->existingWager = Wager::where('seamless_wager_id', $transaction->id)->first();
        }

        return $this->existingWager;
    }

    protected function isNewTransaction(GscRequestTransaction $transaction)
    {
        return !$this->getExistingTransaction($transaction);
    }

    public function getExistingTransaction(GscRequestTransaction $transaction)
    {
        if (!isset($this->existingTransaction)) {
            $this->existingTransaction = SeamlessTransaction::where('seamless_transaction_id', $transaction->id)->first();
        }

        return $this->existingTransaction;
    }

    public function getAfterBalance()
    {
        if (!isset($this->after_balance)) {
            $this->after_balance = $this->getBeforeBalance() + $this->totalTransactionAmount;
        }

        return $this->after_balance;
    }

    public function getBeforeBalance()
    {
        if (!isset($this->before_balance)) {
            $this->before_balance = $this->request->getMember()->balanceFloat;
        }

        return $this->before_balance;
    }

    protected function hasEnoughBalance()
    {
        return $this->getAfterBalance() >= 0;
    }

    public function getRequestTransactions()
    {
        return $this->requestTransactions;
    }

    protected function getSecretKey()
    {
        return config('game.api.secret_key');
    }

    protected function response(SlotWebhookResponseCode $responseCode)
    {
        // $this->response = SlotWebhookService::buildResponse(
        //     $responseCode,
        //     $this->request->getMember() ? $this->getAfterBalance() : 0,
        //     $this->request->getMember() ? $this->getBeforeBalance() : 0
        // );
        $this->response=SlotWebhookService::buildGscResponse(
            $responseCode,
            $this->request->getMember()->user_name,
            $this->request->getProductID(),
            $this->request->getMember()->balanceFloat,
            $this->request->getMember()->balanceFloat
        );
        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function fails()
    {
        return isset($this->response);
    }

    public static function make(GscWebhookRequest $request)
    {
        return new self($request);
    }
}
