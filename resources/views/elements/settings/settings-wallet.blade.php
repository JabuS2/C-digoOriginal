{{-- Paypal and stripe actual buttons --}}
<div class="paymentOption paymentPP d-none">
    <form id="wallet-deposit" method="post" action="{{route('payment.initiatePayment')}}" >
        @csrf
        <input type="hidden" name="amount" id="wallet-deposit-amount" value="1">
        <input type="hidden" name="transaction_type" id="payment-type" value="">
        <input type="hidden" name="provider" id="provider" value="">
        <input type="hidden" name="manual_payment_files" id="manual-payment-files" value="">
        <input type="hidden" name="manual_payment_description" id="manual-payment-description" value="">

        <button class="payment-button" type="submit"></button>
    </form>
</div>

<div class="paymentOption ml-2 paymentStripe d-none">
    <button id="stripe-checkout-button">{{__('Checkout')}}</button>
</div>

{{-- Actual form --}}
<div>
    @include('elements/message-alert', ['classes' =>'mb-2'])

    <div class="alert alert-primary text-white font-weight-bold" role="alert">
        <div class="d-flex"><h3 class="font-weight-bold wallet-total-amount">{{\App\Providers\SettingsServiceProvider::getWebsiteFormattedAmount(number_format(Auth::user()->wallet->total, 2, '.', ''))}}</h3> <small class="ml-2"></small> </div>
        <div class="d-flex justify-content-between align-items-center mt-3">
    </div>
        <p class="mb-0">{{__('Available funds. You can deposit more money or become a creator to earn more.')}}</p>
        
        @if(getSetting('payments.withdrawal_allow_fees') && floatval(getSetting('payments.withdrawal_default_fee_percentage')) > 0)

        @else
            <h5></h5>
        @endif
        <div class="d-flex align-items-center">
            <span class="text-right">
                Saldo a receber {{\App\Providers\SettingsServiceProvider::getWebsiteFormattedAmount(number_format(Auth::user()->wallet->retained_balance, 2, '.', ''))}}
            </span>
        </div>
    </div>

    <div class="mt-3 inline-border-tabs">
        <nav class="nav nav-pills nav-justified">
            @foreach(\App\Providers\SettingsServiceProvider::allowWithdrawals(Auth::user()) ? ['deposit', 'withdraw'] : ['deposit'] as $tab)
                <a class="nav-item nav-link {{$activeTab == $tab ? 'active' : ''}}" href="{{route('my.settings',['type' => 'wallet', 'active' => $tab])}}">

                    <div class="d-flex align-items-center justify-content-center">
                        @if($tab == 'deposit')
                            @include('elements.icon',['icon'=>'wallet','variant'=>'medium','classes'=>'mr-2'])
                        @elseif(\App\Providers\SettingsServiceProvider::allowWithdrawals(Auth::user()))
                            @include('elements.icon',['icon'=>'card','variant'=>'medium','classes'=>'mr-2'])
                        @endif
                        {{__(ucfirst($tab))}}

                    </div>
                </a>
            @endforeach
        </nav>
        
    </div>

    @if($activeTab != null && $activeTab === 'withdraw' && \App\Providers\SettingsServiceProvider::allowWithdrawals(Auth::user()))
        @include('elements/settings/settings-wallet-withdraw')
    @else
        @include('elements/settings/settings-wallet-deposit')
    @endif

</div>
