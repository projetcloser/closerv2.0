<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cinetpay;
use App\Models\PaymentPayload;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PaymentApiController extends Controller
{

    protected $marchand = array(
        "apikey" => "4331665486718cc4a7a68d2.58982525", // Enrer votre apikey
        "site_id" => "5881950", //Entrer votre site_ID
        "secret_key" => "12894506036718eb32389318.31428764" //Entrer votre clé secret
    );
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payloads = PaymentPayload::where('open_close', '!=', 1)->get();
        return response()->json($payloads);
    }

    public function action(Request $req)
    {
        try {
            if ($req->isMethod('post')) {
                $data = $req->all();
                // echo "<pre>";
                // print_r($data);
                // die;
                $member_id = $data['member_id'];
                $customer_name = $data['customer_name'];
                $customer_surname = $data['customer_surname'];
                $description = $data['description'];
                $amount = $data['amount'];
                $currency = $data['currency'];
            } else {
                echo "Veuillez passer par le formulaire";
            }
            //transaction id
            $id_transaction = date("YmdHis"); // or $id_transaction = Cinetpay::generateTransId()

            // echo $id_transaction . "<br>";
            //Veuillez entrer votre apiKey
            $apikey = $this->marchand["apikey"];
            // echo $apikey . "<br>";
            //Veuillez entrer votre siteId
            $site_id = $this->marchand["site_id"];
            // echo $site_id . "<br>";

            //notify url
            $notify_url = 'https://webhook.site/aa8da616-6487-4d2b-9b91-7fa4b0dba1ae'; //$this->getCurrentUrl() . 'cinetpay-sdk-php/notify/notify.php';
            //return url
            $return_url = 'https://webhook.site/aa8da616-6487-4d2b-9b91-7fa4b0dba1ae'; //$this->getCurrentUrl() . 'cinetpay-sdk-php/return/return.php';
            $channels = "ALL";

            /*information supplémentaire que vous voulez afficher
            sur la facture de CinetPay(Supporte trois variables
            que vous nommez à votre convenance)*/
            $invoice_data = array(
                "Data 1" => "Data 1",
                "Data 2" => "Data 2",
                "Data 3" => "Data 3"
            );

            // echo "<pre>";
            // print_r($invoice_data);
            // echo "<br>";


            $formData = array(
                "transaction_id" => $id_transaction,
                "amount" => $amount,
                "currency" => $currency,
                "customer_surname" => $customer_name,
                "customer_name" => $customer_surname,
                "description" => $description,
                "notify_url" => $notify_url,
                "return_url" => $return_url,
                "channels" => $channels,
                "invoice_data" => $invoice_data,
                //pour afficher le paiement par carte de credit
                "customer_email" => ($data['customer_email'] ?? ""), //l'email du client
                "customer_phone_number" => ($data['customer_phone_number'] ?? ""), //Le numéro de téléphone du client
                "customer_address" => ($data['customer_address'] ?? ""), //l'adresse du client
                "customer_city" => ($data['customer_city'] ?? ""), // ville du client
                "customer_country" => ($data['customer_country'] ?? ""), //Le pays du client, la valeur à envoyer est le code ISO du pays (code à deux chiffre) ex : CI, BF, US, CA, FR
                "customer_state" => ($data['customer_state'] ?? ""), //L’état dans de la quel se trouve le client. Cette valeur est obligatoire si le client se trouve au États Unis d’Amérique (US) ou au Canada (CA)
                "customer_zip_code" => ($data['customer_zip_code'] ?? "") //Le code postal du client
            );


            $CinetPay = new Cinetpay($site_id, $apikey, $VerifySsl = false); //$VerifySsl=true <=> Pour activerr la verification ssl sur curl
            $result = $CinetPay->generatePaymentLink($formData);

            // echo "<pre>";
            // print_r($formData);
            // die;


            $payload = new PaymentPayload([
                "member_id" => $member_id,
                "transaction_id" => $id_transaction,
                "form_data" => json_encode($formData),
                "request_result" => json_encode($result),
            ]);

            // echo "<pre>";
            // print_r($payload);
            // die;

            // enregistrer la transaction dans votre base de donnée
            $payload->save();

            if ($result["code"] == '201') {
                // $url = $result["data"]["payment_url"];
                //redirection vers l'url de paiement
                //return Redirect::to($url);
                if (!empty($result)) {
                    return response()->json($result);
                } else {
                    return response()->json([
                        "message" => "Error"
                    ], 404);
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    public function getCurrentUrl()
    {
        return  $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
    }

    public function verify($transactionId)
    {

        if (!empty($transactionId)) {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api-checkout.cinetpay.com/v2/payment/check',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                  "transaction_id": "' . $transactionId . '",
                  "site_id": "' . $this->marchand["site_id"] . '",
                  "apikey" : "' . $this->marchand["apikey"] . '"

              }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return response()->json([
                    "message" => $err
                ], 404);
            } else {
                $payload = PaymentPayload::where('transaction_id', $transactionId)->first();
                $payload->update([
                    "status" => json_decode($response, true)['message'],
                    "check_result" => $response
                ]);
                return response()->json($response);
            }
        } else {
            echo "Veuillez renseigner l'id de la transaction";
        }
    }
}
