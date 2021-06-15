<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('subscriptions.store')}}" method="post" id="form">
                        @csrf
                        <div class="col-span-6 sm:col-span-4 py-2">
                            <input type="text" name="card-holder-name" id="card-holder-name">
                        </div>
                        <div class="col-span-6 sm:col-span-4 py-2">
                            <div id="card-element"></div>
                        </div>
                        <div class="col-span-6 sm:col-span-4 py-2">
                            <button data-secret="{{ $intent->client_secret }}" type="submit" id="card-button"
                            class="h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800">
                            Enviar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>

const stripe = Stripe("{{ config('cashier.key')}}");
const elements = stripe.elements();
const cardElement = elements.create('card');

cardElement.mount('#card-element');

//subscription payment

const form = document.getElementById('form')
const cardHolderName = document.getElementById('card-holder-name')
const cardButton = document.getElementById('card-button')
const clientSecret = cardButton.dataset.secret

form.addEventListener('submit', async (e) =>{
    e.preventDefault()
    /* console.log(cardHolderName.value)
    console.log(clientSecret) */

    const {setupIntent, error} = await stripe.confirmCardSetup(
        clientSecret,{
        payment_method:{
            card: cardElement,
            billing_details:{
                name: cardHolderName.value
            }
        }}
    );

    if(error){
        alert('Erro')
        //console.log(error)
        return;
    }

    let token = document.createElement('input')
    token.setAttribute('type', 'hidden')
    token.setAttribute('name', 'token')
    token.setAttribute('value', setupIntent.payment_method)
    form.appendChild(token)
    form.submit()
})

</script>
