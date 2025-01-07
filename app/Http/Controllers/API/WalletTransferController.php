<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WalletTransfer\WalletTransferRequest;
use App\Repositories\WalletTransfer\WalletTransferInterface;

class WalletTransferController extends Controller
{
    //
    private $walletTransferRepo;
    public function __construct(WalletTransferInterface $repo)
    {
        $this->walletTransferRepo = $repo;
    }

    public function createWalletTransfer(WalletTransferRequest $request)
    {
        $data = $this->walletTransferRepo->createWalletTransfer($request);
        ResponseMessage('Wallet Transfer is successfully',200);
    }
}
