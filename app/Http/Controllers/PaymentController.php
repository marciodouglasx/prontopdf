<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $baseUrl = env('APP_URL');
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));

        $tipo = $request->input('tipo', 'documento');
        $valor = (float) $request->input('valor', 0.50);

        $client = new PreferenceClient();
        try {
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
        } catch (MPApiException $e) {
            // 🔍 Mostra resposta completa da API
            return response()->json([
                'message' => 'Erro na API do Mercado Pago',
                'details' => $e->getApiResponse()->getContent()
            ], 400);
        } catch (\Exception $e) {
            // Captura erros genéricos de PHP/Laravel
            return response()->json([
                'message' => 'Erro inesperado',
                'details' => $e->getMessage()
            ], 500);
        }
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
