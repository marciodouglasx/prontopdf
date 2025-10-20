<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $baseUrl = "https://aleen-streamiest-softheartedly.ngrok-free.dev";
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));

        $tipo = $request->input('tipo', 'documento');
        $valor = (float) $request->input('valor', 0.50);

        $client = new PreferenceClient();
        $preference = $client->create([
            "items" => [
                [
                    "title" => "Geração de {$tipo}",
                    "quantity" => 1,
                    "unit_price" => $valor
                ]
            ],
            "payment_methods" => [
                "excluded_payment_types" => [],   // não excluir nenhum tipo
                "installments" => 1              // PIX não parcelado
            ],
            "back_urls" => [
                "success" => $baseUrl . "/pagamento/sucesso?tipo={$tipo}",
                "failure" => $baseUrl . "/pagamento/falha",
                "pending" => $baseUrl . "/pagamento/pendente",
            ],
            "auto_return" => "approved"
        ]);

        return redirect($preference->init_point);
    }

    public function success(Request $request)
    {
        $tipo = $request->input('tipo');
        return redirect()->route('document.create', $tipo)->with('paid', true);
    }

    public function failure()
    {
        return redirect('/')->with('error', 'Pagamento não concluído');
    }

    public function pending()
    {
        return redirect('/')->with('info', 'Pagamento pendente de confirmação');
    }
}
